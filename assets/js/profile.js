// ! Affichage du garage
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

      const imageElement = document.createElement("img"); // ! <i class="fa-solid fa-trash-can"></i>    <i class="fa-solid fa-gear"></i>

      imageElement.src = bike.url ? bike.url : "assets/img/default-bike.avif";

      imageElement.alt = `Photo de ${bike.marque}`;
      imageElement.classList.add("bike-img");
      cardBike.appendChild(imageElement);
      // -----------------------------------

      const trash = document.createElement("i");
      trash.classList.add("fa-solid", "fa-trash-can");

      const setting = document.createElement("i");
      setting.classList.add("fa-solid", "fa-gear");

      const marque = document.createElement("p");
      marque.classList.add("bike-marque");

      const modele = document.createElement("p");
      modele.classList.add("bike-modele");

      const annee = document.createElement("p");
      annee.classList.add("bike-annee");

      marque.textContent = `Marque : ${bike.marque}`;
      modele.textContent = `Modèle : ${bike.modele}`;
      annee.textContent = `Année : ${bike.annee}`;

      cardBike.appendChild(trash);
      cardBike.appendChild(setting);
      cardBike.appendChild(marque);
      cardBike.appendChild(modele);
      cardBike.appendChild(annee);

      bikeContainer.appendChild(cardBike);
    });
  })
  .catch((error) => {
    console.error("Erreur de récupération :", error);
    bikeContainer.textContent = "Erreur lors du chargement.";
  });

// On sélectionne tous les boutons d'onglets
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
