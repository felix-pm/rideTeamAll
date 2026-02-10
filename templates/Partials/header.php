<nav>
    <a href="index.php?route=home">Découvrir</a>
    <a href="index.php?route=map">Carte</a>
    <a href="index.php?route=create_way">+</a>
    <a href="index.php?route=follow">Abonnés</a>
    
    <?php if (isset($_SESSION['id'])): ?>
        <a href="index.php?route=profile"><img src="<?= $_SESSION['avatar']?>" alt="" style="border-radius: 50%; width: 50px; height: 50px;"></a>
      <?php else: ?>
        <a href="index.php?route=login">Connexion</a>
    <?php endif; ?>
</nav>