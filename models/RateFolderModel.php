<?php
declare(strict_types=1);

class RateFolderModel {
    public ?int $id;
    public int $folder_id;
    public int $user_id;
    public int $rate;

    public function __construct(?int $id = null, int $folder_id, int $user_id, int $rate) {
        $this->id = $id;
        $this->folder_id = $folder_id;
        $this->user_id = $user_id;
        $this->rate = $rate;
    }

    public function validate(): array {
        $errors = [];
        if ($this->rate < 1 || $this->rate > 5) {
            $errors[] = "La note doit être comprise entre 1 et 5.";
        }
        return $errors;
    }

    public function isValid(): bool {
        return count($this->validate()) === 0;
    }

    public static function fromArray(array $data): RateFolderModel {
        return new RateFolderModel(
            $data['id'] ?? null,
            $data['folder_id'] ?? 0,
            $data['user_id'] ?? 0,
            $data['rate'] ?? 0
        );
    }
}
?>
