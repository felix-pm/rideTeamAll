<?php require_once __DIR__ . '/../Partials/head.php'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<link rel="stylesheet" href="assets/css/create_way.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<body class="app-bg">
    
    <main id="app-container">
        <header class="app-header">
            <div class="header-content">
                <h1>Nouvelle Balade</h1>
                <p>Roadbook & Good Vibes ✌️</p>
            </div>
        </header>

        <section class="form-wrapper">
            
            <?php if (!empty($errors)): ?>
                <div class="error-box animate-pop">
                    <?php foreach ($errors as $error): ?>
                        <p><i class="fa-solid fa-triangle-exclamation"></i> <?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="index.php?route=create_way" method="POST">
                
                <div class="input-group">
                    <label for="title"><i class="fa-solid fa-route"></i> Titre</label>
                    <input type="text" name="title" id="title" placeholder="Ex: Voyage vers la mer" required>
                </div>

                <div class="input-group">
                    <label for="description"><i class="fa-solid fa-align-left"></i>Le lieu de rendez-vous</label>
                    <textarea name="description" id="description" placeholder="Donne un lieu précis du rdv..." required></textarea>
                </div>

                <div class="row-group">
                    <div class="input-group half">
                        <label for="start_date"><i class="fa-regular fa-calendar"></i> Date</label>
                        <input type="date" name="start_date" id="start_date" required>
                    </div>
                    <div class="input-group half">
                        <label for="start_hour"><i class="fa-regular fa-clock"></i> Heure</label>
                        <input type="time" name="start_hour" id="start_hour" required>
                    </div>
                </div>

                <div class="timeline-inputs">
                    <div class="input-group" style="position: relative;">
                        <label for="start_location" class="start-label"><i class="fa-solid fa-location-dot"></i> Départ</label>
                        <input type="text" name="start_location" id="start_location" placeholder="Ville de départ" autocomplete="off" required>
                    </div>
                    
                    <div class="connector-line"></div>
                    
                    <div class="input-group" style="position: relative;">
                        <label for="end_location" class="end-label"><i class="fa-solid fa-flag-checkered"></i> Arrivée</label>
                        <input type="text" name="end_location" id="end_location" placeholder="Ville d'arrivée" autocomplete="off" required>
                    </div>
                </div>

                <div class="row-group">
                    <div class="input-group half">
                        <label for="difficulty_level"><i class="fa-solid fa-layer-group"></i> Niveau</label>
                        <select name="difficulty_level" id="difficulty_level">
                            <option value="1">Facile</option>
                            <option value="2">Moyen</option>
                            <option value="3">Difficile</option>
                        </select>
                    </div>
                    <div class="input-group half">
                        <label for="max_participants"><i class="fa-solid fa-users"></i> Max</label>
                        <input type="number" name="max_participants" id="max_participants" min="1" max="50" value="5" required>
                    </div>
                </div>

                <button type="submit" class="submit-btn">
                    Créer la balade <i class="fa-solid fa-motorcycle"></i>
                </button>

            </form>
        </section>
    </main>
</body>