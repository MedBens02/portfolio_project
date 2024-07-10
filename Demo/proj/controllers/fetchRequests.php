<?php
session_start();
require_once '../database/DB.php';

$studentId = $_SESSION['id_etd'];
$db = DB::connect();
$sql = "SELECT cours_id FROM enrollment_requests WHERE student_id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$studentId]);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($requests);
