<?php require_once __DIR__ . '/../Partials/head.php'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div style="position: relative; width: 100%; height: 110vh;">
    
    <img id="img-map" src="assets/img/favicon.png" alt="RideTeam Logo" style="width: 75px; height: 75px; border-radius: 8px; object-fit: cover; flex-shrink: 0;">
    
    <div id="map" style="height: 100%; width: 100%;"></div>

</div>

<script>
    const ridesData = <?= json_encode($rides) ?>;
</script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="assets/js/map.js"></script>