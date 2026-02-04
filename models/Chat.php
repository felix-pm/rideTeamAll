<?php

class Chat
{

    public function __construct(private ?int $id, private Ride $ride_id, private User $user_id, private string $content, private date $creater_at)
    {

    } 

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
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


    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }


    public function getCreater_at()
    {
        return $this->creater_at;
    }

    public function setCreater_at($creater_at)
    {
        $this->creater_at = $creater_at;

        return $this;
    }
}

?>