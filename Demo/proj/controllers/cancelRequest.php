<?php
session_start();
require_once '../database/DB.php';

if (!isset($_POST['courseId'])) {
    echo "Invalid request data.";
    exit;
}

$courseId = $_POST['courseId'];
$studentId = null;

// Use '==' for comparison or '===' for strict comparison
if ($_SESSION['role'] == 'etudiant') {
    $studentId = $_SESSION['id_etd'];
} elseif ($_SESSION['role'] == 'prof') {
    if (!isset($_POST['studentId'])) {
        echo "Student ID is required for professors.";
        exit;
    }
    $studentId = $_POST['studentId'];
}

$db = DB::connect();
$sql = "DELETE FROM enrollment_requests WHERE student_id = ? AND cours_id = ?";
$stmt = $db->prepare($sql);
$success = $stmt->execute([$studentId, $courseId]);

if ($success) {
    echo "Demande enlevee avec succes.";
} else {
    echo "Failed to cancel request.";
}
?>