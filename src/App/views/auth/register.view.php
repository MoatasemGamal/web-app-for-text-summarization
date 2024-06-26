@extends('main')
@section('title', '<?= __('Register') ?>')
@section('content')
<div class="container d-flex justify-content-center align-items-center my-5" style="height: 70vh">
  <div class="register-container p-4 rounded shadow bg-white" style="max-width: 400px; width: 100%">
    <h2 class="text-center"><?= __('Register') ?></h2>
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
        <label for="name"><?= __('Name') ?></label>
        <input type="text" class="form-control" id="name" name="name" placeholder="<?= __('Enter your name') ?>" />
      </div>
      <div class="form-group mb-3">
        <label for="email"><?= __('Email') ?></label>
        <input type="email" class="form-control" id="email" name="email" placeholder="<?= __('Enter your email') ?>" />
      </div>
      <div class="form-group mb-3">
        <label for="password"><?= __('Password') ?></label>
        <input type="password" class="form-control" id="password" name="password"
          placeholder="<?= __('Enter your password') ?>" />
      </div>
      <button type="submit" class="btn btn-primary btn-block w-100">
        <?= __('Register') ?>
      </button>
      <p class="text-center mt-3">
        <?= __('Already have an account?') ?> <a href="/login"><?= __('Login') ?></a>
      </p>
    </form>
  </div>
</div>
@endSection