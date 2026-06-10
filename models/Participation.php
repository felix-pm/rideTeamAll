<?php

class Participation
{

    public function __construct(private int $ride_id, private int $user_id, private string $created_at, private ?string $user_pseudo = null, private ?string $user_avatar = null)
    {

    }  

    public function getRide_id() : int
    {
        return $this->ride_id;
    }
 
    public function setRide_id($ride_id)
    {
        $this->ride_id = $ride_id;

        return $this;
    }

 
    public function getUser_id() : int
    {
        return $this->user_id;
    }

    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

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


    public function getUser_pseudo()
    {
        return $this->user_pseudo;
    }

    public function setUser_pseudo($user_pseudo)
    {
        $this->user_pseudo = $user_pseudo;

        return $this;
    }


    public function getUser_avatar()
    {
        return $this->user_avatar;
    }

    public function setUser_avatar($user_avatar)
    {
        $this->user_avatar = $user_avatar;

        return $this;
    }
}

?>