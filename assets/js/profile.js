document.addEventListener("DOMContentLoaded", () => {
  //! 1. Gestion du bouton de partage du profil
  const shareProfileBtn = document.getElementById("btn-share-profile");
  if (shareProfileBtn) {
    shareProfileBtn.addEventListener("click", async (e) => {
      e.preventDefault();
      const shareUrl = shareProfileBtn.getAttribute("data-url");
      const shareTitle = shareProfileBtn.getAttribute("data-title");

      if (navigator.share) {
        try {
          await navigator.share({
            title: "RideTeam",
            text: shareTitle,
            url: shareUrl,
          });
        } catch (err) {
          console.log("Partage annulé ou échoué :", err);
        }
      } else {
        try {
          await navigator.clipboard.writeText(shareUrl);
          alert("Le lien de ton profil a été copié dans le presse-papier !");
        } catch (err) {
          console.error("Erreur lors de la copie :", err);
        }
      }
    });
  }

  //! 2. Gestion des onglets (balades futures ou passées)
  const tabButtons = document.querySelectorAll(".tab-btn");
  const tabPanels = document.querySelectorAll(".tab-panel");

  tabButtons.forEach((button) => {
    button.addEventListener("click", () => {
      tabButtons.forEach((btn) => btn.classList.remove("active"));
      tabPanels.forEach((panel) => panel.classList.remove("active"));

      button.classList.add("active");
      const targetTab = button.getAttribute("data-tab");
      document.getElementById(targetTab).classList.add("active");
    });
  });

  //! 3. Affichage/Masquage du formulaire classique d'ajout de moto
  const btnAddBike = document.getElementById("button-add-bike");
  const formAddBike = document.getElementById("add-bike");
  const btnBackAddBike = document.getElementById("btn-back-add-bike");
  const displayGarages = document.getElementById("display-garages");

  if (btnAddBike && formAddBike) {
    btnAddBike.addEventListener("click", () => {
      formAddBike.style.display = "block";
      displayGarages.style.display = "none";
    });

    btnBackAddBike.addEventListener("click", () => {
      formAddBike.style.display = "none";
      displayGarages.style.display = "block";
    });
  }

  //! 4. Modale de modification des informations du compte utilisateur
  const profileModal = document.getElementById("settings-modal");
  const openProfileBtn = document.getElementById("open-settings-btn");
  const closeProfileBtn = document.getElementById("close-settings-btn");

  if (openProfileBtn && profileModal) {
    openProfileBtn.addEventListener("click", (e) => {
      e.preventDefault();
      profileModal.style.display = "flex";
    });
  }

  if (closeProfileBtn && profileModal) {
    closeProfileBtn.addEventListener("click", () => {
      profileModal.style.display = "none";
    });
  }

  //! 5. Modales de modification des motos
  const openBikeBtns = document.querySelectorAll(".open-edit-bike-btn");
  const closeBikeBtns = document.querySelectorAll(".close-edit-bike-btn");

  openBikeBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      const targetId = btn.getAttribute("data-target");
      const modal = document.getElementById(targetId);
      if (modal) {
        modal.style.display = "flex";
      }
    });
  });

  closeBikeBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      const modal = btn.closest(".edit-bike-modal");
      if (modal) {
        modal.style.display = "none";
      }
    });
  });

  //! 6. Modales de modification de balades (Calqué sur les motos)
  const openEditRideBtns = document.querySelectorAll(".open-edit-ride-btn");
  const closeEditRideBtns = document.querySelectorAll(".close-edit-ride-btn");

  openEditRideBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      const targetId = btn.getAttribute("data-target");
      const modal = document.getElementById(targetId);
      if (modal) {
        modal.style.display = "flex";
      }
    });
  });

  closeEditRideBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      const modal = btn.closest(".edit-ride-modal");
      if (modal) {
        modal.style.display = "none";
      }
    });
  });

  //! 7. Fermeture globale lors d'un clic en dehors d'une fenêtre ouverte
  window.addEventListener("click", (e) => {
    if (e.target === profileModal) {
      profileModal.style.display = "none";
    }
    if (e.target.classList.contains("edit-bike-modal")) {
      e.target.style.display = "none";
    }
    if (e.target.classList.contains("edit-ride-modal")) {
      e.target.style.display = "none";
    }
  });
});

// Validation JS des mots de passe
function validatePassword() {
  const password = document.getElementById("password").value;
  const confirmPassword = document.getElementById("confirmPassword").value;

  if (password !== "" && password !== confirmPassword) {
    alert("Les mots de passe ne correspondent pas !");
    return false;
  }
  return true;
}
