<?php
declare(strict_types=1);

require_once __DIR__ . '/../dao/RateFolderDAO.php';
require_once __DIR__ . '/../dto/RateFolderDTO.php';

class RateFolderRepository {
    private RateFolderDAO $rateFolderDAO;

    public function __construct(RateFolderDAO $rateFolderDAO) {
        $this->rateFolderDAO = $rateFolderDAO;
    }

    public function findAllByFolderId(int $folder_id): array {
        $ratings = $this->rateFolderDAO->findAllByFolderId($folder_id);
        return array_map(fn($rate) => RateFolderDTO::fromArray($rate), $ratings);
    }

    public function createRating(RateFolderDTO $dto): bool {
        return $this->rateFolderDAO->create($dto->folder_id, $dto->user_id, $dto->rate);
    }

    public function deleteRating(int $id): bool {
        return $this->rateFolderDAO->delete($id);
    }
}
?>
