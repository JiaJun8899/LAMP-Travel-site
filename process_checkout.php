<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

$fname = $lname = $number = $email = "";
$ccname = $ccnum = $ccexp = $cccvc = $savecard = $today = $errorMsg = "";
$success = true;
$memberid = $_SESSION['mid'];
$secretKey = "secret";
$totalamt = $_POST["totalamt"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["firstName"])) {
        $fname = sanitize_input($_POST["firstName"]);
    }
    if (empty($_POST["lastName"])) {
        $errorMsg .= "Last name is required.<br>";
        $success = false;
    } else {
        $lname = sanitize_input($_POST["lastName"]);
    }
    if (empty($_POST["phoneNo"])) {
        $errorMsg .= "A contact number is required.<br>";
        $success = false;
    } else {
        $number = filter_var($_POST["phoneNo"], FILTER_SANITIZE_NUMBER_INT);
        if (!validate_mobile($number)) {
            $errorMsg .= "A valid contact number is required.<br>";
            $success = false;
        }
    }
    if (empty($_POST["email"])) {
        $errorMsg .= "Email is required.<br>";
        $success = false;
    } else {
        $email = sanitize_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMsg .= "Invalid email format.<br>";
            $success = false;
        }
    }

//    if (isset($_POST['savecard'])) {
    if (!isset($_POST['card'])) {
        if (empty($_POST["ccname"])) {
            $errorMsg .= "Name on Card is required.<br>";
            $success = false;
        } else {
            $ccname = sanitize_input($_POST["ccname"]);
        }
        if (empty($_POST["ccnum"])) {
            $errorMsg .= "Credit Card Number is required.<br>";
            $success = false;
        } else {
            $ccnum = preg_replace("([^0-9])", "", $_POST["ccnum"]);
            if (!validatecard($ccnum)) {
                $errorMsg .= "Invalid Credit Card Number. Please use a different card.<br>";
                $success = false;
            }
        }
        if (empty($_POST["ccexp"])) {
            $errorMsg .= "Expiry Date is required.<br>";
            $success = false;
        } else {
            $ccexpS = preg_replace("([^0-9])", "", $_POST["ccexp"]);
            $expire = \DateTime::createFromFormat('mY', $ccexpS);
            $now = new \DateTime();
            if ($expire < $now) {
                $errorMsg .= "This card has Expired. Please use a different card.<br>";
                $success = false;
            }
        }
        if (empty($_POST["cccvc"])) {
            $errorMsg .= "CVC is required.<br>";
            $success = false;
        }
    }
    if (!empty($_POST['card']) && isset($_POST['savecard'])) {
        $errorMsg .= "You already chose a saved card, please uncheck the option to save the card.<br>";
        $success = false;
    }
//    }
    if ($success) {
        $today = date("Y-m-d");
//        echo $today;
        saveTransactionToDB($today, $memberid, $totalamt);
        emailer($_SESSION['user'], $lname);
        if (isset($_POST["savecard"])) {
            saveCCToDB();
        }
    }
} else {
    $_SESSION["errormsg"] = "That webpage is not supposed to be viewed directly!";
    header("Location: http://35.187.229.58/project/index.php");
    exit();
}

