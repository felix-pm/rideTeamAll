<?php

class ParticipationManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll() {
        $query = $this->db->prepare('SELECT * FROM participations');
        $parameters = [

        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $participations = [];

        foreach($result as $item)
        {
            $participation = new Participation($item["ride_id"], $item["user_id"], $item["comments"], $item["created_at"]);
            $participations[] = $participation;
        }

        return $participations;
    }

    public function findOneByRideId() {
        $query = $this->db->prepare('SELECT * FROM participations WHERE ride_id = :ride_id');
        $parameters = [
            "ride_id" => $ride_id
        ];
        $query->execute($parameters);
        $item = $query->fetch(PDO::FETCH_ASSOC);

        if($item)
        {
            return new Participation($item["ride_id"], $item["user_id"], $item["comments"], $item["created_at"]);
        }

        return null;
    }

    public function findOneByUserId(int $user_id) {
        $query = $this->db->prepare('SELECT * FROM participations WHERE user_id = :user_id');
        $parameters = [
            "user_id" => $user_id
        ];
        $query->execute($parameters);
        $item = $query->fetch(PDO::FETCH_ASSOC);

        if($item)
        {
            return new Participation($item["ride_id"], $item["user_id"], $item["comments"], $item["created_at"]);
        }

        return null;
    }

    public function createParticipation(Participation $participation, Ride $ride, User $user) {
            $query = $this->db->prepare("INSERT INTO participations VALUES (:ride_id, :user_id, :comments, :created_at)");
            $parameters = [
                ':ride_id' => $ride->getRide_id(),
                ':user_id' => $user->getUser_id(),
                ':comments' => $participation->getComments(),
                ':created_at' => $participation->getCreated_at()
            ];

            // 3. On exécute
            $query->execute($parameters);
        }

    public function deleteParticipation() {
        $query = $this->db->prepare('DELETE FROM participations WHERE ride_id = :ride_id');
        $parameters = [
            ':ride_id' => $ride->getRide_id()
        ];
        $query->execute($parameters);
    }

    // ? pour le créateur de la balade, il peut modifier les participants
    public function updateParticipation(Participation $participation, Ride $ride, User $user) {
        $query = $this->db->prepare('UPDATE participations SET ride_id = :ride_id, user_id = :user_id, comments = :comments, created_at = :created_at WHERE ride_id = :ride_id');;
       $parameters = [
            ':ride_id' => $ride->getRide_id(),
            ':user_id' => $user->getUser_id(),
            ':comments' => $participation->getComments(),
            ':created_at' => $participation->getCreated_at()
        ];
        $query->execute($parameters);
    }
}
