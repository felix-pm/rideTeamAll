<?php

class BikeManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAllBikeByUserId(int $user_id) : array
    {
        $query = $this->db->prepare('SELECT * FROM categories WHERE user_id = :user_id');
        $parameters = [
            "user_id" => $user_id
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $bikes = [];

        foreach($result as $item)
        {
            $bike = new Bike($item["id"], $item["marque"], $item["modele"], $item["annee"], $item["user_id"]);
            $bikes[] = $bike;
        }

        return $bikes;
    }

    public function findOneBike(int $user_id) : array
    {
        $query = $this->db->prepare('SELECT * FROM categories WHERE user_id = :user_id AND id = :id');
        $parameters = [
            "user_id" => $user_id
            "id" => $id
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $bikes = [];

        foreach($result as $item)
        {
            $bike = new Bike($item["id"], $item["marque"], $item["modele"], $item["annee"], $item["user_id"]);
            $bikes[] = $bike;
        }

        return $bikes;
    }

    public function createBike() // ! a faire

    public function deleteBike() // ! a faire

    public function updateBike() // ! a faire
    // ? comment faire pour que ce soit uniquement la personne à qui appartient la moto qui puisse modifier les specs (l'admin aussi)
}
