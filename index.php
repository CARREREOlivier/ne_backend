<?php
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

// Inclure les fichiers de contrôleur nécessaires
require_once __DIR__ . '/controllers/FolderController.php';
require_once __DIR__ . '/dao/FolderDAO.php';
require_once __DIR__ . '/repositories/FolderRepository.php';

// Routeur basique pour rediriger les requêtes
switch (true) {
    // Route pour récupérer tous les dossiers
    case preg_match('/\/folders\/?$/', $requestUri) && $requestMethod === 'GET':
        $folderController = new FolderController();  // Crée une instance de FolderController
        $folderController->getAllFolders();
        break;

    // Route pour accéder à un dossier par son slug
    case preg_match('/\/aar\/([a-z0-9\-]+)\/?$/', $requestUri, $matches) && $requestMethod === 'GET':
        $folderController = new FolderController();
        $slug = $matches[1];
        $folderController->getFolderBySlug($slug);  // Appel avec uniquement le slug
        break;

    case preg_match('/\/lets-play\/([a-z0-9\-]+)\/?$/', $requestUri, $matches) && $requestMethod === 'GET':
        $folderController = new FolderController();
        $slug = $matches[1];
        $folderController->getFolderBySlug($slug);
        break;

    case preg_match('/\/fan-fiction\/([a-z0-9\-]+)\/?$/', $requestUri, $matches) && $requestMethod === 'GET':
        $folderController = new FolderController();
        $slug = $matches[1];
        $folderController->getFolderBySlug($slug);
        break;

    default:
        http_response_code(404);
        echo json_encode(['message' => 'Route not found']);
        break;
}
