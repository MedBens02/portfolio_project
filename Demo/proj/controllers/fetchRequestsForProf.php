<?php
session_start();
require_once '../database/DB.php';

// Check if the user is logged in as a professor
if (!isset($_SESSION['logged']) || $_SESSION['role'] !== 'prof') {
    echo json_encode([]);
    exit;
}

$profId = $_SESSION['id_prf'];
$db = DB::connect();
$sql = "SELECT * FROM enrollment_requests WHERE prof_id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$profId]);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($requests);
?>
