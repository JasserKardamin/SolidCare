<?php
include '../../model/sessions_start.php' ; 
require_once '../../model/db_connect_front.php';

$cin = $_POST['login'];
$pass = $_POST['pass'] ;

try {
    $query = $pdo->prepare("SELECT * FROM user WHERE CIN =:c AND password =:pass");
    $query->bindParam(':c', $cin);
    $query->bindParam(':pass', $pass);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($query->rowCount() > 0) {
        $_SESSION['cin'] = $cin ;  
        $_SESSION['name'] = $result['firstname'] ; 
        $_SESSION['gender'] = $result['gender']  ; 
        $_SESSION['role'] = $result['typee']     ; 

        if($result['typee'] == "nurse") {
            header('Location: ../../view/front_office/homepages/nurse/nurse.php') ;
        }
        
        if($result['typee'] == "patient") {
            header('Location: ../../view/front_office/homepages/patient/patient.php') ;
        }
    } 
    else {
        header('Location: ../../view/front_office/user/login.html') ;
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


?>
