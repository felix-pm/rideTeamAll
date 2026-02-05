<nav>
    <a href="index.php?route=home">Découvrir</a>
    <a href="index.php?route=map">Carte</a>
    <a href="index.php?route=follow">Abonnés</a>
    
    <?php if (isset($_SESSION['id'])): ?>
        <a href="index.php?route=profile">Mon Profil (<?= $_SESSION['pseudo'] ?>)</a>
        <a href="index.php?route=logout">Déconnexion</a>
    <?php else: ?>
        <a href="index.php?route=login">Connexion</a>
    <?php endif; ?>
</nav>