<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../utils/SlugGenerator.php';

class FolderDAO {
    private PDO $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();  // Initialisation de la connexion à la base de données
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

    // Récupérer un dossier par son slug, incluant le type de dossier
    public function findBySlug(string $slug): ?array {
        $query = "SELECT folders.*, types.folder_type 
                  FROM folders 
                  JOIN types ON folders.type = types.id 
                  WHERE folders.slug = :slug";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }





}
?>
