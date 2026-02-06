<?php

class Signalement
{

    public function __construct(private ?int $id, private string $title, private string $comments, private int $user_id_createur, private int $user_id_signaler)
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


    public function getComments()
    {
        return $this->comments;
    }

    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }


    public function getUser_id_createur()
    {
        return $this->user_id_createur;
    }

    public function setUser_id_createur($user_id_createur)
    {
        $this->user_id_createur = $user_id_createur;

        return $this;
    }


    public function getUser_id_signaler()
    {
        return $this->user_id_signaler;
    }

    public function setUser_id_signaler($user_id_signaler)
    {
        $this->user_id_signaler = $user_id_signaler;

        return $this;
    }
}

?>