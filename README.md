# 🏍️ RideTeam — Plateforme Communautaire des Deux-Roues


**RideTeam** est une application web complète développée en solo (projet de fin d'année). Elle a pour but de rassembler la communauté des passionnés de deux-roues (motards et cyclistes) en centralisant la gestion de leur garage, la création d'itinéraires et la communication en temps réel.

---

## 🎯 Présentation du projet
L'idée de RideTeam est née d'un constat simple : l'organisation de balades entre amis nécessite souvent d'utiliser plusieurs applications distinctes (Google Maps pour l'itinéraire, Facebook/WhatsApp pour l'organisation et le chat). RideTeam unifie cette expérience dans une seule plateforme centralisée, interactive et dynamique.

## ✨ Fonctionnalités Principales

### 👤 Gestion des Utilisateurs & Sécurité
* **Authentification sécurisée** : Inscription et connexion blindées contre les injections SQL (requêtes préparées PDO) avec hachage irréversible des mots de passe (`bcrypt`).
* **Profils personnalisés** : Gestion de l'avatar et de ses informations personnelles.
* **Réseau social** : Système d'abonnement (Follow/Unfollow) pour suivre les autres pilotes de la communauté et rechercher des utilisateurs spécifiques.

### 🏍️ Le Garage Virtuel
* **Gestion de véhicules** : Ajout, modification et suppression de motos/vélos liés au compte de l'utilisateur.
* **Upload d'images sécurisé** : Système d'ajout de photos pour chaque véhicule avec renommage unique (`uniqid`) et protection contre les failles d'upload (`Directory Traversal`).

### 🗺️ Cartographie & Balades (Rides)
* **Création dynamique d'itinéraires** : Utilisation de l'API externe **Nominatim (OpenStreetMap)** via des appels AJAX asynchrones (avec système de *debounce* pour optimiser les requêtes) pour auto-compléter les adresses de départ et d'arrivée.
* **Carte interactive** : Affichage des balades en cours et à venir sur une carte au thème sombre générée via la librairie **Leaflet.js**, incluant des marqueurs personnalisés animés en CSS.
* **Participation** : Possibilité de rejoindre (Join) ou de se désinscrire d'une balade organisée par un membre.

### 💬 Messagerie en Temps Réel (WebSockets)
* **Chat par événement** : Une fois inscrit à une balade, accès à une "Room" de discussion instantanée.
* **Serveur WebSocket** : Communication bidirectionnelle en temps réel propulsée par PHP (librairie **Ratchet**), évitant la surcharge HTTP habituelle (Long-Polling).
* **Sécurité des échanges** : Historique persisté en base de données à la volée et protection systématique contre les failles XSS (`htmlspecialchars`).

### ⚙️ Modération (Panel Admin)
* **Tableau de bord administrateur** : Vue globale sur les statistiques du site (inscriptions, balades créées).
* **Gestion des signalements** : Interface permettant aux administrateurs de modérer les comportements abusifs.

---

## 🛠️ Stack Technique & Architecture

L'application repose sur une architecture **MVC (Modèle-Vue-Contrôleur)** construite de zéro (sans framework), permettant une maîtrise totale du flux de données.

* **Backend :** PHP (Routeur maison, POO complète)
* **Base de données :** MySQL (PDO)
* **Frontend :** HTML5, CSS3, JavaScript (Vanilla)
* **Dépendances gérées via Composer :**
  * `vlucas/phpdotenv` : Sécurisation des variables d'environnement.
  * `cboden/ratchet` : Serveur WebSocket.

---

## 🚀 Installation Locale

1. **Cloner le dépôt :**
   ```bash
   git clone https://github.com/felix-pm/rideTeamAll
