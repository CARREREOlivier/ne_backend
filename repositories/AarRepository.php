<?php
require_once __DIR__ .'/../Utils/SlugGenerator.php';
class AarRepository {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Méthode pour récupérer tous les AAR et le nombre d'articles associés
    public function findAllAars() {
        $query = "
            SELECT aars.*, users.username, COUNT(aars_articles.id) AS article_count 
            FROM aars 
            LEFT JOIN users ON aars.user_id = users.id
            LEFT JOIN aars_articles ON aars.id = aars_articles.aar_id
            GROUP BY aars.id
            ORDER BY aars.created_at DESC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function storeOneAar(string $title, string $description, string $text, int $userId, bool $isVisible, string $slug): bool {
        try {
            $query = "INSERT INTO aars (title, description, text, user_id, isVisible, slug, created_at, last_modified) 
                  VALUES (:title, :description, :text, :user_id, :isVisible, :slug, NOW(), NOW())";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':text', $text);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':isVisible', $isVisible, PDO::PARAM_BOOL);
            $stmt->bindParam(':slug', $slug);

            return $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'insertion de l'AAR : " . $e->getMessage());
        }
    }
}
