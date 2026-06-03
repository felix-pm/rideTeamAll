<?php

class AdminController extends AbstractController
{
    public function admin(){
        // Vérification de sécurité
        if (!isset($_SESSION['role']) || $_SESSION['role'] != 'ADMIN')
        {
            $this->redirect('index.php?route=login');
            exit;
        }
        else {
            $errors = [];
        }
        
        // ! Récupération des utilisateurs
        $userManager = new UserManager();
        $users = [];
        $keywordUser = '';
        if (isset($_GET['rechercheUser-admin']) && !empty(trim($_GET['rechercheUser-admin']))) {
            $keywordUser = trim($_GET['rechercheUser-admin']);
            $users = $userManager->searchUser($keywordUser);
        } else {
            $users = $userManager->findAll();
        }

        // ! Récupération des balades
        $rideManager = new RideManager();
        $rides = [];
        $keyword = '';
        if (isset($_GET['recherche-balade_admin']) && !empty(trim($_GET['recherche-balade_admin']))) {
            $keyword = trim($_GET['recherche-balade_admin']);
            $rides = $rideManager->searchRides($keyword);
        } else {
            $rides = $rideManager->findAll();
        }

        // ! Statistiques pour le Dashboard
        // Données réelles
        $activeRidesCount = count($rides); 
        $totalUsersCount = count($users);
        
        $usersLastMonth = 15; 
        $ridesLastMonth = 8; 
        $pendingReports = 4; 

        $this->render('admin/admin', [
            'users' => $users,
            'rides' => $rides,
            'keywordUser' => $keywordUser,
            'keywordRide' => $keyword,
            'stats' => [
                'active_rides' => $activeRidesCount,
                'total_users' => $totalUsersCount,
                'users_last_month' => $usersLastMonth,
                'rides_last_month' => $ridesLastMonth,
                'pending_reports' => $pendingReports
            ]
        ]);
    }
}