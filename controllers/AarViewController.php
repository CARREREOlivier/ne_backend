<?php
require_once __DIR__ . '/../repositories/AarRepository.php';
require_once __DIR__ . '/../models/AarModel.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../Utils/SlugGenerator.php';

class AarViewController {
    private $aarRepository;
    private PDO $conn; // Ajout de la déclaration explicite de la propriété
    public function __construct() {
        $db = new Database();
        $this->aarRepository = new AarRepository($db->getConnection());

        // Charger les variables d'environnement du fichier .env
        $this->loadEnv();

        // Récupérer les variables d'environnement
        $host = getenv('DB_HOST');
        $dbName = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');

        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$dbName", $user, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    // Méthode pour récupérer tous les AAR par ordre anti-chronologique
    public function getAllAars() {
        $aars = $this->aarRepository->findAllAars();
        echo json_encode($aars);
    }
    public function createAar() {
        try {
            if (!isset($_SESSION['user_id'])) {
                http_response_code(401);
                echo json_encode(['status' => 'error', 'message' => 'Utilisateur non authentifié.']);
                return;
            }

            $data = json_decode(file_get_contents("php://input"), true);
            // Vérification des données reçues
            if (!isset($data['title']) || !isset($data['description']) || !isset($data['text'])) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Données manquantes']);
                return;
            }

            // Création de l'AAR
            $title = $data['title'];
            $description = $data['description'];
            $text = $data['text'];
            $userId = $_SESSION['user_id'];
            $isVisible = isset($data['isVisible']) ? (bool)$data['isVisible'] : true;

            // Génération du slug et sauvegarde
            $slugGenerator = new SlugGenerator();
            $slug = $slugGenerator->generateSlug($title);
            $aarRepository = new AarRepository($this->conn);
            $result = $aarRepository->storeOneAar($title, $description, $text, $userId, $isVisible, $slug);

            if ($result) {
                http_response_code(200);
                echo json_encode(['status' => 'success', 'message' => 'AAR créé avec succès']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la création de l\'AAR']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Erreur: ' . $e->getMessage()]);
        }
    }

    public function getOneAar($slug) {
        try {
            // Récupérer les données de l'AAR via le repository
            $aar = $this->aarRepository->findBySlugWithArticles($slug);

            if ($aar) {
                echo json_encode($aar);
            } else {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'AAR non trouvé']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Erreur: ' . $e->getMessage()]);
        }
    }

    private function loadEnv() {
        if (file_exists(__DIR__ . '/../.env')) {
            $lines = file(__DIR__ . '/../.env');
            foreach ($lines as $line) {
                if (trim($line) !== '' && strpos(trim($line), '#') !== 0) {
                    putenv(trim($line));
                }
            }
        }
    }

}
