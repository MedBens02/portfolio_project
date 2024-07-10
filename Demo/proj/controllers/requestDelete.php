<?php
session_start();

if (!isset($_SESSION['logged']) || ($_SESSION['role'] !== 'prof' && $_SESSION['role'] !== 'etudiant')) {
    echo "Unauthorized access.";
    exit;
}

require_once('../models/user.php');  // Update this path as needed

$userType = $_SESSION['role'];

if ($userType === 'prof') {
	$prfid = $_SESSION['id_prf'];  // Assuming this is stored in the session
	$response = Prof::requestDelete($prfid);
} else if ($userType === 'etudiant') {
	$prfid = $_SESSION['id_etd'];  // Assuming this is stored in the session
	$response = Etudiant::requestDelete($prfid);
}
echo $response;
