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
            else if($_GET['route'] === 'follow') {
                $uc = new UserController();
                $uc->follow();
            }
            else if($_GET['route'] === 'home') {
                $uc = new UserController();
                $uc->home();
            }
            else if($_GET['route'] === 'ride' && isset($_GET['id'])) {
                $rc = new RideController();
                $rc->show($_GET['id']); 
            }
            else if($_GET['route'] === 'create_way') {
                $rc = new RideController();
                $rc->addRide();
            }
            else if($_GET['route'] === 'api_rides') {
                $rc = new RideController();
                $rc->api_list();
            }
            else if($_GET['route'] === 'api_bikes') {
                $bc = new BikeController();
                $bc->api_bike();
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