//Phone no. validation
function validate_mobile($mobile) {
    return preg_match('/^[0-9]{8}$/', $mobile);
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validatecard($number) {
    global $type;

    $cardtype = array(
        "visa" => "/^4[0-9]{12}(?:[0-9]{3})?$/",
        "mastercard" => "/^5[1-5][0-9]{14}$/",
        "amex" => "/^3[47][0-9]{13}$/",
    );

    if (preg_match($cardtype['visa'], $number)) {
        $type = "visa";
        return 'visa';
    } else if (preg_match($cardtype['mastercard'], $number)) {
        $type = "mastercard";
        return 'mastercard';
    } else if (preg_match($cardtype['amex'], $number)) {
        $type = "amex";
        return 'amex';
    } else {
        return false;
    }
}

function encrypt($plainText, $key) {
    $secretKey = md5($key);
    $iv = substr(hash('sha256', "aaaabbbbcccccddddeweee"), 0, 16);
    $encryptedText = openssl_encrypt($plainText, 'AES-128-CBC', $secretKey, OPENSSL_RAW_DATA, $iv);
    return base64_encode($encryptedText);
}

function saveTransactionToDB($today, $memberid, $totalamt) {
    global $errorMsg, $success;
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
        $stmt = $conn->prepare("INSERT INTO transactions (transactiondate, members_mid, amountpaid) VALUES (?, ?, ?)");
// Bind & execute the query statement:
        $stmt->bind_param("sii", $today, $memberid, $totalamt);
        if (!$stmt->execute()) {
//            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $errorMsg = "Transaction Failed. An Error Ocurred, Please Try again later.";
            $success = false;
//        } else {
//            emailer($_SESSION['user'], $lname);
//            if (isset($_POST["savecard"])) {
//                saveCCToDB();
//            }
        }
        $stmt->close();
    }
    $conn->close();
}

function saveCCToDB() {
    global $memberid, $ccname, $ccnum, $ccexpS, $secretKey, $errorMsg, $success;
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
            $config['password'], $config['dbname']);
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        $stmt = $conn->prepare("INSERT INTO creditcard (cardnum, expdate, nameoncard, members_mid) VALUE (?, ?, ?, ?)");
        $stmt->bind_param("sssi", encrypt($ccnum, $secretKey), $ccexpS, $ccname, $memberid);
        if (!$stmt->execute()) {
//            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $errorMsg = "Failed to Save the Card.";
            $success = false;
        }
        $stmt->close();
    }
    $conn->close();
}

function deleteAllfromCart($cart_id) {
    global $errorMsg, $success;
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
            $config['password'], $config['dbname']);
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        $stmt = $conn->prepare("DELETE FROM cart WHERE cartid = ?;");
        $stmt->bind_param("s", $cart_id);
        if (!$stmt->execute()) {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
        }
        $stmt->close();
    }
    $conn->close();
}

function emailer($email, $lname) {
    $message = file_get_contents('emailtemp/index.html');
    $config = parse_ini_file('../../private/smtp-config.ini');
    //Create an instance; passing true enables exceptions
    $mail = new PHPMailer(true);
    //Server settings
    $mail->isSMTP(); //Send using SMTP
    $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
    $mail->SMTPAuth = true; //Enable SMTP authentication
    $mail->Username = $config['username']; //SMTP username
    $mail->Password = $config['password']; //SMTP password
    $mail->Port = 587; //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS 
    try {
        //Recipients
        $mail->setFrom($config['username'], 'allons ICT1004');
        $mail->addAddress($email); //Add a recipient
        $mail->addBCC($config['username']);
        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'Thank you purchasing with us! ' . $lname;
        $mail->msgHTML($message);
        $mail->AltBody = "Testing 123";
        $mail->send();
    } catch (Exception $e) {
        $errorMsg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        $_SESSION["errormsg"] = " Something went wrong, we are working on a fix!";
    }
}
?>

<html lang="en">
    <head>
        <title>Payment Results</title>
        <script defer src="js/scripts.js"></script>
        <?php
        include "header.inc.php";
        ?>
    </head>
    <body>
        <?php
        include 'nav.inc.php';
        ?>
        <main class="container">
            <?php
            if ($success) {
                echo "<h4>Payment successful!</h4>";
                echo "<p>Thank you for purchasing our Tour Packages.</p>";
                //add a clear cart function
                deleteAllfromCart($_SESSION['user']);
            } else {
                echo "<h2>Oops!</h2>";
                echo "<h4>The following input errors were detected:</h4>";
                echo "<p>" . $errorMsg . "</p>";
                echo "<a href='checkout.php' class='btn btn-danger'>Return to Checkout</a>";
            }
            ?>
        </main>
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>
