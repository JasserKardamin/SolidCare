<?php
require_once ("db_connect_front.php");
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
    public function read_NRS($pdo)
    {
        try {
            $query = $pdo->prepare("SELECT * FROM user where typee = 'nurse'");
            $query->execute() ;
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } 
    }
    public function read_NRS_by_CIN($cinn,$pdo)
    {

        try {
            $query = $pdo->prepare("SELECT * FROM user where CIN = :cin");
            $query->bindParam(':cin',$cinn) ; 
            $query->execute() ;
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        }
    }
}
?>