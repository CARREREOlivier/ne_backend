<?php
require_once __DIR__ . '/../dao/FolderDAO.php';

class FolderRepository {
    private FolderDAO $folderDAO;

    public function __construct(FolderDAO $folderDAO) {
        $this->folderDAO = $folderDAO;
    }

    public function findAll(): array {
        return $this->folderDAO->findAll();
    }

    public function findById(int $id): ?array {
        return $this->folderDAO->findById($id);
    }

    public function findBySlug(string $slug): ?array {
        return $this->folderDAO->findBySlug($slug);
    }

    public function findByType($type) {
        $query = "SELECT folders.*, COUNT(articles.id) AS articleCount FROM folders 
              LEFT JOIN articles ON folders.id = articles.folder_id 
              WHERE folders.type = :type 
              GROUP BY folders.id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':type', $type);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
?>
