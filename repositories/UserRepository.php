<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../dto/UserDTO.php';

class UserRepository {
    private UserDAO $userDAO;
    private $conn;

    public function __construct( $conn = null) {
        //$this->userDAO = $userDAO;
        $this->conn = (new Database())->getConnection();
    }

    public function findAll(): array {
        $users = $this->userDAO->findAll();
        return array_map(fn($user) => UserDTO::fromArray($user), $users);
    }

    public function findById($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmail(string $email): ?UserDTO {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function findByUsername($username) {
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($username, $email, $password, $role_id) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, email, password, role_id) VALUES (:username, :email, :password, :role_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role_id', $role_id);

        return $stmt->execute();
    }

    public function create(UserDTO $userDTO): bool {
        return $this->userDAO->create(
            $userDTO->username,
            $userDTO->email,
            $userDTO->password,
            $userDTO->date_of_birth,
            $userDTO->description,
            $userDTO->slug
        );
    }

    public function update(UserDTO $userDTO): bool {
        return $this->userDAO->update(
            $userDTO->id,
            $userDTO->username,
            $userDTO->email,
            $userDTO->password,
            $userDTO->banStatus,
            $userDTO->date_of_birth,
            $userDTO->theme_preference,
            $userDTO->description,
            $userDTO->slug,
            $userDTO->validated_by_admin
        );
    }

    public function delete(int $id): bool {
        return $this->userDAO->delete($id);
    }
}
?>
