<?php

session_start();
require_once('../models/user.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION['logged']) || $_SESSION['role'] !== 'prof' || !isset($data['courseId']) || !isset($data['students'])) {
    echo "Error";
    exit;
}

$result = Prof::enrollStudents($data['courseId'], $data['students']);
echo $result ? "Success" : "Error";
