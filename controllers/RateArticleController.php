<?php
declare(strict_types=1);

require_once __DIR__ . '/../repositories/RateArticleRepository.php';
require_once __DIR__ . '/../config/db.php';

class RateArticleController {
    private RateArticleRepository $repository;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->repository = new RateArticleRepository(new RateArticleDAO($db));
    }

    public function getAllRatingsByArticle(int $article_id): void {
        $ratings = $this->repository->findAllByArticleId($article_id);
        echo json_encode($ratings);
    }

    public function createRating(array $data): void {
        $ratingDTO = RateArticleDTO::fromArray($data);
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
