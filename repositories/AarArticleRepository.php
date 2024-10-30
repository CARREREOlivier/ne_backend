<?php

class AarArticleRepository
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Récupère un article spécifique par son slug
     */
    public function findBySlug(string $slug): ?array
    {
        $query = "SELECT * FROM aars_articles WHERE slug = :slug AND isVisible = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();

        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        return $article ? $article : null;
    }

    /**
     * Récupère tous les articles associés à un AAR spécifique par l'ID de l'AAR
     */
    public function findAllByAarId(int $aarId): array
    {
        $query = "SELECT * FROM aars_articles WHERE aar_id = :aarId AND isVisible = 1 ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':aarId', $aarId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
