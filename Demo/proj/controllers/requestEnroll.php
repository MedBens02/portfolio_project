<?php
session_start();
require_once '../models/user.php';

if (isset($_POST['courseId'], $_POST['profId']) && isset($_SESSION['id_etd'])) {
    $courseId = $_POST['courseId'];
    $profId = $_POST['profId'];
    $studentId = $_SESSION['id_etd'];

    $result = Etudiant::requestEnrollment($studentId, $courseId, $profId);
    
    echo $result ? "Demande envoyée avec succès." : "Erreur lors de la demande.";
} else {
    echo "Données incomplètes.";
}
?>
