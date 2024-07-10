<?php
session_start();
require_once '../database/DB.php';

if (!isset($_SESSION['logged']) || $_SESSION['role'] !== 'prof') {
    echo json_encode([]);
    exit;
}

$courseId = $_GET['courseId'] ?? ''; // Get the course ID from the request

if ($courseId) {
	$db = DB::connect();
    $sql = "SELECT student_id FROM enrollment_requests WHERE cours_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$courseId]);
    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(array_column($requests, 'student_id'));
} else {
    echo json_encode([]);
}
?>
