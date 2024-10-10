<?php
declare(strict_types=1);

class ArticleCommentaryModel {
    public ?int $id;
    public int $article_id;
    public int $user_id;
    public string $text;

    public function __construct(?int $id = null, int $article_id, int $user_id, string $text) {
        $this->id = $id;
        $this->article_id = $article_id;
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

    public static function fromArray(array $data): ArticleCommentaryModel {
        return new ArticleCommentaryModel(
            $data['id'] ?? null,
            $data['article_id'] ?? 0,
            $data['user_id'] ?? 0,
            $data['text'] ?? ''
        );
    }
}
?>
