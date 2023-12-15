<?php
// delete_treatment.php

// Include your PDO connection and Treatment class here
require '../../../model/db_connect_front.php'; // Include your connection file
require '../../../model/treatement.php'; // Include your Treatment class file

// Create a Treatment object using your PDO connection
$treatment = new Treatment($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Call the deleteTreatment method from the Treatment class
    $treatment->deleteTreatment($id); // Perform treatment deletion

    // You can optionally return a success message
    echo 'Treatment record deleted successfully';
} else {
    // Handle the case where the ID is not received properly or the request method is not POST
    echo 'Invalid request';
}
?>
