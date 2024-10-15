<?php

require_once __DIR__ . '/../utils/SlugGenerator.php';

class FolderDAO {
    private PDO $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    public function createFolder(array $data): bool {
        // Générer le slug à partir du titre
        $slug = SlugGenerator::generateSlug($data['title']);

        $query = "INSERT INTO folders (title, description, text, created_at, user_id, type, slug) 
                  VALUES (:title, :description, :text, :created_at, :user_id, :type_id, :slug)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':text', $data['text']);
        $stmt->bindParam(':created_at', $data['created_at']);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':type_id', $data['type_id']);
        $stmt->bindParam(':slug', $slug);
        return $stmt->execute();
    }
}

?>
