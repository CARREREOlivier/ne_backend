<?php
require_once __DIR__ . '/../repositories/FolderRepository.php';
require_once __DIR__ . '/../dao/FolderDAO.php';

class FolderController {
    private FolderRepository $folderRepository;

    public function __construct() {
        // Crée une instance de FolderDAO
        $folderDAO = new FolderDAO();

        // Passe l'instance de FolderDAO à FolderRepository
        $this->folderRepository = new FolderRepository($folderDAO);
    }

    public function getAllFolders(): void {
        $folders = $this->folderRepository->findAll();
        echo json_encode($folders);
    }

    public function getFolderById(int $id): void {
        $folder = $this->folderRepository->findById($id);
        if ($folder) {
            echo json_encode($folder);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Folder not found']);
        }
    }

    public function getFolderBySlug(string $slug): void {
        $folder = $this->folderRepository->findBySlug($slug);
        if ($folder) {
            echo json_encode($folder);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Folder not found']);
        }
    }

}
?>
