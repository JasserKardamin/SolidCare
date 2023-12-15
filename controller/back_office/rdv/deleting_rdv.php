<?php
require_once("../../../model/rdv.php");
$id_rdv = $_POST['id_del']; 
$new_rdv = new rdv();
var_dump($id_rdv);
$new_rdv -> delete_RDV($id_rdv);
echo'pass';
header('Location: ../../view/RDV/MainAdminRdv.php') ;  
?>