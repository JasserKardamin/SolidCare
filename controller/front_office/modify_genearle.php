<?php
require '../../model/sessions_start.php';
require '../../model/db_connect_front.php' ; 

$cin = $_SESSION['cin'];
$fn = $_POST['fname'];
$ln = $_POST['lname'];
$p = $_POST['phone'];
$des = $_POST['desc'];
$loc = $_POST['loc'];
$date = $_POST['date'];





//$imageData = file_get_contents($file['tmp_name']);


if ($fn != '') {
    try {
        $q = $pdo->prepare('UPDATE user SET firstname = :val WHERE CIN = :c');
        $q->bindParam(':val', $fn);
        $q->bindParam(':c', $cin);
        $q->execute();
        header('Location: ../../view/front_office/profile/profile/general.php');
    } catch (PDOException $e) {
        echo 'error' . $e->getMessage();
    }
   
}
if ($ln != '' ) {
    try {
        $q = $pdo->prepare('UPDATE user SET lastname = :val WHERE CIN = :c');
        $q->bindParam(':val', $ln);
        $q->bindParam(':c', $cin);
        $q->execute();
        header('Location: ../../view/front_office/profile/profile/general.php');
    } catch (PDOException $e) {
        echo 'error' . $e->getMessage();
    }
   
}

if ($p != '' ) {
    try {
        $q = $pdo->prepare('UPDATE user SET phone = :val WHERE CIN = :c');
        $q->bindParam(':val', $p);
        $q->bindParam(':c', $cin);
        $q->execute();
         header('Location: ../../view/front_office/profile/profile/general.php');
} catch (PDOException $e) {
        echo 'error' . $e->getMessage();
    }
}

if ($des != '' ) {
    try {
        $q = $pdo->prepare('UPDATE user SET description  = :val WHERE CIN = :c');
        $q->bindParam(':val', $des);
        $q->bindParam(':c', $cin);
        $q->execute();
        header('Location: ../../view/front_office/profile/profile/general.php');
} catch (PDOException $e) {
        echo 'error' . $e->getMessage();
    }
}


if ($loc != '' ) {
    try {
        $q = $pdo->prepare('UPDATE user SET location = :val WHERE CIN = :c');
        $q->bindParam(':val', $loc);
        $q->bindParam(':c', $cin);
        $q->execute();
         header('Location: ../../view/front_office/profile/profile/general.php');
} catch (PDOException $e) {
        echo 'error' . $e->getMessage();
    }
}


if ($date != '' ) {
    try {
        $q = $pdo->prepare('UPDATE user SET date_of_birth = :val WHERE CIN = :c');
        $timestamp = strtotime($date);
        $formattedDate = date('Y-m-d', $timestamp);
        $q->bindParam(':val', $formattedDate);
        $q->bindParam(':c', $cin);
        $q->execute();
        header('Location: ../../view/front_office/profile/profile/general.php');
    } catch (PDOException $e) {
        echo 'error' . $e->getMessage();
    }
}


if (isset($_FILES['imagee'])) {
    $image = $_FILES['imagee']['tmp_name']; 
    $imageType = $_FILES['imagee']['type'];  

    // Read the file content
    $imageContent = file_get_contents($image);

    // Prepare SQL statement
    $stmt = $pdo->prepare("UPDATE user SET photo = :p WHERE  CIN = :c");
    $stmt->bindParam(':p', $imageContent, PDO::PARAM_LOB);
    $stmt->bindParam(':c', $cin);
    // Execute the query
    if ($stmt->execute()) {
        echo "Image uploaded successfully.";
    } else {
        echo "Error uploading image.";
    }
} 


header('Location: ../../view/front_office/profile/profile/general.php');

?>
