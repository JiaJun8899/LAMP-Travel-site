<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
$email = $fname = $lname = $errorMsg = $success = $pwd = "";
$phone = 0;
$success = true;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
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
    if (empty($_POST['agree'])) {
        $errorMsg .= "Accepting terms and conditions is required.<br>";
        $success = false;
    }
    if (empty($_POST["fname"])) {
        $errorMsg .= "First Name is required.<br>";
        $success = false;
    } else {
        $fname = sanitize_input($_POST["fname"]);
    }
    if (!empty($_POST["lname"])) {
        $lname = sanitize_input($_POST["lname"]);
    }
    if (empty($_POST["pwd"])) {
        $errorMsg .= "Password is required.<br>";
        $success = false;
    } else if (empty($_POST["pwd_confirm"])) {
        $errorMsg .= "Password confirm is required.<br>";
        $success = false;
    } else {
        if ($success === password_chk($_POST["pwd"], $_POST["pwd_confirm"])&& validatepwd($_POST["pwd"])) {
            $pwd = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
        } else {
            $errorMsg .= "There are some issues with the passwords.<br>";
            $success = false;
        }
    }
    if (empty($_POST["phone"])) {
        $errorMsg .= "Phone Number is required.<br>";
        $success = false;
    } else {
        $phone = filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT);
        if (!validate_mobile($phone)) {
            $errorMsg .= "A valid contact number is required.<br>";
            $success = false;
        }
    }
    if ($success) {
        saveMemberToDB();
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

function validate_mobile($mobile) {
    return preg_match('/^[0-9]{8}$/', $mobile);
}

function password_chk($pwd, $con_pwd) {
    if ($pwd === $con_pwd) {
        return true;
    } else {
        return false;
    }
}

function validatepwd($password) {
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);

    if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
        return false;
    }else{
        return true;
    }
}

function saveMemberToDB() {
    global $email, $fname, $lname, $errorMsg, $success, $pwd, $phone;
    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
            $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        // Prepare the statement:
        $stmt = $conn->prepare("INSERT INTO members(email, password, fname, lname, phoneno, cart_cartid) VALUES (?, ?, ?, ?, ?, ?)");
        // Bind & execute the query statement:
        $stmt->bind_param("ssssii", $email, $pwd, $fname, $lname, $phone, $phone);
        if (!$stmt->execute()) {
            $errorMsg = "Something went wrong! You might have an acount with us!";
            $success = false;
        } else {
            emailer($email, $fname, $lname);
        }
        $stmt->close();
    }
    $conn->close();
}

function emailer($email, $fname, $lname) {
    $message = file_get_contents('emailtemp/register.html');
    $message = str_replace('%lname%', $lname, $message);
    $config = parse_ini_file('../../private/smtp-config.ini');
    //Create an instance; passing true enables exceptions
    $mail = new PHPMailer(true);

    //Server settings
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
        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'Welcome to allons-y, ' . $fname . ' ' . $lname . '!';
        $mail->msgHTML($message);
        $mail->AltBody = "Welcome to allons-y";
        $mail->send();
    } catch (Exception $e) {
        $errorMsg = "Something went wrong, we are working on a fix!";
        $_SESSION["errormsg"] = "Something went wrong, we are working on a fix!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include 'header.inc.php';
        ?>
        <title>Registration</title>
    </head>
    <body>
        <?php
        include "nav.inc.php";
        ?>
        <main class="container text-center">
            <section>
                <?php
                if ($success) {
                    echo "<h4>Your registration successful!</h4>";
                    echo "<p>Thank you for signing up </p>";
                    echo "<p>You will be redirected in 5 secs </p>";
                    echo"<div><a href ='login.php' class='btn btn-success'>Click here to login</a></div>";
                    header("refresh:5;url=http://35.187.229.58/project/login.php");
                } else {
                    echo '<h3>OOPS!</h3>';
                    echo "<h4>The following input errors were detected:</h4>";
                    echo "<p>" . $errorMsg . "</p>";
                    echo"<a href ='register.php' class= 'btn btn-danger pb-3'>Return to Sign-up</a>";
                }
                ?>
            </section>
        </main>
    </body>
    <?php
    include 'footer.inc.php';
    ?>
</html>