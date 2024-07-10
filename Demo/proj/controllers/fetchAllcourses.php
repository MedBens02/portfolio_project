<?php
session_start();
require_once("../database/DB.php");
require_once("../models/cours.php");

// Check if the user is logged in and is a prof
if (!isset($_SESSION['logged']) || $_SESSION['role'] !== 'prof') {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}
try {
	$prfid = $_SESSION['id_prf'];
	$cours = Cours::getAllCourses($prfid);
    echo json_encode($cours);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error while fetching students']);
}
