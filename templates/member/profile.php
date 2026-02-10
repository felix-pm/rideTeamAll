<?php require_once __DIR__ . '/../Partials/head.php'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<section id="section-profile">
    <div id="div-all">
        <img src="<?= $_SESSION['avatar']?>" alt="">

        <h2><?= $_SESSION['pseudo']?></h2>

        <button>Partager mon profil</button>

        <div id="modif-profile">
            <div class="flex-setting">
                <p>Modifier mon Avatar</p>
                <p>></p>
            </div>
            <div class="flex-setting">
                <p>Modifier mon Pseudo</p>
                <p>></p>
            </div>
            <div class="flex-setting">
                <p>Modifier mon Email</p>
                <p>></p>
            </div>
            <div class="flex-setting">
                <p>Modifier mon Mot de passe</p>
                <p>></p>
            </div>
        </div>
    </div>
    <?php if (isset($_SESSION['id'])): ?>
        <a href="index.php?route=logout">Déconnexion</a>
    <?php endif; ?>
</section>


<!-- <input type="file" accept="image/*"> -->




