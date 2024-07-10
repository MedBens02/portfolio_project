<?php
session_start();
require_once('../models/user.php');

// Check for proper session and permissions
if (!isset($_SESSION['logged']) || $_SESSION['role'] !== 'prof') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Decode the JSON POST content
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['courseId'], $data['studentId'])) {
    echo json_encode(['success' => false, 'message' => 'Missing data']);
    exit;
}

$result = Prof::removeStudentFromCourse($data['courseId'], $data['studentId']);
echo json_encode(['success' => $result, 'message' => $result ? 'Enrollment removed' : 'Error removing enrollment']);
?>
