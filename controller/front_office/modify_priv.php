<?php
require '../../model/sessions_start.php';
require '../../model/db_connect_front.php' ; 

$cin = $_SESSION['cin'];
$email = $_POST['email'];

if ($email != '') {
    try {
        $q = $pdo->prepare('UPDATE user SET email = :val WHERE CIN = :c');
        $q->bindParam(':val', $email);
        $q->bindParam(':c', $cin);
        $q->execute();
    } catch (PDOException $e) {
        echo 'error' . $e->getMessage();
    }
}
$cemail = $_POST['remail'] ;
if ($cemail != '' ) {
    try {
        $q = $pdo->prepare('UPDATE user SET recovery_email = :val WHERE CIN = :c');
        $q->bindParam(':val', $cemail);
        $q->bindParam(':c', $cin);
        $q->execute();
    } catch (PDOException $e) {
        echo 'error' . $e->getMessage();
    }
}

$pass = $_POST['pass'];
$cpass = $_POST['cpass'];

if ($pass != '' && $pass == $cpass) {
    try {
        $q = $pdo->prepare('UPDATE user SET password = :val WHERE CIN = :c');
        $q->bindParam(':val', $pass);
        $q->bindParam(':c', $cin);
        $q->execute();
    } catch (PDOException $e) {
        echo 'error' . $e->getMessage();
}
}


header('Location: ../../view/front_office/profile/privacy/privacy.php');
?>
