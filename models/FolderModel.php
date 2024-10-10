<?php
declare(strict_types=1);

class FolderModel {
    public ?int $id;
    public string $title;
    public string $description;
    public string $text;
    public int $user_id;
    public int $type;
    public int $language;
    public bool $isVisible;
    public string $created_at;
    public string $last_modified;
    public string $slug;

    public function __construct(
        ?int $id = null,
        string $title,
        string $description,
        string $text,
        int $user_id,
        int $type,
        int $language,
        bool $isVisible = true,
        string $created_at = '',
        string $last_modified = '',
        string $slug = ''
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->text = $text;
        $this->user_id = $user_id;
        $this->type = $type;
        $this->language = $language;
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

        if (strlen($this->text) > 2000) {
            $errors[] = "Le contenu ne doit pas dépasser 2000 caractères.";
        }

        if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $this->slug)) {
            $errors[] = "Le slug doit être en format valide (lettres minuscules, chiffres et tirets uniquement).";
        }

        return $errors;
    }

    public function isValid(): bool {
        return count($this->validate()) === 0;
    }

    public function generateSlug(): void {
        $this->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->title)));
    }

    public static function fromArray(array $data): FolderModel {
        return new FolderModel(
            $data['id'] ?? null,
            $data['title'] ?? '',
            $data['description'] ?? '',
            $data['text'] ?? '',
            $data['user_id'] ?? 0,
            $data['type'] ?? 0,
            $data['language'] ?? 0,
            $data['isVisible'] ?? true,
            $data['created_at'] ?? '',
            $data['last_modified'] ?? '',
            $data['slug'] ?? ''
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'text' => $this->text,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'language' => $this->language,
            'isVisible' => $this->isVisible,
            'created_at' => $this->created_at,
            'last_modified' => $this->last_modified,
            'slug' => $this->slug,
        ];
    }
}
?>
