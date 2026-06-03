<?php require_once __DIR__ . '/../Partials/head.php'; ?>
<?php require_once __DIR__ . '/../Partials/header.php'; ?>

<main id="app-container" class="admin-dashboard">
    <div class="admin-header">
        <h1>Dashboard Administrateur</h1>
        <p>Gérez les balades, les utilisateurs et les signalements.</p>
    </div>

    <section class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon pulse-green"><i class="fa-solid fa-motorcycle"></i></div>
            <div class="stat-info">
                <h3><?= $stats['active_rides'] ?></h3>
                <p>Balades actives</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pulse-blue"><i class="fa-solid fa-users"></i></div>
            <div class="stat-info">
                <h3><?= $stats['total_users'] ?></h3>
                <p>Utilisateurs totaux (dont <?= $stats['users_last_month'] ?> ce mois)</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pulse-blue"><i class="fa-solid fa-route"></i></div>
            <div class="stat-info">
                <h3><?= $stats['rides_last_month'] ?></h3>
                <p>Balades créées ce mois</p>
            </div>
        </div>
        <div class="stat-card alert-card">
            <div class="stat-icon pulse-red"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div class="stat-info">
                <h3><?= $stats['pending_reports'] ?></h3>
                <p>Signalements en attente</p>
            </div>
        </div>
    </section>

    <section class="content-grid">
        
        <div class="lists-column">
            
            <div class="admin-panel-card">
                <div class="card-header">
                    <h2>Balades en cours</h2>
                    <form action="index.php" method="GET" class="admin-search-form">
                        <input type="hidden" name="route" value="admin">
                        <input type="text" name="recherche-balade_admin" placeholder="Rechercher une balade..." value="<?= htmlspecialchars($keywordRide ?? '') ?>">
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>
                <div class="list-container">
                    <?php if(!empty($rides)): ?>
                        <?php foreach($rides as $ride): ?>
                            <div class="list-item">
                                <div class="item-details">
                                    <strong><?= htmlspecialchars($ride->getTitle()) ?></strong>
                                    <span><?= htmlspecialchars($ride->getStart_location()) ?> ➔ <?= htmlspecialchars($ride->getEnd_location()) ?></span>
                                </div>
                                <a href="index.php?route=ride&id=<?= $ride->getId() ?>" class="btn-action">Voir</a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="empty-state">Aucune balade trouvée.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="admin-panel-card">
                <div class="card-header">
                    <h2>Utilisateurs</h2>
                    <form action="index.php" method="GET" class="admin-search-form">
                        <input type="hidden" name="route" value="admin">
                        <input type="text" name="rechercheUser-admin" placeholder="Rechercher un pseudo..." value="<?= htmlspecialchars($keywordUser ?? '') ?>">
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>
                <div class="list-container">
                    <?php if(!empty($users)): ?>
                        <?php foreach($users as $user): ?>
                            <div class="list-item">
                                <div class="item-details">
                                    <strong><?= htmlspecialchars($user->getPseudo()) ?></strong>
                                    <span class="role-badge <?= strtolower($user->getRole()) ?>"><?= htmlspecialchars($user->getRole()) ?></span>
                                </div>
                                <a href="index.php?route=user_profile&id=<?= $user->getId() ?>" class="btn-action">Gérer</a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="empty-state">Aucun utilisateur trouvé.</p>
                    <?php endif; ?>
                </div>
            </div>
            
        </div>

        <div class="map-column">
            <div class="admin-panel-card map-widget" id="map-widget-container">
                <h2>Carte globale</h2>
                <div class="map-wrapper">
                    <div id="map" style="width: 100%; height: 100%; border-radius: 8px;"></div>
                    
                    <button class="expand-map-btn" id="expandMapBtn" title="Agrandir la carte">
                        <i class="fa-solid fa-expand"></i>
                    </button>
                </div>
            </div>
        </div>

    </section>
</main>

<link rel="stylesheet" href="assets/css/admin.css">

<script src="assets/js/admin.js" defer></script>
<script src="assets/js/map.js" defer></script>