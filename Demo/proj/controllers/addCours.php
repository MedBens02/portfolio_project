<?php

session_start();

if (!isset($_SESSION['logged']) || $_SESSION['role'] !== 'prof') {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

require_once('../models/cours.php');

$nom = isset($_POST['title']) ? $_POST['title'] : NULL;
$description = isset($_POST['desc']) ? $_POST['desc'] : NULL;
$prfid = $_SESSION['id_prf'];

$data = array(
    'nom' =>  $nom,
    'description' =>  $description,
    'prfid' => $prfid
);
if (Cours::check($nom, $prfid)) {
    echo "already exist";
    return;
}
$res = Cours::ajouterCours($data);
if ($res === "ok") {
    echo "ok";
} else {
    echo "erreur";
}
