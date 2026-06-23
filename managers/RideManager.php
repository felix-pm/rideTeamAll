<?php

class RideManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll() : array {
        $query = $this->db->prepare('
            SELECT rides.*, users.pseudo AS organizer_pseudo FROM rides JOIN users ON rides.organizer_id = users.id WHERE start_date > CURDATE() OR (start_date = CURDATE() AND start_hour > CURTIME())
        ');
        $parameters = [

        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $rides = [];

        foreach($result as $item)
        {
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
                $item["organizer_id"],
                $item["organizer_pseudo"]
            );
            $rides[] = $ride;
        }

        return $rides;
    }

    public function ridesFollowed($user_id) : array {
        $query = $this->db->prepare('
            SELECT rides.*, users.pseudo AS organizer_pseudo 
            FROM rides 
            JOIN follows ON rides.organizer_id = follows.followed_id 
            JOIN users ON rides.organizer_id = users.id
            WHERE follows.follower_id = :user_id
            AND start_date > CURDATE() OR (start_date = CURDATE() AND start_hour > CURTIME())
        ');
        $parameters = [
            "user_id" => $user_id
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $rides = [];

        foreach($result as $item)
        {
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
                $item["organizer_id"],
                $item["organizer_pseudo"]
            );
            $rides[] = $ride;
        }

        return $rides;
    }

    public function searchRides(string $keyword): array{
        $query = $this->db->prepare('
            SELECT rides.*, users.pseudo AS organizer_pseudo 
            FROM rides 
            JOIN users ON rides.organizer_id = users.id 
            WHERE (title LIKE :keyword OR start_location LIKE :keyword) 
            AND (start_date > CURDATE() OR (start_date = CURDATE() AND start_hour > CURTIME()))
        ');
        
        $parameters = [
            'keyword' => '%' . $keyword . '%'
        ];
        
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $rides = [];

        foreach($result as $item) {
            $rides[] = new Ride(
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
                $item["organizer_id"],
                $item["organizer_pseudo"]
            );
        }

        return $rides;
    }

    public function findRidesByOrganizerId($user_id) : array {
        $query = $this->db->prepare('
            SELECT rides.*, users.pseudo AS organizer_pseudo 
            FROM rides 
            JOIN users ON rides.organizer_id = users.id 
            WHERE rides.organizer_id = :user_id
            AND (rides.start_date > CURDATE() OR (rides.start_date = CURDATE() AND rides.start_hour > CURTIME()))
            ORDER BY rides.start_date ASC
        ');
        
        $query->execute(['user_id' => $user_id]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $rides = [];

        foreach($result as $item) {
            $rides[] = new Ride(
                $item["id"], $item["title"], $item["description"], 
                $item["start_hour"], $item["start_date"], 
                $item["start_location"], $item["start_latitude"],  
                $item["start_longitude"], $item["end_location"], 
                $item["end_latitude"], $item["end_longitude"],   
                $item["difficulty_level"], $item["max_participants"], 
                $item["organizer_id"], $item["organizer_pseudo"]
            );
        }

        return $rides;
    }

    public function findPastParticiaptionsByUserid($user_id){
        $query = $this->db->prepare('
        SELECT rides.*, users.pseudo AS organizer_pseudo FROM rides 
        JOIN participations ON rides.id = participations.ride_id 
        JOIN users ON rides.organizer_id = users.id 
        WHERE (start_date < CURDATE() OR (start_date = CURDATE() AND start_hour < CURTIME())) 
        AND :user_id = participations.user_id
        ');

        $parameters = [
            "user_id" => $user_id
        ];

        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $rides = [];

        foreach($result as $item)
        {
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
                $item["organizer_id"],
                $item["organizer_pseudo"]
            );
            $rides[] = $ride;
        }

        return $rides;
    }
    

    public function findFutureParticiaptionsByUserid($user_id){
        $query = $this->db->prepare('
        SELECT rides.*, users.pseudo AS organizer_pseudo FROM rides 
        JOIN participations ON rides.id = participations.ride_id 
        JOIN users ON rides.organizer_id = users.id 
        WHERE (start_date > CURDATE() OR (start_date = CURDATE() AND start_hour > CURTIME())) 
        AND :user_id = participations.user_id
        ');

        $parameters = [
            "user_id" => $user_id
        ];

        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $rides = [];

        foreach($result as $item)
        {
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
                $item["organizer_id"],
                $item["organizer_pseudo"]
            );
            $rides[] = $ride;
        }

        return $rides;
    }

    public function isParticipating(int $user_id, int $ride_id) : bool {
        $query = $this->db->prepare("SELECT count(*) FROM participations WHERE user_id = :user_id AND ride_id = :ride_id");

        $parameters = [
            ':user_id' => $user_id, 
            ':ride_id' => $ride_id
        ];

        $query->execute($parameters);

        return $query->fetchColumn() > 0;
    }

    public function findOne($id) {
        $query = $this->db->prepare('
            SELECT rides.*, users.pseudo AS organizer_pseudo 
            FROM rides 
            JOIN users ON rides.organizer_id = users.id 
            WHERE rides.id = :id
        ');        
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
                    $item["organizer_id"], 
                    $item["organizer_pseudo"]
                );
        }

        return null;
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

    public function createRide(Ride $ride, $user_id) {
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



        $ride_id = $this->db->lastInsertId();

        $queryParticipationOrganizer = $this->db->prepare('INSERT INTO participations (ride_id, user_id, created_at) VALUES (:ride_id, :user_id, NOW())');

         $parametersParticipationOrganizer = [
            "user_id" => $user_id,
            "ride_id" => $ride_id
        ];

        $queryParticipationOrganizer->execute($parametersParticipationOrganizer);
    }
    

    public function updateRide(Ride $ride) 
    {
        $query = $this->db->prepare("
            UPDATE rides 
            SET title = :title, 
                description = :description, 
                start_date = :start_date, 
                start_hour = :start_hour, 
                start_location = :start_location, 
                start_latitude = :start_latitude,
                start_longitude = :start_longitude,
                end_location = :end_location, 
                end_latitude = :end_latitude,
                end_longitude = :end_longitude,
                difficulty_level = :difficulty_level, 
                max_participants = :max_participants
            WHERE id = :id
        ");
                
        $parameters = [
            ':id' => $ride->getId(),
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
            ':max_participants'  => $ride->getMax_participants()
        ];

        $query->execute($parameters);
    }

    public function getStats() {
        $stats = [];
        // Total balades créées
        $stats['total'] = $this->db->query('SELECT COUNT(*) FROM rides')->fetchColumn();
        // Balades en cours / à venir
        $stats['active'] = $this->db->query('SELECT COUNT(*) FROM rides WHERE start_date > CURDATE() OR (start_date = CURDATE() AND start_hour > CURTIME())')->fetchColumn();
        // Balades créées ce mois-ci
        $stats['month'] = $this->db->query('SELECT COUNT(*) FROM rides WHERE MONTH(start_date) = MONTH(CURDATE()) AND YEAR(start_date) = YEAR(CURDATE())')->fetchColumn();

        return $stats;
    }
}



