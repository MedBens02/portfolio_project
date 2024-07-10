<?php
session_start();
require_once('../models/Cours.php');

if (!isset($_SESSION['logged']) || $_SESSION['role'] !== 'prof') {
    http_response_code(403);
    echo "Unauthorized access";
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['partId'])) {
    $partId = $data['partId'];

    // Call the method to remove the part
    if (Cours::removePart($partId)) {
        echo "Part removed successfully";
    } else {
        echo "Failed to remove part";
    }
} else {
    echo "Missing part ID";
}
