@extends('main')
@section('title', 'login')
@section('content')
<div class="container d-flex justify-content-center align-items-center my-5" style="height: 70vh">
  <div class="login-container p-4 rounded shadow bg-white" style="max-width: 400px; width: 100%">
    <h2 class="text-center"><?= __('Login') ?></h2>
    <form method="POST">
      <div class="form-group mb-3">
        <?php if (isset($errors) && !empty($errors)): ?>
          <div class="alert alert-danger" role="alert">
            <?php
            foreach ($errors as $k => $v) {
              echo '- ' . $v . '<br/>';
            }
            ?>
          </div>
        <?php endif; ?>
        <label for="email"><?= __('Email') ?></label>
        <input type="email" class="form-control" id="email" name="email" placeholder="<?= __('Enter your email') ?>" />
      </div>
      <div class="form-group mb-3">
        <label for="password"><?= __('Password') ?></label>
        <input type="password" class="form-control" id="password" name="password"
          placeholder="<?= __('Enter your password') ?>" />
      </div>
      <button type="submit" class="btn btn-primary btn-block w-100">
        <?= __('Login') ?>
      </button>
      <p class="text-center mt-3">
        <?= __("Don't have an account?") ?> <a href="/register"><?= __('Register Now') ?></a>
      </p>
    </form>
  </div>
</div>
@endSection