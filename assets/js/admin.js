document.addEventListener("DOMContentLoaded", () => {
  const expandBtn = document.getElementById("expandMapBtn");
  const mapWidget = document.getElementById("map-widget-container");
  const icon = expandBtn.querySelector("i");

  expandBtn.addEventListener("click", () => {
    // Active ou désactive le mode plein écran
    mapWidget.classList.toggle("fullscreen-mode");

    // Change l'icone
    if (mapWidget.classList.contains("fullscreen-mode")) {
      icon.classList.replace("fa-expand", "fa-compress");
    } else {
      icon.classList.replace("fa-compress", "fa-expand");
    }

    // Si tu utilises Leaflet, Mapbox ou Google Maps, il est souvent nécessaire de
    // dire à la carte de se redimensionner quand son parent change de taille.
    // Si tu utilises Leaflet, décommente la ligne ci-dessous :
    // setTimeout(() => { map.invalidateSize(); }, 300);
  });
});
