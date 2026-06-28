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
                    $cheminImage = null; 
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $dossierDestination = 'assets/img/'; 
                        $nomFichier = uniqid() . '_' . basename($_FILES['image']['name']);
                        $cheminComplet = $dossierDestination . $nomFichier;
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

    public function editBike(int $id) 
    {
        if (!isset($_SESSION['id'])) {
            $this->redirect('index.php?route=login');
            exit;
        }

        $bikeManager = new BikeManager();
        $bike = $bikeManager->findOneBikeById($id);

        if (!$bike) {
            $this->redirect('index.php?route=profile');
            exit;
        }

        $isOwner = $bike->getUser_id()->getId() === $_SESSION['id'];
        $isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'ADMIN';

        if (!$isOwner && !$isAdmin) {
            $this->redirect('index.php?route=profile');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['marque']) && !empty($_POST['modele']) && !empty($_POST['annee'])) {
                
                $bike->setMarque($_POST['marque']);
                $bike->setModele($_POST['modele']);
                $bike->setAnnee($_POST['annee']);

                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $dossierDestination = 'assets/img/'; 
                    $nomFichier = uniqid() . '_' . basename($_FILES['image']['name']);
                    $cheminComplet = $dossierDestination . $nomFichier;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $cheminComplet)) {
                        $bike->setUrl($cheminComplet); 
                    }
                }

                $bikeManager->updateBike($bike);

                $this->redirect('index.php?route=profile');
                exit;
            }
        }

        $this->redirect('index.php?route=profile');
        exit;
    }

    
}