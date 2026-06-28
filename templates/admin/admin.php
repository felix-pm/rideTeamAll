<?php require_once __DIR__ . '/../Partials/head.php'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<main class="admin-dashboard">
    <div class="admin-header">
        <h1>Dashboard Administrateur</h1>
        <p>Aperçu global de l'activité de RideTeam</p>
    </div>

    <div class="kpi-grid">
        <div class="kpi-card glow-blue">
            <div class="kpi-icon"><i class="fa-solid fa-users"></i></div>
            <div class="kpi-content">
                <h3><?= $userStats['total'] ?></h3>
                <p>Membres inscrits</p>
                <div class="kpi-substats">
                    <span><i class="fa-solid fa-arrow-trend-up"></i> +<?= $userStats['today'] ?> ajd</span>
                    <span>• +<?= $userStats['month'] ?> ce mois</span>
                </div>
            </div>
        </div>

        <div class="kpi-card glow-orange">
            <div class="kpi-icon"><i class="fa-solid fa-motorcycle"></i></div>
            <div class="kpi-content">
                <h3><?= $rideStats['total'] ?></h3>
                <p>Balades créées</p>
                <div class="kpi-substats">
                    <span class="text-orange"><i class="fa-solid fa-fire"></i> <?= $rideStats['active'] ?> en cours/à venir</span>
                </div>
            </div>
        </div>

        <div class="kpi-card glow-green">
            <div class="kpi-icon"><i class="fa-solid fa-comments"></i></div>
            <div class="kpi-content">
                <h3><?= $messageStats['total'] ?></h3>
                <p>Messages envoyés</p>
                <div class="kpi-substats">
                    <span><i class="fa-solid fa-bolt"></i> +<?= $messageStats['today'] ?> ajd</span>
                    <span>• +<?= $messageStats['month'] ?> ce mois</span>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="dashboard-main">
            <div class="admin-panel-card">
                <div class="card-header">
                    <h2>Croissance des utilisateurs</h2>
                </div>
                <div style="position: relative; height: 300px;">
                    <canvas id="usersChart"></canvas>
                </div>
            </div>

            <div class="admin-panel-card">
                <div class="card-header">
                    <h2>Gestion des membres</h2>
                    <form action="index.php" method="get" class="admin-search-form">
                        <input type="hidden" name="route" value="admin">
                        <input type="text" name="rechercheUser-admin" placeholder="Pseudo ou email..." value="<?= htmlspecialchars($keywordUser) ?>">
                        <button type="submit"><i class="fa-solid fa-search"></i></button>
                    </form>
                </div>
                <div class="list-container">
                    <?php foreach ($users as $user): ?>
                        <div class="list-item">
                            <div class="item-details">
                                <strong><?= htmlspecialchars($user->getPseudo()) ?></strong>
                                <span><?= htmlspecialchars($user->getEmail()) ?></span>
                                <span class="role-badge <?= strtolower($user->getRole()) ?>"><?= $user->getRole() ?></span>
                            </div>
                            <div class="item-actions">
                                <a href="index.php?route=user_profile&id=<?= $user->getId() ?>" class="btn-action"><i class="fa-solid fa-eye"></i></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="admin-panel-card">
                <div class="card-header">
                    <h2>Gestion des balades</h2>
                    <form action="index.php" method="get" class="admin-search-form">
                        <input type="hidden" name="route" value="admin">
                        <input type="text" name="recherche-balade_admin" placeholder="Titre, ville..." value="<?= htmlspecialchars($keywordRide) ?>">
                        <button type="submit"><i class="fa-solid fa-search"></i></button>
                    </form>
                </div>
                <div class="list-container">
                    <?php foreach ($rides as $ride): ?>
                        <div class="list-item">
                            <div class="item-details">
                                <strong><?= htmlspecialchars($ride->getTitle()) ?></strong>
                                <span><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($ride->getStart_location()) ?> • <i class="fa-regular fa-calendar"></i> <?= htmlspecialchars($ride->getStart_date()) ?></span>
                            </div>
                            <div class="item-actions">
                                <a href="index.php?route=ride&id=<?= $ride->getId() ?>" class="btn-action"><i class="fa-solid fa-eye"></i></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="dashboard-side">
            <div class="admin-panel-card map-card" style="height: 100%; min-height: 500px;">
                <div class="card-header">
                    <h2>Carte Globale des Balades</h2>
                </div>
                <div id="admin-map" style="width: 100%; height: calc(100% - 60px); border-radius: 8px; z-index: 1;"></div>
            </div>
        </div>
    </div>
</main>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const ctx = document.getElementById('usersChart').getContext('2d');
    const chartDataRaw = <?= $chartData ?>;
    
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(240, 90, 48, 0.5)');
    gradient.addColorStop(1, 'rgba(240, 90, 48, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartDataRaw.labels,
            datasets: [{
                label: 'Nouveaux inscrits',
                data: chartDataRaw.data,
                borderColor: '#f05a30',
                backgroundColor: gradient,
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#151521',
                pointBorderColor: '#f05a30',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });

    const adminMap = L.map("admin-map").setView([46.6, 2.5], 5);
    L.tileLayer("https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png").addTo(adminMap);

    const ridesData = <?= $mapRides ?>;
    
    const adminIcon = L.divIcon({
      className: "custom-icon-wrapper",
      html: `<div style="background-color: var(--accent-orange); width: 20px; height: 20px; border-radius: 50%; border: 3px solid #151521; box-shadow: 0 0 10px rgba(240,90,48,0.8);"></div>`,
      iconSize: [20, 20],
      iconAnchor: [10, 10]
    });

    ridesData.forEach((ride) => {
        let lat = parseFloat(ride.start_latitude);
        let lng = parseFloat(ride.start_longitude);
        if (!isNaN(lat) && !isNaN(lng)) {
            L.marker([lat, lng], { icon: adminIcon }).addTo(adminMap)
             .bindPopup(`<b>${ride.title}</b><br><a href="index.php?route=ride&id=${ride.id}" style="color: #f05a30;">Voir la balade</a>`);
        }
    });
});
</script>