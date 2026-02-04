<?php

class AdminController extends AbstractController
{
    
    // FONCTION POUR L'ADMIN
    public function create_user() :void 
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] != 'ADMIN')
        {
            $this->redirect('index.php?route=login');
        }
        else {
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
                    $_POST['pseudo'],
                    $_POST['email'],
                    $hashedPassword,
                    "USER"
                );
                $manager->create_user($userToCreate);
                $this->redirect('index.php?route=list_admin');
                exit;
            }
        }
        }
        $this->render('admin/user/create.html.twig', ['errors' => $errors]); // ! changer la redirection
    }

    public function update_user() : void {
        if (!isset($_SESSION['role']) || $_SESSION['role'] != 'ADMIN')
        {
            $this->redirect('index.php?route=login');
        }
        else {

            $ctrl = new UserManager;
            $datas = $ctrl->findById($_GET["id"]);
            if ($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $update_user = new User($_POST["pseudo"], $_POST["email"], password_hash($_POST["password"], PASSWORD_DEFAULT), $_POST["role"], $_POST["avatar"]);
                $ctrl->update($update_user);
            }
            $this->render('admin/user/update.html.twig', ['datas' => $datas]); // ! changer la redirection
        }
    }

    public function delete_user() : void {
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'ADMIN')
    {
        $this->redirect('index.php?route=login');
        return; 
    }

    if (isset($_GET['id'])) 
    {
        $id = (int)$_GET['id'];
        $manager = new UserManager();
        $userToDelete = $manager->findById($id);

        if ($userToDelete) 
        {
            $manager->delete($userToDelete);
        }
    }

    $this->redirect('index.php?route=list_admin'); // ! changer la redirection
}

    public function list_admin() : void 
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] != 'ADMIN')
        {
            $this->redirect('index.php?route=login');
        }
        else
        {
            $ctrl = new UserManager;
            $datas = $ctrl->findAll();
            $this->render('admin/user/list_admin.html.twig', ['datas' => $datas]); // ! changer la redirection
        }
    }

    public function show_user() : void
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] != 'ADMIN')
        {
            $this->redirect('index.php?route=login');
        }
        else
        {
            $id = $_GET["id"];
            $ctrl = new UserManager;
            $datas = $ctrl->findById($id);
            $this->render('admin/user/show.html.twig', ["datas" => $datas]); // ! changer la redirection
        }

    }

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
