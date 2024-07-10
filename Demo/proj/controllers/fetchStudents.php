<?php
session_start();
require_once("../database/DB.php");
require_once("../models/admin.php");
require_once("../models/user.php");

// Check if the user is logged in and is an admin
if (!isset($_SESSION['logged']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'prof')) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

try {
	if ($_SESSION['role'] === 'admin')
    	$students = Admin::getAllEtudiants();
    else if ($_SESSION['role'] === 'prof')
    	$students = Prof::getAllEtudiants();
    echo json_encode($students);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error while fetching students']);
}
?>
