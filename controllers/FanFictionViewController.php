<?php
require_once __DIR__ . '/../repositories/FanFictionRepository.php';
require_once __DIR__ . '/../models/FanFictionModel.php';
require_once __DIR__ . '/../config/db.php';

class FanFictionViewController {
    private $fanFictionRepository;

    public function __construct() {
        $db = new Database();
        $this->fanFictionRepository = new FanFictionRepository($db->getConnection());
    }

    public function getAllFanFictions() {
        $fanFictions = $this->fanFictionRepository->findAllFanFictions();
        echo json_encode($fanFictions);
    }
}
