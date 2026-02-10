<?php require_once __DIR__ . '/../partials/header.php'; ?>

<h2>Page profil</h2>

<button>⚙️</button>

<section>
    <button><</button>
    <input type="file" accept="image/*">
    <?php if (isset($_SESSION['id'])): ?>
        <a href="index.php?route=logout">Déconnexion</a>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>