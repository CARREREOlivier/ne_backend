<?php
require_once '../repositories/UserRepository.php';
require_once '../config/db.php';

class AuthController {
    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function login($username, $password, $rememberMe) {
        $user = $this->userRepository->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            // Connexion réussie
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role_id'] = $user['role_id'];

            // Durée de session : 24 heures par défaut
            $sessionDuration = 24 * 60 * 60;  // 24 heures

            if ($rememberMe) {
                $sessionDuration = 30 * 24 * 60 * 60;  // Prolonger la session
            }

            setcookie(session_name(), session_id(), time() + $sessionDuration, "/", "", true, true);

            return ['status' => 'success', 'message' => 'Connexion réussie'];
        } else {
            return ['status' => 'error', 'message' => 'Nom d\'utilisateur ou mot de passe incorrect'];
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
        return ['status' => 'success', 'message' => 'Déconnexion réussie'];
    }
}
