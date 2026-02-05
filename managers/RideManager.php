<?php

class RideManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll() : array
    {
        $query = $this->db->prepare('SELECT * FROM rides');
        $parameters = [

        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $rides = [];

        foreach($result as $item)
        {
            $ride = new Ride($item["id"], $item["title"], $item["description"], $item["start_date"], $item["start_location"], $item["end_location"], $item["difficulty_level"], $item["max_participants"], $item["organizer_id"]);
            $rides[] = $ride;
        }

        return $rides;
    }

    public function findOne() {
        $query = $this->db->prepare('SELECT * FROM rides WHERE id = :id');
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $item = $query->fetch(PDO::FETCH_ASSOC);

        if($item)
        {
            return new Ride($item["id"], $item["title"], $item["description"], $item["start_date"], $item["start_location"], $item["end_location"], $item["difficulty_level"], $item["max_participants"], $item["organizer_id"]);
        }

        return null;
    }

    public function createRide(Ride $ride, User $user) {
        $query = $this->db->prepare("INSERT INTO rides VALUES (:title, :description, :start_date, :start_location, :end_location, :difficulty_level, :max_participants, :organizer_id)");
        $parameters = [
            ':title' => $ride->getTitle(), 
            ':description' => $ride->getDescription(),
            ':start_date' => $ride->getStart_date(),
            ':start_location' => $ride->getStart_location(),
            ':end_location' => $ride->getEnd_location(),
            ':difficulty_level' => $ride->getDifficulty_level(),
            ':max_participants'  => $ride->getMax_participants(),
            ':organizer_id' => $user->getId(),
        ];

        // 3. On exécute
        $query->execute($parameters);
        }

    public function deleteRide() {
        $query = $this->db->prepare('DELETE FROM rides WHERE id = :id');
        $parameters = [
            "id" => $user->getId()
        ];
        $query->execute($parameters);
    }

    // ! comment faire pour que ce soit uniquement la personne qui à créer le sortie qui puisse la modifier (l'admin aussi)
    public function updateRide() { 
        $query = $this->db->prepare('UPDATE users SET title = :title, description = :description, start_date = :start_date, start_location = :start_location, end_location = :end_location, difficulty_level = :difficulty_level, max_participants = :max_participants, organizer_id = :organizer_id WHERE id = :id');;
        $parameters = [
            ':title' => $ride->getTitle(), 
            ':description' => $ride->getDescription(),
            ':start_date' => $ride->getStart_date(),
            ':start_location' => $ride->getStart_location(),
            ':end_location' => $ride->getEnd_location(),
            ':difficulty_level' => $ride->getDifficulty_level(),
            ':max_participants'  => $ride->getMax_participants(),
            ':organizer_id' => $user->getId(),
        ];
        $query->execute($parameters);
    }
    

    public function signalerRide() // ! a faire en js 
}
