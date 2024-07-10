<?php
session_start();
require_once("../database/DB.php");
require_once("../models/user.php");

// Check if the user is logged in and is a prof
if (!isset($_SESSION['logged']) || $_SESSION['role'] !== 'etudiant') {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

$profID = isset($_GET['profID']) ? intval($_GET['profID']) : 0;


try {
	$name = Prof::getUserName($profID);
    echo json_encode($name);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error while fetching students']);
}
