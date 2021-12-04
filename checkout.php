<?php
session_start();
$memberid = $fname = $lname = $phone = $email = $errMsg = "";
$successD = true;
$current_user = $_SESSION['user'];
$secretKey = "secret";
getUserDetails($current_user);
getCartItems($current_user);
getCards($memberid);
$_SESSION['mid'] = $memberid;
$_SESSION['cart'] = $cartitem;
$testcart = $_SESSION['cart'];

function getCards($memberid) {
    global $errMsg, $success, $cardArray;
    $count = 0;
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
            $config['password'], $config['dbname']); //$config['dbname']
    if ($conn->connect_error) {
        $errMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        $stmt = $conn->prepare("SELECT * FROM creditcard WHERE members_mid=?");
        $stmt->bind_param("i", $memberid);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $cardArray[$count] = array();
            $cardArray[$count]["cardnum"] = $row["cardnum"];
            $cardArray[$count]["expiry"] = $row["expdate"];
            $cardArray[$count]["nameoncard"] = $row["nameoncard"];
            $count += 1;
        }
        $stmt->close();
    }
    $conn->close();
}

function MaskCreditCard($cc) {
    $cc = str_replace(array('-', ' '), '', $cc);
    // Get the CC Length
    $cc_length = strlen($cc);
    // Initialize the new credit card to contain the last four digits
    $newCreditCard = substr($cc, -4);
    // Walk backwards through the credit card number and add a dash after every fourth digit
    for ($i = $cc_length - 5; $i >= 0; $i--) {
        // If on the fourth character add a dash
        if ((($i + 1) - $cc_length) % 4 == 0) {
            $newCreditCard = ' ' . $newCreditCard;
        }
        // Add the current character to the new credit card
        $newCreditCard = $cc[$i] . $newCreditCard;
    }
    // Get the cc Length
    $cc_length = strlen($newCreditCard);
    // Replace all characters of credit card except the last four and dashes
    for ($i = 0; $i < $cc_length - 4; $i++) {
        if ($newCreditCard[$i] == ' ') {
            continue;
        }
        $newCreditCard[$i] = 'X';
    }
    // Return the masked Credit Card #
    return $newCreditCard;
}

function decrypt($encryptedText, $key) {
    $key = md5($key);
    $iv = substr(hash('sha256', "aaaabbbbcccccddddeweee"), 0, 16);
    $decryptedText = openssl_decrypt(base64_decode($encryptedText), 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return $decryptedText;
}

function getUserDetails($current_user) {
    global $memberid, $fname, $lname, $phone, $email, $errMsg, $successD;
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
            $config['password'], $config['dbname']); //$config['dbname']
    if ($conn->connect_error) {
        $errMsg = "Connection failed: " . $conn->connect_error;
        $successD = false;
    } else {
// Prepare the statement:
        $stmt = $conn->prepare("SELECT * FROM members WHERE email=?");
// Bind & execute the query statement:
        $stmt->bind_param("s", $current_user);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $fname = $row["fname"];
            $lname = $row["lname"];
            $phone = $row["phoneno"];
            $email = $row["email"];
            $memberid = $row["mid"];
        } else {
            $errMsg = "User Not Found";
            $successD = false;
        }$stmt->close();
    }
    $conn->close();
}

