<?php
session_start();
if (!isset($_SESSION['logged']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

require_once('../models/admin.php');

$stdId = $_POST['stdId'] ?? null;
if ($stdId && Admin::removeEtudiant($stdId)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Failed to delete']);
}
