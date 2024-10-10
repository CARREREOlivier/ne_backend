<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';

class UserDAODAO {
    private ?PDO $conn;

    public function __construct(?PDO $db) {
        $this->conn = $db;
    }

    public function findAll(): array {
        $query = "SELECT * FROM Users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): array {
        $query = "SELECT * FROM Users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }
}
?>
