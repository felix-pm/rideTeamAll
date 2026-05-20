document.addEventListener("DOMContentLoaded", () => {
  const container = document.getElementById("rides-container");

  fetch("index.php?route=api_rides")
    .then((response) => response.json())
    .then((data) => {
      container.innerHTML = "";

      if (data.length === 0) {
        container.textContent = "Aucune balade pour le moment.";
        return;
      }

      data.forEach((ride, index) => {
        const card = document.createElement("a");
        card.classList.add("ride-card");
        card.href = `index.php?route=ride&id=${ride.id}`;

        const imageWrapper = document.createElement("div");
        imageWrapper.classList.add("card-image-wrapper");

        const img = document.createElement("img");
        img.classList.add("card-img");
        img.src = `https://picsum.photos/400/200?random=${index}`;
        img.alt = "Image de la balade";

        // --- DÉBUT DE LA MODIFICATION POUR LA DIFFICULTÉ ---
        const badge = document.createElement("span");
        badge.classList.add("badge");

        let diffValue = ride.difficultyLevel;
        let badgeText = "Inconnu";
        let diffClass = "badge-medium"; // Classe par défaut

        // Si ta BDD renvoie un nombre entier (ex: 1 = Facile, 2 = Moyen, 3 = Difficile)
        if (typeof diffValue === "number" || !isNaN(diffValue)) {
          const intDiff = parseInt(diffValue);
          if (intDiff === 1) {
            badgeText = "Facile";
            diffClass = "badge-easy";
          } else if (intDiff === 2) {
            badgeText = "Moyen";
            diffClass = "badge-medium";
          } else if (intDiff >= 3) {
            badgeText = "Difficile";
            diffClass = "badge-hard";
          }
        }
        // Si finalement ta BDD renvoie du texte (au cas où tu changes ton format)
        else if (typeof diffValue === "string") {
          badgeText = diffValue.charAt(0).toUpperCase() + diffValue.slice(1); // Majuscule au début
          const lowerString = diffValue.toLowerCase();

          if (lowerString === "difficile") {
            diffClass = "badge-hard";
          } else if (lowerString === "facile") {
            diffClass = "badge-easy";
          } else {
            diffClass = "badge-medium";
          }
        }

        // On assigne le texte et la bonne classe
        badge.textContent = badgeText;
        badge.classList.add(diffClass);
        // --- FIN DE LA MODIFICATION ---

        imageWrapper.appendChild(img);
        imageWrapper.appendChild(badge);

        const content = document.createElement("div");
        content.classList.add("card-content");

        const title = document.createElement("h3");
        title.textContent = ride.title;

        const author = document.createElement("p");
        author.classList.add("author");
        author.textContent = `${ride.getOrganizerId} A REMPLACER PAR LE NOM`;

        const date = document.createElement("div");
        date.classList.add("info-row");
        date.innerHTML = `<i class="fa-regular fa-calendar"></i> <span>${ride.date}</span>`;

        const location = document.createElement("div");
        location.classList.add("info-row");
        location.innerHTML = `<i class="fa-solid fa-location-dot"></i> <span>${ride.startLocation}</span>`;

        const nbParticipants = document.createElement("div");
        nbParticipants.classList.add("participants-row");
        nbParticipants.innerHTML = `
            <i class="fa-solid fa-user-group"></i>
            <div class="avatars">
                <div class="avatar"></div>
                <div class="avatar"></div>
                <div class="avatar"></div>
            </div>
            <span>... / ${ride.getMaxParticipants || 12} participants</span>
        `;

        content.appendChild(title);
        content.appendChild(author);
        content.appendChild(date);
        content.appendChild(location);
        content.appendChild(nbParticipants);

        card.appendChild(imageWrapper);
        card.appendChild(content);

        container.appendChild(card);
      });
    })
    .catch((error) => {
      console.error("Erreur de récupération :", error);
      container.textContent =
        "Erreur lors du chargement. Vérifie la console de ton navigateur.";
    });
});
