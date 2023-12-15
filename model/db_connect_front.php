<?php
// Database configuration
$username = 'Just_Trying' ; 
$password = '274988' ;

// PDO connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=SolidCare", $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>