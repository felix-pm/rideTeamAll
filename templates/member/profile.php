<?php require_once __DIR__ . '/../Partials/head.php'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<img src="<?= $_SESSION['avatar']?>" alt="" style="border-radius: 50%; width: 50px; height: 50px;">

<h2>Page profil</h2>

<button>Partager mon profil</button>

<section id="modif-profile">
    <div class="space-between">
        <a href="">Modifier mon Avatar</a>
        <p>></p>
    </div>
    <div class="space-between">
        <a href="">Modifier mon Pseudo</a>
        <p>></p>
    </div>
    <div class="space-between">
        <a href="">Modifier mon Email</a>
        <p>></p>
    </div>
    <div class="space-between">
        <a href="">Modifier mon Mot de passes</a>
        <p>></p>
    </div>
</section>



<!-- <input type="file" accept="image/*"> -->



<?php if (isset($_SESSION['id'])): ?>
    <a href="index.php?route=logout">Déconnexion</a>
<?php endif; ?>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>