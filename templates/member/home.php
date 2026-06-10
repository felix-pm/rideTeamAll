<?php require_once __DIR__ . '/../Partials/head.php'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<main id="app-container" class="home-main">
    
    <header class="app-header">
        <div class="header-content">
            <form action="index.php" method="get" style="display: flex;">
                <input type="hidden" name="route" value="home"> 
                
                <div class="search-container">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" autocomplete="off" name="recherche" placeholder="Rechercher..." value="<?= htmlspecialchars($keyword ?? '') ?>">
                </div>
                <button type="submit" class="btn-sent-home"><i class="fa-solid fa-paper-plane"></i></button>
            </form>
            
            <h1>Les balades à venir</h1>
            <p>Trouve ta prochaine balade !</p>
        </div>
    </header>

    <div class="container">
        <div class="menu-header">
            <button class="tab-btn-switch active" data-tab="tab-avenir">Découvrir</button>
            <button class="tab-btn-switch" data-tab="tab-passees">Abonné(e)s</button>
        </div>

        <div class="tabs-content">
            <div id="tab-avenir" class="tab-second active">
                <section class="rides-wrapper">
                    <div id="rides-container">
                        <?php if (empty($rides)): ?>
                            <p style="text-align: center; color: var(--text-grey); padding: 20px; margin-top: 50%;">Aucune balade pour le moment.</p>
                        <?php else: ?>
                            <?php foreach ($rides as $index => $ride): ?>
                                <?php
                                $diffValue = $ride->getDifficulty_level();
                                $badgeText = "Inconnu";
                                $diffClass = "badge-medium";

                                if (is_numeric($diffValue)) {
                                    $intDiff = (int)$diffValue;
                                    if ($intDiff === 1) {
                                        $badgeText = "Facile";
                                        $diffClass = "badge-easy";
                                    } elseif ($intDiff === 2) {
                                        $badgeText = "Moyen";
                                        $diffClass = "badge-medium";
                                    } elseif ($intDiff >= 3) {
                                        $badgeText = "Difficile";
                                        $diffClass = "badge-hard";
                                    }
                                }

                                $dateValue = $ride->getStart_date();
                                $dateBdd = new DateTime($dateValue);
                                
                                $dateFormatter = new IntlDateFormatter(
                                    'fr_FR', 
                                    IntlDateFormatter::LONG, 
                                    IntlDateFormatter::NONE
                                );
                                $dateFinal = $dateFormatter->format($dateBdd);
                                ?>

                                <a class="ride-card" href="index.php?route=ride&id=<?= htmlspecialchars($ride->getId()) ?>">
                                    <div class="card-image-wrapper">
                                        <img class="card-img" src="https://picsum.photos/400/200?random=<?= $index ?>" alt="Image de la balade">
                                        <span class="badge <?= $diffClass ?>"><?= htmlspecialchars($badgeText) ?></span>
                                    </div>
                                    
                                    <div class="card-content">
                                        <h3><?= htmlspecialchars($ride->getTitle()) ?></h3>
                                        
                                        <p class="author"><?= htmlspecialchars($ride->getOrganizer_pseudo()) ?></p>
                                        
                                        <div class="info-row">
                                            <i class="fa-regular fa-calendar"></i> 
                                            <span><?= $dateFinal ?> à <?= htmlspecialchars(substr($ride->getStart_hour(), 0, 5)) ?></span>
                                        </div>
                                        
                                        <div class="info-row">
                                            <i class="fa-solid fa-location-dot"></i> 
                                            <span><?= htmlspecialchars($ride->getStart_location()) ?></span>
                                        </div>
                                        
                                        <div class="participants-row">
                                            <i class="fa-solid fa-user-group"></i>
                                            <div class="avatars">
                                                <div class="avatar"></div>
                                                <div class="avatar"></div>
                                                <div class="avatar"></div>
                                            </div>
                                            <span><?= count($participations[$ride->getId()] ?? []) ?> / <?= htmlspecialchars($ride->getMax_participants() ?? 12) ?> participants</span>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
            <div id="tab-passees" class="tab-second">
                <section class="rides-wrapper">
                    <div id="rides-container">
                        <?php if (empty($ridesFollowed)): ?>
                            <p style="text-align: center; color: var(--text-grey); padding: 20px; margin-top: 50%;">Aucune balade pour le moment.</p>
                        <?php else: ?>
                            <?php foreach ($ridesFollowed as $index => $ride): ?>
                                <?php
                                $diffValue = $ride->getDifficulty_level();
                                $badgeText = "Inconnu";
                                $diffClass = "badge-medium";

                                if (is_numeric($diffValue)) {
                                    $intDiff = (int)$diffValue;
                                    if ($intDiff === 1) {
                                        $badgeText = "Facile";
                                        $diffClass = "badge-easy";
                                    } elseif ($intDiff === 2) {
                                        $badgeText = "Moyen";
                                        $diffClass = "badge-medium";
                                    } elseif ($intDiff >= 3) {
                                        $badgeText = "Difficile";
                                        $diffClass = "badge-hard";
                                    }
                                }

                                $dateValue = $ride->getStart_date();
                                $dateBdd = new DateTime($dateValue);
                                
                                $dateFormatter = new IntlDateFormatter(
                                    'fr_FR', 
                                    IntlDateFormatter::LONG, 
                                    IntlDateFormatter::NONE
                                );
                                $dateFinal = $dateFormatter->format($dateBdd);
                                ?>

                                <a class="ride-card" href="index.php?route=ride&id=<?= htmlspecialchars($ride->getId()) ?>">
                                    <div class="card-image-wrapper">
                                        <img class="card-img" src="https://picsum.photos/400/200?random=<?= $index ?>" alt="Image de la balade">
                                        <span class="badge <?= $diffClass ?>"><?= htmlspecialchars($badgeText) ?></span>
                                    </div>
                                    
                                    <div class="card-content">
                                        <h3><?= htmlspecialchars($ride->getTitle()) ?></h3>
                                        
                                        <p class="author"><?= htmlspecialchars($ride->getOrganizer_pseudo()) ?></p>
                                        
                                        <div class="info-row">
                                            <i class="fa-regular fa-calendar"></i> 
                                            <span><?= $dateFinal ?> à <?= htmlspecialchars(substr($ride->getStart_hour(), 0, 5)) ?></span>
                                        </div>
                                        
                                        <div class="info-row">
                                            <i class="fa-solid fa-location-dot"></i> 
                                            <span><?= htmlspecialchars($ride->getStart_location()) ?></span>
                                        </div>
                                        
                                        <div class="participants-row">
                                            <i class="fa-solid fa-user-group"></i>
                                            <div class="avatars">
                                                <div class="avatar"></div>
                                                <div class="avatar"></div>
                                                <div class="avatar"></div>
                                            </div>
                                            <span><?= count($participations[$ride->getId()] ?? []) ?> / <?= htmlspecialchars($ride->getMax_participants() ?? 12) ?> participants</span>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </div>
    </div>

    
<script src="assets/js/home.js"></script>
</main>