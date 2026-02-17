<?php

class BikeController extends AbstractController
{
    public function addBike() { // J'ai renommé en addBike, comme l'indique votre erreur
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (empty($_POST["marque"]) || empty($_POST["modele"]) || empty($_POST["annee"]))
            {
                $errors[] = "Veuillez remplir tous les champs !";
            }
            
            $manager = new BikeManager();
            
            if (empty($errors)) {
                
                // 1. C'EST CE QU'IL MANQUAIT : On définit qui est $user !
                $userManager = new UserManager();
                // On va chercher l'utilisateur connecté grâce à sa session
                $user = $userManager->findById($_SESSION['id']);
                
                // On s'assure qu'on a bien trouvé l'utilisateur
                if ($user) {
                    
                    // 2. Maintenant, $user existe et contient bien un objet User !
                    $bikeToCreate = new Bike(
                        id: null,
                        marque: $_POST['marque'],
                        modele: $_POST['modele'],
                        annee: $_POST['annee'],
                        user_id: $user // On peut enfin le passer sans erreur
                    );
                    
                    // 3. On sauvegarde la moto. 
                    // Note : D'après le code de votre BikeManager vu précédemment, 
                    // votre méthode createBike() demande 2 paramètres : l'objet Bike ET l'objet User.
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

    public function api_bike()
    {
        // 1. On récupère les données depuis la BDD
        $manager = new BikeManager();
        $ridesObjects = $manager->findAllBikeByUserId($_SESSION['id']);

        // 2. On transforme les objets complexes en tableau simple
        $ridesArray = [];
        foreach($ridesObjects as $ride) {
            $ridesArray[] = [
                'id' => $ride->getId(),
                'marque' => $ride->getMarque(),
                'modele' => $ride->getModele(),
                'annee' => $ride->getAnnee()
            ];
        }

        // 3. On prévient le navigateur qu'on envoie du JSON et on l'affiche
        header('Content-Type: application/json');
        echo json_encode($ridesArray);
        exit; // Très important : on arrête le script ici pour ne pas envoyer de HTML par erreur
    }
}