<?php

class FanFictionRepository {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function findAllFanFictions() {
        $query = "
            SELECT fan_fictions.*, users.username, COUNT(fan_fictions_articles.id) AS article_count 
            FROM fan_fictions 
            LEFT JOIN users ON fan_fictions.user_id = users.id
            LEFT JOIN fan_fictions_articles ON fan_fictions.id = fan_fictions_articles.fan_fiction_id
            GROUP BY fan_fictions.id
            ORDER BY fan_fictions.created_at DESC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
