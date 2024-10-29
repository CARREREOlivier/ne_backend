<?php

class LetsPlayRepository {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function findAllLetsPlays() {
        $query = "
            SELECT lets_plays.*, users.username, COUNT(lets_plays_articles.id) AS article_count 
            FROM lets_plays 
            LEFT JOIN users ON lets_plays.user_id = users.id
            LEFT JOIN lets_plays_articles ON lets_plays.id = lets_plays_articles.lets_play_id
            GROUP BY lets_plays.id
            ORDER BY lets_plays.created_at DESC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
