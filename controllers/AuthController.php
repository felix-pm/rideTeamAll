<?php

class AuthController extends AbstractController
{
    public function login(): void {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if (empty($_POST["email"]) || empty($_POST["password"])) {
                $errors[] = "Veuillez remplir tous les champs !";
            }

            if (empty($errors)) {
                $manager = new UserManager();
                $user = $manager->findByEmail($_POST["email"]);
                if ($user !== null) {
                    $hashedPassword = $user->getPassword();
                    if (password_verify($_POST["password"], $hashedPassword)) {
                        $_SESSION["id"] = $user->getId();
                        $_SESSION['pseudo'] = $user->getPseudo();
                        $_SESSION['email'] = $user->getEmail();
                        $_SESSION['role'] = $user->getRole();
                        $_SESSION['avatar'] = $user->getAvatar();
                        if($user->getRole() === 'ADMIN')
                        {
                            $this->redirect("index.php?route=admin");
                        }
                        else 
                        {
                            $this->redirect("index.php?route=home");
                        }
                        exit;
                    } else {
                        $errors[] = "Identifiants incorrects (mot de passe).";
                    }
                } else {
                    $errors[] = "Identifiants incorrects (email).";
                }
            }
        }

        $this->render('auth/login', ['errors' => $errors]);
    }


    public function logout() : void
    {
        session_destroy();
        $this->redirect('index.php?route=login');
    }

    public function register(): void
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (empty($_POST["pseudo"]) || empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["confirmPassword"]))
            {  
                $errors[] = "Veuillez remplir tous les champs !";
            }
            $manager = new UserManager();
            $userCandidat = $manager->findByEmail($_POST["email"]);
            if ($userCandidat !== null)
            {
                $errors[] = "Cet email est déjà utilisé !";
            }
            if ($_POST["password"] !== $_POST["confirmPassword"])
            {
                $errors[] = "Les mots de passe ne correspondent pas !";
            }
            if (empty($errors)) {
                $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
                
                $userToCreate = new User(
                    id: null,
                    pseudo: $_POST['pseudo'],
                    email: $_POST['email'],
                    password: $hashedPassword,
                    role: "USER",
                    avatar: "./assets/img/default-avatar.png"
                );
                $manager->create_user($userToCreate);
                $this->redirect('index.php?route=login');
                exit;
            }
        }
        
        $this->render('auth/register', ['errors' => $errors]);
    }

    public function notFound() : void
    {
        $this->render('error/not_found', []);
    }
}