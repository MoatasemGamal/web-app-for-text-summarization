<?php
/**
 * Organize routes in a separate file
 */
use App\Controllers\ApiController;
use App\Controllers\SummaryController;
use App\Controllers\UserController;
use Core\App;
use Core\Http\Response;
use \Core\Route;

Route::get("/", "index");
Route::get("/summarize", [SummaryController::class, 'index']);
Route::post("/summarize", [SummaryController::class, 'summarize']);



Route::get("/login", [UserController::class, "login"]);
Route::post("/login", [UserController::class, "login"]);


Route::get("/profile", [UserController::class, "profile"]);
Route::post("/profile", [UserController::class, "editProfile"]);

Route::get("/register", [UserController::class, 'register']);
Route::post("/register", [UserController::class, 'register']);
Route::get("/logout", [UserController::class, 'logout']);

Route::get("/history", [UserController::class, 'history']);

Route::post("/feedback", [SummaryController::class, 'feedback']);

Route::get("/apis", [ApiController::class, 'index']);
Route::post("/apis", [ApiController::class, 'create']);



Route::get('/change-language/{{lang}}', function ($lang) {
    $lang = match ($lang[0]) {
        'ar' => 'ar',
        'ara' => 'ar',
        'Ar' => 'ar',
        'arabic' => 'ar',
        'Arabic' => 'ar',
        'en' => 'en',
        'eng' => 'en',
        'english' => 'en',
        'English' => 'en',
        'En' => 'en',
        default => 'ar'
    };
    app('session')->start();
    $_SESSION['language'] = $lang;
    if (!App::isGuest())
        $_SESSION['user']->edit(['language' => $lang])->save();

    return Response::redirect('/summarize');
});


Route::get('/api/edit', [ApiController::class, 'edit']);
Route::get('/api/delete/{{token}}', [ApiController::class, 'delete']);

Route::post('/api-summarize/{{token}}', [ApiController::class, 'summarize']);

Route::get('/api/history', [ApiController::class, 'history']);
