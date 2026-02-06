<?php

class SignalementManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll() : array
    {
        $query = $this->db->prepare('SELECT * FROM signalements');
        $parameters = [

        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $signalements = [];

        foreach($result as $item)
        {
            $signalement = new Signalement($item["id"], $item["title"], $item["comments"], $item["user_id_createur"], $item["user_id_signaler"]);
            $signalements[] = $signalement;
        }

        return $signalements;
    }

    public function findById(int $id)
    {
        $query = $this->db->prepare('SELECT * FROM signalements WHERE id = :id');
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $item = $query->fetch(PDO::FETCH_ASSOC);

        if($item)
        {
            return new Signalement($item["id"], $item["title"], $item["comments"], $item["user_id_createur"], $item["user_id_signaler"]);
        }

        return null;
    }

    public function createSignalement(Signalement $signalement, User $user)
        {
            $query = $this->db->prepare("INSERT INTO participations VALUES (:id, :title, :comments, :user_id_createur, :user_id_signaler)");
            $parameters = [
                ':title' => $signalement->getTitle(),
                ':comments' => $signalement->getComments(),
                ':user_id_createur' => $user->getUser_id_createur(),
                ':user_id_signaler' => $user->getUser_id_signaler()
            ];

            $query->execute($parameters);
        }

    public function update() {} // ! a faire si besoin

    public function delete(Signalement $signalement) : void
    {
        $query = $this->db->prepare('DELETE FROM participations WHERE id = :id');
        $parameters = [
            "id" => $user->getId()
        ];
        $query->execute($parameters);
    }
}
