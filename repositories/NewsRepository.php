<?php
declare(strict_types=1);

require_once __DIR__ . '/../dao/NewsDAO.php';
require_once __DIR__ . '/../dto/NewsDTO.php';

class NewsRepository {
    private NewsDAO $newsDAO;

    public function __construct(NewsDAO $newsDAO) {
        $this->newsDAO = $newsDAO;
    }

    public function findAll(): array {
        $newsList = $this->newsDAO->findAll();
        return array_map(fn($news) => NewsDTO::fromArray($news), $newsList);
    }

    public function findById(int $id): ?NewsDTO {
        $newsData = $this->newsDAO->findById($id);
        return $newsData ? NewsDTO::fromArray($newsData) : null;
    }

    public function create(NewsDTO $newsDTO): bool {
        return $this->newsDAO->create($newsDTO->title, $newsDTO->text, $newsDTO->slug);
    }

    public function update(NewsDTO $newsDTO): bool {
        return $this->newsDAO->update(
            $newsDTO->id,
            $newsDTO->title,
            $newsDTO->text,
            $newsDTO->slug,
            $newsDTO->isVisible
        );
    }

    public function delete(int $id): bool {
        return $this->newsDAO->delete($id);
    }
}
?>
