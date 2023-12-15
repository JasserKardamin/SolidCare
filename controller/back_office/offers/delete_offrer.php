<?php

require '../../../model/money_class.php' ; 

$plan = new plans() ; 
$rowname = $_POST['row_name'];

if (isset($rowname)) {
    $plan->delete_plan($rowname) ; 
    header('Location: ../../../view/back_office/offers/offers.php');
}

exit();
?>
