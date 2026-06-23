<?php

class AdminController extends AbstractController
{
    public function admin(){
        if (!isset($_SESSION['role']) || $_SESSION['role'] != 'ADMIN') {
            $this->redirect('index.php?route=login');
            exit;
        }
        
        $userManager = new UserManager();
        $rideManager = new RideManager();
        $messageManager = new ChatManager();

        // Recherche Utilisateurs
        $keywordUser = trim($_GET['rechercheUser-admin'] ?? '');
        $users = !empty($keywordUser) ? $userManager->searchUser($keywordUser) : $userManager->findAll();

        // Recherche Balades
        $keywordRide = trim($_GET['recherche-balade_admin'] ?? '');
        $rides = !empty($keywordRide) ? $rideManager->searchRides($keywordRide) : $rideManager->findAll();

        // Récupération des statistiques globales
        $userStats = $userManager->getStats();
        $rideStats = $rideManager->getStats();

        $messageStats = $messageManager->getStats();
        
        $chartDates = [];
        $chartValues = [];
        foreach($userStats['chart_7_days'] as $data) {
            $chartDates[] = date('d/m', strtotime($data['date']));
            $chartValues[] = $data['count'];
        }

        $this->render('admin/admin', [
            'users' => $users,
            'rides' => $rides,
            'keywordUser' => $keywordUser,
            'keywordRide' => $keywordRide,
            'userStats' => $userStats,
            'rideStats' => $rideStats,
            'messageStats' => $messageStats,
            'chartData' => json_encode(['labels' => $chartDates, 'data' => $chartValues]),
            'mapRides' => json_encode($rides)
        ]);
    }
}