<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';

class RateFolderDAO {
    private ?PDO $conn;

    public function __construct(?PDO $db) {
        $this->conn = $db;
    }

    public function findAllByFolderId(int $folder_id): array {
        $query = "SELECT * FROM rate_folder WHERE folder_id = :folder_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':folder_id', $folder_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(int $folder_id, int $user_id, int $rate): bool {
        $query = "INSERT INTO rate_folder (folder_id, user_id, rate) VALUES (:folder_id, :user_id, :rate)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':folder_id', $folder_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':rate', $rate, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete(int $id): bool {
        $query = "DELETE FROM rate_folder WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
