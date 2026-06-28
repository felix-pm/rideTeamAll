document.addEventListener("DOMContentLoaded", () => {
  const expandBtn = document.getElementById("expandMapBtn");
  const mapWidget = document.getElementById("map-widget-container");
  const icon = expandBtn.querySelector("i");

  expandBtn.addEventListener("click", () => {
    // Active ou désactive le mode plein écran
    mapWidget.classList.toggle("fullscreen-mode");

    if (mapWidget.classList.contains("fullscreen-mode")) {
      icon.classList.replace("fa-expand", "fa-compress");
    } else {
      icon.classList.replace("fa-compress", "fa-expand");
    }
  });
});
