<?php

include "createdmd.php";
require_once "db_connect_front.php";
require 'sessions_start.php' ;

$CIN_nurse = $_SESSION['cin_nurse'] ; 
//get cin_patient with session 
$CIN_patient = $_SESSION['cin'];
//-------------
$infos = isset($_POST["in"]) ? $_POST["in"] : '';
$date = isset($_POST["dt"]) ? $_POST["dt"] : '';

try {

    $new_dmd = new dmd();
    $new_dmd->create_DMD($CIN_nurse, $CIN_patient, $infos, $date, $pdo);

    header('Location: ../view/front_office/Demand/LookingForNurse.php');
    exit() ; 

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

header('Location: ../View/Demande/LookingForNurse.php');

?>