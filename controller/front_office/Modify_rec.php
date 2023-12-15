<?php
require_once '../../model/db_connect_front.php';

try {

    $value = $_POST['modify'];

    $delete = $pdo->prepare('UPDATE reclamationstatus SET status = "Not Treated" WHERE idrec = :id');
    $delete->bindParam(':id', $value);
    $delete->execute();
    header('Location: ../View/mail/mailing.php');
} catch (PDOException $e) {
    echo "error" . $e->getMessage();
}

?>