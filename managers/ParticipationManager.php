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
            $participation = new Participation($item["ride_id"], $item["user_id"], $item["created_at"]);
            $participations[] = $participation;
        }

        return $participations;
    }

    public function findParticipantsByRideId($ride_id) : array {
        $query = $this->db->prepare('SELECT users.pseudo, users.avatar, participations.* FROM participations JOIN users ON participations.user_id = users.id WHERE ride_id = :ride_id');
        $parameters = [
            "ride_id" => $ride_id
        ];
        $query->execute($parameters);

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $participations = [];

        foreach ($results as $item) {
            $participations[] = new Participation($item["ride_id"], $item["user_id"], $item["created_at"], $item["pseudo"], $item["avatar"]);
        }

        return $participations;
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
            return new Participation($item["ride_id"], $item["user_id"], $item["created_at"]);
        }

        return null;
    }

    // ? pour le créateur de la balade, il peut modifier les participants
    public function updateParticipation(Participation $participation, Ride $ride, User $user) {
        $query = $this->db->prepare('UPDATE participations SET ride_id = :ride_id, user_id = :user_id, created_at = :created_at WHERE ride_id = :ride_id');;
       $parameters = [
            ':ride_id' => $ride->getRide_id(),
            ':user_id' => $user->getUser_id(),
            ':created_at' => $participation->getCreated_at()
        ];
        $query->execute($parameters);
    }

    public function addParticipation(int $ride_id, int $user_id) : bool {
        $query = $this->db->prepare('
            INSERT IGNORE INTO participations (ride_id, user_id, created_at) 
            VALUES (:ride_id, :user_id, NOW())
        ');
        
        $parameters = [
            "ride_id" => $ride_id,
            "user_id" => $user_id
        ];
        
        $query->execute($parameters);

        return $query->rowCount() > 0;
    }

    public function deleteParticipation(int $ride_id, int $user_id) {
        $query = $this->db->prepare('DELETE FROM participations WHERE ride_id = :ride_id AND user_id = :user_id');

        $parameters = [
            ':ride_id' => $ride_id,
            "user_id" => $user_id
            
        ];

        $query->execute($parameters);
    }
}
