<?php require_once __DIR__ . '/../Partials/head.php'; ?>
<body>
<header>
    <nav>
        <div class="flex">
            <a href="index.php?route=home">
                <i class="fa-solid fa-house"></i>
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
            <a href="index.php?route=search">
                <i class="fa-solid fa-magnifying-glass"></i>
                Rechercher
            </a>
        </div>
        
        <?php if (isset($_SESSION['id'])): ?>
            <a href="index.php?route=profile">
                <img src="<?= $_SESSION['avatar']?>" alt="">
                Profil
            </a>
            <?php else: ?>
            <a href="index.php?route=login">
                <img src="./assets/img/default-avatar.jpg" alt="">
                Connexion
            </a>
        <?php endif; ?>
    </nav>
</header>