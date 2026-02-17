<?php

class UserController extends AbstractController
{
    public function profile() :void
    {
        if(isset($_SESSION["id"], $_SESSION["pseudo"], $_SESSION["email"], $_SESSION["role"]))
        {
            // AJOUT : Gestion du formulaire de modification
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['pseudo'], $_POST['email'])){
                    $manager = new UserManager();
                    // On récupère l'utilisateur actuel pour avoir son ID et ses infos actuelles
                    $user = $manager->findById($_SESSION['id']); 
                    
                    if ($user) {
                        // On met à jour l'objet avec les données du formulaire
                        $user->setPseudo($_POST['pseudo']);
                        $user->setEmail($_POST['email']);
                        
                        // Gestion simple du mot de passe (à améliorer avec hashage et vérification confirmPassword)
                        if (!empty($_POST['password'])) {
                            $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
                        }

                        // On sauvegarde en base
                        $manager->update($user);

                        // On met à jour la session pour que l'affichage change tout de suite
                        $_SESSION['pseudo'] = $user->getPseudo();
                        $_SESSION['email'] = $user->getEmail();
                    }
                }
            }

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

    public function create_way() :void{
        $this->render('member/create_way', []);
    }
}
