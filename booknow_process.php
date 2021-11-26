<?php
$fname = $lname = $number = $countrycode = $country = $email = "";
$ccname = $ccnum = $ccexp = $cccvc = $savecard = $today = $errorMsg = "";
$success = true;
$memberid = 1;

//$fname = $_POST["firstName"];
//$lname = $_POST["lastName"];
$number = $_POST["countrycode"] . $_POST["phoneNo"];
//$countrycode = ;
//$country = $_POST["country"];
//$email = $_POST["email"];
//$ccname = $_POST["ccname"];
//$ccnum = $_POST["ccnum"];
//$ccexp = $_POST["ccexp"];
//$cccvc = $_POST["cccvc"];
//$savecard = $_POST["savecard"];

if (!empty($_POST["firstName"])) {
    $fname = sanitize_input($_POST["firstName"]);
}
if (empty($_POST["lastName"])) {
    $errorMsg .= "Last name is required.<br>";
    $success = false;
} else {
    $lname = sanitize_input($_POST["lastName"]);
}
if (empty($number)) {
    $errorMsg .= "A contact number is required.<br>";
    $success = false;
} else {
    $number = filter_var($number, FILTER_SANITIZE_NUMBER_INT);
    if (!validate_mobile($number)) {
        $errorMsg .= "A valid contact number is required.<br>";
        $success = false;
    }
//    $number = sanitize_input($number);
}
if (empty($_POST["country"])) {
    $errorMsg .= "Country is required.<br>";
    $success = false;
} else {
    $country = sanitize_input($_POST["country"]);
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
//    $ccnum = sanitize_input($_POST["ccnum"]);
    $ccnum = preg_replace("([^0-9])", "", $_POST["ccnum"]);
    if (!validatecard($ccnum)) {
        $errorMsg .= "Invalid Credit Card Number. Please use a different card.<br>";
        $success = false;
    } else {
        echo '<p> Card type: ' . validatecard($ccnum) . '</p>';
    }
}
if (empty($_POST["ccexp"])) {
    $errorMsg .= "Expiry Date is required.<br>";
    $success = false;
} else {
//    $ccexp = sanitize_input($ccexp);
    $ccexpS = preg_replace("([^0-9])", "", $_POST["ccexp"]);
    //        $ccexpS = $_POST["ccexp"];
    $expire = \DateTime::createFromFormat('mY', $ccexpS);
    $now = new \DateTime();
    if ($expire < $now) {
        echo '<br><p>CARD EXPIRED</P>';
        $errorMsg .= "This card has Expired. Please use a different card.<br>";
        $success = false;
    } else {
        echo '<br><p>CARD VALID - ' . $ccexpS . '</p>';
    }
//    $ccexp = preg_replace("([^0-9/])", "", $_POST["ccexp"]);
    //$ccexp = preg_replace("([^0-9])", "", $_POST["ccexp"]);
}
if (empty($_POST["cccvc"])) {
    $errorMsg .= "CVC is required.<br>";
    $success = false;
}
if($success){
//    ECHO "WHAT ABOUT HERE";
    $today = date("Y-m-d");
    echo $today;
    saveTransactionToDB();
    if($_POST["savecard"]){
        //yada yada
        ECHO "IN SAVE CARD HERE";
        saveCCToDB();
    }
} else {
//    echo 'ERROR!! AT SAVE TO DB';
}

function validate_mobile($mobile) {
    return preg_match('/^[+][0-9]{10}$/', $mobile);
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
//        "discover"   => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
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
    }
//    else if (preg_match($cardtype['discover'],$number))
//    {
//	$type= "discover";
//        return 'discover';
//    }
    else {
        return false;
    }
}

function saveTransactionToDB() {
    global $today, $memberid, $errorMsg, $success;
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
            $config['password'], $config['dbname']);
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        $stmt = $conn->prepare("INSERT INTO transactions (transactiondate, "
            . "tour_packages_pid, members_mid, amountpaid, "
            . "tour_packages_pid1) VALUES (?, 1, ?, 20, 1)");
        ECHO "LAST ONE :)";
        $stmt->bind_param("si", $today, $memberid);
        
        if (!$stmt->execute()) {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
        }
        $stmt->close();
    }
    $conn->close();
}

function saveCCToDB() {
    global $memberid, $ccname, $ccnum, $ccexpS, $errorMsg, $success;
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
            $config['password'], $config['dbname']);
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        $stmt = $conn->prepare("INSERT INTO creditcard (cardnum, expdate, nameoncard, members_mid) VALUE (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $ccnum, $ccexpS, $ccname, $memberid);
        
        if (!$stmt->execute()) {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<html>
    <body>
<?php
echo '<p>First Name: ' . $fname . "</p><br><p>Last Name: " . $lname . "</p><br><p>Phone No.: " . $number . "</p><br>";
echo '<p>Country: ' . $country . "</p><br><p>Email: " . $email . "</p><br><p>CC-Name: " . $ccname . "</p><br>";
echo '<p>CC-Num: ' . $ccnum . "</p><br><p>CC-Exp: " . $ccexpS . "</p><br><p>Save Card: " . $_POST["savecard"] . "</p><br>";
echo '<p>Success?: ' . $success . '</p>';
?>
        <hr>
<?php
if ($success) {
    echo "<h4>Payment successful!</h4>";
    echo "<h4>Thank you for signing up, " . $fname . "" . $lname . ".</h4>";
//                echo "<p>Last Name: " .$_POST["lname"]. ".</p>";
    echo "<a href='#' class='btn btn-success'>Log-in</a>";
} else {
    echo "<h2>Oops!</h2>";
    echo "<h4>The following input errors were detected:</h4>";
    echo "<p>" . $errorMsg . "</p>";
    echo "<a href='booknowform.php' class='btn btn-danger'>Return to Checkout</a>";
}
?>
    </body>
</html>
