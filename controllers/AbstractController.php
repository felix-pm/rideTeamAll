<?php

class AbstractController
{
    protected function render(string $templatePath, array $data = []) : void
    {
        // 1. On "déballe" les données pour qu'elles deviennent des variables
        // Ex: ['titre' => 'Accueil'] devient la variable $titre = 'Accueil'
        extract($data);

        // 2. On inclut le fichier (Attention au chemin !)
        // On suppose que tes vues sont dans "templates/"
        require_once __DIR__ . '/../templates/' . $templatePath . '.php';
    }

    protected function jsonResponse(array $data, int $statusCode = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    protected function redirect(string $url) : void
    {
        header('Location: '.$url);
        exit;
    }
}