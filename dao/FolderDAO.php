<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';

class FolderDAO {
    private ?PDO $conn;

    public function __construct(?PDO $db) {
        $this->conn = $db;
    }

    public function findAll(): array {
        $query = "SELECT * FROM Folders";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): array {
        $query = "SELECT * FROM Folders WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function create(string $title, string $description, string $text, int $user_id, int $type, int $language, string $slug): bool {
        $query = "INSERT INTO Folders (title, description, text, user_id, type, language, slug) VALUES (:title, :description, :text, :user_id, :type, :language, :slug)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':type', $type, PDO::PARAM_INT);
        $stmt->bindParam(':language', $language, PDO::PARAM_INT);
        $stmt->bindParam(':slug', $slug);
        return $stmt->execute();
    }

    public function update(int $id, string $title, string $description, string $text, string $slug, bool $isVisible): bool {
        $query = "UPDATE Folders SET title = :title, description = :description, text = :text, slug = :slug, isVisible = :isVisible, last_modified = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':isVisible', $isVisible, PDO::PARAM_BOOL);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete(int $id): bool {
        $query = "DELETE FROM Folders WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
