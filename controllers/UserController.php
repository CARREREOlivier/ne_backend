<?php
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../dao/UserDAO.php';

class UserController {
    private UserRepository $userRepository;

    public function __construct() {
        // Passer l'instance de UserDAO au constructeur de UserRepository
        $this->userRepository = new UserRepository(new UserDAO());
    }

    public function getAllUsers(): void {
        $users = $this->userRepository->findAll();
        echo json_encode($users);
    }
}
?>
