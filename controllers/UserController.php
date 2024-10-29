<?php
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../config/db.php';
class UserController {
    private UserRepository $userRepository;

    public function __construct() {
        $db = new Database();  // Connexion à la base de données
        $this->userRepository = new UserRepository($db->getConnection());
    }

    public function getAllUsers(): void {
        $users = $this->userRepository->findAll();
        echo json_encode($users);
    }

    public function getUserById($id) {
        $user = $this->userRepository->findById($id);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Utilisateur non trouvé']);
        }
    }
}
?>
