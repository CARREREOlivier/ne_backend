<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';

class NewsDAO {
    private ?PDO $conn;

    public function __construct(?PDO $db) {
        $this->conn = $db;
    }

    public function findAll(): array {
        $query = "SELECT * FROM News";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): array {
        $query = "SELECT * FROM News WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function create(string $title, string $text, string $slug): bool {
        $query = "INSERT INTO News (title, text, slug) VALUES (:title, :text, :slug)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':slug', $slug);
        return $stmt->execute();
    }

    public function update(int $id, string $title, string $text, string $slug, bool $isVisible): bool {
        $query = "UPDATE News SET title = :title, text = :text, slug = :slug, isVisible = :isVisible, modified_at = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':isVisible', $isVisible, PDO::PARAM_BOOL);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete(int $id): bool {
        $query = "DELETE FROM News WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
