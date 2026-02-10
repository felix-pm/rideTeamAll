<?php require_once __DIR__ . '/../Partials/head.php'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<section id="section-profile">
    <div id="div-all">

        <div id="profil">
            <img src="<?= $_SESSION['avatar']?>" alt="">
            <h2><?= $_SESSION['pseudo']?></h2>
            <button>Partager mon profil</button>
            <div id="modif-profile">
                <div id="flex-profil">
                    <p>Modifier mon profil</p>
                    <p>></p>
                </div>
                <div id="flex-balades">
                    <p>Mes balades</p>
                    <p>></p>
                </div>
                <div id="flex-garage">
                    <p>Mon garage</p>
                    <p>></p>
                </div>
            </div>
        </div>
        
        <div id="display-profil" style="display: none;">
            <p id="btn-back-profil"><</p>
            <img src="<?= $_SESSION['avatar']?>" alt="">
            <h2><?= $_SESSION['pseudo']?></h2>
            <form method="post" action="">
                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo" required />

                <label for="email">Email</label>
                <input type="email" name="email" id="email" required />

                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required />

                <label for="confirmPassword">Confirmez le mot de passe</label>
                <input type="password" name="confirmPassword" id="confirmPassword" required />

                <button type="submit" style="width: 100%; margin-top: 20px">Enregistrer</button>
            </form>
        </div>

        <div id="display-balades" style="display: none;">
            <p id="btn-back-balades"><</p>
            <p>Mes balades... (feature a venir)</p>
        </div>

        <div id="display-garages" style="display: none;">
            <p id="btn-back-garage"><</p>
            <p>Mon garage... (feature a venir)</p>
        </div>

    </div>
    <div id="btn-logout">
        <?php if (isset($_SESSION['id'])): ?>
            <a href="index.php?route=logout">Déconnexion</a>
        <?php endif; ?>
    </div>
</section>


<!-- <input type="file" accept="image/*"> -->




<!-- <div class="flex-setting">
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
</div> -->