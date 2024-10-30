<?php
require_once __DIR__ . '/../Utils/SlugGenerator.php';

class AarRepository
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Méthode pour récupérer tous les AAR et le nombre d'articles associés
    public function findAllAars()
    {
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

    public function findBySlug($slug)
    {
        $query = "SELECT aars.* FROM aars  WHERE aars.slug = :slug;";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findBySlugWithArticles($slug)
    {
        $query = "
        SELECT aars.id, aars.title, aars.description, aars.text, aars.slug, aars.isVisible, aars.created_at, aars.last_modified, 
               users.username AS author_name, users.id AS author_id
        FROM aars
        JOIN users ON aars.user_id = users.id
        WHERE aars.slug = :slug AND aars.isVisible = 1;
    ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();

        $aar = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($aar) {
            // Récupérer les articles associés à l'AAR
            $queryArticles = "
            SELECT articles.id, articles.title, articles.description, articles.created_at, articles.last_modified
            FROM aars_articles AS articles
            WHERE articles.aar_id = :aar_id AND articles.isVisible = 1
            ORDER BY articles.created_at DESC;
        ";

            $stmtArticles = $this->conn->prepare($queryArticles);
            $stmtArticles->bindParam(':aar_id', $aar['id'], PDO::PARAM_INT);
            $stmtArticles->execute();

            $aar['articles'] = $stmtArticles->fetchAll(PDO::FETCH_ASSOC);
        }

        return $aar ?: null;
    }

    public function storeOneAar(string $title, string $description, string $text, int $userId, bool $isVisible, string $slug): bool
    {
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

    public function deleteAarBySlug($slug) {
        try {
            // Commence une transaction
            $this->conn->beginTransaction();

            //récupère l'id de l'aar
            $aar = $this->findBySlug($slug);
            $aar_id = $aar['id'];

            // Supprime les commentaires associés
            $queryComments = "DELETE FROM aars_commentaries WHERE aar_id = :aarId";
            $stmtComments = $this->conn->prepare($queryComments);
            $stmtComments->bindParam(":aarId", $aar_id, PDO::PARAM_INT);
            $stmtComments->execute();

            // Supprime les articles associés
            $queryArticles = "DELETE FROM aars_articles WHERE aars_articles.aar_id = :aarId";
            $stmtArticles = $this->conn->prepare($queryArticles);
            $stmtArticles->bindParam("aarId",$aar_id, PDO::PARAM_INT);
            $stmtArticles->execute();

            // Supprime l'AAR
            $queryAar = "DELETE FROM aars WHERE id = :aarId";
            $stmtAar = $this->conn->prepare($queryAar);
            $stmtAar->bindParam("aarId",$aar_id, PDO::PARAM_INT);
            $stmtAar->execute();

            // Valide la transaction
            $this->conn->commit();

            return true;
        } catch (Exception $e) {
            // Annule la transaction en cas d'erreur
            $this->conn->rollBack();
            throw new Exception("Erreur lors de la suppression : " . $e->getMessage());
        }
    }

}
