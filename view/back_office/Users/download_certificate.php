<?php

require '../../../model/db_connect_front.php';

// Check if the user is logged in

// Check if the user ID is provided in the URL
if (isset($_GET['cin'])) {
    $user_id = $_GET['cin'];

    // Fetch the user's name and certificate based on the user ID from the users table
    $sql = "SELECT firstname, lastname, certificate FROM users WHERE cin = :cin";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":cin", $user_id);
    $stmt->execute();

    // Retrieve the user's name and certificate as an associative array
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result !== false) {
        $firstname = $result['firstname'];
        $lastname = $result['lastname'];
        $certificate = $result['certificate'];

        // Set the filename to the user's name concatenated with "certificate.pdf"
        $filename = $firstname . " " . $lastname . " 's certification.pdf";

        // Provide file for download with the dynamically set filename
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=$filename");
        echo $certificate;
        exit();
    } else {
        echo "Certificate not found for this user.";
    }
} else {
    echo "User ID not provided.";
}


$pdo = null;
?>
