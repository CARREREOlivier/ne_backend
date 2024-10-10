<?php
declare(strict_types=1);

require_once __DIR__ . '/../dao/FolderCommentaryDAO.php';
require_once __DIR__ . '/../dto/FolderCommentaryDTO.php';

class FolderCommentaryRepository {
    private FolderCommentaryDAO $folderCommentaryDAO;

    public function __construct(FolderCommentaryDAO $folderCommentaryDAO) {
        $this->folderCommentaryDAO = $folderCommentaryDAO;
    }

    public function findAllByFolderId(int $folder_id): array {
        $commentaries = $this->folderCommentaryDAO->findAllByFolderId($folder_id);
        return array_map(fn($commentary) => FolderCommentaryDTO::fromArray($commentary), $commentaries);
    }

    public function createCommentary(FolderCommentaryDTO $dto): bool {
        return $this->folderCommentaryDAO->create($dto->folder_id, $dto->user_id, $dto->text);
    }

    public function deleteCommentary(int $id): bool {
        return $this->folderCommentaryDAO->delete($id);
    }
}
?>
