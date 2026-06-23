document.addEventListener("DOMContentLoaded", () => {
  const messagesContainer = document.getElementById("chat-messages");
  const chatForm = document.getElementById("chat-form");

  // Si le formulaire n'existe pas (visiteur non connecté), on arrête le script
  if (!chatForm) {
    if (messagesContainer)
      messagesContainer.scrollTop = messagesContainer.scrollHeight;
    return;
  }

  // Récupération des données utilisateur fournies par le HTML/PHP
  const rideId = document.getElementById("chat-ride-id").value;
  const userId = document.getElementById("chat-user-id").value;
  const pseudo = document.getElementById("chat-user-pseudo").value;
  const avatar = document.getElementById("chat-user-avatar").value;
  const chatInput = document.getElementById("chat-input");

  // 1. Connexion au serveur Ratchet
  const socket = new WebSocket("ws://localhost:8080");

  // Dès que la connexion s'ouvre, on dit au serveur "Je rejoins la balade X"
  socket.onopen = () => {
    console.log("Connecté au serveur de chat !");
    socket.send(
      JSON.stringify({
        action: "join",
        ride_id: rideId,
      }),
    );
  };

  // 2. Écoute des messages renvoyés par le serveur
  socket.onmessage = (event) => {
    const data = JSON.parse(event.data);

    // Sécurité côté client : on s'assure que le message est bien destiné à cette balade
    if (data.ride_id == rideId) {
      appendNewMessage(data);
    }
  };

  socket.onclose = () => {
    console.log("Déconnecté du serveur de chat.");
  };

  // 3. Soumission du formulaire (Envoi d'un message)
  chatForm.addEventListener("submit", (e) => {
    e.preventDefault(); // Bloque le rechargement de la page !

    const content = chatInput.value.trim();
    if (content === "") return;

    // On envoie l'objet en JSON au serveur WebSocket
    socket.send(
      JSON.stringify({
        action: "message",
        ride_id: rideId,
        user_id: userId,
        pseudo: pseudo,
        avatar: avatar,
        content: content,
      }),
    );

    chatInput.value = ""; // Vide le champ de texte
  });

  // Fonction pour ajouter le message dynamiquement au DOM
  function appendNewMessage(data) {
    const messageDiv = document.createElement("div");
    messageDiv.classList.add("chat-message");

    messageDiv.innerHTML = `
            <img src="${data.avatar}" class="chat-avatar" alt="Avatar">
            <div class="message-content">
                <span class="message-author">${data.pseudo}</span>
                <p class="message-text">${data.content}</p>
            </div>
        `;

    messagesContainer.appendChild(messageDiv);
    // Scroll automatique vers le bas pour voir le dernier message
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
  }

  // Scroll initial au chargement de la page
  messagesContainer.scrollTop = messagesContainer.scrollHeight;
});
