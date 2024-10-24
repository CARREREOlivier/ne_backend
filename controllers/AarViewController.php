<?php
require_once __DIR__ . '/../repositories/AarRepository.php';
require_once __DIR__ . '/../models/AarModel.php';
require_once __DIR__ . '/../config/db.php';

class AarViewController {
    private $aarRepository;

    public function __construct() {
        $db = new Database();
        $this->aarRepository = new AarRepository($db->getConnection());
    }

    // Méthode pour récupérer tous les AAR par ordre anti-chronologique
    public function getAllAars() {
        $aars = $this->aarRepository->findAllAars();
        echo json_encode($aars);
    }
}
