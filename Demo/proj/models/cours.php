<?php
// include_once($_SERVER['DOCUMENT_ROOT'] . '/proj/database/DB.php');
require_once "../database/DB.php";


class Cours
{

    public static function check($login, $prfid)
    {
        $conn = DB::connect();
        $stmt = $conn->prepare('SELECT * FROM modules WHERE nom = :nom AND prof_id = :id');
        $stmt->bindParam(':nom', $login);
        $stmt->bindParam(':id', $prfid);
        $stmt->execute();
        $count = $stmt->rowCount();
        $stmt = null;
        return $count > 0;
    }
    public static function ajouterCours($data)
    {
        $conn = DB::connect();
        $stmt = $conn->prepare('INSERT INTO modules (nom, description, prof_id) VALUES (:nom, :description, :id)');


        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':id', $data['prfid']);
        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
    }
    static public function getAllCourses($prfid)
    {
        $stmt = DB::connect()->prepare('SELECT * FROM modules WHERE prof_id = ?');
        $stmt->execute([$prfid]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    static public function removeCours($crsId)
    {
        $stmt = DB::connect()->prepare('DELETE FROM modules WHERE id = :id');
        $stmt->bindParam(':id', $crsId);
        return $stmt->execute();
    }

    public static function getPartsByCourseId($courseId)
    {
        $stmt = DB::connect()->prepare('SELECT * FROM parties WHERE id_cours = :courseId');
        $stmt->bindParam(':courseId', $courseId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getMyPartsByCourseId($courseId)
    {
        $stmt = DB::connect()->prepare('SELECT * FROM parties WHERE id_cours = :courseId AND view_flag = 1');
        $stmt->bindParam(':courseId', $courseId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function toggleViewFlag($partId, $viewFlag)
    {
        $stmt = DB::connect()->prepare('UPDATE parties SET view_flag = :viewFlag WHERE id_part = :partId');
        $stmt->bindParam(':viewFlag', $viewFlag, PDO::PARAM_BOOL);
        $stmt->bindParam(':partId', $partId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function addPart($courseId, $title, $filePath, $viewFlag)
    {
        $stmt = DB::connect()->prepare('INSERT INTO parties (id_cours, title_part, path_part, view_flag) VALUES (:courseId, :title, :filePath, :viewFlag)');
        $stmt->bindParam(':courseId', $courseId);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':filePath', $filePath);
        $stmt->bindParam(':viewFlag', $viewFlag);
        return $stmt->execute();
    }

    public static function removePart($partId)
    {
        $stmt = DB::connect()->prepare('DELETE FROM parties WHERE id_part = :partId');
        $stmt->bindParam(':partId', $partId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    static public function getAllExistantCourses()
    {
        $stmt = DB::connect()->prepare('SELECT * FROM modules');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
