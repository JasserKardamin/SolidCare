<?php
require_once '../Model/Connect.php';

try {

    $value = $_POST['delete'];

    $delete = $pdo->prepare('DELETE FROM solidcare.dmds WHERE id_dmd = :id');
    $delete->bindParam(':id', $value);
    $delete->execute();
    header('Location: ../View/Demande/backDemand.php');
} catch (PDOException $e) {
    echo "error" . $e->getMessage();
}

?>