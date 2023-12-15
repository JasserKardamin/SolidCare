<?php

require '../../model/db_connect.php';
require '../../model/functions.php' ; 

if (isset($_POST["btn1"])) {

    $cin = $_POST['cin'];
    ban_user($cin) ;  
    header('Location: ../../view/Users/users.php');  

} elseif (isset($_POST["btn2"])) {

    $cin = $_POST["cin"];
    delete_user($cin) ; 
    header('Location: ../../view/Users/users.php');  
        
}
?>