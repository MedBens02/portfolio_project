<?php


// require_once("../database/DB.php");
require_once "../database/DB.php";


class Admin
{

    static public function loginAdmin($login)
    {
        $stmt = DB::connect()->prepare('SELECT * FROM admin WHERE login = ?');
        $stmt->execute([$login]);
        $user = $stmt->fetch(PDO::FETCH_OBJ);  //returns an object with each column as attribute and value.
        return $user; //object from table
        $stmt->close();
        $stmt = null;
    }

    static public function getAllProfs()
    {
        $stmt = DB::connect()->prepare('SELECT * FROM professeurs ORDER BY request DESC');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    static public function getAllEtudiants()
    {
        $stmt = DB::connect()->prepare('SELECT * FROM etudiant ORDER BY request DESC');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    static public function removeProf($profId)
    {
        $stmt = DB::connect()->prepare('DELETE FROM professeurs WHERE id = :id');
        $stmt->bindParam(':id', $profId);
        return $stmt->execute();
    }

    static public function removeEtudiant($etudiantId)
    {
        $stmt = DB::connect()->prepare('DELETE FROM etudiant WHERE id = :id');
        $stmt->bindParam(':id', $etudiantId);
        return $stmt->execute();
    }
}
