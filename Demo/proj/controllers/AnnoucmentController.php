<?php
session_start();
require_once "../models/chat.php";
require_once "../database/DB.php";


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    echo json_encode(['error' => 'Request method not allowed']);
    exit;
}

if (!isset($_SESSION["logged"])) {
    http_response_code(401);
    echo json_encode(['error' => 'UnAuthenticated']);
    exit;
}

$userRole = $_SESSION['role'];

if (!in_array($userRole, ["prof", "etudiant"])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

if (!isset($_GET["module"])) {
    http_response_code(400);
    echo json_encode(['error' => 'missing ?module query']);
    exit;
}



try {
    $data =  json_decode(file_get_contents("php://input"), true);

    $conn = DB::connect();
    $stmt = $conn->prepare('SELECT * FROM enrollement WHERE id_cours = :id');
    $stmt->bindParam(':id', $_GET["module"]);
    $stmt->execute();
    $stds_in_module = $stmt->fetchAll(PDO::FETCH_OBJ);


    $firstParty;
    switch ($userRole) {
        case "prof":
            $firstParty = $_SESSION["id_prf"];
            break;
        case "etudiant":
            $firstParty = $_SESSION["id_etd"];
            break;
    }
    foreach ($stds_in_module as $std) {

        Chat::SendMessage($firstParty, $std->id_etd, $data["message"]);
    }
} catch (Exception $ex) {
    http_response_code(500);
    echo json_encode(['error' => "internal Server error", 'details' => $ex]);
    exit;
}
