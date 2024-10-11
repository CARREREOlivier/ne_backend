<?php
require_once __DIR__ . '/../config/db.php';

class FolderDAO {
    private PDO $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();  // Initialisation de la connexion à la base de données
    }

    public function findAll(): array {
        $query = "SELECT * FROM folders";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array {
        $query = "SELECT * FROM folders WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
}
?>
