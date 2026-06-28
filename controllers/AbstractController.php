<?php

class AbstractController
{
    protected function render(string $templatePath, array $data = []) : void
        extract($data);
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