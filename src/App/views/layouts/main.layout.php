<?php
use Core\App;

$dir = App::getCurrentLanguage() == 'ar' ? 'rtl' : 'ltr';
?>
<!DOCTYPE html>
<html lang="en" dir="<?= $dir ?>">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title')</title>
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="/assets/css/fontawesome.min.css" />
  <link rel="stylesheet" href="/assets/css/main.css" />
  <link rel="icon" type="image/x-icon" href="/favicon.ico" />
  <?php /*
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
*/ ?>
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
        <ul class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton" dir="ltr">
          <!-- <li>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="themeChangerBtn" onchange="changeTheme()" />
              <label class="form-check-label" for="themeChangerBtn">Dark Mode</label>
            </div>
          </li> 
          <li>
            <hr class="dropdown-divider" />
          </li>-->
          <li>
            <div class="form-check">
              <!-- Assuming you are using Blade templating based on the PHP tags used -->
              <a href="/change-language/<?= App::getCurrentLanguage() == 'ar' ? 'en' : 'ar' ?>">
                <?php if (App::getCurrentLanguage() == 'ar'): ?>
                  <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                    <mask id="circleFlagsUsBetsyRoss0">
                      <circle cx="256" cy="256" r="256" fill="#fff" />
                    </mask>
                    <g mask="url(#circleFlagsUsBetsyRoss0)">
                      <path fill="#d80027" d="M312 0h200v512H0V273Z" />
                      <path fill="#eee"
                        d="M280 41v39h232V41Zm0 78v39h232v-39zm0 78v39h232v-39ZM0 275v39h512v-39H312l-156-64Zm0 78v39h512v-39zm0 78v39h512v-39z" />
                      <path fill="#0052b4" d="M0 0h312v275H0Z" />
                      <path fill="#eee"
                        d="m260 176l2 17l-15 6l16 4l1 16l9-14l16 3l-11-12l8-14l-15 7zm-144 0l-11 12l-15-6l8 14l-11 12l17-3l8 14l1-16l16-4l-15-6zm173-47l-10 13l-15-5l9 13l-9 13l15-5l10 13v-16l15-5l-15-5zm-201 0v16l-16 5l16 5v16l9-13l16 5l-10-13l10-13l-16 5zm177-48l-2 16l-16 4l15 6l-2 17l11-12l15 6l-8-14l11-12l-16 3zm-153 0l-8 14l-17-3l11 12l-8 14l15-6l11 12l-2-17l15-6l-16-4zm134-32l-12 11l-14-8l7 15l-13 11l17-2l6 15l4-16l16-1l-14-8zm-116 0l3 16l-14 9l16 1l4 16l7-15l16 2l-12-11l6-15l-14 8zm58-15l-5 15h-16l13 10l-5 15l13-9l13 9l-5-15l13-10h-16zm58 217l-12-11l-14 8l7-15l-13-11l17 2l6-15l4 16l16 1l-14 8zm-116 0l3-16l-14-9l16-1l4-16l7 15l16-2l-12 11l6 15l-14-8zm58 15l-5-15h-16l13-10l-5-15l13 9l13-9l-5 15l13 10h-16z" />
                    </g>
                  </svg>
                  English
                <?php else: ?>
                  <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                    <mask id="circleFlagsEg0">
                      <circle cx="256" cy="256" r="256" fill="#fff" />
                    </mask>
                    <g mask="url(#circleFlagsEg0)">
                      <path fill="#eee" d="m0 144l256-32l256 32v224l-256 32L0 368Z" />
                      <path fill="#d80027" d="M0 0h512v144H0Z" />
                      <path fill="#333" d="M0 368h512v144H0Z" />
                      <path fill="#ff9811"
                        d="M250 191c-8 0-17 4-22 14c5-3 16-1 16 13c0 4-2 8-5 10c-8 0-14-14-29-14c-10 0-19 7-19 17v69l46-7l-14 27h66l-14-27l46 7v-69c0-10-9-17-19-17c-15 0-21 14-29 14c8-23-7-37-23-37" />
                    </g>
                  </svg>
                  العربية
                <?php endif; ?>

              </a>
            </div>
          </li>

          <li>
            <a class="dropdown-item" href="/summarize"><i class="fa-solid fa-text-width"></i>
              <?= __('Summarizer') ?></a>
          </li>
          <li>
            <hr class="dropdown-divider" />
          </li>
          <?php if (App::isGuest()): ?>
            <li>
              <a class="dropdown-item" href="/login"><i class="fa-solid fa-user"></i> <?= __('Login') ?></a>
            </li>
            <li>
              <a class="dropdown-item" href="/register"><i class="fa-solid fa-user-plus"></i> <?= __('Register') ?></a>
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
              <a class="dropdown-item" href="/history"><i class="fa-solid fa-clock-rotate-left"></i>
                <?= __('history') ?></a>
            </li>
            <li>
              <a class="dropdown-item" href="/apis"><i class="fa-solid fa-link"></i> APIs</a>
            </li>
            <li>
              <a class="dropdown-item" href="/logout"><i class="fa-solid fa-right-from-bracket"></i>
                <?= __('Logout') ?></a>
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
    &copy; <?= __('2024 Text Recap. All rights reserved.') ?>
  </footer>
  <script>
    // Call handleInput initially if there is already text loaded
    handleInput();

    // Update counters initially
    updateCounters();
  </script>
</body>

</html>