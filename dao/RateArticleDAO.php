<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';

class RateArticleDAO {
    private ?PDO $conn;

    public function __construct(?PDO $db) {
        $this->conn = $db;
    }

    public function findAllByArticleId(int $article_id): array {
        $query = "SELECT * FROM rate_article WHERE article_id = :article_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(int $article_id, int $user_id, int $rate): bool {
        $query = "INSERT INTO rate_article (article_id, user_id, rate) VALUES (:article_id, :user_id, :rate)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':rate', $rate, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete(int $id): bool {
        $query = "DELETE FROM rate_article WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
