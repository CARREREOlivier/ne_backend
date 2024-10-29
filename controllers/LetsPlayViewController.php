<?php
require_once __DIR__ . '/../repositories/LetsPlayRepository.php';
require_once __DIR__ . '/../models/LetsPlayModel.php';
require_once __DIR__ . '/../config/db.php';

class LetsPlayViewController {
    private $letsPlayRepository;

    public function __construct() {
        $db = new Database();
        $this->letsPlayRepository = new LetsPlayRepository($db->getConnection());
    }

    public function getAllLetsPlays() {
        $letsPlays = $this->letsPlayRepository->findAllLetsPlays();
        echo json_encode($letsPlays);
    }
}
