<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';

class ArticleCommentaryDAO {
    private ?PDO $conn;

    public function __construct(?PDO $db) {
        $this->conn = $db;
    }

    public function findAllByArticleId(int $article_id): array {
        $query = "SELECT * FROM Article_Commentaries WHERE article_id = :article_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(int $article_id, int $user_id, string $text): bool {
        $query = "INSERT INTO Article_Commentaries (article_id, user_id, text) VALUES (:article_id, :user_id, :text)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':text', $text);
        return $stmt->execute();
    }

    public function delete(int $id): bool {
        $query = "DELETE FROM Article_Commentaries WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
