<?php
require_once '../../../model/db_connect_front.php';
require '../../../model/money_class.php' ; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["btn1"])) {
        
        $plan = new plans() ;

        $name = $_POST["name"];
        $price = $_POST["price"];
        $desc = $_POST["desc"];
        $duration = $_POST["duration"];

        if(ctype_alpha($name) && is_numeric($price) && is_numeric($duration)){

                $plan->add_plan($name,$price,$desc,$duration) ;
                header('Location: ../../../view/back_office/offers/offers.php');
                
        }else {
        header('Location: ../../../view/back_office/offers/offers.php');
            }

    }   
    
    elseif (isset($_POST["btn2"])) {
        $plan = new plans() ;
        $name = $_POST["name"];
        $price = $_POST["price"];
        $desc = $_POST["desc"];
        $duration = $_POST["duration"];
        if(ctype_alpha($name) && is_numeric($price) && is_numeric($duration)){
          
            $plan->update_plan($name,$price,$desc,$duration) ; 
        
            header('Location: ../../../view/back_office/offers/offers.php');

        }else {
            header('Location: ../../../view/back_office/offers/offers.php');
        }
    }
}
?>
