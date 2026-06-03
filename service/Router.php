<?php

class Router
{
    public function handleRequest() : void
    {
        if(!empty($_GET['route'])) {
            if($_GET['route'] === 'login') {
                $ac = new AuthController(); 
                $ac->login();
            }
            else if($_GET['route'] === 'register') {
                $ac = new AuthController();
                $ac->register();
            }
            else if($_GET['route'] === 'logout') {
                $ac = new AuthController();
                $ac->logout();
            }
            else if($_GET['route'] === 'profile') {
                $uc = new UserController(); 
                $uc->profile();
            }
            else if($_GET['route'] === 'map') {
                $uc = new UserController();
                $uc->map();
            }
            else if($_GET['route'] === 'follow' && isset($_GET['id'])) {
                $uc = new UserController();
                $uc->follow($_GET['id']);
            }
            else if($_GET['route'] === 'unfollow' && isset($_GET['id'])) {
                $uc = new UserController();
                $uc->unfollow($_GET['id']);
            }
            else if($_GET['route'] === 'search') {
                $uc = new UserController();
                $uc->searchUser();
            }
            else if($_GET['route'] === 'home') {
                $uc = new UserController();
                $uc->home();
            }
            else if($_GET['route'] === 'admin') {
                $uc = new AdminController();
                $uc->admin();
            }
            else if($_GET['route'] === 'ride' && isset($_GET['id'])) {
                $rc = new RideController();
                $rc->show($_GET['id']); 
            }
            else if($_GET['route'] === 'join_ride' && isset($_GET['id'])) {
                $rc = new RideController();
                $rc->joinRide($_GET['id']); 
            }
            else if($_GET['route'] === 'user_profile' && isset($_GET['id'])) {
                $uc = new UserController();
                $uc->showProfile($_GET['id']);
            }
            else if($_GET['route'] === 'create_way') {
                $rc = new RideController();
                $rc->addRide();
            }
            else if ($_GET['route'] === 'add_bike') {
                $bc = new BikeController();
                $bc->addBike();
            }
            else
            {
                $ac = new AuthController();
                $ac->notFound();
            }
        }
        else
        {
            $uc = new UserController();
            $uc->home(); 
        }
    }
}