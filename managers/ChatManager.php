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

    public function saveMessage(int $rideId, int $userId, string $content): bool
    {
        $query = "INSERT INTO chat (ride_id, user_id, content, created_at) 
                  VALUES (?, ?, ?, NOW())";
                  
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$rideId, $userId, $content]);
    }

    public function getStats() {
        $stats = [];
        try {
            $stats['total'] = $this->db->query('SELECT COUNT(*) FROM chat')->fetchColumn();
            $stats['today'] = $this->db->query('SELECT COUNT(*) FROM chat WHERE DATE(created_at) = CURDATE()')->fetchColumn();
            $stats['month'] = $this->db->query('SELECT COUNT(*) FROM chat WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())')->fetchColumn();
        } catch(Exception $e) {
            $stats['total'] = 0; $stats['today'] = 0; $stats['month'] = 0;
        }
        return $stats;
    }
}
