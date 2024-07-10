<?php
session_start();
require_once "../models/chat.php";



if (!isset($_SESSION["logged"])) {
    http_response_code(401);
    echo json_encode(['error' => 'UnAuthenticated']);
    goto TERMINATE;
}

$userRole = $_SESSION['role'];

if (!in_array($userRole, ["prof", "etudiant"])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized access']);
    goto TERMINATE;
}


if (!isset($_GET["method"])) {
    http_response_code(400);
    echo json_encode(['error' => '?method is required.']);
    goto TERMINATE;
}

$firstParty;
switch ($userRole) {
    case "prof":
        $firstParty = $_SESSION["id_prf"];
        break;
    case "etudiant":
        $firstParty = $_SESSION["id_etd"];
        break;
}

$method = $_GET["method"];
switch ($method) {
    case "get_chat_logs":
        // include_once "./fetchChat.php";
        if (!isset($_GET['secondParty'])) {
            http_response_code(400);
            echo json_encode(['error' => '?secondParty is required']);
            goto TERMINATE;
        }

        $secondParty = intval($_GET['secondParty']) ?? 0;


        $chat = Chat::getMsgs($secondParty, $firstParty);

        echo json_encode($chat);
        break;

    case "send_message":
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(400);
            echo json_encode(['error' => 'Request method not allowed']);
            goto TERMINATE;
        }

        if (!isset($_GET['secondParty'])) {
            http_response_code(400);
            echo json_encode(['error' => '?secondParty is required']);
            goto TERMINATE;
        }
        $secondParty = $_GET["secondParty"];
        $data =  json_decode(file_get_contents("php://input"), true);
        if (!$data["message"]) {
            http_response_code(400);
            echo json_encode(['error' => 'message is required']);
            goto TERMINATE;
        }
        try {
            $success = Chat::SendMessage($firstParty, $secondParty, $data["message"]);
            if ($success) {
                http_response_code(201);
            } else {
                throw new Error("Could not send message");
            }
        } catch (Exception $ex) {
            http_response_code(500);
            echo json_encode(['error' => "internal Server error", 'details' => $ex]);
            exit;
        }


        break;
    default:
        http_response_code(400);
        echo json_encode(['error' => 'invalid method.']);
        goto TERMINATE;
}



TERMINATE:
exit;
