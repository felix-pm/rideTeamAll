<?php require_once __DIR__ . '/../Partials/head.php'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<main id="app-container" class="home-main">
    
    <header class="app-header">
        <div class="header-content">
            <form action="index.php" method="get" style="display: flex;">
                <input type="hidden" name="route" value="search"> 
                
                <img src="assets/img/favicon.png" alt="RideTeam Logo" style="width: 42px; height: 42px; border-radius: 8px; object-fit: cover; flex-shrink: 0;">

                <div class="search-container">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="rechercheUser" autocomplete="off" placeholder="Rechercher des riders..." value="<?= htmlspecialchars($keywordUser ?? '') ?>">
                </div>
                <button type="submit" class="btn-sent-home"><i class="fa-solid fa-paper-plane"></i></button>
            </form>
        </div>
    </header>
    <section id="search-wrapper">
        <div id="search-container">
            <?php if (empty($users)): ?>
                <p style="text-align: center; color: var(--text-grey); padding: 20px; margin-top: 50%;">Aucune utilisateur pour le moment.</p>
            <?php else: ?>
                <?php foreach ($users as $index => $user): ?>
                    <a href="index.php?route=user_profile&id=<?= $user->getId() ?>" class="all">
                        <img src="<?= htmlspecialchars($user->getAvatar()) ?>" alt="Photo de profil de l'utilisateur">
                        <div class="pseudo">
                            <h2>
                                <?= htmlspecialchars($user->getPseudo()) ?>
                            </h2>
                        </div>
                    </a>
                    
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</main>