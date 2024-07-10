<?php
session_start();
require_once('../models/Cours.php');

if (!isset($_SESSION['logged']) || $_SESSION['role'] !== 'prof') {
    http_response_code(403);
    echo "Unauthorized access";
    exit;
}

if (isset($_POST['partTitle'], $_FILES['partFile'], $_POST['courseId'])) {
    $title = $_POST['partTitle'];
    $courseId = $_POST['courseId'];
    $file = $_FILES['partFile'];

    // Define the upload directory relative to the project root
    $uploadDir = '/uploads/parts/';
    // Define the full path to save the file on the server
    $serverPath = $_SERVER['DOCUMENT_ROOT'] . "/proj" . $uploadDir;
    $filePath = $serverPath . basename($file['name']);

    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        // Format the path that will be saved in the database
        $dbPath = $uploadDir . basename($file['name']);
        
        // Insert part into the database
        if (Cours::addPart($courseId, $title, $dbPath, 0)) { // Assuming view_flag defaults to 0
            echo "Part added successfully";
        } else {
            echo "Error adding part to the database";
        }
    } else {
        echo "Error uploading file";
    }
} else {
    echo "Missing data";
}
