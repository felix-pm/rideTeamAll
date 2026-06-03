<?php

class BikeController extends AbstractController
{
    public function addBike() {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (empty($_POST["marque"]) || empty($_POST["modele"]) || empty($_POST["annee"])) {
                $errors[] = "Veuillez remplir tous les champs !";
            }
            
            $manager = new BikeManager();
            
            if (empty($errors)) {
                $userManager = new UserManager();
                $user = $userManager->findById($_SESSION['id']);
                
                if ($user) {
                    // --- GESTION DE L'IMAGE ---
                    $cheminImage = null; // Par défaut, pas d'image
                    
                    // Si un fichier a été uploadé et sans erreur
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        // On définit le dossier de destination (n'oubliez pas de créer ce dossier 'assets/img/bikes/')
                        $dossierDestination = 'assets/img/'; 
                        $nomFichier = uniqid() . '_' . basename($_FILES['image']['name']); // Nom unique pour éviter d'écraser des fichiers
                        $cheminComplet = $dossierDestination . $nomFichier;
                        
                        // On déplace le fichier temporaire vers notre dossier
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $cheminComplet)) {
                            $cheminImage = $cheminComplet;
                        }
                    }

                    $bikeToCreate = new Bike(
                        id: null,
                        marque: $_POST['marque'],
                        modele: $_POST['modele'],
                        annee: $_POST['annee'],
                        url: $cheminImage,
                        user_id: $user
                    );
                    
                    $manager->createBike($bikeToCreate, $user);
                    $this->redirect('index.php?route=profile');
                    exit;
                } else {
                    $errors[] = "Erreur : Utilisateur introuvable. Veuillez vous reconnecter.";
                }
            }
        }
        $this->render('member/profile', ['errors' => $errors]);
    }
}