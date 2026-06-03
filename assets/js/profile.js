//! gestion du btn d'envoie de profil
const shareProfileBtn = document.getElementById("btn-share-profile");

if (shareProfileBtn) {
  shareProfileBtn.addEventListener("click", async (e) => {
    e.preventDefault(); // Empêche la page de remonter tout en haut (comportement par défaut du "#")

    // On récupère les infos stockées dans le HTML
    const shareUrl = shareProfileBtn.getAttribute("data-url");
    const shareTitle = shareProfileBtn.getAttribute("data-title");

    // On vérifie si l'appareil supporte le partage natif (smartphone, OS récent)
    if (navigator.share) {
      try {
        await navigator.share({
          title: "RideTeam",
          text: shareTitle,
          url: shareUrl,
        });
        console.log("Profil partagé avec succès !");
      } catch (err) {
        // L'utilisateur a probablement annulé le partage, on l'ignore silencieusement.
        console.log("Partage annulé ou échoué :", err);
      }
    } else {
      // PLAN B : Si le partage natif n'est pas dispo (ex: vieux navigateur PC)
      // On copie directement le lien dans le presse-papier
      try {
        await navigator.clipboard.writeText(shareUrl);
        alert("Le lien de ton profil a été copié dans le presse-papier !");
      } catch (err) {
        console.error("Erreur lors de la copie :", err);
        alert("Impossible de copier le lien automatiquement.");
      }
    }
  });
}

//! gestion des balades futures ou passées
const tabButtons = document.querySelectorAll(".tab-btn");
const tabPanels = document.querySelectorAll(".tab-panel");

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

// Gérer l'affichage du formulaire d'ajout de moto
const btnAddBike = document.getElementById("button-add-bike");
const formAddBike = document.getElementById("add-bike");
const btnBackAddBike = document.getElementById("btn-back-add-bike");
const displayGarages = document.getElementById("display-garages");

if (btnAddBike && formAddBike) {
  btnAddBike.addEventListener("click", () => {
    formAddBike.style.display = "block";
    displayGarages.style.display = "none"; // Optionnel : cache le garage pendant l'ajout
  });

  btnBackAddBike.addEventListener("click", () => {
    formAddBike.style.display = "none";
    displayGarages.style.display = "block"; // Fait réapparaitre le garage
  });
}
