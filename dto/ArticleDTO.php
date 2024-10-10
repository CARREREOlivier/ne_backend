<?php
declare(strict_types=1);

class ArticleDTO {
    public int $id;
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
        int $id,
        string $title,
        string $description,
        string $text,
        int $author_id,
        int $folder_id,
        bool $isVisible,
        string $created_at,
        string $last_modified,
        string $slug
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

    // Méthode statique pour convertir un tableau en ArticleDTO
    public static function fromArray(array $data): ArticleDTO {
        return new ArticleDTO(
            $data['id'] ?? 0,
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

    // Méthode pour convertir l'ArticleDTO en tableau
    public function toArray(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'text' => $this->text,
            'author_id' => $this->author_id,
            'folder_id' => $this->folder_id,
            'isVisible' => $this->isVisible,
            'created_at' => $this->created_at,
            'last_modified' => $this->last_modified,
            'slug' => $this->slug,
        ];
    }
}
?>
