<?php
// Include your PDO connection and Treatment class here
require '../../../../model/db_connect_front.php'; // Include your connection file
require '../../../../model/treatement.php'; // Include your Treatment class file
require '../../../../model/sessions_start.php';  

// Retrieve the order value sent via AJAX
$order = $_GET['order'];

// Retrieve the value of cin from cookies
if (isset($_SESSION['cin'])) {
    $cin = $_SESSION['cin'];
} else {
    // Handle the case where the cookie doesn't exist or is not set
    // Redirect or display an error message, etc.
    exit('Error: Cin Session not set!');
}

// Create a Treatment object using your PDO connection
$treatment = new Treatment($pdo);

// Fetch treatment records from the database using the fetchTreatments method
$stmt = $pdo->prepare("SELECT * FROM treatment WHERE CIN_Patient = :cin OR CIN_NURSE = :cin ORDER BY date_of_treatment $order");
$stmt->execute([':cin' => $cin]);
$treatmentRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare and return the HTML content for the table rows
$html = '';
foreach ($treatmentRecords as $record) {
    $html .= "<tr>";
    $html .= "<td>{$record['date_of_treatment']}</td>";
    $html .= "<td>{$record['type_of_treatment']}</td>";

    // Fetch patient name based on CIN from the database
    $stmtPatient = $pdo->prepare("SELECT lastname FROM user WHERE CIN = ?");
    $stmtPatient->execute([$record['CIN_Patient']]);
    $patientName = $stmtPatient->fetchColumn();

    // Fetch nurse name based on CIN from the database
    $stmtNurse = $pdo->prepare("SELECT lastname FROM user WHERE CIN = ?");
    $stmtNurse->execute([$record['CIN_NURSE']]);
    $nurseName = $stmtNurse->fetchColumn();

    $html .= "<td>$patientName</td>";
    $html .= "<td>$nurseName</td>";
    $html .= "</tr>";
}

// Return the HTML content back to the AJAX call
echo $html;
?>
