<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$port = 8080;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ChatWebSocket()
        )
    ),
    $port
);

echo "Serveur WebSocket de discussion démarré sur le port {$port}...\n";
$server->run();