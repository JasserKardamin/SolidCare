<?php
require_once '../../model/db_connect_front.php';
require_once '../../model/sessions_start.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $verificationCode = $_POST['verification_code'];

        // Assuming $pdo is your PDO object
        $select = $pdo->prepare('SELECT verification_code FROM newsletter WHERE verification_code = :verification_code');
        $select->bindParam(':verification_code', $verificationCode);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['verification_code'] === $verificationCode) {
            // Verification code is correct
            $update = $pdo->prepare('UPDATE newsletter SET status = "Verified" WHERE verification_code = :verification_code');
            $update->bindParam(':verification_code', $verificationCode);
            
            
            $update->execute();
            $role = $_SESSION['role'] ;
            if($role == NULl) {
                header("Location: ../../view/front_office/homepages/public/Contact.php");
            }
            else if($role == 'nurse'){
                header("Location: ../../view/front_office/homepages/nurse/Contact.php");
            }
            if($role == 'nurse') {
                header("Location ../../view/front_office/homepages/patient/Contact.php");
            }
            header('Location: ../../View/front_office/homepages/public/Contact.php');
            exit();
            
        } else {
            // Invalid code
            echo "<script>alert('Invalid code.');</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>

<body>
    <div style="text-align: center; margin-top: 50px;">
        <h2>Verify Your Email</h2>
        <p>Your email has been successfully registered. To complete the verification process, enter the code below:</p>

        <form action="verification.php" method="post">
            <label for="verification_code">Enter Verification Code:</label>
            <input type="text" name="verification_code" required>
            <button type="submit" name="verify">Verify Your Email</button>
        </form>
    </div>
</body>

</html>
