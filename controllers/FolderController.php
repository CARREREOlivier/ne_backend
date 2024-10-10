<?php
declare(strict_types=1);

require_once __DIR__ . '/../repositories/FolderRepository.php';
require_once __DIR__ . '/../config/db.php';

class FolderController {
    private FolderRepository $repository;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->repository = new FolderRepository(new FolderDAO($db));
    }

    public function getAllFolders(): void {
        $folders = $this->repository->findAll();
        echo json_encode($folders);
    }

    public function getFolderById(int $id): void {
        $folder = $this->repository->findById($id);
        echo json_encode($folder);
    }

    public function createFolder(array $data): void {
        $folderDTO = FolderDTO::fromArray($data);
        if ($this->repository->create($folderDTO)) {
            echo json_encode(["message" => "Folder created successfully."]);
        } else {
            echo json_encode(["message" => "Failed to create folder."]);
        }
    }

    public function updateFolder(int $id, array $data): void {
        $folderDTO = FolderDTO::fromArray(array_merge($data, ["id" => $id]));
        if ($this->repository->update($folderDTO)) {
            echo json_encode(["message" => "Folder updated successfully."]);
        } else {
            echo json_encode(["message" => "Failed to update folder."]);
        }
    }

    public function deleteFolder(int $id): void {
        if ($this->repository->delete($id)) {
            echo json_encode(["message" => "Folder deleted successfully."]);
        } else {
            echo json_encode(["message" => "Failed to delete folder."]);
        }
    }
}
?>
