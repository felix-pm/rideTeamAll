<?php

class Ride
{

    public function __construct(private ?int $id, private string $title, private string $description, private string $start_date, private string $start_location, private string $end_location, private int $difficulty_level, private int $max_participants, private User $organizer_id)
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


    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }


    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }


    public function getStart_date()
    {
        return $this->start_date;
    }

    public function setStart_date($start_date)
    {
        $this->start_date = $start_date;

        return $this;
    }


    public function getStart_location()
    {
        return $this->start_location;
    }

    public function setStart_location($start_location)
    {
        $this->start_location = $start_location;

        return $this;
    }


    public function getEnd_location()
    {
        return $this->end_location;
    }

    public function setEnd_location($end_location)
    {
        $this->end_location = $end_location;

        return $this;
    }


    public function getDifficulty_level()
    {
        return $this->difficulty_level;
    }

    public function setDifficulty_level($difficulty_level)
    {
        $this->difficulty_level = $difficulty_level;

        return $this;
    }


    public function getMax_participants()
    {
        return $this->max_participants;
    }

    public function setMax_participants($max_participants)
    {
        $this->max_participants = $max_participants;

        return $this;
    }


    public function getOrganizer_id() : User
    {
        return $this->organizer_id;
    }

    public function setOrganizer_id($organizer_id)
    {
        $this->organizer_id = $organizer_id;

        return $this;
    }
}

?>