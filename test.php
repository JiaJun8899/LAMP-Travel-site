<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

//Create an instance; passing true enables exceptions
$mail = new PHPMailer(true);

//Server settings
$mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
//$config = parse_ini_file('../allconfig/allconfig.ini');

$mail->isSMTP(); //Send using SMTP
$mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
$mail->SMTPAuth = true; //Enable SMTP authentication
$mail->Username = ; //SMTP username
$mail->Password = ; //SMTP password
// $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
$mail->Port = 587; //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS 
try {
//Recipients
    $mail->setFrom('ict1004.allons@gmail.com', 'allons ICT1004');
    $mail->addAddress('cjj8899@gmail.com'); //Add a recipient
    $mail->addReplyTo('cjj7475@gmail.com');

    //Content
    $mail->isHTML(true); //Set email format to HTML
    $mail->Subject = 'Someone contacted us';
    $mail->Body = "Testing 123";
    $mail->AltBody = "Testing 123";

    $mail->send();
} catch (Exception $e) {
    $errorMsg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
