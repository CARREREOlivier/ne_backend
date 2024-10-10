<?php
declare(strict_types=1);

class ArticleCommentaryDTO {
    public int $id;
    public int $article_id;
    public int $user_id;
    public string $text;

    public function __construct(int $id, int $article_id, int $user_id, string $text) {
        $this->id = $id;
        $this->article_id = $article_id;
        $this->user_id = $user_id;
        $this->text = $text;
    }

    public static function fromArray(array $data): ArticleCommentaryDTO {
        return new ArticleCommentaryDTO(
            $data['id'] ?? 0,
            $data['article_id'] ?? 0,
            $data['user_id'] ?? 0,
            $data['text'] ?? ''
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'article_id' => $this->article_id,
            'user_id' => $this->user_id,
            'text' => $this->text
        ];
    }
}
?>
