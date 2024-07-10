<?php
session_start();

require_once('../models/user.php');

    $login = isset($_POST['identifiant']) ? $_POST['identifiant'] : NULL;
    $mdp = isset($_POST['mdp']) ? $_POST['mdp'] : NULL;
    $role = isset($_POST['userType']) ? $_POST['userType'] : NULL;
	$nom = isset($_POST['name']) ? $_POST['name'] : NULL;
	$surname = isset($_POST['surname']) ? $_POST['surname'] : NULL;
	$address = isset( $_POST['address']) ? $_POST['address'] : NULL;

	$data = array(
		'nom' =>  $nom ,
		'prenom' =>  $surname ,
		'adresse' => $address ,
		'email' =>  $login ,
		'mot_de_passe' => $mdp ,
	);

	if ($role === "etudiant") {
		if (Etudiant::checkEmailExists($login)) {
    		echo "errorEmail";
    		return;
    	}
    	$res = Etudiant::addUser($data);
	} else if ($role === "prof") {
	    if (Prof::checkEmailExists($login)) {
    		echo "errorEmail";
    		return;
    	}
    	$res = Prof::addUser($data);
	}

	if ($res === "ok")
    	echo "ok" . ucfirst($role);  // Returns "okEtudiant" or "okProf"
	else
    	echo "error";

    

