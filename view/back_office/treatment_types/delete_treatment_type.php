<?php
// delete_treatmenttype.php

// Include your PDO connection and TreatmentType class here
require '../../../model/db_connect_front.php'; // Include your connection file
require '../../../model/treatmenttypeC.php'; // Include your TreatmentType class file

$treatmentType = new TreatmentType($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom'])) {
    $nom = $_POST['nom'];

    // Call the deleteTreatmentType method from the TreatmentType class
    $treatmentType->deleteTreatmentType($nom); // Perform treatment type deletion

    // You can optionally return a success message
    echo 'Treatment type record deleted successfully';
} else {
    // Handle the case where the nom is not received properly or the request method is not POST
    echo 'Invalid request';
}
?>
