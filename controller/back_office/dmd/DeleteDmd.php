<?php
require_once '../../../model/db_connect_front.php';

try {

    $value = $_POST['delete'];

    $delete = $pdo->prepare('DELETE FROM DMDS WHERE id_dmd = :id');
    $delete->bindParam(':id', $value);
    $delete->execute();
    header('Location: ../../../view/back_office/Demande/backDemand.php');
} catch (PDOException $e) {
    echo "error" . $e->getMessage();
}

?>