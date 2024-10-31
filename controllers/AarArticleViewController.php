<?php
namespace AarArticleViewController ;

require_once __DIR__ . '/../config/db.php';

use AarArticleRepository;
use AllowDynamicProperties;
use Database;
use Exception;
use PDO;
use PDOException;
use Utils\EnvLoader;
#[AllowDynamicProperties] class AarArticleViewController
{

public function __construct(){
    $db = new Database();
    $this->aarArticleRepository = new AarArticleRepository($db->getConnection());
    // Charger les variables d'environnement du fichier .env

    EnvLoader::loadEnv();

    try {
        // Initialiser la connexion à la base de données en utilisant les variables d'environnement
        $this->conn = new PDO(
            "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASSWORD']
        );
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        throw new Exception("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}
    public function getAarArticleBySlug($slug): void
    {
        $aarArticleRepository = new AarArticleRepository($this->conn);
        $article = $aarArticleRepository->findBySlug($slug);

        if ($article) {
            echo json_encode(['status' => 'success', 'article' => $article]);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Article non trouvé']);
        }
    }
}