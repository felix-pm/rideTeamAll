<?php require_once __DIR__ . '/../partials/header.php'; ?>

<?php if (isset($_SESSION['id'])): ?>
    <a href="index.php?route=logout">Déconnexion</a>
<?php else: ?>
    <a href="index.php?route=login">Connexion</a>
<?php endif; ?>
<h2>Page profil</h2>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>