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

}
?>
