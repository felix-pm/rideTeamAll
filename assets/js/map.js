// Initialisation de la carte
const map = L.map("map").setView([46.6, 2.5], 6);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution: "© OpenStreetMap",
}).addTo(map);

let routeLayer = null;
let currentSteps = [];

setTimeout(() => {
  map.invalidateSize();
}, 100);

const flagIcon = L.icon({
  iconUrl: "assets/img/flag-depart.png",
  iconSize: [32, 32],
  iconAnchor: [16, 32],
  popupAnchor: [0, -32],
});

if (typeof ridesData !== "undefined") {
  ridesData.forEach((ride) => {
    let lat = parseFloat(ride.start_latitude);
    let lng = parseFloat(ride.start_longitude);

    if (!isNaN(lat) && !isNaN(lng)) {
      L.marker([lat, lng], { icon: flagIcon }).addTo(map).bindPopup(`
        <b>${ride.title}</b><br>
        <a href="${"//felix-pm.fr/"}" style="color: blue; text-decoration: underline;">
            Cliquez pour voir la balade.
        </a>
    `);
    }
  });
}
