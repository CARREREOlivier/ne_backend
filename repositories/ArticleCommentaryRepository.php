<?php
declare(strict_types=1);

require_once __DIR__ . '/../dao/ArticleCommentaryDAO.php';
require_once __DIR__ . '/../dto/ArticleCommentaryDTO.php';

class ArticleCommentaryRepository {
    private ArticleCommentaryDAO $articleCommentaryDAO;

    public function __construct(ArticleCommentaryDAO $articleCommentaryDAO) {
        $this->articleCommentaryDAO = $articleCommentaryDAO;
    }

    public function findAllByArticleId(int $article_id): array {
        $commentaries = $this->articleCommentaryDAO->findAllByArticleId($article_id);
        return array_map(fn($commentary) => ArticleCommentaryDTO::fromArray($commentary), $commentaries);
    }

    public function createCommentary(ArticleCommentaryDTO $dto): bool {
        return $this->articleCommentaryDAO->create($dto->article_id, $dto->user_id, $dto->text);
    }

    public function deleteCommentary(int $id): bool {
        return $this->articleCommentaryDAO->delete($id);
    }
}
?>
