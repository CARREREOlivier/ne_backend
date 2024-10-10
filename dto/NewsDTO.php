<?php
declare(strict_types=1);

class NewsDTO {
    public int $id;
    public string $title;
    public string $text;
    public bool $isVisible;
    public string $created_at;
    public string $modified_at;
    public string $slug;

    public function __construct(
        int $id,
        string $title,
        string $text,
        bool $isVisible,
        string $created_at,
        string $modified_at,
        string $slug
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->text = $text;
        $this->isVisible = $isVisible;
        $this->created_at = $created_at;
        $this->modified_at = $modified_at;
        $this->slug = $slug;
    }

    public static function fromArray(array $data): NewsDTO {
        return new NewsDTO(
            $data['id'] ?? 0,
            $data['title'] ?? '',
            $data['text'] ?? '',
            $data['isVisible'] ?? true,
            $data['created_at'] ?? '',
            $data['modified_at'] ?? '',
            $data['slug'] ?? ''
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'text' => $this->text,
            'isVisible' => $this->isVisible,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
            'slug' => $this->slug
        ];
    }
}
?>
