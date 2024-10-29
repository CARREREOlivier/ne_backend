<?php
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../config/db.php';

class AuthController {
    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }




public function login($username, $password, $rememberMe) {

        try {
            // Initialisation de la connexion à la base de données
            $conn = new PDO("mysql:host=localhost;dbname=ne_bd", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Instancie le UserRepository
            $userRepository = new UserRepository($conn);

            // Recherche l'utilisateur par son nom
            $user = $userRepository->findByUsername($username);


            // Vérifie si l'utilisateur existe et si le mot de passe est correct
            if (!$user || !password_verify($password, $user['password'])) {
                return ['status' => 'error', 'message' => 'Nom d\'utilisateur ou mot de passe incorrect'];
            }

            // Si la connexion réussit, on enregistre l'ID de l'utilisateur dans la session
            $_SESSION['user_id'] = $user['id'];

            // Gérer la fonctionnalité "Se souvenir de moi" si nécessaire
            if ($rememberMe) {
                setcookie('user_id', $user['id'], time() + (86400 * 30), "/"); // Cookie valable 30 jours
            }

            // Réponse de succès

            return ['status' => 'success', 'message' => 'Connexion réussie'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Erreur lors de la connexion : ' . $e->getMessage()];
        }
    } 

    public function logout() {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
        echo json_encode(['status' => 'success', 'message' => 'Déconnexion réussie']);
        exit; // Assure la fin immédiate de l'exécution pour éviter les caractères superflus
    }
}
