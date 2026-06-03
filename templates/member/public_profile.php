<?php require_once __DIR__ . '/../Partials/head.php'; ?>
<?php require_once __DIR__ . '/../Partials/header.php'; ?>

<section id="section-profile">
    <div id="div-all">

        <div id="profil">
            <a href="javascript:history.back()" class="btn-back-overlay">
                <i class="fa-solid fa-chevron-left"></i>
            </a>
            <img src="assets/img/default-avatar.jpg" alt="Avatar">
            
            <h2><?= htmlspecialchars($user->getPseudo()) ?></h2>

            <div class="social-stats">
                <div class="stat">
                    <strong><?= $followersCount ?></strong> Abonnés
                </div>
                <div class="stat">
                    <strong><?= $followedsCount ?></strong> Abonnements
                </div>
            </div>

            <?php if (isset($_SESSION['id']) && $_SESSION['id'] != $user->getId()): ?>
                <?php if ($following): ?>
                    <a class="btn-unfollow" href="index.php?route=unfollow&id=<?= $user->getId() ?>">Se désabonner</a>
                <?php else: ?>
                    <a class="btn-follow" href="index.php?route=follow&id=<?= $user->getId() ?>">S'abonner</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div id="display-garages">
            <h2>Le garage de <?= htmlspecialchars($user->getPseudo()) ?></h2>
            
            <?php if (!empty($garage)): ?>
                <div id="public-bikes-container">
                    <?php foreach ($garage as $bike): ?>
                        <div class="bike-card">
                            <?php 
                                $bikeUrl = $bike->getUrl();
                                $imgSrc = !empty($bikeUrl) ? htmlspecialchars($bikeUrl) : 'assets/img/default-bike.avif';
                            ?>
                            
                            <img src="<?= $imgSrc ?>" alt="Moto" class="bike-img">
                            
                            <p class="bike-marque"><?= htmlspecialchars($bike->getMarque()) ?></p>
                            <p class="bike-modele"><?= htmlspecialchars($bike->getModele()) ?></p>
                            <p class="bike-annee">Année : <?= htmlspecialchars($bike->getAnnee()) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="text-align: center; color: var(--text-grey); margin-top: 20px;">
                    Son garage est vide pour le moment !
                </p>
            <?php endif; ?>
        </div>

    </div>
</section>

<link rel="stylesheet" href="assets/css/profile.css">