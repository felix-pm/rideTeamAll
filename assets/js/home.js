//! gestion des balades futures ou passées
const tabButtons = document.querySelectorAll(".tab-btn-switch");
const tabPanels = document.querySelectorAll(".tab-second");

tabButtons.forEach((button) => {
  button.addEventListener("click", () => {
    // 1. Retirer la classe 'active' de tous les boutons et panneaux
    tabButtons.forEach((btn) => btn.classList.remove("active"));
    tabPanels.forEach((panel) => panel.classList.remove("active"));

    // 2. Ajouter la classe 'active' au bouton cliqué
    button.classList.add("active");

    // 3. Afficher le panneau correspondant grâce à l'attribut data-tab
    const targetTab = button.getAttribute("data-tab");
    document.getElementById(targetTab).classList.add("active");
  });
});
