<?php
require '../../../../model/money_class.php' ; 

try {
  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $money = new subs() ; 
        $id = $_POST['id']; 
        $cin = $_POST['cin'];
        echo $cin ;
        $name = $_POST['names-s'];
        // 7amdoula ya rabi     
        $money->modify_sub($id,$cin,$name) ;
        header('Location: ../../../../view/back_office/sales/sales.php') ; 
        }
        
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }   


exit();
?>
