<?php
session_start();
require_once('../models/Cours.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION['logged']) || $_SESSION['role'] !== 'prof' || !isset($data['partId']) || !isset($data['viewFlag'])) {
    echo "Error";
    exit;
}

$result = Cours::toggleViewFlag($data['partId'], $data['viewFlag']);
echo $result ? "Success" : "Error";
