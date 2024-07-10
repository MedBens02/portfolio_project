<?php
session_start();

if (!isset($_SESSION['logged']) || ($_SESSION['role'] !== 'prof' && $_SESSION['role'] !== 'etudiant')) {
    // Redirect them to login page or show an error
    header('Location: ../login.php');
    exit;
}

require_once('../models/user.php');

$nom = isset($_POST['name']) ? $_POST['name'] : NULL;
$surname = isset($_POST['surname']) ? $_POST['surname'] : NULL;
$newEmail = isset($_POST['email']) ? $_POST['email'] : NULL;
$address = isset( $_POST['address']) ? $_POST['address'] : NULL;

$data = array(
		'nom' =>  $nom ,
		'prenom' =>  $surname ,
		'adresse' => $address ,
		'email' =>  $newEmail ,
	);


$userEmail = $_SESSION['email'];
$userType = $_SESSION['role'];


if ($userType === 'prof') {
	$prfid = $_SESSION['id_prf'];
	if (Prof::checkEmailExists($newEmail)) {
		echo "emailExists";
		exit;
	}
	Prof::modifyUser($prfid, $data);
	$prf = Prof::loginUser($newEmail);
	$_SESSION['nom'] = $prf->nom;
    $_SESSION['prenom'] = $prf->prenom;
    $_SESSION['email'] = $prf->email;
    $_SESSION['adresse'] = $prf->adresse;
    $_SESSION['nom_complet'] = $prf->nom." ".$prf->prenom;
	echo "changed";
} else if ($userType === 'etudiant') {
	$stdid = $_SESSION['id_etd'];
	if (Etudiant::checkEmailExists($newEmail)) {
		echo "emailExists";
		exit;
	}
	Etudiant::modifyUser($stdid, $data);
	$etd = Etudiant::loginUser($newEmail);
	$_SESSION['nom'] = $etd->nom;
    $_SESSION['prenom'] = $etd->prenom;
    $_SESSION['email'] = $etd->email;
    $_SESSION['adresse'] = $etd->adresse;
    $_SESSION['nom_complet'] = $etd->nom." ".$etd->prenom;
	echo "changed";
} else {
    echo "error";
}

