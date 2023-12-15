<?php
require_once("connexion.php");
class dmd
{
    public int $id_dmd;
    public int $CIN_nurse;
    public int $CIN_patient;
    public string $infos; 
    public string $date;
    public function read_DMD_nurse($cin)
    {
        try {
            $pdo = connexion::getConnexion();
            
            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
            $query = $pdo->prepare("SELECT * FROM DMDS WHERE CIN_nurse  = $cin AND status != 'refused' AND status != 'accepted'");
            $query->execute() ;
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function read_DMD_patient($cin)
    {
        try {
            $pdo = connexion::getConnexion();
            
            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
            $query = $pdo->prepare("SELECT * FROM DMDS WHERE CIN_patient = :cin AND status NOT IN ('refused', 'accepted')");
            $query->bindParam(':cin', $cin);
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function read_DMD_patient_wr($cin)
    {
        try {
            $pdo = connexion::getConnexion();
            
            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
            $query = $pdo->prepare("SELECT * FROM DMDS WHERE CIN_patient  = $cin AND status = 'refused'");
            $query->execute() ;
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {    
            die('Error: ' . $e->getMessage());
        }
    }
    public function create_DMD($CIN_nurse, $CIN_patient, $infos, $date)
    {
        $pdo = connexion::getConnexion();
        try {
            $query = $pdo->prepare('INSERT INTO DMDS (CIN_nurse,CIN_patient,infos,date)VALUES (?,?,?,?)');
            $query->bindParam(1, $CIN_nurse);
            $query->bindParam(2, $CIN_patient);
            $query->bindParam(3, $infos);
            $query->bindParam(4, $date);
            $query->execute();
            echo 'inserted';
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function update_DMD($id, $status)
    {
        $pdo = connexion::getConnexion();
        try {
            $query = $pdo->prepare('UPDATE DMDS SET status= :status WHERE id_dmd = :id');
            $query->execute([
                'id' => $id,
                'status' => $status
            ]);
            echo $query->rowCount() . " updated seccessfully !!";
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    public function delete_DMD($id)
    {
        $pdo = connexion::getConnexion();
        try {
            $query = $pdo->prepare('
            DELETE FROM DMDS where id_dmd = :id
            ');
            $query->execute([
                'id' => $id
            ]);

            $maxQuery = $pdo->query('SELECT MAX(id_dmd) AS max_id FROM DMDS');
            $maxId = $maxQuery->fetchColumn();
            $pdo->exec("ALTER TABLE DMDS AUTO_INCREMENT = " . ($maxId + 1));
    
            echo $query->rowCount() . ' deleted successfully';
        } catch (PDOException $e) {
            echo 'error' . $e->getMessage();
        }
    }
}
?>