<?php

class Follow
{

    public function __construct(private int $follower_id, private int $followed_id, private string $created_at)
        {
        }
    

    public function getFollower_id()
    {
        return $this->follower_id;
    }

    public function setFollower_id($follower_id)
    {
        $this->follower_id = $follower_id;

        return $this;
    }


    public function getFollowed_id()
    {
        return $this->followed_id;
    }

    public function setFollowed_id($followed_id)
    {
        $this->followed_id = $followed_id;

        return $this;
    }


    public function getCreated_at()
    {
        return $this->created_at;
    }

    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }
}

?>