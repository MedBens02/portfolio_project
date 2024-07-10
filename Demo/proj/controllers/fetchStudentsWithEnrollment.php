<?php
session_start();

// Include the necessary classes
require_once('../models/user.php');

// Ensure the user is logged in and is a professor
if (!isset($_SESSION['logged']) || $_SESSION['role'] !== 'prof') {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

// Check for the presence of a courseId in the query string
$courseId = isset($_GET['courseId']) ? intval($_GET['courseId']) : 0;

if (!$courseId) {
    echo json_encode(['error' => 'No course ID provided']);
    exit;
}

try {
    // Assuming you have a method in the Prof class that can fetch this data
    $students = Prof::getStudentsWithEnrollmentStatus($courseId);
    echo json_encode($students);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
