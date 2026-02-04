<?php

class RideManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll(int $user_id) : array
    {
        $query = $this->db->prepare('SELECT * FROM rides');
        $parameters = [
            "user_id" => $user_id
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

    public function findAll(int $user_id) : array
    {
        $query = $this->db->prepare('SELECT * FROM rides');
        $parameters = [
            "user_id" => $user_id
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $rides = [];

        foreach($result as $item)
        {
            $ride = new Ride($item["id"], $item["marque"], $item["modele"], $item["annee"], $item["user_id"]);
            $rides[] = $ride;
        }

        return $rides;
    }

    public function createRide() // ! a faire

    public function deleteRide() // ! a faire

    public function updateRide() // ! a faire
    // ? comment faire pour que ce soit uniquement la personne qui à créer le sortie qui puisse la modifier (l'admin aussi)

    public function signalerRide() // ! renvoie une notification à l'admin 
}
