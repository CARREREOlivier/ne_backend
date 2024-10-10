<?php
declare(strict_types=1);

require_once __DIR__ . '/../repositories/NewsRepository.php';
require_once __DIR__ . '/../config/db.php';

class NewsController {
    private NewsRepository $repository;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->repository = new NewsRepository(new NewsDAO($db));
    }

    public function getAllNews(): void {
        $news = $this->repository->findAll();
        echo json_encode($news);
    }

    public function getNewsById(int $id): void {
        $news = $this->repository->findById($id);
        echo json_encode($news);
    }

    public function createNews(array $data): void {
        $newsDTO = NewsDTO::fromArray($data);
        if ($this->repository->create($newsDTO)) {
            echo json_encode(["message" => "News created successfully."]);
        } else {
            echo json_encode(["message" => "Failed to create news."]);
        }
    }

    public function updateNews(int $id, array $data): void {
        $newsDTO = NewsDTO::fromArray(array_merge($data, ["id" => $id]));
        if ($this->repository->update($newsDTO)) {
            echo json_encode(["message" => "News updated successfully."]);
        } else {
            echo json_encode(["message" => "Failed to update news."]);
        }
    }

    public function deleteNews(int $id): void {
        if ($this->repository->delete($id)) {
            echo json_encode(["message" => "News deleted successfully."]);
        } else {
            echo json_encode(["message" => "Failed to delete news."]);
        }
    }
}
?>
