<?php
declare(strict_types=1);

class NewsModel {
    public ?int $id;
    public string $title;
    public string $text;
    public bool $isVisible;
    public string $created_at;
    public string $modified_at;
    public string $slug;

    public function __construct(
        ?int $id = null,
        string $title,
        string $text,
        bool $isVisible = true,
        string $created_at = '',
        string $modified_at = '',
        string $slug = ''
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->text = $text;
        $this->isVisible = $isVisible;
        $this->created_at = $created_at;
        $this->modified_at = $modified_at;
        $this->slug = $slug;
    }

    public function validate(): array {
        $errors = [];
        if (strlen($this->title) > 75) {
            $errors[] = "Le titre ne doit pas dépasser 75 caractères.";
        }
        if (strlen($this->text) > 5000) {
            $errors[] = "Le texte ne doit pas dépasser 5000 caractères.";
        }
        return $errors;
    }

    public function isValid(): bool {
        return count($this->validate()) === 0;
    }

    public static function fromArray(array $data): NewsModel {
        return new NewsModel(
            $data['id'] ?? null,
            $data['title'] ?? '',
            $data['text'] ?? '',
            $data['isVisible'] ?? true,
            $data['created_at'] ?? '',
            $data['modified_at'] ?? '',
            $data['slug'] ?? ''
        );
    }
}
?>
