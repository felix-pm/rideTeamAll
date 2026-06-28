//! affichages des balades à découvrir ou des abonnés
const tabButtons = document.querySelectorAll(".tab-btn-switch");
const tabPanels = document.querySelectorAll(".tab-second");

tabButtons.forEach((button) => {
  button.addEventListener("click", () => {
    tabButtons.forEach((btn) => btn.classList.remove("active"));
    tabPanels.forEach((panel) => panel.classList.remove("active"));

    button.classList.add("active");

    const targetTab = button.getAttribute("data-tab");
    document.getElementById(targetTab).classList.add("active");
  });
});
