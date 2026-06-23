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

        $userManager = new UserManager();
        $user = $userManager->findById($user_id);

        foreach($result as $item)
        {
            $bike = new Bike($item["id"], $item["marque"], $item["modele"], $item["annee"], $user, $item["url"]);
            $bikes[] = $bike;
        }

        return $bikes;
    }

    public function findOneBikeById(int $id) : ?Bike
    {
        $query = $this->db->prepare('SELECT * FROM bikes WHERE id = :id');
        $query->execute(['id' => $id]);
        $item = $query->fetch(PDO::FETCH_ASSOC);

        if (!$item) {
            return null;
        }

        $userManager = new UserManager();
        $user = $userManager->findById($item['user_id']);

        return new Bike($item["id"], $item["marque"], $item["modele"], $item["annee"], $user, $item["url"]);
    }

    public function createBike(Bike $bike, User $user) {
        $query = $this->db->prepare("INSERT INTO bikes (marque, modele, annee, url, user_id) VALUES (:marque, :modele, :annee, :url, :user_id)");
            $parameters = [
                ':marque' => $bike->getMarque(),
                ':modele' => $bike->getModele(),
                ':annee' => $bike->getAnnee(),
                ':url' => $bike->getUrl(),
                ':user_id' => $user->getId()
            ];

            $query->execute($parameters);
    }

    public function deleteBike(Bike $bike) {
        $query = $this->db->prepare('DELETE FROM bikes WHERE user_id = :user_id AND id = :id');
        $parameters = [
            "id" => $bike->getId()
        ];
        $query->execute($parameters);
    }

    public function updateBike(Bike $bike) : void {
        $query = $this->db->prepare('UPDATE bikes SET marque = :marque, modele = :modele, url = :url, annee = :annee WHERE id = :id');
        $parameters = [
            ':id' => $bike->getId(),
            ':marque' => $bike->getMarque(),
            ':modele' => $bike->getModele(),
            ':annee' => $bike->getAnnee(),
            ':url' => $bike->getUrl()
        ];
        $query->execute($parameters);
    }
}
