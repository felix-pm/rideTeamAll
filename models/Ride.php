<?php

class Ride
{
    public function __construct(
        private ?int $id, 
        private string $title, 
        private string $description, 
        private string $start_hour, 
        private string $start_date, 
        private string $start_location,
        private ?float $start_latitude,   
        private ?float $start_longitude,  
        private string $end_location, 
        private ?float $end_latitude,     
        private ?float $end_longitude,    
        private int $difficulty_level, 
        private int $max_participants, 
        private int $organizer_id,
        private ?string $organizer_pseudo = null
    ) {
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
    
    public function getStart_hour()
    {
        return $this->start_hour;
    }

    public function setStart_hour($start_hour)
    {
        $this->start_hour = $start_hour;
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


    public function getStart_latitude()
    {
        return $this->start_latitude;
    }

    public function setStart_latitude($start_latitude)
    {
        $this->start_latitude = $start_latitude;
        return $this;
    }

    public function getStart_longitude()
    {
        return $this->start_longitude;
    }

    public function setStart_longitude($start_longitude)
    {
        $this->start_longitude = $start_longitude;
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


    public function getEnd_latitude()
    {
        return $this->end_latitude;
    }

    public function setEnd_latitude($end_latitude)
    {
        $this->end_latitude = $end_latitude;
        return $this;
    }

    public function getEnd_longitude()
    {
        return $this->end_longitude;
    }

    public function setEnd_longitude($end_longitude)
    {
        $this->end_longitude = $end_longitude;
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

    public function getOrganizer_id()
    {
        return $this->organizer_id;
    }

    public function setOrganizer_id($organizer_id)
    {
        $this->organizer_id = $organizer_id;
        return $this;
    }

    public function getOrganizer_pseudo(): ?string
    {
        return $this->organizer_pseudo;
    }

    public function setOrganizer_pseudo($organizer_pseudo): self
    {
        $this->organizer_pseudo = $organizer_pseudo;
        return $this;
    }
}

?>