<?php
require_once "../database/DB.php";

class User
{

    protected $nom;
    protected $prenom;
    protected $email;
    protected $adresse;
    protected $mot_de_passe;
    protected $path_profile;

    public static function loginUser($email)
    {
        $stmt = DB::connect()->prepare('SELECT * FROM ' . static::$tableName . ' WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        $stmt = null;
        return $user;
    }

    public static function checkEmailExists($email)
    {
        $stmt = DB::connect()->prepare('SELECT COUNT(*) FROM ' . static::$tableName . ' WHERE email = ?');
        $stmt->execute([$email]);
        $count = $stmt->fetchColumn();
        $stmt = null; // Closing connection
        return $count > 0;
    }

    public static function addUser($data)
    {
        $hashedPassword = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);

        $stmt = DB::connect()->prepare('INSERT INTO ' . static::$tableName . ' (nom, prenom, adresse, email, mot_de_passe, request) VALUES (:nom, :prenom, :adresse, :email, :mot_de_passe, 0)');
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':prenom', $data['prenom']);
        $stmt->bindParam(':adresse', $data['adresse']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':mot_de_passe', $hashedPassword);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
        $stmt = null;
    }

    public static function changePassword($prfid, $newPass)
    {
        try {
            $hashedNewPass = password_hash($newPass, PASSWORD_DEFAULT);

            $stmt = DB::connect()->prepare('UPDATE ' . static::$tableName . ' SET mot_de_passe = :password WHERE id = :id');
            $stmt->bindParam(':password', $hashedNewPass);
            $stmt->bindParam(':id', $prfid);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function modifyUser($prfid, $data)
    {
        try {
            $stmt = DB::connect()->prepare('UPDATE ' . static::$tableName . ' SET nom = :nom, prenom = :prenom, adresse = :adresse, email = :email WHERE id = :id');

            $stmt->bindParam(':nom', $data['nom']);
            $stmt->bindParam(':prenom', $data['prenom']);
            $stmt->bindParam(':adresse', $data['adresse']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':id', $prfid);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function requestDelete($prfid)
    {
        try {
            $stmt = DB::connect()->prepare('UPDATE ' . static::$tableName . ' SET request = 1 WHERE id = :id');
            $stmt->bindParam(':id', $prfid);
            $stmt->execute();
            $stmt = null;
            return 'ok';
        } catch (PDOException $e) {
            error_log('Failed to request deletion: ' . $e->getMessage());
            return 'error';
        }
    }

    public static function getUserName($prfid)
    {
        try {
            $stmt = DB::connect()->prepare('SELECT nom, prenom FROM ' . static::$tableName . ' WHERE id = :id');
            $stmt->bindParam(':id', $prfid);
            $stmt->execute();
            $name = $stmt->fetch(PDO::FETCH_OBJ);
            $stmt = null;
            return $name;
        } catch (PDOException $e) {
            error_log('Failed to request deletion: ' . $e->getMessage());
            return 'error';
        }
    }
}

class Etudiant extends User
{
    protected static $tableName = 'etudiant';

    static public function getMyCourses($stdid)
    {
        $stmt = DB::connect()->prepare('SELECT m.id, m.nom, m.description, m.prof_id FROM modules m
            JOIN enrollement e ON m.id = e.id_cours
            WHERE e.id_etd = ?');
        $stmt->execute([$stdid]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    static public function requestEnrollment($studentId, $courseId, $profId) {
        $db = DB::connect();
        $sql = "INSERT INTO enrollment_requests (student_id, cours_id, prof_id) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$studentId, $courseId, $profId]);
    }

    // Additional methods specific to Etudiant can be added here
}

class Prof extends User
{
    protected static $tableName = 'professeurs';

    public static function getAllEtudiants()
    {
        $stmt = DB::connect()->prepare('SELECT * FROM etudiant');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);  // Fetch all students as objects
    }

    public static function getCourses($profId)
    {
        $stmt = DB::connect()->prepare('SELECT id, name FROM courses WHERE prof_id = ?');
        $stmt->execute([$profId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function enrollStudents($courseId, $studentIds)
    {
        $stmt = DB::connect()->prepare('INSERT INTO enrollement (id_cours, id_etd) VALUES (?, ?)');
        foreach ($studentIds as $id) {
            $stmt->execute([$courseId, $id]);
        }
        return true;
    }

    public static function getStudentsWithEnrollmentStatus($courseId)
    {
        $db = DB::connect();
        $sql = "SELECT etudiant.*, 
                CASE WHEN enrollement.id_cours IS NULL THEN 0 ELSE 1 END AS is_enrolled
                FROM etudiant
                LEFT JOIN enrollement ON etudiant.id = enrollement.id_etd AND enrollement.id_cours = :courseId";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':courseId', $courseId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function removeStudentFromCourse($courseId, $studentId)
    {
        $stmt = DB::connect()->prepare('DELETE FROM enrollement WHERE id_cours = :courseId AND id_etd = :studentId');
        $stmt->bindParam(':courseId', $courseId);
        $stmt->bindParam(':studentId', $studentId);
        return $stmt->execute();
    }


    // Additional methods specific to Prof can be added here
}
