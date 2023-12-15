<?php

require '../../../../model/money_class.php' ;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['row_name'])) {
        $money = new subs() ; 

        $id = $_POST['row_name'];
        $money->delete_sub($id) ;
       
        header('Location: ../../../../view/back_office/sales/sales.php');
        exit();
    }
}

exit();
?>
