<?php

class Participation
{

    public function __construct(private Ride $ride_id, private User $user_id, private string $comments, private string $created_at)
    {

    }  

    public function getRide_id() : Ride
    {
        return $this->ride_id;
    }
 
    public function setRide_id($ride_id)
    {
        $this->ride_id = $ride_id;

        return $this;
    }

 
    public function getUser_id() : User
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