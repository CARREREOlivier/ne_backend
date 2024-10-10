<?php
declare(strict_types=1);

require_once __DIR__ . '/../repositories/RateFolderRepository.php';
require_once __DIR__ . '/../config/db.php';

class RateFolderController {
    private RateFolderRepository $repository;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->repository = new RateFolderRepository(new RateFolderDAO($db));
    }

    public function getAllRatingsByFolder(int $folder_id): void {
        $ratings = $this->repository->findAllByFolderId($folder_id);
        echo json_encode($ratings);
    }

    public function createRating(array $data): void {
        $ratingDTO = RateFolderDTO::fromArray($data);
        if ($this->repository->createRating($ratingDTO)) {
            echo json_encode(["message" => "Rating created successfully."]);
        } else {
            echo json_encode(["message" => "Failed to create rating."]);
        }
    }

    public function deleteRating(int $id): void {
        if ($this->repository->deleteRating($id)) {
            echo json_encode(["message" => "Rating deleted successfully."]);
        } else {
            echo json_encode(["message" => "Failed to delete rating."]);
        }
    }
}
?>
<?php
