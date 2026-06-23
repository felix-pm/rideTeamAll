<?php require_once __DIR__ . '/../Partials/head.php'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<section id="section-profile">
    <div id="div-all">

        <div id="profil">
            <?php
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $domain = $_SERVER['HTTP_HOST'];
            $publicProfileUrl = $protocol . "://" . $domain . "/rideteamall/index.php?route=user_profile&id=" . $_SESSION['id'];
            ?>
            <a href="#" id="btn-share-profile" data-url="<?= $publicProfileUrl ?>" data-title="Découvre le profil de <?= $_SESSION['pseudo'] ?> sur RideTeam !">
                <i class="fa-solid fa-share"></i>
            </a>
            <a id="open-settings-btn" class="btn-settings"><i class="fa-solid fa-gear"></i></a>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'ADMIN'): ?>
                <a href="index.php?route=admin" id="btn-admin">
                    <i class="fa-solid fa-user-shield"></i>
                </a>
            <?php endif; ?>
            <form action="index.php?route=profile" method="POST" enctype="multipart/form-data" id="form-avatar">
                <div class="avatar-wrapper">
                    <img src="<?= htmlspecialchars($_SESSION['avatar']) ?>" alt="Avatar">
                    <label for="avatar-input" class="edit-avatar-btn">
                        <i class="fa-solid fa-plus"></i>
                    </label>
                    <input type="file" id="avatar-input" name="new_avatar" accept="image/*" style="display: none;" onchange="this.form.submit()">
                </div>
            </form>
            <h2><?= $_SESSION['pseudo']?></h2>
            <div class="social-stats">
                <div class="stat">
                    <strong><?= $followersCount ?></strong> Abonnés
                </div>
                <div class="stat">
                    <strong><?= $followedsCount ?></strong> Abonnements
                </div>
            </div>
        </div>
        
        <div id="display-garages">
            <h2>Mon garage</h2>
            <div id="bikes-container">
                <?php
                if (!isset($garage)): ?>
                    <p class="error-message" style="color: red; text-align: center;">
                        <i class="fa-solid fa-circle-exclamation"></i> Erreur technique : Impossible d'accéder au garage.
                    </p>

                <?php
                elseif (empty($garage)): ?>
                    <p class="no-bikes" style="color: var(--text-grey); text-align: center; padding: 20px; font-style: italic;">
                        Aucune moto dans votre garage pour le moment...
                    </p>

                <?php
                else: ?>
                    <?php foreach ($garage as $bike): ?>
                        <?php 
                        if (!$bike instanceof Bike) {
                            continue;
                        }
                        $bikeUrl = $bike->getUrl();
                        $imageSrc = !empty($bikeUrl) ? htmlspecialchars($bikeUrl) : 'assets/img/default-bike.avif';
                        ?>

                        <div class="bike-card">
                            <img class="bike-img" src="<?= $imageSrc ?>" alt="Photo de <?= htmlspecialchars($bike->getMarque()) ?>">
                            
                            <a href="#" class="open-edit-bike-btn" data-target="edit-bike-modal-<?= $bike->getId() ?>" style="color: inherit;">
                                <i class="fa-solid fa-gear" title="Modifier cette moto"></i>
                            </a>
                            
                            <p class="bike-marque"><?= htmlspecialchars($bike->getMarque()) ?></p>
                            <p class="bike-modele"><?= htmlspecialchars($bike->getModele()) ?></p>
                            <p class="bike-annee"><?= htmlspecialchars($bike->getAnnee()) ?></p>
                        </div>

                        <div id="edit-bike-modal-<?= $bike->getId() ?>" class="modal edit-bike-modal" style="display: none;">
                            <div class="modal-content animate-pop">
                                <span class="close-btn close-edit-bike-btn"><i class="fa-solid fa-xmark"></i></span>
                                
                                <div id="display-edit-bike">
                                    <h2>Modifier ma moto</h2>
                                    
                                    <form method="POST" enctype="multipart/form-data" action="index.php?route=edit_bike&id=<?= $bike->getId() ?>">
                                        
                                        <div class="input-group">
                                            <label for="marque-<?= $bike->getId() ?>"><i class="fa-solid fa-route"></i> Marque</label>
                                            <input type="text" name="marque" id="marque-<?= $bike->getId() ?>" value="<?= htmlspecialchars($bike->getMarque()) ?>" required />
                                        </div>

                                        <div class="input-group">
                                            <label for="modele-<?= $bike->getId() ?>"><i class="fa-solid fa-align-left"></i> Modèle</label>
                                            <input type="text" name="modele" id="modele-<?= $bike->getId() ?>" value="<?= htmlspecialchars($bike->getModele()) ?>" required />
                                        </div>

                                        <div class="input-group">
                                            <label for="annee-<?= $bike->getId() ?>"><i class="fa-regular fa-calendar"></i> Année</label>
                                            <input type="date" name="annee" id="annee-<?= $bike->getId() ?>" value="<?= htmlspecialchars($bike->getAnnee()) ?>" required />
                                        </div>

                                        <div class="input-group">
                                            <label for="image-<?= $bike->getId() ?>"><i class="fa-solid fa-camera"></i> Nouvelle photo (optionnel)</label>
                                            <input type="file" name="image" id="image-<?= $bike->getId() ?>" accept="image/*">
                                        </div>

                                        <?php if ($bike->getUrl()): ?>
                                            <div style="margin-top: 10px; text-align: center;">
                                                <p style="font-size: 0.9em; color: var(--text-grey);">Photo actuelle :</p>
                                                <img src="<?= htmlspecialchars($bike->getUrl()) ?>" alt="Aperçu" style="max-width: 150px; border-radius: 8px;">
                                            </div>
                                        <?php endif; ?>

                                        <button type="submit" class="submit-btn">
                                            Enregistrer les modifications <i class="fa-solid fa-motorcycle"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <button id="button-add-bike">Ajouter une moto</button>
        </div>

        <div id="display-my-rides">
            <h2>Mes balades en cours</h2>
            
            <section class="rides-wrapper" style="padding: 0; padding-bottom: 20px;">
                <div id="my-rides-container">
                    <?php
                    if (!isset($myRides)): ?>
                        <p class="error-message" style="color: red; text-align: center;">
                            <i class="fa-solid fa-circle-exclamation"></i> Erreur technique : Impossible d'accéder à vos balades.
                        </p>
                    <?php
                    elseif (empty($myRides)): ?>
                        <p class="no-bikes" style="color: var(--text-grey); text-align: center; padding: 20px; font-style: italic;">
                            Vous n'avez organisé aucune balade pour le moment...
                        </p>
                    <?php
                    else: ?>
                        <?php foreach ($myRides as $myRide): ?>
                            <?php
                            $dateValue = $myRide->getStart_date();
                            $dateBdd = new DateTime($dateValue);
                            
                            $dateFormatter = new IntlDateFormatter(
                                'fr_FR', 
                                IntlDateFormatter::LONG, 
                                IntlDateFormatter::NONE
                            );
                            $dateFinal = $dateFormatter->format($dateBdd);
                            ?>
                            
                            <div class="modal-rides" style="position: relative; height: 100%;"> 
                                
                                <a class="ride-card" href="index.php?route=ride&id=<?= $myRide->getId() ?>" style="margin-bottom: 0; height: 100%;">
                                    <div class="card-image-wrapper">
                                        <img class="card-img" src="https://picsum.photos/400/200?random=<?= $myRide->getId() ?>" alt="Image de la balade">
                                    </div>
                                    
                                    <div class="card-content">
                                        <h3><?= htmlspecialchars($myRide->getTitle()) ?></h3>
                                        <div class="info-row">
                                            <i class="fa-regular fa-calendar"></i> 
                                            <span><?= $dateFinal ?> à <?= htmlspecialchars(substr($myRide->getStart_hour(), 0, 5)) ?></span>
                                        </div>
                                        <div class="info-row">
                                            <i class="fa-solid fa-location-dot"></i> 
                                            <span><?= htmlspecialchars($myRide->getStart_location()) ?></span>
                                        </div>
                                    </div>
                                </a>
                                
                                <i class="fa-solid fa-gear" 
                                   onclick="document.getElementById('edit-ride-modal-<?= $myRide->getId() ?>').style.display='flex';" 
                                   title="Modifier cette balade" 
                                   style="position: absolute; top: 10px; right: 10px; background-color: rgba(0, 0, 0, 0.6); color: var(--text-white); padding: 8px; border-radius: 50%; font-size: 0.9rem; cursor: pointer; z-index: 20;"></i>
                            </div>

                            <div id="edit-ride-modal-<?= $myRide->getId() ?>" class="modal edit-ride-modal" style="display: none;">
                                <div class="modal-content animate-pop">
                                    <span class="close-btn" onclick="document.getElementById('edit-ride-modal-<?= $myRide->getId() ?>').style.display='none';">
                                        <i class="fa-solid fa-xmark"></i>
                                    </span>
                                    
                                    <div id="display-profil"> 
                                        <h2 style="margin-bottom: 25px; text-align: center;">Modifier la balade</h2>
                                        
                                        <form method="POST" action="index.php?route=edit_ride&id=<?= $myRide->getId() ?>">
                                            <div class="input-group">
                                                <label for="title-<?= $myRide->getId() ?>"><i class="fa-solid fa-heading"></i> Titre</label>
                                                <input type="text" name="title" id="title-<?= $myRide->getId() ?>" value="<?= htmlspecialchars($myRide->getTitle()) ?>" required />
                                            </div>

                                            <div class="row-group" style="display: flex; gap: 15px; width: 100%;">
                                                <div class="input-group half" style="flex: 1;">
                                                    <label for="date-<?= $myRide->getId() ?>"><i class="fa-regular fa-calendar"></i> Date</label>
                                                    <input type="date" name="start_date" id="date-<?= $myRide->getId() ?>" value="<?= htmlspecialchars($myRide->getStart_date()) ?>" required />
                                                </div>
                                                <div class="input-group half" style="flex: 1;">
                                                    <label for="hour-<?= $myRide->getId() ?>"><i class="fa-regular fa-clock"></i> Heure</label>
                                                    <input type="time" name="start_hour" id="hour-<?= $myRide->getId() ?>" value="<?= htmlspecialchars(substr($myRide->getStart_hour(), 0, 5)) ?>" required />
                                                </div>
                                            </div>

                                            <div class="input-group">
                                                <label for="start_loc-<?= $myRide->getId() ?>"><i class="fa-solid fa-location-dot"></i> Point de départ</label>
                                                <input type="text" name="start_location" id="start_loc-<?= $myRide->getId() ?>" value="<?= htmlspecialchars($myRide->getStart_location()) ?>" required />
                                            </div>

                                            <button type="submit" class="submit-btn">
                                                Mettre à jour <i class="fa-solid fa-route"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
            
            <a href="index.php?route=create_way" id="button-add-ride" style="display: block; width: 100%; text-align: center; background: transparent; border: 2px dashed var(--accent-orange); color: var(--accent-orange); padding: 15px; border-radius: var(--border-radius); font-weight: bold; margin-bottom: 20px; text-decoration: none;">
                Créer une nouvelle balade
            </a>
        </div>

        <div id="add-bike" style="display: none;">
            <p id="btn-back-add-bike"><</p>
            <form action="index.php?route=add_bike" method="POST" enctype="multipart/form-data">
                
                <label for="marque"><i class="fa-solid fa-route"></i> Marque :</label>
                <input type="text" name="marque" id="marque" placeholder="La marque de ta moto" required>

                <label for="modele"><i class="fa-solid fa-align-left"></i>Modèle :</label>
                <input type="text" name="modele" id="modele" placeholder="Le modèle de ta moto" required>

                <label for="annee"><i class="fa-regular fa-calendar"></i> Année</label>
                <input type="date" name="annee" id="annee" required>

                <label for="image"><i class="fa-solid fa-camera"></i> Photo de la moto :</label>
                <input type="file" name="image" id="image" accept="image/*">

                <button type="submit" class="submit-btn">
                    Enregistrer ta moto <i class="fa-solid fa-motorcycle"></i>
                </button>

            </form>
        </div>

        <div class="tabs-container">
            <div class="tabs-header">
                <button class="tab-btn active" data-tab="tab-avenir">À venir</button>
                <button class="tab-btn" data-tab="tab-passees">Passées</button>
            </div>

            <div class="tabs-content">
                <div id="tab-avenir" class="tab-panel active">
                    <section class="rides-wrapper">
                        <div id="rides-container">
                            <?php if (empty($futuresBalades)): ?>
                                <p style="text-align: center; color: var(--text-grey); padding: 20px; margin-top: 50%;">Aucune balade pour le moment.</p>
                            <?php else: ?>
                                <?php foreach ($futuresBalades as $index => $ride): ?>
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
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </section>
                </div>
                
                <div id="tab-passees" class="tab-panel">
                    <section class="rides-wrapper">
                        <div id="rides-container">
                            <?php if (empty($pastBalades)): ?>
                                <p style="text-align: center; color: var(--text-grey); padding: 20px; margin-top: 50%;">Aucune balade pour le moment.</p>
                            <?php else: ?>
                                <?php foreach ($pastBalades as $index => $ride): ?>
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
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        
        <div id="settings-modal" class="modal" style="display: none;">
            <div class="modal-content animate-pop">
                <span id="close-settings-btn" class="close-btn"><i class="fa-solid fa-xmark"></i></span>
                
                <div id="display-profil">
                    <img src="<?= htmlspecialchars($_SESSION['avatar']) ?>" alt="Avatar" class="modal-avatar">
                    <h2>Modifier mon profil</h2>
                    
                    <form method="post" action="index.php?route=profile" onsubmit="return validatePassword()">
                        <div class="input-group">
                            <label for="pseudo"><i class="fa-solid fa-user"></i> Pseudo</label>
                            <input type="text" name="pseudo" id="pseudo" value="<?= htmlspecialchars($_SESSION['pseudo']) ?>" required />
                        </div>

                        <div class="input-group">
                            <label for="email"><i class="fa-solid fa-envelope"></i> Email</label>
                            <input type="email" name="email" id="email" value="<?= htmlspecialchars($_SESSION['email']) ?>" required />
                        </div>

                        <div class="input-group">
                            <label for="password"><i class="fa-solid fa-lock"></i> Nouveau mot de passe</label>
                            <input type="password" name="password" id="password" placeholder="Laisser vide si inchangé" />
                        </div>

                        <div class="input-group">
                            <label for="confirmPassword"><i class="fa-solid fa-shield-halved"></i> Confirmation</label>
                            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Laisser vide si inchangé" />
                        </div>

                        <button type="submit" class="submit-btn">
                            Enregistrer les modifications <i class="fa-solid fa-motorcycle"></i>
                        </button>
                    </form>

                    <div id="btn-logout">
                        <?php if (isset($_SESSION['id'])): ?>
                            <a href="index.php?route=logout">Déconnexion</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>