<?php
// controllers/UserController.php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../repositories/UserRepository.php';

class UserController {
    private $repository;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->repository = new UserRepository($db);
    }

    public function getAllUsers() {
        $users = $this->repository->getAllUsers();
        echo json_encode($users);
    }

    public function getUserById($id) {
        $user = $this->repository->getUserById($id);
        echo json_encode($user);
    }

    public function createUser($username, $email, $password, $date_of_birth, $description) {
        $result = $this->repository->createUser($username, $email, $password, $date_of_birth, $description);
        if ($result) {
            echo json_encode(array("message" => "User created successfully."));
        } else {
            echo json_encode(array("message" => "Failed to create user."));
        }
    }
}
?>
<?php
