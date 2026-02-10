<?php require_once __DIR__ . '/../Partials/head.php'; ?>
<body>
<header>
    <nav>
        <div class="flex">
            <a href="index.php?route=home">
                <i class="fa-solid fa-magnifying-glass"></i>
                Découvrir
            </a>
        </div>
        <div class="flex">
            <a href="index.php?route=map">
                <i class="fa-regular fa-map"></i>
                carte
            </a>
        </div>
        <div class="flex">
            <a href="index.php?route=create_way">+</a>
            <p>Créer</p>
        </div>
        <div class="flex">
            <a href="index.php?route=follow">
                <i class="fa-regular fa-user"></i>
                Abonnés
            </a>
        </div>
        
        <?php if (isset($_SESSION['id'])): ?>
            <a href="index.php?route=profile">
                <img src="<?= $_SESSION['avatar']?>" alt="">
                Profil
            </a>
            <?php else: ?>
            <a href="index.php?route=login">Connexion</a>
        <?php endif; ?>
    </nav>
</header>