// Initialisation de la carte
const map = L.map("map").setView([46.6, 2.5], 6);

L.tileLayer("https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png", {
  attribution:
    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
  subdomains: "abcd",
  maxZoom: 20,
}).addTo(map);

let routeLayer = null;
let currentSteps = [];

setTimeout(() => {
  map.invalidateSize();
}, 100);

// On crée notre icône en HTML/CSS
const prettyIcon = L.divIcon({
  // En mettant une classe vide ou personnalisée, on annule le carré blanc par défaut de Leaflet
  className: "custom-icon-wrapper",

  // Notre structure HTML (Le marqueur + la pulsation)
  html: `
    <div style="position: relative;">
        <div class="marker-pulse"></div>
        <div class="beautiful-marker">🏍️</div>
    </div>
  `,

  // Paramétrages de position
  iconSize: [36, 36], // Taille totale
  iconAnchor: [18, 18], // Le point exact qui touche la carte (le centre)
  popupAnchor: [0, -22], // Où la popup s'ouvre par rapport au marqueur
});

// Votre boucle modifiée
if (typeof ridesData !== "undefined") {
  ridesData.forEach((ride) => {
    let lat = parseFloat(ride.start_latitude);
    let lng = parseFloat(ride.start_longitude);

    if (!isNaN(lat) && !isNaN(lng)) {
      // On utilise prettyIcon ici
      L.marker([lat, lng], { icon: prettyIcon }).addTo(map).bindPopup(`
        <b>${ride.title}</b>
        <a href="index.php?route=ride&id=${ride.id}" class="custom-popup-btn">
            Voir la balade
        </a>
      `);
    }
  });
}
