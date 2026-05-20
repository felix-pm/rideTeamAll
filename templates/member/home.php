<?php require_once __DIR__ . '/../Partials/head.php'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<main id="app-container" class="home-main">
    
    <header class="app-header">
        <div class="header-content">
            <form action="#" method="get" style="display: flex;">
                <div class="search-container">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="recherche" placeholder="Rechercher...">
                </div>
                <button type="submit" class="btn-sent-home"><i class="fa-solid fa-paper-plane"></i></button>
            </form>
            <h1>Les balades à venir</h1>
            <p>Trouve ta prochaine balade !</p>
        </div>
    </header>

    <section class="rides-wrapper">
        <div id="rides-container">
            <p style="text-align: center; color: var(--text-grey); padding: 20px; margin-top: 50%;">Chargement des balades...</p>
        </div>
    </section>

</main>

<script src="assets/js/ride.js"></script>