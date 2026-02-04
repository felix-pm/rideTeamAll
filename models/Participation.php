<?php

class Participation
{

    public function __construct(private int $ride_id, private int $user_id, private string $comments, private string $created_at)
    {

    }  

    public function getRide_id()
    {
        return $this->ride_id;
    }
 
    public function setRide_id($ride_id)
    {
        $this->ride_id = $ride_id;

        return $this;
    }

 
    public function getUser_id()
    {
        return $this->user_id;
    }

    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }


    public function getComments()
    {
        return $this->comments;
    }

    public function setComments($comments)
    {
        $this->comments = $comments;

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