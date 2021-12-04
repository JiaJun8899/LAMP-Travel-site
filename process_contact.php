<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $name = $subject = $message = $errorMsg = $success = "";
    $success = true;
    if (empty($_POST["email"])) {
        $errorMsg .= "Email is required.<br>";
        $success = false;
    } else {
        $email = sanitize_input($_POST["email"]);
        // Additional check to make sure e-mail address is well-formed.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMsg .= "Invalid email format.<br>";
            $success = false;
        }
    }
    if (empty($_POST["name"])) {
        $errorMsg .= "Name is required.<br>";
        $success = false;
    } else {
        $name = sanitize_input($_POST["name"]);
    }
    if (empty($_POST["subject"])) {
        $errorMsg .= "Subject is required.<br>";
        $success = false;
    } else {
        $subject = sanitize_input($_POST["subject"]);
    }
    if (empty($_POST["message"])) {
        $errorMsg .= "Message is required.<br>";
        $success = false;
    } else {
        $message = sanitize_input($_POST["message"]);
    }
    if ($success) {
        $_SESSION["errormsg"] = "Thank you for the feedback!";
        emailer($email, $name, $message, $subject);
    }
} else {
    $_SESSION["errormsg"] = "Unauthorised Access!";
    header("Location: http://35.187.229.58/project/index.php");
    exit();
}

//Helper function that checks input for malicious or unwanted content.
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function emailer($email, $name, $message, $subject) {
    $config = parse_ini_file('../../private/smtp-config.ini');
    //Create an instance; passing true enables exceptions
    $mail = new PHPMailer(true);

    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output

    $mail->isSMTP(); //Send using SMTP
    $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
    $mail->SMTPAuth = true; //Enable SMTP authentication
    $mail->Username = $config['username']; //SMTP username
    $mail->Password = $config['password']; //SMTP password
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
    $mail->Port = 587; //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS 
    try {
        //Recipients
        $mail->setFrom($config['username'], 'allons ICT1004');
        $mail->addAddress($email); //Add a recipient
        $mail->addBCC($config['username']);

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'Thank your for the feedback, ' . $name;
        $mail->Body = 'Here is what your feedback said: <br> Subject: ' . $subject . '<br>Feedback: ' . $message . "<br>We'll get back to you as soon as possible!";
        $mail->AltBody = "Testing 123";
        $mail->send();
    } catch (Exception $e) {
        $errorMsg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        $_SESSION["errormsg"] = " Something went wrong, we are working on a fix!";
    }
    header("Location: http://35.187.229.58/project/index.php");
    exit();
}

?>