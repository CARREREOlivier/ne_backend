<?php
declare(strict_types=1);

class ArticleModel {
    public ?int $id;
    public string $title;
    public string $description;
    public string $text;
    public int $author_id;
    public int $folder_id;
    public bool $isVisible;
    public string $created_at;
    public string $last_modified;
    public string $slug;

    public function __construct(
        ?int $id = null,
        string $title,
        string $description,
        string $text,
        int $author_id,
        int $folder_id,
        bool $isVisible = true,
        string $created_at = '',
        string $last_modified = '',
        string $slug = ''
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->text = $text;
        $this->author_id = $author_id;
        $this->folder_id = $folder_id;
        $this->isVisible = $isVisible;
        $this->created_at = $created_at;
        $this->last_modified = $last_modified;
        $this->slug = $slug;
    }

    public function validate(): array {
        $errors = [];
        if (strlen($this->title) > 75) {
            $errors[] = "Le titre ne doit pas dépasser 75 caractères.";
        }
        if (strlen($this->description) > 500) {
            $errors[] = "La description ne doit pas dépasser 500 caractères.";
        }
        if (strlen($this->text) > 5000) {
            $errors[] = "Le contenu ne doit pas dépasser 5000 caractères.";
        }
        if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $this->slug)) {
            $errors[] = "Le slug doit être en format valide (lettres minuscules, chiffres et tirets uniquement).";
        }
        return $errors;
    }

    public function isValid(): bool {
        return count($this->validate()) === 0;
    }

    public static function fromArray(array $data): ArticleModel {
        return new ArticleModel(
            $data['id'] ?? null,
            $data['title'] ?? '',
            $data['description'] ?? '',
            $data['text'] ?? '',
            $data['author_id'] ?? 0,
            $data['folder_id'] ?? 0,
            $data['isVisible'] ?? true,
            $data['created_at'] ?? '',
            $data['last_modified'] ?? '',
            $data['slug'] ?? ''
        );
    }
}
?>
