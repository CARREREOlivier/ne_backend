<?php
declare(strict_types=1);

require_once __DIR__ . '/../repositories/ArticleRepository.php';
require_once __DIR__ . '/../config/db.php';

class ArticleController {
    private ArticleRepository $repository;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->repository = new ArticleRepository(new ArticleDAO($db));
    }

    public function getAllArticles(): void {
        $articles = $this->repository->findAll();
        echo json_encode($articles);
    }

    public function getArticleById(int $id): void {
        $article = $this->repository->findById($id);
        echo json_encode($article);
    }

    public function createArticle(array $data): void {
        $articleDTO = ArticleDTO::fromArray($data);
        if ($this->repository->create($articleDTO)) {
            echo json_encode(["message" => "Article created successfully."]);
        } else {
            echo json_encode(["message" => "Failed to create article."]);
        }
    }

    public function updateArticle(int $id, array $data): void {
        $articleDTO = ArticleDTO::fromArray(array_merge($data, ["id" => $id]));
        if ($this->repository->update($articleDTO)) {
            echo json_encode(["message" => "Article updated successfully."]);
        } else {
            echo json_encode(["message" => "Failed to update article."]);
        }
    }

    public function deleteArticle(int $id): void {
        if ($this->repository->delete($id)) {
            echo json_encode(["message" => "Article deleted successfully."]);
        } else {
            echo json_encode(["message" => "Failed to delete article."]);
        }
    }
}
?>
