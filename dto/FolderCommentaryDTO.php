<?php
declare(strict_types=1);

class FolderCommentaryDTO {
    public int $id;
    public int $folder_id;
    public int $user_id;
    public string $text;

    public function __construct(int $id, int $folder_id, int $user_id, string $text) {
        $this->id = $id;
        $this->folder_id = $folder_id;
        $this->user_id = $user_id;
        $this->text = $text;
    }

    public static function fromArray(array $data): FolderCommentaryDTO {
        return new FolderCommentaryDTO(
            $data['id'] ?? 0,
            $data['folder_id'] ?? 0,
            $data['user_id'] ?? 0,
            $data['text'] ?? ''
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'folder_id' => $this->folder_id,
            'user_id' => $this->user_id,
            'text' => $this->text
        ];
    }
}
?>
