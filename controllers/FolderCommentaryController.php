<?php
declare(strict_types=1);

require_once __DIR__ . '/../repositories/FolderCommentaryRepository.php';
require_once __DIR__ . '/../config/db.php';

class FolderCommentaryController {
    private FolderCommentaryRepository $repository;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->repository = new FolderCommentaryRepository(new FolderCommentaryDAO($db));
    }

    public function getAllCommentariesByFolder(int $folder_id): void {
        $commentaries = $this->repository->findAllByFolderId($folder_id);
        echo json_encode($commentaries);
    }

    public function createCommentary(array $data): void {
        $commentaryDTO = FolderCommentaryDTO::fromArray($data);
        if ($this->repository->createCommentary($commentaryDTO)) {
            echo json_encode(["message" => "Commentary created successfully."]);
        } else {
            echo json_encode(["message" => "Failed to create commentary."]);
        }
    }

    public function deleteCommentary(int $id): void {
        if ($this->repository->deleteCommentary($id)) {
            echo json_encode(["message" => "Commentary deleted successfully."]);
        } else {
            echo json_encode(["message" => "Failed to delete commentary."]);
        }
    }
}
?>
<?php
