<?php

class RideManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll() : array
    {
        $query = $this->db->prepare('
            SELECT * 
            FROM rides 
            WHERE start_date > CURDATE() 
            OR (start_date = CURDATE() AND start_hour > CURTIME())
        ');
        $parameters = [

        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $rides = [];

        foreach($result as $item)
        {
            // À remplacer dans findAll() ET dans findOne() :
            $ride = new Ride(
                $item["id"], 
                $item["title"], 
                $item["description"], 
                $item["start_hour"], 
                $item["start_date"], 
                $item["start_location"], 
                $item["start_latitude"],  
                $item["start_longitude"], 
                $item["end_location"], 
                $item["end_latitude"],    
                $item["end_longitude"],   
                $item["difficulty_level"], 
                $item["max_participants"], 
                $item["organizer_id"]
            );
            $rides[] = $ride;
        }

        return $rides;
    }

    public function findOne($id) {
        $query = $this->db->prepare('SELECT * FROM rides WHERE id = :id');
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $item = $query->fetch(PDO::FETCH_ASSOC);

        if($item)
        {
            return $ride = new Ride(
                    $item["id"], 
                    $item["title"], 
                    $item["description"], 
                    $item["start_hour"], 
                    $item["start_date"], 
                    $item["start_location"], 
                    $item["start_latitude"],  
                    $item["start_longitude"], 
                    $item["end_location"], 
                    $item["end_latitude"],    
                    $item["end_longitude"],   
                    $item["difficulty_level"], 
                    $item["max_participants"], 
                    $item["organizer_id"]
                );
        }

        return null;
    }

    public function createRide(Ride $ride) {
        $query = $this->db->prepare("INSERT INTO rides (
                    title, 
                    description, 
                    start_date, 
                    start_hour, 
                    start_location, 
                    start_latitude,
                    start_longitude,
                    end_location, 
                    end_latitude,
                    end_longitude,
                    difficulty_level, 
                    max_participants, 
                    organizer_id
                ) VALUES (
                    :title, 
                    :description, 
                    :start_date, 
                    :start_hour, 
                    :start_location, 
                    :start_latitude,
                    :start_longitude,
                    :end_location, 
                    :end_latitude,
                    :end_longitude,
                    :difficulty_level, 
                    :max_participants, 
                    :organizer_id
                )");
                
        $parameters = [
            ':title' => $ride->getTitle(), 
            ':description' => $ride->getDescription(),
            ':start_hour' => $ride->getStart_hour(),
            ':start_date' => $ride->getStart_date(),
            ':start_location' => $ride->getStart_location(),
            ':start_latitude' => $ride->getStart_latitude(), 
            ':start_longitude' => $ride->getStart_longitude(),
            ':end_location' => $ride->getEnd_location(),
            ':end_latitude' => $ride->getEnd_latitude(), 
            ':end_longitude' => $ride->getEnd_longitude(), 
            ':difficulty_level' => $ride->getDifficulty_level(),
            ':max_participants'  => $ride->getMax_participants(),
            ':organizer_id' => $ride->getOrganizer_id(),
        ];

        $query->execute($parameters);
}

    public function deleteRide($ride) {
        $query = $this->db->prepare('DELETE FROM rides WHERE id = :id');
        $parameters = [
            "id" => $ride->getId()
        ];
        $query->execute($parameters);
    }

    // ! comment faire pour que ce soit uniquement la personne qui à créer le sortie qui puisse la modifier (l'admin aussi)
    public function addRide() {
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if (empty($_POST["title"]) || empty($_POST["description"]) || empty($_POST["start_hour"]) || empty($_POST["start_date"]) || empty($_POST["start_location"]) || empty($_POST["end_location"]) || empty($_POST["difficulty_level"]) || empty($_POST["max_participants"]))
        {
            $errors[] = "Veuillez remplir tous les champs !";
        }
        $manager = new RideManager();
        
        if (empty($errors)) {
            // 1. On récupère les coordonnées via l'API
            $startCoords = $this->getCoordinates($_POST['start_location']);
            $endCoords = $this->getCoordinates($_POST['end_location']);
   
            $rideToCreate = new Ride(
                    $item["id"], 
                    $item["title"], 
                    $item["description"], 
                    $item["start_hour"], 
                    $item["start_date"], 
                    $item["start_location"], 
                    $item["start_latitude"],  
                    $item["start_longitude"], 
                    $item["end_location"], 
                    $item["end_latitude"],    
                    $item["end_longitude"],   
                    $item["difficulty_level"], 
                    $item["max_participants"], 
                    $item["organizer_id"]
                );
            $manager->createRide($rideToCreate);
            $this->redirect('index.php?route=home');
            exit;
        }
    }
    $this->render('member/create_way', ['errors' => $errors]);
}
    

    public function signalerRide() {} // ! a faire en js 
}
