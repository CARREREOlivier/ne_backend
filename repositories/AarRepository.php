<?php

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
}
