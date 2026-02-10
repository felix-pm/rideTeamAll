const buttonModifProfil = document.getElementById("flex-profil");
const pageProfil = document.getElementById("profil");
const pageModifProfil = document.getElementById("display-profil");
const btnLogout = document.getElementById("btn-logout");
buttonModifProfil.addEventListener("click", () => {
  pageProfil.style.display = "none";
  btnLogout.style.display = "none";
  pageModifProfil.style.display = "flex";
});

const btnBackProfil = document.getElementById("btn-back-profil");
btnBackProfil.addEventListener("click", () => {
  pageModifProfil.style.display = "none";
  pageProfil.style.display = "block";
});

const buttonBalades = document.getElementById("flex-balades");
const pageBalades = document.getElementById("display-balades");
buttonBalades.addEventListener("click", () => {
  pageProfil.style.display = "none";
  btnLogout.style.display = "none";
  pageBalades.style.display = "block";
});

const btnBackBalades = document.getElementById("btn-back-balades");
btnBackBalades.addEventListener("click", () => {
  pageBalades.style.display = "none";
  pageProfil.style.display = "block";
});

const buttonGarage = document.getElementById("flex-garage");
const pageGarage = document.getElementById("display-garages");
buttonGarage.addEventListener("click", () => {
  pageProfil.style.display = "none";
  btnLogout.style.display = "none";
  pageGarage.style.display = "block";
});

const btnBackGarage = document.getElementById("btn-back-garage");
btnBackGarage.addEventListener("click", () => {
  pageGarage.style.display = "none";
  pageProfil.style.display = "block";
});
