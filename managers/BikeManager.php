<?php

class BikeManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAllBikeByUserId(int $user_id) : array
    {
        $query = $this->db->prepare('SELECT * FROM bikes WHERE user_id = :user_id');
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
        $query = $this->db->prepare('SELECT * FROM bikes WHERE user_id = :user_id AND id = :id');
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

    public function createBike(Bike $bike, User $user) {
        $query = $this->db->prepare("INSERT INTO bikes (marque, modele, annee, user_id) VALUES (:marque, :modele, :annee, :user_id)");
            $parameters = [
                ':marque' => $bike->getMarque(),
                ':modele' => $bike->getModele(),
                ':annee' => $bike->getAnnee(),
                ':user_id' => $user->getId(),
            ];

            $query->execute($parameters);
    }

    public function deleteBike() {
        $query = $this->db->prepare('DELETE FROM bikes WHERE id = :id');
        $parameters = [
            "id" => $bike->getId()
        ];
        $query->execute($parameters);
    }

    public function updateBike() {
        $query = $this->db->prepare('UPDATE bikes SET marque = :marque, modele = :modele, annee = :annee WHERE id = :id');;
        $parameters = [
            ':marque' => $bike->getMarque(),
            ':modele' => $bike->getModele(),
            ':annee' => $bike->getAnnee(),
            ':user_id' => $user->getId(),
        ];
        $query->execute($parameters);
    }
    // ? comment faire pour que ce soit uniquement la personne à qui appartient la moto qui puisse modifier les specs (l'admin aussi)
}
