<?php
require_once '../../model/db_connect_front.php';
require '../../model/sessions_start.php' ; 
try {
    
    $cin = $_SESSION['cin'] ; 
    $name = $_SESSION['name'] ; 

    $query1 = $pdo->prepare('SELECT * FROM plans ORDER BY name LIMIT 1');
    $query2 = $pdo->prepare('SELECT * FROM plans ORDER BY name LIMIT 1 OFFSET 1');
    $query3 = $pdo->prepare('SELECT * FROM plans LIMIT 1 OFFSET 2');

    $query1->execute();
    $query2->execute();
    $query3->execute();

    $result1 = $query1->fetch(PDO::FETCH_ASSOC);
    $result2 = $query2->fetch(PDO::FETCH_ASSOC);
    $result3 = $query3->fetch(PDO::FETCH_ASSOC);
   
    // Prepare the INSERT query
    $q1 = $pdo->prepare('INSERT INTO sbscriptions(cin_user, offre_name) VALUES(:cin, :nom)');
    $q1->bindParam(':cin', $cin);

    try {
        $btn1 = isset($_POST['btn1']);
        $btn2 = isset($_POST['btn2']);
        $btn3 = isset($_POST['btn3']);
        $name = NULL;

        if ($btn1) {
            $name = $result1['name'];
        }
        if ($btn2) {
            $name = $result2['name'];
        }
        if ($btn3) {
            $name = $result3['name'];
        }

        // Bind the name parameter and execute the query
        $q1->bindParam(':nom', $name);
        $q1->execute();
        if ( $cin != NULL) {
            header('Location: ../../view/front_office/homepages/patient/patient.php');
        }
        else{
            header('Location: ../../view/front_office/homepages/patient/patient.php');

        }
        // Redirect to plans.php
        exit();
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
   
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


?>
