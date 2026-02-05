<?php

class UserController extends AbstractController
{
    public function profile() :void
    {
        if(isset($_SESSION["id"] && $_SESSION["pseudo"]) && isset($_SESSION["email"]) && isset($_SESSION["role"]))
        {
            if($_SESSION["role"] === "ADMIN")
            {
                $this->redirect('index.php?route=list_admin');
            }
            else
            {
                $this->render('member/profile.html.twig', []);
            }
        }
        else
        {
            $this->render('auth/login.html.twig', []);
        }
    }

    public function profilOther() // ! faire une fonction pour voir le profil des autres utilisateurs

    // ! à voir si je la garde (ou si je change le nom)
    public function home()
    {
        if (!isset($_SESSION['id'])) {
            $this->redirect('index.php?route=login');
        }

        $userId = $_SESSION['id'];

        $manager = new Group_userManager();
        $myGroups = $manager->findGroupsByUserId($userId);

        

        return $this->render('home/home.html.twig', [
            "groups" => $myGroups            
    ]);
    }
}
