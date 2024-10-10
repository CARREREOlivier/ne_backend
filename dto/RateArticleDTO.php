<?php
declare(strict_types=1);

class RateArticleDTO {
    public int $id;
    public int $article_id;
    public int $user_id;
    public int $rate;

    public function __construct(int $id, int $article_id, int $user_id, int $rate) {
        $this->id = $id;
        $this->article_id = $article_id;
        $this->user_id = $user_id;
        $this->rate = $rate;
    }

    public static function fromArray(array $data): RateArticleDTO {
        return new RateArticleDTO(
            $data['id'] ?? 0,
            $data['article_id'] ?? 0,
            $data['user_id'] ?? 0,
            $data['rate'] ?? 0
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'article_id' => $this->article_id,
            'user_id' => $this->user_id,
            'rate' => $this->rate
        ];
    }
}
?>
