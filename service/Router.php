<?php

class Router
{
    private AuthController $ac;
    private UserController $uc;
    public function __construct()
    {
        $this->ac = new AuthController();
        $this->uc = new UserController();
    }

    public function handleRequest() : void
    {
        if(!empty($_GET['route'])) {
            if($_GET['route'] === 'login') {
                $this->ac->login();
            }
            else if($_GET['route'] === 'register') {
                $this->ac->register();
            }
            else if($_GET['route'] === 'connexion') {
                $this->ac->connexion();
            }
            else if($_GET['route'] === 'logout') {
                $this->ac->logout();
            }
            else if($_GET['route'] === 'profile') {
                $this->uc->profile();
            }
            else if($_GET['route'] === 'decouvrir') {
                $this->uc->decouvrir();
            }
            else if($_GET['route'] === 'follow') {
                $this->uc->follow();
            }
            else
            {
                $this->ac->notFound();
            }
        }
        else
        {
            $this->uc->map();
        }
    }
}
