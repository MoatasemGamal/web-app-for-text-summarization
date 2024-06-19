let darkLogoPath =
  location.protocol +
  "//" +
  location.hostname +
  ":" +
  window.location.port +
  "/assets/images/logo-for-dark-mode.png";
let lightLogoPath =
  location.protocol +
  "//" +
  location.hostname +
  ":" +
  window.location.port +
  "/assets/images/logo.png";

function updateCounter() {}

function changeTheme() {
  let body = document.body;
  let themeChangerLbl = document.getElementById("themeChangerLbl");
  let logo = document.getElementById("brand-logo");
  body.dataset.bsTheme = body.dataset.bsTheme == "light" ? "dark" : "light";
  createCookie("theme", body.dataset.bsTheme, 7);

  themeChangerLbl.innerHTML =
    themeChangerLbl.innerHTML == "Light Mode" ? "Dark Mode" : "Light Mode";

  logo.src = logo.src == darkLogoPath ? lightLogoPath : darkLogoPath;
}

if (themeCookie === null) {
  createCookie("theme", "light", 7);
} else {
  document.body.dataset.bsTheme = themeCookie;
  if (themeCookie == "dark") {
    document.getElementById("themeChangerBtn").checked = true;
    document.getElementById("brand-logo").src = darkLogoPath;
    document.getElementById("themeChangerLbl").innerHTML = "Light Mode";
  } else {
    document.getElementById("themeChangerBtn").checked = false;
    document.getElementById("brand-logo").src = lightLogoPath;
    document.getElementById("themeChangerLbl").innerHTML = "Dark Mode";
  }
}

function clearAllText() {
  document.getElementById("fullText").value = "";
  document.getElementById("summarizedText").innerHTML = "";
  document.getElementById("fileName").innerText = "";
  updateCounters();
}

function handleFileUpload() {
  const fileInput = document.getElementById("fileInput");
  const file = fileInput.files[0];
  if (file) {
    document.getElementById("fileName").innerText = file.name;
  }
}

function pasteText() {
  navigator.clipboard.readText().then((text) => {
    document.getElementById("fullText").value = text;
    handleInput();
  });
}

function detectLanguage() {
  const text = document.getElementById("fullText").value;
  const arabicCount = (text.match(/[\u0600-\u06FF]/g) || []).length;
  const englishCount = (text.match(/[a-zA-Z]/g) || []).length;

  if (arabicCount > englishCount) {
    document.getElementById("fullText").style.direction = "rtl";
    createCookie("language", "arabic", 7);
  } else {
    document.getElementById("fullText").style.direction = "ltr";
    createCookie("language", "english", 7);
  }
}

function toggleSummaryLengthInput() {
  const modelSelection = document.getElementById("modelSelection");
  const summaryLengthInput = document.getElementById("summaryLengthInput");

  if (modelSelection.value === "textRank") {
    summaryLengthInput.style.display = "flex";
  } else {
    summaryLengthInput.style.display = "none";
  }
}

function updateCounters() {
  const fullText = document.getElementById("fullText").value;
  const summarizedText = document.getElementById("summarizedText").innerText;

  const wordCount1 = fullText
    .split(/\s+/)
    .filter((word) => word.length > 0).length;
  const sentenceCount1 = fullText
    .split(/[.!?]+/)
    .filter((sentence) => sentence.trim().length > 0).length;

  const wordCount2 = summarizedText
    .split(/\s+/)
    .filter((word) => word.length > 0).length;
  const sentenceCount2 = summarizedText
    .split(/[.!?]+/)
    .filter((sentence) => sentence.trim().length > 0).length;

  document.getElementById("wordCount1").innerText = wordCount1;
  document.getElementById("sentenceCount1").innerText = sentenceCount1;

  document.getElementById("wordCount2").innerText = wordCount2;
  document.getElementById("sentenceCount2").innerText = sentenceCount2;
}

function handleInput() {
  detectLanguage();
  updateCounters();
  const pasteBtn = document.getElementById("pasteBtn");
  if (document.getElementById("fullText").value.length > 0) {
    pasteBtn.style.display = "none";
  } else {
    pasteBtn.style.display = "block";
  }
}

function submitFeedback(feedbackType) {
  const feedbackForm = document.getElementById("feedbackForm");
  const hiddenInput = document.createElement("input");
  hiddenInput.type = "hidden";
  hiddenInput.name = "feedbackType";
  hiddenInput.value = feedbackType;
  feedbackForm.appendChild(hiddenInput);
  feedbackForm.submit();
}

// language Cookie
const languageCookie = getCookie("language");

if (languageCookie === null) {
  createCookie("language", "arabic", 7);
} else {
  if (languageCookie == "arabic") {
    document.getElementById("summarizedText").style.direction = "rtl";
    document.getElementById("fullText").style.direction = "rtl";
  } else {
    document.getElementById("summarizedText").style.direction = "ltr";
    document.getElementById("fullText").style.direction = "ltr";
  }
}

document.getElementById("fullText").addEventListener("input", handleInput);
document
  .getElementById("modelSelection")
  .addEventListener("change", toggleSummaryLengthInput);

document.addEventListener("DOMContentLoaded", function () {
  const tabTriggerList = [].slice.call(
    document.querySelectorAll("#myTab button")
  );
  tabTriggerList.forEach(function (tabTriggerEl) {
    const tab = new bootstrap.Tab(tabTriggerEl);

    tabTriggerEl.addEventListener("click", function (event) {
      event.preventDefault();
      tab.show();
    });
  });
});

/**/
document.addEventListener("DOMContentLoaded", function () {
  const tabTriggerList = [].slice.call(
    document.querySelectorAll("#myTab button")
  );
  tabTriggerList.forEach(function (tabTriggerEl) {
    const tab = new bootstrap.Tab(tabTriggerEl);

    tabTriggerEl.addEventListener("click", function (event) {
      event.preventDefault();
      tab.show();
    });
  });

  function changeTheme() {
    let body = document.body;
    let themeChangerLbl = document.getElementById("themeChangerLbl");
    let logo = document.getElementById("brand-logo");
    body.dataset.bsTheme = body.dataset.bsTheme == "light" ? "dark" : "light";
    createCookie("theme", body.dataset.bsTheme, 7);

    themeChangerLbl.innerHTML =
      themeChangerLbl.innerHTML == "Light Mode" ? "Dark Mode" : "Light Mode";

    logo.src = logo.src == darkLogoPath ? lightLogoPath : darkLogoPath;
  }

  function changeLanguage(lang) {
    createCookie("language", lang, 7);
    location.reload();
  }

  const themeCookie = getCookie("theme");
  if (themeCookie !== null) {
    document.body.dataset.bsTheme = themeCookie;
  }

  const languageCookie = getCookie("language");
  if (languageCookie !== null) {
    if (languageCookie === "arabic") {
      document.getElementById("arabicRadio").checked = true;
      document.body.setAttribute("lang", "ar");
    } else {
      document.getElementById("englishRadio").checked = true;
      document.body.setAttribute("lang", "en");
    }
  }

  document.getElementById("fullText").addEventListener("input", handleInput);
  document
    .getElementById("modelSelection")
    .addEventListener("change", toggleSummaryLengthInput);
});
