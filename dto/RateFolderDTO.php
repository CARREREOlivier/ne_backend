<?php
declare(strict_types=1);

class RateFolderDTO {
    public int $id;
    public int $folder_id;
    public int $user_id;
    public int $rate;

    public function __construct(int $id, int $folder_id, int $user_id, int $rate) {
        $this->id = $id;
        $this->folder_id = $folder_id;
        $this->user_id = $user_id;
        $this->rate = $rate;
    }

    public static function fromArray(array $data): RateFolderDTO {
        return new RateFolderDTO(
            $data['id'] ?? 0,
            $data['folder_id'] ?? 0,
            $data['user_id'] ?? 0,
            $data['rate'] ?? 0
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'folder_id' => $this->folder_id,
            'user_id' => $this->user_id,
            'rate' => $this->rate
        ];
    }
}
?>
