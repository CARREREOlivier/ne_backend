<?php
declare(strict_types=1);

class RateArticleModel {
    public ?int $id;
    public int $article_id;
    public int $user_id;
    public int $rate;

    public function __construct(?int $id = null, int $article_id, int $user_id, int $rate) {
        $this->id = $id;
        $this->article_id = $article_id;
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

    public static function fromArray(array $data): RateArticleModel {
        return new RateArticleModel(
            $data['id'] ?? null,
            $data['article_id'] ?? 0,
            $data['user_id'] ?? 0,
            $data['rate'] ?? 0
        );
    }
}
?>
