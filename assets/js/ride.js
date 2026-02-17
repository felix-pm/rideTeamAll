// On attend que la page HTML soit chargée
document.addEventListener("DOMContentLoaded", () => {
  const container = document.getElementById("rides-container");

  // 1. On appelle notre route PHP (le livreur)
  fetch("index.php?route=api_rides")
    .then((response) => response.json()) // 2. On traduit la réponse texte en Objet JS
    .then((data) => {
      container.innerHTML = "";

      if (data.length === 0) {
        container.textContent = "Aucune balade pour le moment.";
        return;
      }
      data.forEach((ride) => {
        // ! card pour afficher toutes les balades
        const card = document.createElement("div");
        card.classList.add("ride-card");

        // ! récupération des données pour l'affichage principal
        const title = document.createElement("h3");
        title.textContent = ride.title;

        const location = document.createElement("p");
        location.classList.add("location-card");
        location.textContent = `${ride.startLocation} -> ${ride.endLocation}`;

        const date = document.createElement("p");
        date.classList.add("date-card");
        date.textContent = `Prévue le : ${ride.date}`;

        const nbParticipants = document.createElement("p");
        nbParticipants.classList.add("date-card");
        nbParticipants.textContent = `Nombre de participants : /${ride.getMaxParticipants}`;

        const buttonDetails = document.createElement("button");
        buttonDetails.textContent = "Voir les détails";

        card.appendChild(title);
        card.appendChild(location);
        card.appendChild(date);
        card.appendChild(nbParticipants);
        card.appendChild(buttonDetails);
        container.appendChild(card);

        buttonDetails.addEventListener("click", () => {
          modal.style.display = "block";
        });

        // ! modal pour afficher tous les détails de la balade
        const modal = document.createElement("div");
        modal.classList.add("ride-modal");
        modal.style.display = "none";

        // ! récupération des données pour l'affichage du modal
        const buttonBack = document.createElement("button");
        buttonBack.classList.add("btn-back-modal");
        buttonBack.textContent = "<";

        const titleModal = document.createElement("h3");
        titleModal.textContent = ride.title;

        const locationModal = document.createElement("p");
        locationModal.classList.add("location-modal");
        locationModal.textContent = `${ride.startLocation} -> ${ride.endLocation}`;

        const dateModal = document.createElement("p");
        dateModal.classList.add("date-modal");
        dateModal.textContent = `Prévue le : ${ride.date}`;

        const description = document.createElement("p");
        description.classList.add("description-modal");
        description.textContent = ride.description;

        const startHour = document.createElement("p");
        startHour.classList.add("hour-modal");
        startHour.textContent = `Départ à ${ride.startHour}`;

        const difficultyLevel = document.createElement("p");
        difficultyLevel.classList.add("level-modal");
        difficulty = "";
        if (ride.difficultyLevel === 1) {
          difficulty = "Chill (débutant)";
        } else if (ride.difficultyLevel === 2) {
          difficulty = "rythmé (intermédiaire)";
        } else {
          difficulty = "Sport (expert)";
        }
        difficultyLevel.textContent = `Niveau : ${difficulty}`;

        const maxParticipants = document.createElement("p");
        maxParticipants.classList.add("participants-modal");
        maxParticipants.textContent = `Nombre de participants max : ${ride.getMaxParticipants}`;

        const organizerId = document.createElement("p");
        organizerId.classList.add("organizer-modal");
        organizerId.textContent = `Organisé par : ${ride.getOrganizerId}`;

        const buttonParticipants = document.createElement("button");
        buttonParticipants.classList.add("btn-participants-modal");
        buttonParticipants.textContent = "Voir les participants";

        const buttonJoin = document.createElement("button");
        buttonJoin.classList.add("btn-join-modal");
        buttonJoin.textContent = "Rejoindre";

        buttonBack.addEventListener("click", () => {
          modal.style.display = "none";
        });

        modal.appendChild(buttonBack);
        modal.appendChild(titleModal);
        modal.appendChild(locationModal);
        modal.appendChild(dateModal);
        modal.appendChild(description);
        modal.appendChild(startHour);
        modal.appendChild(difficultyLevel);
        modal.appendChild(maxParticipants);
        modal.appendChild(organizerId);
        modal.appendChild(buttonParticipants);
        modal.appendChild(buttonJoin);
        container.appendChild(modal);
      });
    })
    .catch((error) => {
      console.error("Erreur de récupération :", error);
      container.textContent = "Erreur lors du chargement.";
    });
});
