<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';

class ArticleDAO {
    private ?PDO $conn;

    public function __construct(?PDO $db) {
        $this->conn = $db;
    }

    // Récupérer tous les articles
    public function findAll(): array {
        $query = "SELECT * FROM Articles";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un article par son ID
    public function findById(int $id): array {
        $query = "SELECT * FROM Articles WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    // Créer un nouvel article
    public function create(string $title, string $description, string $text, int $author_id, int $folder_id, string $slug): bool {
        $query = "INSERT INTO Articles (title, description, text, author_id, folder_id, slug) 
                  VALUES (:title, :description, :text, :author_id, :folder_id, :slug)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':author_id', $author_id, PDO::PARAM_INT);
        $stmt->bindParam(':folder_id', $folder_id, PDO::PARAM_INT);
        $stmt->bindParam(':slug', $slug);
        return $stmt->execute();
    }

    // Mettre à jour un article existant
    public function update(int $id, string $title, string $description, string $text, string $slug, bool $isVisible): bool {
        $query = "UPDATE Articles 
                  SET title = :title, description = :description, text = :text, slug = :slug, isVisible = :isVisible, last_modified = NOW()
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':isVisible', $isVisible, PDO::PARAM_BOOL);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Supprimer un article par son ID
    public function delete(int $id): bool {
        $query = "DELETE FROM Articles WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Récupérer tous les articles d'un dossier spécifique
    public function findAllByFolder(int $folder_id): array {
        $query = "SELECT * FROM Articles WHERE folder_id = :folder_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':folder_id', $folder_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Rechercher un article par son titre
    public function findByTitle(string $title): array {
        $query = "SELECT * FROM Articles WHERE title = :title";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtenir les articles récents
    public function getRecentArticles(int $limit): array {
        $query = "SELECT * FROM Articles ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
