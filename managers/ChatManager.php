<?php

class ChatManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMessagesByRide(int $rideId): array
    {
        $query = "SELECT c.*, u.pseudo, u.avatar 
                  FROM chat c 
                  JOIN users u ON c.user_id = u.id 
                  WHERE c.ride_id = ? 
                  ORDER BY c.created_at ASC";
                  
        $stmt = $this->db->prepare($query);
        $stmt->execute([$rideId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Sauvegarde un nouveau message en BDD
     */
    public function saveMessage(int $rideId, int $userId, string $content): bool
    {
        $query = "INSERT INTO chat (ride_id, user_id, content, created_at) 
                  VALUES (?, ?, ?, NOW())";
                  
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$rideId, $userId, $content]);
    }
}
