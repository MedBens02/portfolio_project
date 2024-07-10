<?php
session_start();
if (!isset($_SESSION['logged']) || ($_SESSION['role'] !== 'prof'  && $_SESSION['role'] !== 'admin')) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

require_once('../models/cours.php');

$crsId = $_POST['crsId'] ?? null;
if ($crsId && Cours::removeCours($crsId)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Failed to delete']);
}
