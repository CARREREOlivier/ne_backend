<?php
declare(strict_types=1);

require_once __DIR__ . '/../dao/RateArticleDAO.php';
require_once __DIR__ . '/../dto/RateArticleDTO.php';

class RateArticleRepository {
    private RateArticleDAO $rateArticleDAO;

    public function __construct(RateArticleDAO $rateArticleDAO) {
        $this->rateArticleDAO = $rateArticleDAO;
    }

    public function findAllByArticleId(int $article_id): array {
        $ratings = $this->rateArticleDAO->findAllByArticleId($article_id);
        return array_map(fn($rate) => RateArticleDTO::fromArray($rate), $ratings);
    }

    public function createRating(RateArticleDTO $dto): bool {
        return $this->rateArticleDAO->create($dto->article_id, $dto->user_id, $dto->rate);
    }

    public function deleteRating(int $id): bool {
        return $this->rateArticleDAO->delete($id);
    }
}
?>
