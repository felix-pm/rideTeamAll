<?php

class RideController extends AbstractController
{
    public function addRide() {
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

                $manager->createRide($rideToCreate);
                $this->redirect('index.php?route=home');
                exit;
            }
        }
        $this->render('member/create_way', ['errors' => $errors]);
    }


    public function api_list()
    {
        $manager = new RideManager();
        $ridesObjects = $manager->findAll(); 

        $ridesArray = [];
        foreach($ridesObjects as $ride) {
            $ridesArray[] = [
                'id' => $ride->getId(),
                'title' => $ride->getTitle(),
                'description' => $ride->getDescription(),
                'startHour' => $ride->getStart_hour(),
                'date' => $ride->getStart_date(),
                'startLocation' => $ride->getStart_location(),
                'endLocation' => $ride->getEnd_location(),
                'difficultyLevel' => $ride->getDifficulty_level(),
                'getMaxParticipants' => $ride->getMax_participants(),
                'getOrganizerId' => $ride->getOrganizer_id()
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($ridesArray);
        exit;
    }
}