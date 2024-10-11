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
    case preg_match('/\/folders\/?$/', $requestUri) && $requestMethod === 'GET':
        $folderController = new FolderController();  // Crée une instance de FolderController
        $folderController->getAllFolders();
        break;

    default:
        http_response_code(404);
        echo json_encode(['message' => 'Route not found']);
        break;
}