<?php
session_start();
header('Content-Type: application/json'); // Assurez-vous de toujours renvoyer du JSON
header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();  // Terminer pour les requêtes préliminaires OPTIONS
}

// Récupérer l'URI de la requête
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Inclure ici les fichiers de contrôleur nécessaires
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/userController.php';
require_once __DIR__ . '/controllers/AarViewController.php';
require_once __DIR__ . '/controllers/LetsPlayViewController.php';
require_once __DIR__ . '/controllers/FanFictionViewController.php';
require_once __DIR__ . '/repositories/UserRepository.php';

//instancier ici les controlleurs.

$userController = new userController();

//deboggage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Routeur basique pour rediriger les requêtes
switch (true) {

    // Route pour récupérer un utilisateur par son ID
    case preg_match('/\/users\/(\d+)/', $requestUri, $matches) && $requestMethod === 'GET':
        $userId = $matches[1];
        $userController = new UserController();
        $userController->getUserById($userId);
        break;


// Routes pour récupérer les dossiers par type
    case preg_match('/\/aar\/?$/', $requestUri) && $requestMethod === 'GET':
        $aarController = new AarViewController(); // Crée une instance pour le controleur de la vue aaar
        $aarController->getAllAars();
        break;

    case preg_match('/\/lets-play/', $requestUri) && $requestMethod === 'GET':
        $letplayController = new LetsPlayViewController(); //crée une instance pour le controlleur de la vue let's play
        $letplayController->getAllLetsPlays();
        break;

    case preg_match('/\/fan-fiction/', $requestUri) && $requestMethod === 'GET':
        $fanFictionController = new FanFictionViewController();
        $fanFictionController->getAllFanFictions();
        break;

    //route pour créer un aar
    case preg_match('/\/aar\/create\/?$/', $requestUri) && $requestMethod === 'POST':
        $aarController = new AarViewController();
        $aarController->createAar();
        break;
    // Route pour récupérer un dossier AAR par son slug
    case preg_match('/\/aar\/([a-zA-Z0-9-_]+)/', $requestUri, $matches) && $requestMethod === 'GET':
        $slug = $matches[1];

        break;

    // Route pour récupérer un Let's Play par son slug
    case preg_match('/\/lets-play\/([a-zA-Z0-9-_]+)/', $requestUri, $matches) && $requestMethod === 'GET':
        $slug = $matches[1];

        break;

    // Route pour récupérer une Fan Fiction par son slug
    case preg_match('/\/fan-fiction\/([a-zA-Z0-9-_]+)/', $requestUri, $matches) && $requestMethod === 'GET':
        $slug = $matches[1];

        break;


    // Route pour Authentification
    case preg_match('/\/login/', $requestUri) && $requestMethod === 'POST':
        $authController = new AuthController();

        // Utilisation de php://input pour récupérer les données JSON envoyées par POST
        $data = json_decode(file_get_contents("php://input"), true);

        // Vérifie que $data contient bien 'username' et 'password'
        if (!isset($data['username']) || !isset($data['password'])) {
            echo json_encode(['status' => 'error', 'message' => 'Champs requis manquants']);
            exit;
        }

        $username = $data['username'];
        $password = $data['password'];
        $rememberMe = $data['rememberMe'] ?? false;

        // Appel au contrôleur pour gérer la connexion
        $response = $authController->login($username, $password, $rememberMe);
        echo json_encode($response);
        break;

    // Route pour déconnexion
    case preg_match('/\/logout/', $requestUri) && $requestMethod === 'POST':
        $authController = new AuthController();
        $response = $authController->logout();
        echo json_encode($response);
        break;


    default:
        http_response_code(404);
        echo json_encode(['message' => 'Route not found']);
        break;
}
