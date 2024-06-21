<?php

namespace App\Controllers;

use App\Middleware\PreventGuestMiddleware;
use App\Middleware\PreventLoggedMiddleware;
use App\Models\Summary;
use App\Models\User;
use Core\App;
use Core\Bases\BaseController;
use Core\Http\Request;
use Core\Http\Response;


class UserController extends BaseController
{

    public function __construct()
    {
        $this->registerMiddleware(new PreventGuestMiddleware(['profile', 'editProfile']));
        $this->registerMiddleware(new PreventLoggedMiddleware(['login', 'register']));

    }

    public function login()
    {
        if (Request::isGet()) {
            return view("auth.login");
        } else {
            $errors = [];

            // Sanitize and validate email
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Invalid email format";
            }

            // Validate password
            $password = filter_input(INPUT_POST, 'password');
            if (empty($password)) {
                $errors['password'] = "Password is required";
            }

            // Check if there are any errors
            if (!empty($errors)) {
                return view("auth.login", ['errors' => $errors]);
            }

            // Fetch user from database
            $user = User::one(['email' => $email]);
            if ($user && $user->status == false)
                $errors['general'] = 'your account is suspend';

            // Check if there are any errors
            if (!empty($errors)) {
                return view("auth.login", ['errors' => $errors]);
            }

            // Verify password
            if ($user && password_verify($password, $user->password)) {
                // Start session and store user information
                app('session')->start();
                $_SESSION['user'] = $user;

                // Redirect or show success message
                return Response::redirect('/summarize');
            } else {
                $errors['general'] = "Invalid email or password";
                return view("auth.login", ['errors' => $errors]);
            }

        }
    }


    public function register()
    {
        if (Request::isGet()) {
            return view("auth.register");
        }

        // Retrieve and filter inputs
        $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        // Initialize errors array
        $errors = [];

        // Validate name
        if (empty($name)) {
            $errors['name'] = "Name can't be empty";
        } elseif (strlen($name) < 3) {
            $errors['name'] = "Name should be at least 3 characters long";
        }

        // Validate email
        if (empty($email)) {
            $errors['email'] = "Email can't be empty";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format";
        } elseif (User::one(['email' => $email])) {
            $errors['email'] = "Email already exists";
        }

        // Validate password
        if (empty($password)) {
            $errors['password'] = "Password can't be empty";
        } elseif (strlen($password) < 6) {
            $errors['password'] = "Password should be at least 6 characters long";
        }

        // If there are validation errors, return to registration view with errors
        if (!empty($errors)) {
            return view("auth.register", ['errors' => $errors]);
        }

        // Registration
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ])->save();

        // Store user in session
        app('session')->start();
        $_SESSION['user'] = $user;

        // Redirect or return success view
        return Response::redirect('/summarize');
    }


    public function logout()
    {
        // Start the session if it hasn't been started
        app('session')->start();

        // Unset or clear the session variables
        $_SESSION = [];

        // Destroy the session cookie if it exists
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Destroy the session
        session_destroy();

        // Redirect to the login page or any other page as needed
        return Response::redirect('/summarize');
    }


    //this function run only when user logged (prevented with middleware)
    public function profile()
    {
        return view("profile", ['user' => $_SESSION['user']]);
    }
    public function editProfile()
    {
        // Retrieve and filter inputs
        $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        $confirmPassword = filter_input(INPUT_POST, 'confirmPassword');

        // Initialize errors array
        $errors = [];

        // Validate name
        if (empty($name))
            $errors['name'] = "Name can't be empty";
        elseif (strlen($name) < 3)
            $errors['name'] = "Name should be at least 3 characters long";

        // Validate email
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format";
        } elseif (!empty($email) && $_SESSION['user']->email !== $email && User::one(['email' => $email])) {
            pre($_SESSION['user']->email != $email, $_SESSION['user']->email, );
            $errors['email'] = "Email already exists";
        }

        // Validate password
        if (!empty($password) && strlen($password) < 6)
            $errors['password'] = "Password should be at least 6 characters long";
        elseif (!empty($password) && $password !== $confirmPassword)
            $errors['password'] = "Confirm Password should be the same as Password";

        // Handle file upload for avatar
        $avatarPath = null;
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $avatarFile = $_FILES['avatar']['tmp_name'];
            $avatarName = date('YmdHis') . '_' . $_FILES['avatar']['name'];
            $avatarPath = UPLOADS_PATH . $avatarName;

            // Move uploaded file to desired location
            if (!move_uploaded_file($avatarFile, $avatarPath)) {
                $errors['avatar'] = "Failed to move uploaded file";
            }
        }

        // If there are validation errors, return to profile view with errors
        if (!empty($errors)) {
            return view("profile", ['errors' => $errors]);
        }

        // Update user profile
        $_SESSION['user']->name = $name;
        $_SESSION['user']->email = $email;
        if (!empty($password)) {
            $_SESSION['user']->password = password_hash($password, PASSWORD_DEFAULT);
        }

        // Update avatar if uploaded
        if ($avatarPath) {
            $_SESSION['user']->avatar = $avatarName;
        }

        $_SESSION['user']->save();

        // Redirect or return success message
        return Response::redirect('/profile');
    }

    public function history()
    {
        $result = Summary::paginate(3, ['user_id' => $_SESSION['user']->id]);
        $result['name'] = $_SESSION['user']->name;
        return view('history', $result);
    }

}