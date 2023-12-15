<?php
require '../../model/db_connect_front.php';
require '../../model/sessions_start.php';

$fn = $_POST['fn'];
$ln = $_POST['ln'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$date = $_POST['date'];
$loc = $_POST['loc'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$cin = $_POST['cin'];
$pass = $_POST['pass'];
$role = $_POST['role'];

echo $role;

try {
    $query1 = $pdo->prepare('INSERT INTO user(CIN,firstname,lastname,email,phone,date_of_birth,location,gender,typee,age,password)
                            VALUES(:cin,:fn,:ln,:email,:phone,:dob,:loc,:gender,:rol,:age,:pass)');

    $query1->bindParam(':fn', $fn);
    $query1->bindParam(':ln', $ln);
    $query1->bindParam(':email', $email);
    $query1->bindParam(':phone', $phone);
    $query1->bindParam(':dob', $date);
    $query1->bindParam(':loc', $loc);
    $query1->bindParam(':gender', $gender);
    $query1->bindParam(':rol', $role); // Add this line
    $query1->bindParam(':age', $age);
    $query1->bindParam(':pass', $pass);
    $query1->bindParam(':cin', $cin);

    // Execute the query
    $query1->execute();
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
header('Location: ../../view/front_office/user/login.html') ; 
?>