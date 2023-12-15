<?php

require_once '../../model/db_connect_front.php';
require '../../model/money_class.php' ; 

try {

    $query1 = $pdo->prepare('SELECT * FROM discounts ORDER BY name LIMIT 1');
    $query2 = $pdo->prepare('SELECT * FROM discounts ORDER BY name LIMIT 1 OFFSET 1');
    $query3 = $pdo->prepare('SELECT * FROM discounts LIMIT 1 OFFSET 2');

    $query1->execute();
    $query2->execute();
    $query3->execute();

    $result1 = $query1->fetch(PDO::FETCH_ASSOC);
    $result2 = $query2->fetch(PDO::FETCH_ASSOC);
    $result3 = $query3->fetch(PDO::FETCH_ASSOC);

    $money = new plans() ;

    $currentDate = date('Y-m-d H:i:s'); 
   

    if ($currentDate > $result1['ending']) {
        $money->delete_discount($result1['id'], $result1['name'], $result1['old_price']);
    }

    if ($currentDate > $result2['ending']) {
        $money->delete_discount($result2['id'], $result2['name'], $result2['old_price']);
    }

    if ($currentDate > $result3['ending']) {
        $money->delete_discount($result3['id'], $result3['name'], $result3['old_price']);
    }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>