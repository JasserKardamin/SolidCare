<?php
require("../model/dmd.php");
$CIN_nurse = $_COOKIE["cin"];
/*************************************/
//imported using cookies : 
$CIN_patient = "12345678";
/*************************/
$infos = $_POST["in"];
var_dump($infos);
$date = $_POST["dt"];
var_dump($date);

$current_date = date("Y-m-d");
if($date >= $current_date) {


    $new_dmd = new dmd();

    var_dump($CIN_nurse);
    $new_dmd->create_DMD($CIN_nurse, $CIN_patient, $infos, $date);
    var_dump($CIN_nurse);

   header('Location:ShowNurses.php');

} else {

    header('location:ShowNurses.php');
}
?>