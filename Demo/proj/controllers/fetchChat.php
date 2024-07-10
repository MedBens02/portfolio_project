<?php
require_once "../models/chat.php";


$userRole = $_SESSION['role'];

if (!in_array($userRole, ["prof", "etudiant"])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized access']);
    
    exit;
}


if (!isset($_GET['secondParty'])) {
    http_response_code(400);
    echo json_encode(['error' => '?secondParty is required']);
    exit;
}

$secondParty = intval($_GET['secondParty']) ?? 0;
$firstParty;
switch ($userRole) {
    case "prof":
        $firstParty = $_SESSION["id_prf"];
        break;
    case "etudiant":
        $firstParty = $_SESSION["id_etd"];
        break;
}

try {
    $chat = Chat::getMsgs($secondParty, $firstParty);

    echo json_encode($chat);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error while fetching students', "details" => $e->getMessage()]);
}
