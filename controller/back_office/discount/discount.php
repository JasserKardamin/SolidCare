<?php

require '../../../model/money_class.php' ; 
require '../../../model/db_connect_front.php' ; 

$name = $_POST['name'] ; 
$discount = $_POST['discount'] ; 
$duration = $_POST['duration'] ;
$money = new plans() ;

$startDate = new DateTime();
$startDate->modify('+' . $duration);
$end = $startDate->getTimestamp();  

// verify 
$q = $pdo->prepare('SELECT * FROM discounts WHERE name = :name') ; 
$q->bindParam(':name',$name) ; 
$q->execute() ; 

if($q->rowCount() == 0 ) {
    $money->set_discount($name,$discount,date('Y-m-d H:i:s',$end)) ; 
    header('Location: ../../../view/back_office/offers/offers.php') ;  
}
else {
    header('Location: ../../../view/back_office/offers/offers.php') ;  
}
//setcookie("ending_date",date('Y-m-d H:i:s',$end),0,'./test.php') ; 

?>