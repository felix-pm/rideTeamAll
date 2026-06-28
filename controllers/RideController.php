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
        if (!isset($_SESSION['id'])) {
            $this->redirect('index.php?route=login');
            exit;
        }

        $rideManager = new RideManager();
        $ride = $rideManager->findOne($id);

        // on regarde si la balade existe en BDD
        if (!$ride) {
            $this->redirect('index.php?route=profile');
            exit;
        }

        // il faut être l'organisateur ou l'admin pour modifier la balade
        $isOwner = (int)$ride->getOrganizer_id() === (int)$_SESSION['id'];
        $isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'ADMIN';

        if (!$isOwner && !$isAdmin) {
            $this->redirect('index.php?route=profile');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['title']) && !empty($_POST['start_date']) && !empty($_POST['start_hour']) && !empty($_POST['start_location'])) {
                $ride->setTitle($_POST['title']);
                $ride->setStart_date($_POST['start_date']);
                $ride->setStart_hour($_POST['start_hour']);
                $ride->setStart_location($_POST['start_location']);
                $rideManager->updateRide($ride);

                $this->redirect('index.php?route=profile');
                exit;
            }
        }

        $this->redirect('index.php?route=profile');
        exit;
    }
}