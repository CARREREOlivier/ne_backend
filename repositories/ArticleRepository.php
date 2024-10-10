<?php
declare(strict_types=1);

require_once __DIR__ . '/../dao/ArticleDAO.php';
require_once __DIR__ . '/../dto/ArticleDTO.php';

class ArticleRepository {
    private ArticleDAO $articleDAO;

    public function __construct(ArticleDAO $articleDAO) {
        $this->articleDAO = $articleDAO;
    }

    public function findAll(): array {
        $articles = $this->articleDAO->findAll();
        return array_map(fn($article) => ArticleDTO::fromArray($article), $articles);
    }

    public function findById(int $id): ?ArticleDTO {
        $article = $this->articleDAO->findById($id);
        return $article ? ArticleDTO::fromArray($article) : null;
    }

    public function create(ArticleDTO $articleDTO): bool {
        return $this->articleDAO->create(
            $articleDTO->title,
            $articleDTO->description,
            $articleDTO->text,
            $articleDTO->author_id,
            $articleDTO->folder_id,
            $articleDTO->slug
        );
    }

    public function update(ArticleDTO $articleDTO): bool {
        return $this->articleDAO->update(
            $articleDTO->id,
            $articleDTO->title,
            $articleDTO->description,
            $articleDTO->text,
            $articleDTO->slug,
            $articleDTO->isVisible
        );
    }

    public function delete(int $id): bool {
        return $this->articleDAO->delete($id);
    }
}
?>
