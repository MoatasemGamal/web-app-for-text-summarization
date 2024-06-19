@extends('main')
@section('title', 'profile')
@section('content')
<div class="container d-flex justify-content-center align-items-center my-5" style="height: 70vh">
    <div class="profile-container p-4 rounded shadow bg-white" style="max-width: 600px; width: 100%">
        <form method="POST" enctype="multipart/form-data">
            <?php if (isset($errors) && !empty($errors)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    foreach ($errors as $k => $v) {
                        echo '- ' . $v . '<br/>';
                    }
                    ?>
                </div>
            <?php endif; ?>
            <div class="profile-header text-center">
                <img src="<?= isset($user->avatar) ? 'uploads/' . $user->avatar : '/assets/images/profile.png' ?>"
                    alt="Profile Picture" id="profileImage" class="rounded-circle mb-3"
                    style="width: 120px; height: 120px" />
                <div>
                    <label class="btn btn-secondary">
                        <i class="fas fa-upload"></i> Upload Image
                        <input name="avatar" type="file" id="imageUpload" hidden />
                    </label>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="username"><i class="fas fa-user"></i> Full Name</label>
                <input type="text" class="form-control" id="username" name="name"
                    value="<?= isset($user->name) ? $user->name : '' ?>" placeholder="Enter your Name" />
            </div>
            <div class="form-group mb-3">
                <label for="email"><i class="fas fa-user"></i> Full Name</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?= isset($user->email) ? $user->email : '' ?>" placeholder="Enter your Name" />
            </div>
            <div class="form-group mb-3">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="Enter your password" />
            </div>
            <div class="form-group mb-3">
                <label for="confirmPassword"><i class="fas fa-lock"></i> Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                    placeholder="Confirm your password" />
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </form>
    </div>
</div>
<script>
    document
        .getElementById("imageUpload")
        .addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById("profileImage").src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
</script>
@endSection