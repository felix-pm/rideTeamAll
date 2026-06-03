<?php

class FollowManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll() : array
    {
        $query = $this->db->prepare('SELECT * FROM follows');
        $parameters = [

        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $follows = [];

        foreach($result as $item)
        {
            $follow = new Follow(
                $item["follower_id"], 
                $item["followed_id"], 
                $item["created_at"]
            );
            $follows[] = $follow;
        }

        return $follows;
    }

    public function findOne($id) {
        $query = $this->db->prepare('SELECT * FROM follows WHERE id = :id');
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $item = $query->fetch(PDO::FETCH_ASSOC);

        if($item)
        {
            return $follow = new Follow(
                    $item["follower_id"], 
                    $item["followed_id"], 
                    $item["created_at"]
                );
        }

        return null;
    }

    public function follow(int $follower_id, int $followed_id) {
        $query = $this->db->prepare("INSERT IGNORE INTO follows (
                    follower_id, 
                    followed_id, 
                    created_at
                ) VALUES (
                    :follower_id, 
                    :followed_id, 
                    NOW()
                )");
                
        $parameters = [
            ':follower_id' => $follower_id, 
            ':followed_id' => $followed_id
        ];

        $query->execute($parameters);
    }

    public function unfollow(int $follower_id, int $followed_id) {
        $query = $this->db->prepare("DELETE FROM follows WHERE follower_id = :follower_id AND followed_id = :followed_id;");
                
        $parameters = [
            ':follower_id' => $follower_id, 
            ':followed_id' => $followed_id
        ];

        $query->execute($parameters);
    }

    public function countFollowers(int $user_id) : int {
        $query = $this->db->prepare("SELECT COUNT(*) FROM follows WHERE followed_id = :user_id");
        
        $query->execute([
            ':user_id' => $user_id
        ]);
        
        return (int) $query->fetchColumn();
    }

    public function countFolloweds(int $user_id) : int {
        $query = $this->db->prepare("SELECT COUNT(*) FROM follows WHERE follower_id = :user_id");
        
        $query->execute([
            ':user_id' => $user_id
        ]);
        
        return (int) $query->fetchColumn();
    }

    public function isFollowing(int $follower_id, int $followed_id) : bool {
        $query = $this->db->prepare("SELECT count(*) FROM follows WHERE follower_id = :follower_id AND followed_id = :followed_id");

        $query->execute([
            ':follower_id' => $follower_id,
            ':followed_id' => $followed_id
        ]);

        return $query->fetchColumn() > 0;
    }
}

