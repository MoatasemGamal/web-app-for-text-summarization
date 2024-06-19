<?php
use Core\App;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title')</title>
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="/assets/css/fontawesome.min.css" />
  <link rel="stylesheet" href="/assets/css/main.css" />
  <link rel="icon" type="image/x-icon" href="/favicon.ico" />
  <script>
    function getCookie(name) {
      const cookieName = name + "=";
      const decodedCookie = decodeURIComponent(document.cookie);
      const cookieArray = decodedCookie.split(";");
      for (let i = 0; i < cookieArray.length; i++) {
        let cookie = cookieArray[i];
        while (cookie.charAt(0) === " ") {
          cookie = cookie.substring(1);
        }
        if (cookie.indexOf(cookieName) === 0) {
          return cookie.substring(cookieName.length, cookie.length);
        }
      }
      return null;
    }

    function createCookie(name, value, days) {
      let expires = "";
      if (days) {
        const date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        expires = "; expires=" + date.toUTCString();
      }
      document.cookie = name + "=" + value + expires + "; path=/";
    }

    const themeCookie = getCookie("theme");

    if (themeCookie === null) {
      createCookie("theme", "light", 7);
    }
  </script>
</head>

<body data-bs-theme="light" class="bg-body-secondary">
  <nav class="navbar bg-light-subtle">
    <div class="container">
      <a class="navbar-brand" href="/">
        <img src="/assets/images/logo.png" id="brand-logo" alt="Logo" height="60px"
          class="d-inline-block align-text-top" />
      </a>

      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
          data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa-solid fa-bars"></i>
        </button>
        <ul class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton">
          <li>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="themeChangerBtn" onchange="changeTheme()" />
              <label class="form-check-label" for="themeChangerBtn">Dark Mode</label>
            </div>
          </li>
          <li>
            <hr class="dropdown-divider" />
          </li>
          <li>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="languageRadio" id="arabicRadio"
                onchange="changeLanguage('arabic')" />
              <label class="form-check-label" for="arabicRadio">Lang: Arabic</label>
            </div>
          </li>
          <li>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="languageRadio" id="englishRadio"
                onchange="changeLanguage('english')" />
              <label class="form-check-label" for="englishRadio">Lang: English</label>
            </div>
          </li>
          <li>
            <a class="dropdown-item" href="/summarize"><i class="fa-solid fa-text-width"></i> Summarize</a>
          </li>
          <li>
            <hr class="dropdown-divider" />
          </li>
          <?php if (App::isGuest()): ?>
            <li>
              <a class="dropdown-item" href="/login"><i class="fa-solid fa-user"></i> Login</a>
            </li>
            <li>
              <a class="dropdown-item" href="/register"><i class="fa-solid fa-user-plus"></i> Register</a>
            </li>
          <?php else: ?>
            <li>
              <a class="dropdown-item" href="/profile">
                <img
                  src="<?= isset($_SESSION['user']->avatar) ? 'uploads/' . $_SESSION['user']->avatar : '/assets/images/profile.png' ?>"
                  alt="Profile" class="rounded-circle" style="width: 24px; height: 24px;">
                <?= isset($_SESSION['user']->name) ? $_SESSION['user']->name : 'Profile' ?>
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="/history"><i class="fa-solid fa-clock-rotate-left"></i> history</a>
            </li>
            <li>
              <a class="dropdown-item" href="/apis"><i class="fa-solid fa-link"></i> APIs</a>
            </li>
            <li>
              <a class="dropdown-item" href="/logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  @yield('content')
  <script src="/assets/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
  <script src="/assets/js/fontawesome.min.js"></script>
  <script src="/assets/js/main.js"></script>
  <footer class="p-3 text-center">
    &copy; 2024 Text Recap. All rights reserved.
  </footer>
</body>

</html>