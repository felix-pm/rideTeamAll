<?php require_once __DIR__ . '/../Partials/head.php'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<h2>Créer une balade</h2>

<form method="post" action="">
    <label for="name_balade">Nom de la balade</label>
    <input type="text" name="name_balade" id="name_balade" required />

    <label for="comment">Description de la balade</label>
    <input type="text" name="comment" id="comment" required>

    <label for="start_hour">Horaire de départ</label>
    <input type="time" step="1800" name="start_hour" id="start_hour" required>

    <label for="start_date">Jour de départ</label>
    <input type="date" name="start_date" id="start_date" required />

    <label for="start_location">Jour de départ</label>
    <input type="text" name="start_location" id="start_location" required />

    <label for="end_location">Jour de départ</label>
    <input type="text" name="end_location" id="end_location" required />

    <label for="difficulty_level">Niveau de difficulté</label>
    <select name="difficulty_level">
        <option value="">-- Choisir --</option>
        <option value="1">facile</option>
        <option value="2">intermédiaire</option>
        <option value="3">difficile</option>
    </select>

    <label for="max_participants">Nombre de participants max</label>
    <select name="max_participants">
        <option value="">-- Choisir --</option>
        <option value="1">10</option>
        <option value="2">15</option>
        <option value="3">20</option>
        <option value="4">25</option>
        <option value="5">30</option>
    </select>


    <button type="submit" style="width: 200px; margin-top: 20px">
        Créer la balade
    </button>
</form>
