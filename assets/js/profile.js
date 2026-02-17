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

const buttonChat = document.getElementById("flex-chat");
const pageChat = document.getElementById("display-chat");
buttonChat.addEventListener("click", () => {
  pageProfil.style.display = "none";
  btnLogout.style.display = "none";
  pageChat.style.display = "block";
});

const btnBackChat = document.getElementById("btn-back-chat");
btnBackChat.addEventListener("click", () => {
  pageChat.style.display = "none";
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

// !
// --- GESTION DES ONGLETS "MES BALADES" ---

const tabPassees = document.getElementById("tab-passees");
const tabFutures = document.getElementById("tab-futures");
const contentPassees = document.getElementById("content-passees");
const contentFutures = document.getElementById("content-futures");

if (tabPassees && tabFutures) {
  // Clic sur l'onglet "Passées"
  tabPassees.addEventListener("click", () => {
    // Si l'onglet est déjà actif, on ne fait rien
    if (tabPassees.classList.contains("active-tab")) return;

    // 1. Mettre à jour le style des titres (onglets)
    tabPassees.classList.add("active-tab");
    tabFutures.classList.remove("active-tab");

    // 2. Animer les contenus
    // Le contenu "Passées" arrive par la gauche pour se centrer
    contentPassees.classList.remove("exit-left", "exit-right");
    contentPassees.classList.add("active-content");

    // Le contenu "Futures" s'en va vers la droite
    contentFutures.classList.remove("active-content");
    contentFutures.classList.add("exit-right");
  });

  // Clic sur l'onglet "Futures"
  tabFutures.addEventListener("click", () => {
    // Si l'onglet est déjà actif, on ne fait rien
    if (tabFutures.classList.contains("active-tab")) return;

    // 1. Mettre à jour le style des titres (onglets)
    tabFutures.classList.add("active-tab");
    tabPassees.classList.remove("active-tab");

    // 2. Animer les contenus
    // Le contenu "Futures" arrive par la droite pour se centrer
    contentFutures.classList.remove("exit-left", "exit-right");
    contentFutures.classList.add("active-content");

    // Le contenu "Passées" s'en va vers la gauche
    contentPassees.classList.remove("active-content");
    contentPassees.classList.add("exit-left");
  });
}

const buttonAddBike = document.getElementById("button-add-bike");
const pageAddBike = document.getElementById("add-bike");
buttonAddBike.addEventListener("click", () => {
  pageGarage.style.display = "none";
  pageAddBike.style.display = "block";
});

const buttonBackAddBike = document.getElementById("btn-back-add-bike");
buttonBackAddBike.addEventListener("click", () => {
  pageGarage.style.display = "block";
  pageAddBike.style.display = "none";
});

// ! Affichage du garage
document.addEventListener("DOMContentLoaded", () => {
  const bikeContainer = document.getElementById("bikes-container");

  // 1. On appelle notre route PHP (le livreur)
  fetch("index.php?route=api_bikes")
    .then((response) => response.json()) // 2. On traduit la réponse texte en Objet JS
    .then((data) => {
      // 3. On vide le message "Chargement..."
      bikeContainer.innerHTML = "";

      if (data.length === 0) {
        bikeContainer.textContent =
          "Aucune moto dans votre garage pour le moment...";
        return;
      }

      data.forEach((bike) => {
        const cardBike = document.createElement("div");
        cardBike.classList.add("bike-card");

        const marque = document.createElement("p");
        const modele = document.createElement("p");
        const annee = document.createElement("p");

        marque.textContent = bike.marque;
        modele.textContent = bike.modele;
        annee.textContent = bike.annee;

        // --- ÉTAPE C : Assemblage (on met les textes dans la carte) ---
        cardBike.appendChild(marque);
        cardBike.appendChild(modele);
        cardBike.appendChild(annee);

        // --- ÉTAPE D : Livraison (on met la carte dans la page web) ---
        bikeContainer.appendChild(cardBike);
      });
    })
    .catch((error) => {
      console.error("Erreur de récupération :", error);
      bikeContainer.textContent = "Erreur lors du chargement.";
    });
});
