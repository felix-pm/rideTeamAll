<?php

class UserController extends AbstractController
{
    public function profile() :void
    {
        if(isset($_SESSION["id"], $_SESSION["pseudo"], $_SESSION["email"], $_SESSION["role"]))
        {
            if($_SESSION["role"] === "ADMIN")
            {
                $this->redirect('index.php?route=list_admin');
            }
            else
            {
                $this->render('member/profile', []);
            }
        }
        else
        {
            $this->render('auth/login', []);
        }
    }

    public function profilOther() {} // ! faire une fonction pour voir le profil des autres utilisateurs

    // ! à voir si je la garde (ou si je change le nom)
    public function home()
    {
        // if (!isset($_SESSION['id'])) {
        //     $this->redirect('index.php?route=login');
        // }

        $userId = $_SESSION['id'] ?? null;

        $manager = new RideManager();

        $rides = $manager->findAll(); 

        return $this->render('member/home', [
            "rides" => $rides
        ]);
    }

    public function follow(): void
    {
        $this->render('member/follow', []);
    }

    public function map(): void
    {
        $this->render('member/map', []);
    }
}
