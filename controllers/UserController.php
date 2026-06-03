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
                    $user = $manager->findById($_SESSION['id']); 
                    
                    if ($user) {
                        $user->setPseudo($_POST['pseudo']);
                        $user->setEmail($_POST['email']);
                        
                        if (!empty($_POST['password'])) {
                            $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
                        }

                        $manager->update($user);

                        $_SESSION['pseudo'] = $user->getPseudo();
                        $_SESSION['email'] = $user->getEmail();
                    }
                }
            }

            $followManager = new FollowManager();
            $followersCount = $followManager->countFollowers($_SESSION['id']);
            $followedsCount = $followManager->countFolloweds($_SESSION['id']);

            $bikeManager = new BikeManager();
            $garage = $bikeManager->findAllBikeByUserId($_SESSION['id']);
            {
                $this->render('member/profile', [
                    "followersCount" => $followersCount,
                    "followedsCount" => $followedsCount, 
                    "garage" => $garage
                ]);
            }
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

        $user_id = $_SESSION['id'];
        $ridesFollowed = $rideManager->ridesFollowed($user_id);

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

        $isFollowing = false;
        $bikeManager = new BikeManager();
        $garage = $bikeManager->findAllBikeByUserId($id); 

        $followManager = new FollowManager();
        $followersCount = $followManager->countFollowers($id);
        $followedsCount = $followManager->countFolloweds($id);
        $following = $followManager->isFollowing($_SESSION['id'], $user->getId());

        return $this->render('member/public_profile', [
            "user" => $user,
            "garage" => $garage,
            "followersCount" => $followersCount,
            "followedsCount" => $followedsCount,
            "following" => $following
        ]);
    }

    public function follow($followed_id){
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
