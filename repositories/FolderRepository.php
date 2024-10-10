<?php
declare(strict_types=1);

require_once __DIR__ . '/../dao/FolderDAO.php';
require_once __DIR__ . '/../dto/FolderDTO.php';

class FolderRepository {
    private FolderDAO $folderDAO;

    public function __construct(FolderDAO $folderDAO) {
        $this->folderDAO = $folderDAO;
    }

    public function findAll(): array {
        $folders = $this->folderDAO->findAll();
        return array_map(fn($folder) => FolderDTO::fromArray($folder), $folders);
    }

    public function findById(int $id): ?FolderDTO {
        $folder = $this->folderDAO->findById($id);
        return $folder ? FolderDTO::fromArray($folder) : null;
    }

    public function create(FolderDTO $folderDTO): bool {
        return $this->folderDAO->create(
            $folderDTO->title,
            $folderDTO->description,
            $folderDTO->text,
            $folderDTO->user_id,
            $folderDTO->type,
            $folderDTO->language,
            $folderDTO->slug
        );
    }

    public function update(FolderDTO $folderDTO): bool {
        return $this->folderDAO->update(
            $folderDTO->id,
            $folderDTO->title,
            $folderDTO->description,
            $folderDTO->text,
            $folderDTO->slug,
            $folderDTO->isVisible
        );
    }

    public function delete(int $id): bool {
        return $this->folderDAO->delete($id);
    }
}
?>
