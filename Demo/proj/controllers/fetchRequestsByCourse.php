<?php
session_start();
require_once '../database/DB.php';

if (!isset($_SESSION['logged']) || $_SESSION['role'] !== 'prof') {
    echo json_encode([]);
    exit;
}

// Assuming a SQL statement that selects distinct course IDs from requests
$db = DB::connect();
$sql = "SELECT DISTINCT cours_id FROM enrollment_requests WHERE prof_id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$_SESSION['id_prf']]);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(array_column($requests, 'cours_id'));
?>
