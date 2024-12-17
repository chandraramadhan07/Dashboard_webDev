const toggle = document.getElementById("darkmode-toggle");
const mainContent = document.querySelector(".content");
const cards = document.querySelectorAll(".cards");
const navbar = document.querySelector(".navbar");
const mobileDarkToggle = document.getElementById("darkmode-mobile");
const mobileLightToggle = document.getElementById("lightmode-mobile");

if (localStorage.getItem("darkMode") === "enabled") {
  document.body.classList.add("dark-mode");
  navbar.classList.add("dark-mode");
  cards.forEach((card) => card.classList.add("dark-mode"));
  toggle.checked = true;
}
toggle.addEventListener("change", () => {
  if (toggle.checked) {
    document.body.classList.add("dark-mode");
    navbar.classList.add("dark-mode");
    cards.forEach((card) => card.classList.add("dark-mode"));
    localStorage.setItem("darkMode", "enabled");
  } else {
    document.body.classList.remove("dark-mode");
    navbar.classList.remove("dark-mode");
    cards.forEach((card) => card.classList.remove("dark-mode"));
    localStorage.setItem("darkMode", "disabled");
  }
});
mobileDarkToggle.addEventListener("click", (e) => {
  e.preventDefault();
  document.body.classList.add("dark-mode");
  navbar.classList.add("dark-mode");
  cards.forEach((card) => card.classList.add("dark-mode"));
  localStorage.setItem("darkMode", "enabled");
});
mobileLightToggle.addEventListener("click", (e) => {
  e.preventDefault();
  document.body.classList.remove("dark-mode");
  navbar.classList.remove("dark-mode");
  cards.forEach((card) => card.classList.remove("dark-mode"));
  localStorage.setItem("darkMode", "disabled");
});


const profil = document.getElementById("profil");
const popup = document.getElementById("popup");
const hamburgerMenu = document.getElementById("hamburger-menu");
const arrow = document.getElementById("arrow-button");
const sidebar = document.getElementById("sidebar");

if (localStorage.getItem("sidebarHidden") === "true") {
  sidebar.classList.add("hide");
  arrow.classList.add("rotate-180");
} else {
  sidebar.classList.remove("hide");
  arrow.classList.remove("rotate-180");
}
arrow.addEventListener("click", function () {
  sidebar.classList.toggle("hide");
  arrow.classList.toggle("rotate-180");
  localStorage.setItem("sidebarHidden", sidebar.classList.contains("hide"));
});
profil.addEventListener("click", function () {
  popup.classList.toggle("open-profil");
});
hamburgerMenu.addEventListener("click", function () {
  sidebar.classList.toggle("open-navigation");
});
document.addEventListener("click", function (event) {
  if (!sidebar.contains(event.target) && event.target !== hamburgerMenu) {
    sidebar.classList.remove("open-navigation");
  }
});


