<?php

require '../../../model/money_class.php' ; 

$id = $_POST['id'] ; 
$name = $_POST['name'] ; 
$old_price = $_POST['price'] ;  
$end = $_POST['ending'] ; 

$money = new plans() ; 
$money->delete_discount($id,$name,$old_price) ; 

header('Location: ../../../view/back_office/offers/offers.php') ; 
?>