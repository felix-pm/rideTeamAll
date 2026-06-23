<?php

class UserController extends AbstractController
{
    public function profile() :void
    {
        if(isset($_SESSION["id"], $_SESSION["pseudo"], $_SESSION["email"], $_SESSION["role"]))
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $manager = new UserManager();
                $user = $manager->findById($_SESSION['id']); 
                
                if ($user) {
                    // 1. GESTION DU CHANGEMENT D'INFOS VIA LA MODALE
                    if (isset($_POST['pseudo'], $_POST['email'])){
                        $user->setPseudo($_POST['pseudo']);
                        $user->setEmail($_POST['email']);
                        
                        if (!empty($_POST['password'])) {
                            $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
                        }
                    }

                    // 2. GESTION DE L'AJOUT / MODIFICATION DE LA PHOTO DE PROFIL (AVATAR)
                    if (isset($_FILES['new_avatar']) && $_FILES['new_avatar']['error'] === UPLOAD_ERR_OK) {
                        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];
                        $fileTmpPath = $_FILES['new_avatar']['tmp_name'];
                        $fileMimeType = mime_content_type($fileTmpPath);
                        
                        if (in_array($fileMimeType, $allowedMimeTypes)) {
                            $uploadDir = 'assets/img/';
                            
                            // Génération d'un nom de fichier unique sécurisé
                            $extension = pathinfo($_FILES['new_avatar']['name'], PATHINFO_EXTENSION);
                            $newFileName = uniqid('avatar_') . '.' . $extension;
                            $destination = $uploadDir . $newFileName;
                            
                            if (move_uploaded_file($fileTmpPath, $destination)) {
                                // Nettoyage de l'ancienne photo sur le serveur (sauf si c'est l'avatar par défaut)
                                $oldAvatar = $user->getAvatar();
                                if ($oldAvatar && strpos($oldAvatar, 'default-avatar.jpg') === false && file_exists($oldAvatar)) {
                                    unlink($oldAvatar);
                                }
                                
                                $user->setAvatar($destination);
                            }
                        }
                    }

                    // Sauvegarde des modifications globales en BDD
                    $manager->update($user);

                    // Synchronisation immédiate des variables de session pour l'affichage fluide
                    $_SESSION['pseudo'] = $user->getPseudo();
                    $_SESSION['email'] = $user->getEmail();
                    $_SESSION['avatar'] = $user->getAvatar();
                }
            }
            
            $userId = $_SESSION['id'] ?? null;

            $followManager = new FollowManager();
            $followersCount = $followManager->countFollowers($userId);
            $followedsCount = $followManager->countFolloweds($userId);

            $bikeManager = new BikeManager();
            $garage = $bikeManager->findAllBikeByUserId($userId);

            $rideManager = new RideManager();
            $pastBalades = $rideManager->findPastParticiaptionsByUserid($userId);
            $futuresBalades = $rideManager->findFutureParticiaptionsByUserid($userId);
            $myRides = $rideManager->findRidesByOrganizerId($userId);

            $this->render('member/profile', [
                "followersCount" => $followersCount,
                "followedsCount" => $followedsCount, 
                "garage" => $garage, 
                "pastBalades" => $pastBalades,
                "futuresBalades" => $futuresBalades,
                "myRides" => $myRides
            ]);
        }
        else
        {
            $this->render('auth/login', []);
        }
    }

    // ! à voir si je la garde (ou si je change le nom)

    public function home() {
        $userId = $_SESSION['id'] ?? null;
        $rideManager = new RideManager();
        $rides = [];
        $keyword = '';

        if (isset($_GET['recherche']) && !empty(trim($_GET['recherche']))) {
            $keyword = trim($_GET['recherche']);
            $rides = $rideManager->searchRides($keyword);
        } else {
            $rides = $rideManager->findAll();
        }

        $ridesFollowed = $rideManager->ridesFollowed($userId);

        $participationManager = new ParticipationManager();
        $participations = [];

        foreach ($rides as $ride) {
            $participations[$ride->getId()] = $participationManager->findParticipantsByRideId($ride->getId());
        }

        $this->render('member/home', [
            'rides' => $rides,
            'keyword' => $keyword,
            'participations' => $participations,
            'ridesFollowed' => $ridesFollowed
        ]);
    }

    public function searchUser() {
        $userId = $_SESSION['id'] ?? null;
        $userManager = new UserManager();
        $users = [];
        $keywordUser = '';

        if (isset($_GET['rechercheUser']) && !empty(trim($_GET['rechercheUser']))) {
            $keywordUser = trim($_GET['rechercheUser']);
            $users = $userManager->searchUser($keywordUser);
        } else {
            $users = $userManager->findAll();
        }

        $this->render('member/search', [
            'users' => $users,
            'keywordUser' => $keywordUser
        ]);
    }

    public function map(): void
    {
        $manager = new RideManager();
        $ridesObjects = $manager->findAll(); 

        $ridesArray = [];
        foreach($ridesObjects as $ride) {
            $ridesArray[] = [
                'id' => $ride->getId(),
                'title' => $ride->getTitle(),
                'start_latitude' => $ride->getStart_latitude(),
                'start_longitude' => $ride->getStart_longitude()
            ];
        }

        $this->render('member/map', ['rides' => $ridesArray]);
    }

    public function showProfile($id){
        $userManager = new UserManager();
        $user = $userManager->findById($id);

        if (!$user) {
            $this->redirect('index.php?route=home');
            exit;
        }

        $bikeManager = new BikeManager();
        $garage = $bikeManager->findAllBikeByUserId($id); 

        $followManager = new FollowManager();
        
        $followersCount = $followManager->countFollowers($id);
        $followedsCount = $followManager->countFolloweds($id);
        
        $following = false;

        if (isset($_SESSION['id'])) {
            $following = $followManager->isFollowing($_SESSION['id'], $user->getId());
        }

        return $this->render('member/public_profile', [
            "user" => $user,
            "garage" => $garage,
            "followersCount" => $followersCount,
            "followedsCount" => $followedsCount,
            "following" => $following
        ]);
    }

    public function follow($followed_id){
        if (!isset($_SESSION['id'])) {
            $this->redirect('index.php?route=login');
            exit;
        }
        $follower_id = $_SESSION['id']; 

        $followManager = new FollowManager();
        $followManager->follow($follower_id, $followed_id);

        $this->redirect('index.php?route=user_profile&id=' . $followed_id);
    }

    public function unfollow($followed_id){
        $follower_id = $_SESSION['id']; 

        $followManager = new FollowManager();
        $followManager->unfollow($follower_id, $followed_id);

        $this->redirect('index.php?route=user_profile&id=' . $followed_id);
    }

    public function create_way() :void{
        $this->render('member/create_way', []);
    }

    public function test(){
        $this->redirect('index.php?route=admin');
    }
}
