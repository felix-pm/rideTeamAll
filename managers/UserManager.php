<?php

class UserManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll() : array
    {
        $query = $this->db->prepare('SELECT * FROM users');
        $parameters = [

        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $users = [];

        foreach($result as $item)
        {
            $user = new User($item["id"], $item["pseudo"], $item["email"], $item["password"], $item["role"], $item["avatar"]);
            $users[] = $user;
        }

        return $users;
    }

    public function findById(int $id) : ? User
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $item = $query->fetch(PDO::FETCH_ASSOC);

        if($item)
        {
            return new User($item["id"], $item["pseudo"], $item["email"], $item["password"], $item["role"], $item["avatar"]);
        }

        return null;
    }

    public function findByEmail(string $email): ?User
        {
            $query = $this->db->prepare('SELECT * FROM users WHERE email = :email');
            $query->execute([':email' => $email]);
            $data = $query->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                return new User(
                    $data['id'],        
                    $data['pseudo'],  
                    $data['email'],   
                    $data['password'],
                    $data['role'],
                    $data['avatar']   
                );
            }

            return null;
        }

    public function create_user(User $user)
        {
            $query = $this->db->prepare("INSERT INTO users (pseudo, email, password, role, avatar) VALUES (:pseudo, :email, :password, :role, :avatar)");
            $parameters = [
                ':pseudo' => $user->getPseudo(),
                ':email'     => $user->getEmail(),
                ':password'  => $user->getPassword(),
                ':role'      => $user->getRole()
                ':avatar'    => $user->getAvatar()
            ];

            $query->execute($parameters);
        }

    public function update(User $user) : void
    {
        $query = $this->db->prepare('UPDATE users SET pseudo = :pseudo, email = :email, password = :password, role = :role, avatar = :avatar WHERE id = :id');;
        $parameters = [
                ':pseudo' => $user->getPseudo(),
                ':email'     => $user->getEmail(),
                ':password'  => $user->getPassword(),
                ':role'      => $user->getRole()
                ':avatar'    => $user->getAvatar()
            ];
        $query->execute($parameters);
    }

    public function delete(User $user) : void
    {
        $query = $this->db->prepare('DELETE FROM users WHERE id = :id');
        $parameters = [
            "id" => $user->getId()
        ];
        $query->execute($parameters);
    }
}
