<?php   
class Connexion
{
    private static $pdo = null;
    
    public static function getConnexion()
    {
        $servername = "localhost";
        $dbname ="SolidCare";
        $username ="Just_Trying";
        $password ="274988";
        
        try {
            self::$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
           //echo "You are connected.";
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        
        return self::$pdo;
    }
}
?>
