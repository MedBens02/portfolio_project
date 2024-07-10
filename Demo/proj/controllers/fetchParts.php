<?php
session_start();
require_once "../models/cours.php";

if (!isset($_SESSION['logged']) || ($_SESSION['role'] !== 'prof' && $_SESSION['role'] !== 'etudiant')) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

$courseId = isset($_GET['courseId']) ? intval($_GET['courseId']) : 0;

if (!$courseId) {
    echo json_encode(['error' => 'No course ID provided']);
    exit;
}

$userType = $_SESSION['role'];

try {
	if ($userType == 'prof')
		$parts = Cours::getPartsByCourseId($courseId);
	else if ($userType == 'etudiant')
		$parts = Cours::getMyPartsByCourseId($courseId);
    echo json_encode($parts);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
