<?php
require_once ("connexion.php");
class nurse
{
    public int $CIN;
    public string $last_name;
    public string $first_name;
    public string $date_od_birth;
    public string $email;
    public string $password;
    public int $phone;
    public string $localisation;
    public string $gender;
    public string $domain;
    public function read_NRS()
    {
        try {
            $pdo = connexion::getConnexion();
            
            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
            $query = $pdo->prepare("SELECT * FROM user where typee = 'nurse'");
            $query->execute() ;
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function read_NRS_by_CIN($cinn)
    {
        try {
            $pdo = connexion::getConnexion();
            
            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
            $query = $pdo->prepare("SELECT * FROM user where CIN = :cin");
            $query->bindParam(':cin',$cinn) ; 
            $query->execute() ;
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function update_NRS($id, $field, $value)
    {
        $pdo = connexion::getConnexion();
        try {
            $query = $pdo->prepare("
                UPDATE user SET $field = :value WHERE CIN = :id
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
}
?>