<?php require_once __DIR__ . '/../Partials/head.php'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<main id="app-container" class="home-main">
    
    <header class="app-header">
        <div class="header-content">
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