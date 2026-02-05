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