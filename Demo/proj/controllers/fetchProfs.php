<?php
session_start();
require_once("../database/DB.php");
require_once("../models/admin.php");

// Check if the user is logged in and is an admin
if (!isset($_SESSION['logged']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

try {
    $profs = Admin::getAllProfs();
    echo json_encode($profs);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error while fetching professors']);
}
?>
