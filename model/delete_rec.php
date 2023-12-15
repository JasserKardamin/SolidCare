<?php
require_once '../Model/Connect.php';

try {

    $value = $_POST['delete'];

    $delete = $pdo->prepare('DELETE FROM reclamation WHERE ID = :id');
    $delete1 = $pdo->prepare('DELETE From statusreclamation where idrec = :id');
    $delete->bindParam(':id', $value);
    $delete->execute();
    $delete1->bindParam(':id', $value);
    $delete1->execute();
    header('Location: ../View/mail/mailing.php');
} catch (PDOException $e) {
    echo "error" . $e->getMessage();
}

?>