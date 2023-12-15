<?php

include '../../../model/db_connect_front.php' ;

try {

    $id = $_COOKIE["idd"] ;
    
    $q1 = $pdo->prepare('SELECT * FROM sbscriptions WHERE id_subscription = :id') ; 
    $q1->bindParam(':id',$id) ;
    $q1->execute() ; 
    $r1 = $q1->fetch(PDO::FETCH_ASSOC) ;

    $customer_cin = $r1['cin_user'] ;
    $offre_name = $r1['offre_name'] ;

    // client handeling 
    $q2 = $pdo->prepare('SELECT * FROM user WHERE CIN = :cin ');
    $q2->bindParam(':cin',$customer_cin) ;
    $q2->execute() ;
    $r2 = $q2->fetch(PDO::FETCH_ASSOC); 
   
    $customer_name = $r2['firstname'] ; 
    $customer_surname = $r2['lastname'] ; 
    $customer_email = $r2['email'] ; 
    $customer_phone = $r2['phone'] ; 

  
    //offer handeling 
    $q3 = $pdo->prepare('SELECT * FROM plans  WHERE  name = :n');
    $q3->bindParam(':n',$offre_name); 
    $q3->execute();
    $r3 = $q3->fetch(PDO::FETCH_ASSOC) ;
    $price = $r3['price'] ;
    $duration =$r3['duration'] ;
   

}catch(PDOException $e ) {
    echo 'error'.$e->getMessage() ;
}



$response = array(
    'name' =>$customer_name,
    'surname' => $customer_surname,
    'email'=> $customer_email,
    'phone'=>$customer_phone,
    'price'=>$price,
    'duration'=>$duration
);
echo json_encode($response) ; 



?>