<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';


$mail = new PHPMailer(true); // Passing `true` enables exceptions

//inputs 

$target = $_POST["email"] ; 
$sbj =  $_POST["sbj"] ; 
$body =  $_POST["body"] ; 
$alt = $_POST["alt"] ; 


try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';        // Specify SMTP server
    $mail->SMTPAuth   = true;                    // Enable SMTP authentication
    $mail->Username   = 'solidcaresuppteam@gmail.com';   // SMTP username
    $mail->Password   = 'ziilakdrfryyjvmd';      // SMTP password
    $mail->SMTPSecure = 'ssl';                   // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 465;                     // TCP port to connect to

    // Recipients
    $mail->setFrom('solidcaresuppteam@gmail.com');
    $mail->addAddress($target); // Fix the typo in the email address

    // Content
    $mail->isHTML(true);  // Set email format to HTML
    $mail->Subject = $sbj ;
    $mail->Body    = $body;
    $mail->AltBody = $alt ;  // in case HTML is not supported

    $mail->send();
    header('location:../../view/mail/mailing.php');
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>