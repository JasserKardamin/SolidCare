<?php
require_once("../../model/dmd.php");
 $del_id = $_POST["id_del"];
$new_dmd = new dmd();
$new_dmd -> delete_DMD($del_id);
header('Location: ../../view/front_office/rdv/MainPatientDmd.php'); 
?>