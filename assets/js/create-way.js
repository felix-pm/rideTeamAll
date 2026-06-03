function setupAutocomplete(inputId, resultsId, latId, lonId) {
  const input = document.getElementById(inputId);
  const results = document.getElementById(resultsId);
  const latInput = document.getElementById(latId);
  const lonInput = document.getElementById(lonId);
  let debounceTimer;

  input.addEventListener("input", () => {
    clearTimeout(debounceTimer);

    debounceTimer = setTimeout(async () => {
      const query = input.value.trim();

      if (query.length < 3) {
        results.innerHTML = "";
        return;
      }

      try {
        // Appel direct à l'API Nominatim (OpenStreetMap)
        const response = await fetch(
          `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=5`,
        );
        const places = await response.json();

        results.innerHTML = "";

        places.forEach((place) => {
          const li = document.createElement("li");
          li.textContent = place.display_name;

          li.addEventListener("click", () => {
            input.value = place.name || place.display_name.split(",")[0].trim();
            latInput.value = place.lat;
            lonInput.value = place.lon;

            results.innerHTML = "";
          });
          results.appendChild(li);
        });
      } catch (error) {
        console.error("Erreur autocomplete:", error);
      }
    }, 300);
  });

  document.addEventListener("click", (e) => {
    if (!input.contains(e.target)) results.innerHTML = "";
  });
}

setupAutocomplete(
  "start_location",
  "start_results",
  "start_latitude",
  "start_longitude",
);
setupAutocomplete(
  "end_location",
  "end_results",
  "end_latitude",
  "end_longitude",
);
