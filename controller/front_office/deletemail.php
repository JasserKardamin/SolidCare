<?php
require_once '../../model/db_connect_front.php';

try {

    $value = $_POST['delete'];

    $delete = $pdo->prepare('DELETE FROM solidcare.newslettre WHERE id = :id');
    $delete->bindParam(':id', $value);
    $delete->execute();
    header('Location: ../View/Demande/backDemand.php');
} catch (PDOException $e) {
    echo "error" . $e->getMessage();
}

?>