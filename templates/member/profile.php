<?php require_once __DIR__ . '/../Partials/head.php'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<section id="section-profile">
    <div id="div-all">

        <div id="profil">
            <img src="<?= $_SESSION['avatar']?>" alt="">
            <h2><?= $_SESSION['pseudo']?></h2>
            <button>Partager mon profil</button>
            <div id="modif-profile">
                <div id="flex-profil">
                    <p>Modifier mon profil</p>
                    <p>></p>
                </div>
                <div id="flex-chat">
                    <p>Mes discutions</p>
                    <p>></p>
                </div>
                <div id="flex-balades">
                    <p>Mes balades</p>
                    <p>></p>
                </div>
                <div id="flex-garage">
                    <p>Mon garage</p>
                    <p>></p>
                </div>
            </div>
        </div>
        
        <div id="display-profil" style="display: none;">
            <p id="btn-back-profil"><</p>
            <img src="<?= $_SESSION['avatar']?>" alt="">
            <h2><?= $_SESSION['pseudo']?></h2>
            <form method="post" action="index.php?route=profile">
                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo" required />

                <label for="email">Email</label>
                <input type="email" name="email" id="email" required />

                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required />

                <label for="confirmPassword">Confirmez le mot de passe</label>
                <input type="password" name="confirmPassword" id="confirmPassword" required />

                <button type="submit" style="width: 100%; margin-top: 20px">Enregistrer</button>
            </form>
        </div>

        <div id="display-chat" style="display: none;">
            <p id="btn-back-chat"><</p>
            <p>Mes discutions... (feature a venir)</p>
        </div>

        <div id="display-balades" style="display: none;">
            <p id="btn-back-balades"><</p>
            
            <div class="balades-tabs">
                <h3 id="tab-passees" class="active-tab">Passées</h3>
                <h3 id="tab-futures">Futures</h3>
            </div>

            <div class="balades-content-container">
                <div id="content-passees" class="balades-content active-content">
                    <p>Vos balades terminées apparaîtront ici.</p>
                    </div>
                
                <div id="content-futures" class="balades-content exit-right">
                    <p>Vos balades prévues apparaîtront ici.</p>
                    </div>
            </div>
        </div>

        <div id="display-garages" style="display: none;">
            <p id="btn-back-garage"><</p>
            <div id="bikes-container">
                <p>Vous n'avez encore aucune moto dans votre garage...</p>
            </div>
            <button id="button-add-bike">Ajouter une moto</button>
        </div>

        <div id="add-bike" style="display: none;">
            <p id="btn-back-add-bike"><</p>
            <form action="index.php?route=add_bike" method="POST" enctype="multipart/form-data">
                
                <label for="marque"><i class="fa-solid fa-route"></i> Marque :</label>
                <input type="text" name="marque" id="marque" placeholder="La marque de ta moto" required>

                <label for="modele"><i class="fa-solid fa-align-left"></i>Modèle :</label>
                <input type="text" name="modele" id="modele" placeholder="Le modèle de ta moto" required>

                <label for="annee"><i class="fa-regular fa-calendar"></i> Année</label>
                <input type="date" name="annee" id="annee" required>

                <label for="image"><i class="fa-solid fa-camera"></i> Photo de la moto :</label>
                <input type="file" name="image" id="image" accept="image/*">

                <button type="submit" class="submit-btn">
                    Enregistrer ta moto <i class="fa-solid fa-motorcycle"></i>
                </button>

            </form>
        </div>

    </div>
    <div id="btn-logout">
        <?php if (isset($_SESSION['id'])): ?>
            <a href="index.php?route=logout">Déconnexion</a>
        <?php endif; ?>
    </div>
</section>


<!-- <input type="file" accept="image/*"> -->
