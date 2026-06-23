<?php

class RideController extends AbstractController
{
    public function addRide() {
        $errors = [];

        $user_id = ($_SESSION['id']);

        if (!isset($_SESSION['id'])) {
            $this->redirect('index.php?route=login');
            exit;
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (empty($_POST["title"]) || empty($_POST["description"]) || empty($_POST["start_hour"]) || empty($_POST["start_date"]) || empty($_POST["start_location"]) || empty($_POST["end_location"]) || empty($_POST["difficulty_level"]) || empty($_POST["max_participants"]))
            {
                $errors[] = "Veuillez remplir tous les champs !";
            }
            $manager = new RideManager();
            if (empty($errors)) {
                
                $rideToCreate = new Ride(
                    id: null,
                    title: $_POST['title'],
                    description: $_POST['description'],
                    start_hour: $_POST['start_hour'],
                    start_date: $_POST['start_date'],
                    start_location: $_POST['start_location'],
                    start_latitude: $_POST['start_latitude'], 
                    start_longitude: $_POST['start_longitude'],
                    end_location: $_POST['end_location'],
                    end_latitude: $_POST['end_latitude'], 
                    end_longitude: $_POST['end_longitude'], 
                    difficulty_level: $_POST['difficulty_level'],
                    max_participants: $_POST['max_participants'],
                    organizer_id: $_SESSION['id']
                );

                $manager->createRide($rideToCreate, $user_id);
                $this->redirect('index.php?route=home');
                exit;
            }
        }
        $this->render('member/create_way', ['errors' => $errors]);
    }

    public function show($id){
        $rideManager = new RideManager();
        $ride = $rideManager->findOne($id);

        if (!$ride) {
            $this->redirect('index.php?route=home');
            exit;
        }

        $participating = false;
        
        if (isset($_SESSION['id'])) {
            $participating = $rideManager->isParticipating($_SESSION['id'], $ride->getId());
        }

        $participationManager = new ParticipationManager();
        $participations = $participationManager->findParticipantsByRideId($id);

        return $this->render('member/ride', [
            "ride" => $ride,
            "participations" => $participations,
            "participating" => $participating
        ]);
    }

    public function joinRide($id){
        if (!isset($_SESSION['id'])) {
            $this->redirect('index.php?route=login');
            exit;
        }

        $user_id = $_SESSION['id'];
        
        $rideManager = new RideManager();
        $ride = $rideManager->findOne($id);

        if (!$ride) {
            $this->redirect('index.php?route=home');
            exit;
        }

        $participationManager = new ParticipationManager();
        $participations = $participationManager->findParticipantsByRideId($id);

        if (count($participations) < $ride->getMax_participants()) {
            $participationManager->addParticipation($id, $user_id);
        }

        $this->redirect('index.php?route=ride&id=' . $id);
        exit;
    }

    public function unjoinRide($id){
        if (!isset($_SESSION['id'])) {
            $this->redirect('index.php?route=login');
            exit;
        }

        $user_id = $_SESSION['id'];
        $participationManager = new ParticipationManager();

        $participationManager->deleteParticipation($id, $user_id);

        $this->redirect('index.php?route=ride&id=' . $id);
        exit;
    } 

    public function editRide(int $id) 
    {
        // 1. SÉCURITÉ : L'utilisateur doit être connecté
        if (!isset($_SESSION['id'])) {
            $this->redirect('index.php?route=login');
            exit;
        }

        $rideManager = new RideManager();
        $ride = $rideManager->findOne($id);

        // 2. SÉCURITÉ : La balade doit exister en BDD
        if (!$ride) {
            $this->redirect('index.php?route=profile');
            exit;
        }

        // 3. SÉCURITÉ : Seul l'organisateur (ou un ADMIN) peut modifier la balade
        $isOwner = (int)$ride->getOrganizer_id() === (int)$_SESSION['id'];
        $isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'ADMIN';

        if (!$isOwner && !$isAdmin) {
            $this->redirect('index.php?route=profile');
            exit;
        }

        // 4. Traitement du formulaire au clic sur "Mettre à jour"
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // On vérifie que les champs obligatoires de notre modale sont bien remplis
            if (!empty($_POST['title']) && !empty($_POST['start_date']) && !empty($_POST['start_hour']) && !empty($_POST['start_location'])) {
                
                // Mise à jour de l'objet local avec les nouvelles données
                $ride->setTitle($_POST['title']);
                $ride->setStart_date($_POST['start_date']);
                $ride->setStart_hour($_POST['start_hour']);
                $ride->setStart_location($_POST['start_location']);

                /* Optionnel : Si tu utilises une API de géocodage pour avoir la latitude/longitude 
                   à partir de l'adresse, c'est ici qu'il faudrait la rappeler pour mettre à jour
                   $ride->setStart_latitude(...) et $ride->setStart_longitude(...) */

                // Sauvegarde définitive en BDD
                $rideManager->updateRide($ride);

                // Redirection vers le profil pour recharger la page proprement
                $this->redirect('index.php?route=profile');
                exit;
            }
        }

        // Redirection par sécurité si quelqu'un tente d'accéder à l'URL en direct sans envoyer le formulaire
        $this->redirect('index.php?route=profile');
        exit;
    }
}