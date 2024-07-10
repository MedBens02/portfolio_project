<?php
session_start();

if (!isset($_SESSION['logged']) || ($_SESSION['role'] !== 'prof' && $_SESSION['role'] !== 'etudiant')) {
    // Redirect them to login page or show an error
    header('Location: ../login.php');
    exit;
}

require_once('../models/user.php');

$oldPassword = isset($_POST['oldpass']) ? $_POST['oldpass'] : null;
$newPassword = isset($_POST['newpass']) ? $_POST['newpass'] : null;
$confirmPassword = isset($_POST['newpassConf']) ? $_POST['newpassConf'] : null;

$currPass = $_SESSION['mdp'];
$userType = $_SESSION['role'];


if ($userType === 'prof') {
	$prfid = $_SESSION['id_prf'];

	if ($oldPassword != $currPass) {
	    echo "wrongPass";
	} else if ($confirmPassword != $newPassword) {
		echo "notSimilar";
	} else if ($newPassword == $currPass) {
	    echo "samePass";
	} else if (Prof::changePassword($prfid, $newPassword)) {
		$_SESSION['mdp'] = $newPassword;
	    echo "success";
	} else
	    echo "error";
} else if ($userType === 'etudiant') {
	$prfid = $_SESSION['id_etd'];

	if ($oldPassword != $currPass) {
	    echo "wrongPass";
	} else if ($confirmPassword != $newPassword) {
		echo "notSimilar";
	} else if ($newPassword == $currPass) {
	    echo "samePass";
	} else if (Etudiant::changePassword($prfid, $newPassword)) {
		$_SESSION['mdp'] = $newPassword;
	    echo "success";
	} else
	    echo "error";
}