function getCartItems($cart_id) {
    global $cartitem;
    $count = 0;
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        $stmt = $conn->prepare("SELECT * FROM cart WHERE cartid =?");
        $stmt->bind_param("s", $cart_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            // add rows as array into array
            $cartitem[$count] = array();
            $cartitem[$count]["package_id"] = $row["package_id"];
            $cartitem[$count]["price"] = $row["price"];
            $cartitem[$count]["country"] = $row["country"];
            $cartitem[$count]["quantity"] = $row["quantity"];
            $cartitem[$count]["date"] = $row["date"];
            $cartitem[$count]["cid"] = $row["cid"];
            $count += 1;
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include 'header.inc.php';
        ?>
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/3.0.0/jquery.payment.min.js"></script>
        <script defer src="js/scripts.js"></script>
        <title>CHECKOUT</title>
    </head>
    <body>
        <?php
        include 'nav.inc.php';
        ?>
        <main class="container">
            <div class="row">
                <div class="col-md-4 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <br>
                        <span>Your Cart</span> <!--class="text-muted"-->
                    </h4>

                    <ul class="list-group mb-3">
                        <?php
                        $total = 0;
                        for ($i = 0; $i < count($cartitem); $i++) {
                            $price = $cartitem[$i]["price"];
                            $country = $cartitem[$i]["country"];
                            $quantity = $cartitem[$i]["quantity"];
                            $date = $cartitem[$i]["date"];
                            $cid = $cartitem[$i]["cid"];
                            $pid = $cartitem[$i]["package_id"];
                            $src = $cartimg[$pid]['img'];
                            $total = ($quantity * $price) + $total;
                            echo '<li class="list-group-item d-flex justify-content-between lh-condensed">';
                            echo '<div>';
                            echo '<h5 class="my-0">' . $country . '</h6>';
                            echo '<small class="text-muted">Quantity: ' . $quantity . '</small>';
                            echo '</div>';
                            echo '<span class="text-muted">$' . $price * $quantity . '</span>';
                            echo '</li>';
                        }
                        ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total</span>
                            <strong>$<?php echo $total; ?></strong>
                        </li>
                    </ul>
                </div>
                <div class="col-md-8 order-md-1">
                    <h4 class="mb-3">Contact Information</h4>
                    <form class="needs-validation" id="checkoutform" action="process_checkout.php" method="POST" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName">First name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $fname; ?>" required>
                                <div class="invalid-feedback">
                                    Valid first name is required.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName">Last name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $lname; ?>" required>
                                <div class="invalid-feedback">
                                    Valid last name is required.
                                </div>
                            </div>
                        </div>
                        <label for="phoneNo">Phone Number: </label>
                        <div class="row">
                            <div class="form-group col-md-8 mb-4">
                                <input class="form-control" type="number" id="phoneNo" name="phoneNo" value="<?php echo $phone; ?>" required>  <!--pattern="\+65[6|8|9]\d{7}"-->
                                <div class="invalid-feedback" style="width: 100%;">
                                    Your phone number is required.
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" value="<?php echo $email; ?>" required>
                            <div class="invalid-feedback">
                                Please enter a valid email address.
                            </div>
                        </div>
                        <hr class="mb-4">
                        <div class="mb-3">
                        <h4>Payment</h4>
                        <small>We accept Visa, Master and Amex.</small>
                        </div>
                        <p>Saved Cards</p>
                        <?php
                        for ($i = 0; $i < count($cardArray); $i++) {
                            $cardnum = $cardArray[$i]["cardnum"];
                            $expire = $cardArray[$i]["expiry"];
                            $cardname = $cardArray[$i]["nameoncard"];
                            $actual = decrypt($cardnum, $secretKey);
                            echo "<input type='radio' onclick='displayRadioValue()'"
                            . " name='card' value='" . MaskCreditCard($actual) . "," . $expire . "," . $cardname . "'><label for='html'> "
                            . MaskCreditCard($actual) . "</label><br>";
                        }
                        ?>
                        <button type="button" name="clearRadio" class="btn btn-primary"id="clearRadio" onclick="clearRadioinfo()">Clear Card Info</button>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ccname">Name on card</label>
                                <input type="text" class="form-control" id="ccname" name="ccname" placeholder="" required>
                                <small class="text-muted">Full name as displayed on card</small>
                                <div class="invalid-feedback">
                                    Name on card is required
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ccnum">Credit card number</label>
                                <input type="text" class="form-control ccnum" id="ccnum" name="ccnum" placeholder="•••• •••• •••• ••••" required>
                                <div class="invalid-feedback">
                                    Credit card number is required
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="ccexp">Expiration</label>
                                <input type="text" class="form-control ccexp" id="ccexp" name="ccexp" placeholder="•• / ••" required value="">
                                <div class="invalid-feedback">
                                    Expiration date required
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="cccvc">CVV</label>
                                <input type="text" class="form-control cccvc" id="cccvc" name="cccvc" placeholder="•••" required>
                                <div class="invalid-feedback">
                                    Security code required
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <!--<label for="ccbrand">Card Type</label>-->
                                <input type="hidden" id="totalamt" name="totalamt" value="<?php echo $total; ?>">
                            </div>
                        </div>
                        <div class="form-group form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="savecard" value="save">Save this card
                            </label>
                        </div>
                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block mb-4" id="submitBtn" type="submit">Continue to checkout</button>
                    </form>
                </div>
            </div>
        </main>
        <?php
        include 'footer.inc.php';
        ?>
    </body>
</html>
