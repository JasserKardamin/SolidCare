<?php

require_once 'db_connect_front.php';
require_once 'sessions_start.php';

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$role = $_SESSION['role'];


require '../controller/front_office/PHPMailer/src/Exception.php';
require '../controller/front_office/PHPMailer/src/PHPMailer.php';
require '../controller/front_office/PHPMailer/src/SMTP.php';
require '../controller/front_office/vendor/autoload.php';


// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Collect form data
    $name = isset($_GET['name']) ? $_GET['name'] : '';
    $email = isset($_GET['email']) ? $_GET['email'] : '';
    $subject = isset($_GET['subject']) ? $_GET['subject'] : '';
    $message = isset($_GET['message']) ? $_GET['message'] : '';
    $subscribe = isset($_GET['news']) ? 1 : 0;

    try {

        // Prepare the SQL statement
        $query = $pdo->prepare('INSERT INTO reclamation(name, email, subject, message, id_status) VALUES(:name, :email, :subject, :message, :id_status)');
        // Bind values to parameters

        $query->bindValue(':name', $name);
        $query->bindValue(':email', $email);
        $query->bindValue(':subject', $subject);
        $query->bindValue(':message', $message);
        $query->bindValue(':id_status', 0); // Set id_status to 0 (not-replied)
        // Execute the query
        $query->execute();

        // Check if the user subscribed to the newsletter
        if ($subscribe) {
            // Check if the email already exists in the newsletter table
            $checkEmailQuery = $pdo->prepare('SELECT COUNT(*) FROM newsletter WHERE email = :email');
            $checkEmailQuery->bindValue(':email', $email);
            $checkEmailQuery->execute();
            $emailCount = $checkEmailQuery->fetchColumn();

            // If the email doesn't exist, insert it into the newsletter table
            if ($emailCount == 0) {
                // Prepare the SQL statement for the newsletter subscription
                $verificationCode = bin2hex(random_bytes(16));

                $newsletterQuery = $pdo->prepare('INSERT INTO newsletter (email, status, verification_code) VALUES (:email, :status, :verification_code)');
                $newsletterQuery->bindValue(':email', $email);
                $newsletterQuery->bindValue(':status', "Not verified");
                $newsletterQuery->bindValue(':verification_code', $verificationCode);
                $newsletterQuery->execute();

                // Send verification email
                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'aminesouissi720@gmail.com';
                $mail->Password = 'hgbeokgzrijxfwqv';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                $mail->setFrom('aminesouissi720@gmail.com');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Email Verification';
                $mail->Body = "Enter the link and Copy the following code to verify your email:Link -----> link=http://localhost/Projet-Web/controller/front_office/verification.php Copy your -----> code=$verificationCode";

                $mail->send();

                echo "<script>alert('Message sent successfully! Please check your email for verification.');</script>";
            } else {
                // Email is already in the newsletter
                echo "<script>alert('Email is already subscribed to the newsletter.');</script>";
            }
        }

        // Redirect to the contact page with success parameter
        echo "<script>alert('Message sent successfully!');</script>";
    } catch (PDOException $e) {
        // Redirect to the contact page with error parameter
        echo '<script>alert("Error sending message. Please try again later.");</script>';
        header("Location: contact.php?error=1");
        exit();
    }
    if ($role == NULL) {
        echo '<script>window.location.href="../view/front_office/homepages/public/Contact.php";</script>';
    } else if ($role == 'nurse') {
        echo '<script>window.location.href="../view/front_office/homepages/nurse/Contact.php";</script>';
    } else {
        echo '<script>window.location.href="../view/front_office/homepages/patient/Contact.php";</script>';
    }
    exit();
} else {

    // Redirect to the contact page if the form is not submitted

    if ($role == NULl) {
        header("Location: ../view/front_office/homepages/public/Contact.php");
    } else if ($role == 'nurse') {
        header("Location: ../view/front_office/homepages/nurse/Contact.php");
    } else {
        header("Location: ../view/front_office/homepages/patient/Contact.php");
    }
    exit();
}
?>