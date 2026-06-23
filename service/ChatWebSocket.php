<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class ChatWebSocket implements MessageComponentInterface
{
    protected \SplObjectStorage $clients;
    // Tableau pour associer un client (resourceId) à un salon (ride_id)
    protected array $subscriptions;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->subscriptions = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Stocker la nouvelle connexion client
        $this->clients->attach($conn);
        echo "Nouvelle connexion établie ! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);
        if (!$data) return;

        // Étape 1 : Gérer l'action "join" (L'utilisateur arrive sur la page de la balade)
        if (isset($data['action']) && $data['action'] === 'join') {
            $this->subscriptions[$from->resourceId] = (int)$data['ride_id'];
            echo "Client {$from->resourceId} a rejoint le salon de la balade #{$data['ride_id']}\n";
            return;
        }

        // Étape 2 : Gérer l'action "message" (L'utilisateur envoie un texte)
        if (isset($data['action']) && $data['action'] === 'message') {
            $rideId = (int)$data['ride_id'];
            $userId = (int)$data['user_id'];
            $content = htmlspecialchars(trim($data['content']));
            $pseudo = htmlspecialchars($data['pseudo']);
            $avatar = htmlspecialchars($data['avatar'] ?? 'assets/img/default-avatar.jpg');

            if (empty($content)) return;

            // Instanciation du manager à la volée pour sauvegarder en BDD
            // (évite les coupures de timeout PDO sur un script permanent CLI)
            $chatManager = new ChatManager();
            $chatManager->saveMessage($rideId, $userId, $content);

            // Préparation du message à renvoyer à tout le monde
            $response = json_encode([
                'ride_id'    => $rideId,
                'user_id'    => $userId,
                'pseudo'     => $pseudo,
                'avatar'     => $avatar,
                'content'    => $content,
                'creater_at' => date('Y-m-d H:i:s')
            ]);

            // Diffuser le message UNIQUEMENT aux utilisateurs sur la MÊME balade
            foreach ($this->clients as $client) {
                if (isset($this->subscriptions[$client->resourceId]) && $this->subscriptions[$client->resourceId] === $rideId) {
                    $client->send($response);
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // Nettoyer les structures lors de la déconnexion
        $this->clients->detach($conn);
        unset($this->subscriptions[$conn->resourceId]);
        echo "Connexion fermée pour le client ({$conn->resourceId})\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Une erreur est survenue : {$e->getMessage()}\n";
        $conn->close();
    }
}