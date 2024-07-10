<?php
session_start();

require_once('../models/admin.php');
require_once('../models/user.php');

$login = isset($_POST['identifiant']) ? $_POST['identifiant'] : NULL;
$mdp = isset($_POST['mdp']) ? $_POST['mdp'] : NULL;
$role = isset($_POST['userType']) ? $_POST['userType'] : NULL;


switch ($role) {
    case 'admin':
        $admin = Admin::loginAdmin($login);
        if ($admin && password_verify($mdp, $admin->mot_de_passe)) {
            $_SESSION['logged'] = true;
            $_SESSION['role'] = 'admin';
            $_SESSION['nom'] = $admin->nom;
            $_SESSION['prenom'] = $admin->prenom;
            $_SESSION['nom_complet'] = $admin->nom." ".$admin->prenom;
            echo 'okAdmin';
        } else {
            echo 'error';
        }
        break;

    case 'etudiant':
        $etd = Etudiant::loginUser($login);
        if($etd && password_verify($mdp, $etd->mot_de_passe)) {
            $_SESSION['logged'] = true;
            $_SESSION['role'] = 'etudiant';
            $_SESSION['id_etd'] = $etd->id;
            $_SESSION['email'] = $etd->email;
            $_SESSION['nom'] = $etd->nom;
            $_SESSION['prenom'] = $etd->prenom;
            $_SESSION['mdp'] = $mdp;
            $_SESSION['adresse'] = $etd->adresse;
            $_SESSION['nom_complet'] = $etd->nom." ".$etd->prenom;
            $_SESSION['image'] = $etd->path_profile;
            echo 'okEtudiant';
        } else {
            echo 'error';
        }
        break;

    case 'prof':
        $prf = Prof::loginUser($login);
        if($prf && password_verify($mdp, $prf->mot_de_passe)) {
            $_SESSION['logged'] = true;
            $_SESSION['role'] = 'prof';
            $_SESSION['id_prf'] = $prf->id;
            $_SESSION['email'] = $prf->email;
            $_SESSION['nom'] = $prf->nom;
            $_SESSION['prenom'] = $prf->prenom;
            $_SESSION['mdp'] = $mdp;
            $_SESSION['adresse'] = $prf->adresse;
            $_SESSION['nom_complet'] = $prf->nom." ".$prf->prenom;
            $_SESSION['image'] = $prf->path_profile;
            echo 'okProf';
        } else {
            echo 'error';
        }
        break;
    
    default:
        echo "role non reconnue";
        break;
}
