<?php
require_once("connexion.php");
class rdv
{
    public int $id_rdv;
    public string $CIN_patient;
    public string $CIN_nurse;
    public string $date;
    public string $infos;
    public function read_all_RDV()
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
            $query = $pdo->prepare("SELECT * FROM RDVS ");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function read_RDV_by_id($id_rdv) 
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
            $query = $pdo->prepare("SELECT * FROM RDVS where id_rdv = $id_rdv");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function create_RDV($CIN_patient, $CIN_nurse, $date, $infos)
    {
        $pdo = connexion::getConnexion();
        try {
            $query = $pdo->prepare('
                INSERT INTO RDVS (CIN_patient,CIN_nurse,date,infos)
                VALUES (?,?,?,?)
            ');
            $query->bindParam(1, $CIN_patient);
            $query->bindParam(2, $CIN_nurse);
            $query->bindParam(3, $date);
            $query->bindParam(4, $infos);
            $query->execute();
            echo 'inserted';
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function read_RDV_nurse($cin)
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
            $query = $pdo->prepare("SELECT * FROM RDVS WHERE CIN_nurse  = $cin ");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function read_RDV_patient($cin)
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
            $query = $pdo->prepare("SELECT * FROM RDVS WHERE CIN_patient  = $cin ");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function delete_RDV($id)
    {
        $pdo = connexion::getConnexion();
        try {
            echo 'pass';
            $query = $pdo->prepare('DELETE FROM RDVS where id_rdv = :id');
            $query->execute([
                'id' => $id
            ]);

            echo $query->rowCount() . ' deleted successfully';
        } catch (PDOException $e) {
            echo 'error' . $e->getMessage();
        }
    }
    public function update_RDV($id, $field, $value)
    {
        $pdo = connexion::getConnexion();
        try {
            $query = $pdo->prepare("
            UPDATE RDVS SET $field = :value WHERE id_rdv = :id
        ");
            $query->execute([
                'id' => $id,
                'value' => $value,
            ]);
            echo $query->rowCount() . " updated successfully!";
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    public function read_all_RDV_by_nurse_gender($typee, $gender)
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }

            $queryUsers = $pdo->prepare("
                SELECT CIN
                FROM user
                WHERE gender = :gender AND typee = :typee
            ");

            $queryUsers->bindValue(":gender", $gender, PDO::PARAM_STR);
            $queryUsers->bindValue(":typee", $typee, PDO::PARAM_STR);
            $queryUsers->execute();
            $userCINs = $queryUsers->fetchAll(PDO::FETCH_COLUMN);
            if (empty($userCINs)) {
                return [];
            }
            $queryRDV = $pdo->prepare("
                SELECT RDVS.*
                FROM RDVS
                WHERE CIN_nurse IN (" . implode(',', $userCINs) . ")
            ");

            $queryRDV->execute();
            $results = $queryRDV->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function read_all_RDV_by_patient_gender($typee, $gender)
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }

            $queryUsers = $pdo->prepare("
                SELECT CIN
                FROM user
                WHERE gender = :gender AND typee = :typee
            ");

            $queryUsers->bindValue(":gender", $gender, PDO::PARAM_STR);
            $queryUsers->bindValue(":typee", $typee, PDO::PARAM_STR);
            $queryUsers->execute();
            $userCINs = $queryUsers->fetchAll(PDO::FETCH_COLUMN);
            if (empty($userCINs)) {
                return [];
            }
            $queryRDV = $pdo->prepare("
                SELECT RDVS.*
                FROM RDVS
                WHERE CIN_patient IN (" . implode(',', $userCINs) . ")
            ");

            $queryRDV->execute();
            $results = $queryRDV->fetchAll(PDO::FETCH_ASSOC);

            return $results;
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function search_by_first_and_last_name($name)
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }

            $queryUsers = $pdo->prepare("SELECT CIN FROM user WHERE lastname = :name OR firstname = :name");
            $queryUsers->bindValue(":name", $name, PDO::PARAM_STR);
            $queryUsers->execute();

            $userCINs = $queryUsers->fetchAll(PDO::FETCH_COLUMN);

            if (empty($userCINs)) {
                return [];
            }

            $inClause = implode(',', array_fill(0, count($userCINs), '?'));

            $queryRDV = $pdo->prepare("SELECT * FROM RDVS WHERE CIN_nurse IN ($inClause) OR CIN_patient IN ($inClause)");
            $queryRDV->execute(array_merge($userCINs, $userCINs));

            $results = $queryRDV->fetchAll(PDO::FETCH_ASSOC);

            return $results;
        } catch (PDOException $e) {

            error_log('PDO Error: ' . $e->getMessage());
            return [];
        } catch (Exception $e) {

            error_log('Error: ' . $e->getMessage());
            return [];
        }
    }
    public function read_all_RDV_by_date($date)
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }

            $queryRDV = $pdo->prepare("
                SELECT *
                FROM RDVS
                WHERE date = :date 
            ");
            $queryRDV->bindValue(":date", $date, PDO::PARAM_STR);
            $queryRDV->execute();
            $results = $queryRDV->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function search_by_first_and_last_name_of_patient($name, $cinn)
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }

            $queryUsers = $pdo->prepare("SELECT CIN FROM user WHERE lastname = :name OR firstname = :name");
            $queryUsers->bindValue(":name", $name, PDO::PARAM_STR);
            $queryUsers->execute();
            $userCINs = $queryUsers->fetchAll(PDO::FETCH_COLUMN);
            if (empty($userCINs)) {
                return [];
            }

            $inClause = implode(',', array_fill(0, count($userCINs), '?'));
            $queryRDV = $pdo->prepare("SELECT * FROM RDVS WHERE  CIN_patient IN ($inClause) AND CIN_nurse = $cinn");
            $queryRDV->execute($userCINs);
            $results = $queryRDV->fetchAll(PDO::FETCH_ASSOC);

            return $results;
        } catch (PDOException $e) {

            error_log('PDO Error: ' . $e->getMessage());
            return [];
        } catch (Exception $e) {

            error_log('Error: ' . $e->getMessage());
            return [];
        }
    }
    public function search_by_first_and_last_name_of_nurse($name, $cinp)
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }

            $queryUsers = $pdo->prepare("SELECT CIN FROM user WHERE lastname = :name OR firstname = :name");
            $queryUsers->bindValue(":name", $name, PDO::PARAM_STR);
            $queryUsers->execute();
            $userCINs = $queryUsers->fetchAll(PDO::FETCH_COLUMN);
            if (empty($userCINs)) {
                return [];
            }

            $inClause = implode(',', array_fill(0, count($userCINs), '?'));
            $queryRDV = $pdo->prepare("SELECT * FROM RDVS WHERE  CIN_nurse IN ($inClause) AND CIN_patient = $cinp");
            $queryRDV->execute($userCINs);
            $results = $queryRDV->fetchAll(PDO::FETCH_ASSOC);

            return $results;
        } catch (PDOException $e) {

            error_log('PDO Error: ' . $e->getMessage());
            return [];
        } catch (Exception $e) {

            error_log('Error: ' . $e->getMessage());
            return [];
        }
    }
}
?>