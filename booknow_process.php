<?php
$fname = $lname = $number = $countrycode = $country = $email = "";
$ccname = $ccnum = $ccexp = $cccvc = $savecard = $today = $errorMsg = "";
$success = true;
$memberid = 27;
$secretKey = "secret";

//$fname = $_POST["firstName"];
//$lname = $_POST["lastName"];
//$number = $_POST["countrycode"] . $_POST["phoneNo"];
//$countrycode = ;
//$country = $_POST["country"];
//$email = $_POST["email"];
//$ccname = $_POST["ccname"];
//$ccnum = $_POST["ccnum"];
//$ccexp = $_POST["ccexp"];
//$cccvc = $_POST["cccvc"];
//$savecard = $_POST["savecard"];
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
//    $number = sanitize_input($number);
    }
//if (empty($_POST["country"])) {
//    $errorMsg .= "Country is required.<br>";
//    $success = false;
//} else {
//    $country = sanitize_input($_POST["country"]);
//}
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
//        } else {
//            echo '<p> Card type: ' . validatecard($ccnum) . '</p>';
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
//            echo '<br><p>CARD EXPIRED</P>';
            $errorMsg .= "This card has Expired. Please use a different card.<br>";
            $success = false;
//        } else {
//            echo '<br><p>CARD VALID - ' . $ccexpS . '</p>';
        }
//    $ccexp = preg_replace("([^0-9/])", "", $_POST["ccexp"]);
        //$ccexp = preg_replace("([^0-9])", "", $_POST["ccexp"]);
    }
    if (empty($_POST["cccvc"])) {
        $errorMsg .= "CVC is required.<br>";
        $success = false;
    }
    if ($success) {
        $today = date("Y-m-d");
        echo $today;
        saveTransactionToDB();
        if ($_POST["savecard"]) {
            saveCCToDB();
        }
    }
} else {
    echo "<h2> This page is not meant to be run directly.</h2>";
    echo "<p> You can proceed to check out from the Cart or Choose to continue browsing our Tour Packages.</p>";
    echo "<a href = 'shoppingcart.php'> Shopping Cart </a><br>";
    echo "<a href = 'tour_packages.php'> Tour Packages </a>";
    exit();
}


//Phone no. validation
function validate_mobile($mobile) {
    return preg_match('/^[0-9]{10}$/', $mobile);
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

function encrypt($plainText, $key) {
    $secretKey = md5($key);
    $iv = substr(hash('sha256', "aaaabbbbcccccddddeweee"), 0, 16);
    $encryptedText = openssl_encrypt($plainText, 'AES-128-CBC', $secretKey, OPENSSL_RAW_DATA, $iv);
    return base64_encode($encryptedText);
}

function saveTransactionToDB() {
    global $today, $memberid, $totalamt, $errorMsgSaveDB, $success;
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
        $stmt = $conn->prepare("INSERT INTO transactions (transactiondate, "
                . " members_mid, amountpaid) VALUES (?, ?, ?)");
// Bind & execute the query statement:
        $stmt->bind_param("sii", $today, $memberid, $totalamt);
        if (!$stmt->execute()) {
            //this des not work right now!!
//            if(($stmt->errno) == 1062){
//                $errorMsg = "Execute failed: (" . $stmt->errno . ") " . "This card is alredy saved";
//                $success = false;
//            }else{
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
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

//        ECHO "test TEHE";
        if (!$stmt->execute()) {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
        }
        $stmt->close();
    }
    $conn->close();
}

function deleteAllfromCart() {
    global $memberid, $errorMsg, $success;
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
            $config['password'], $config['dbname']);
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        $stmt = $conn->prepare("DELETE FROM cart_has_tour_packages WHERE cart_cartid=(SELECT cart_cartid FROM members WHERE mid = ?);");
        $stmt->bind_param("i", $memberid);
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
    <head>
        <title>Payment Results</title>
        
        <link rel="stylesheet" href="main.css" />
        <link rel="stylesheet"
              href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
              integrity=
              "sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
              crossorigin="anonymous">
        <!-- CSS has to be After the BootStrap -->
        <link rel="stylesheet" href="cssmain.css"/>
        <!--jQuery *Bootstrap JS uses jQuery functions so jQuery must be above Bootstrap JS--> 
        <script defer
                src="https://code.jquery.com/jquery-3.4.1.min.js"
                integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
                crossorigin="anonymous">
        </script>
        <!--Bootstrap JS-->
        <script defer
                src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"
                integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"
                crossorigin="anonymous">
        </script>
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/3.0.0/jquery.payment.min.js"></script>
        <!-- Custom JS -->
        <script defer src="scripts.js"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php
//        include "header.php";
        ?>
    </head>
    <body>
        <?php
        //checking values passed through form.
        //echo '<p>First Name: ' . $fname . "</p><br><p>Last Name: " . $lname . "</p><br><p>Phone No.: " . $number . "</p><br>";
        //echo '<p>Country: ' . $country . "</p><br><p>Email: " . $email . "</p><br><p>CC-Name: " . $ccname . "</p><br>";
        //echo '<p>CC-Num: ' . $ccnum . "</p><br><p>CC-Exp: " . $ccexpS . "</p><br><p>Save Card: " . $_POST["savecard"] . "</p><br>";
        //echo '<p>total: '. $_POST["totalamt"].'<br><p>Success?: ' . $success . '</p>';
        ?>
        <!--<hr>-->
        <main class="container">
            <?php
            if ($success) {
                echo "<h4>Payment successful!</h4>";
                echo "<p>Thank you for purchasing our Tour Packages.</p>";
                //add a clear cart function
                deleteAllfromCart();
            } else {
                echo "<h2>Oops!</h2>";
                echo "<h4>The following input errors were detected:</h4>";
                echo "<p>" . $errorMsg . "</p>";
                echo "<a href='booknowform.php' class='btn btn-danger'>Return to Checkout</a>";
            }
            ?>
        </main>
        <?php
//        include "footer.php";
        ?>
    </body>
</html>
