<?php
declare(strict_types=1);

class FolderCommentaryModel {
    public ?int $id;
    public int $folder_id;
    public int $user_id;
    public string $text;

    public function __construct(?int $id = null, int $folder_id, int $user_id, string $text) {
        $this->id = $id;
        $this->folder_id = $folder_id;
        $this->user_id = $user_id;
        $this->text = $text;
    }

    public function validate(): array {
        $errors = [];
        if (strlen($this->text) > 500) {
            $errors[] = "Le commentaire ne doit pas dépasser 500 caractères.";
        }
        return $errors;
    }

    public function isValid(): bool {
        return count($this->validate()) === 0;
    }

    public static function fromArray(array $data): FolderCommentaryModel {
        return new FolderCommentaryModel(
            $data['id'] ?? null,
            $data['folder_id'] ?? 0,
            $data['user_id'] ?? 0,
            $data['text'] ?? ''
        );
    }
}
?>
