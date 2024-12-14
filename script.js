const profil = document.getElementById("profil");
const popup = document.getElementById("popup");
const hamburgerMenu = document.getElementById("hamburger-menu");
const arrow = document.getElementById("arrow-button");
const sidebar = document.getElementById("sidebar");

arrow.addEventListener("click", function () {
  sidebar.classList.toggle("hide");
  arrow.classList.toggle("rotate-180");
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

const toggle = document.getElementById("darkmode-toggle");
const mainContent = document.querySelector(".content");
const cards = document.querySelectorAll(".cards");
const navbar = document.querySelector(".navbar");
const mobileDarkToggle = document.getElementById("darkmode-mobile");
const mobileLightToggle = document.getElementById("lightmode-mobile");

toggle.addEventListener("change", () => {
  if (toggle.checked) {
    document.body.classList.add("dark-mode");
    navbar.classList.add("dark-mode");
    cards.forEach((card) => card.classList.add("dark-mode"));
  } else {
    document.body.classList.remove("dark-mode");
    navbar.classList.remove("dark-mode");
    cards.forEach((card) => card.classList.remove("dark-mode"));
  }
});

mobileDarkToggle.addEventListener("click", (e) => {
  e.preventDefault();
  cards.forEach((card) => card.classList.add("dark-mode"));
  navbar.classList.add("dark-mode");
  document.body.classList.add("dark-mode");
});

mobileLightToggle.addEventListener("click", (e) => {
  e.preventDefault();
  document.body.classList.remove("dark-mode");
  navbar.classList.add("dark-mode");
  cards.forEach((card) => card.classList.remove("dark-mode"));
});