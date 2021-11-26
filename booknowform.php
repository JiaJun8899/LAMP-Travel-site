<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
$memberid = $cardnum = $expdate = $nameCard = $errMsg = $resultsArray ="";
$success = true;
$memberid = 1;

getCards();
$cardnum = MaskCreditCard($cardnum);

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

function getCards() {
    global $memberid, $errMsg, $success, $resultsArray;

    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
            $config['password'], "travel"); //$config['dbname']
    if ($conn->connect_error) {
        $errMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        $stmt = $conn->prepare("SELECT * FROM creditcard WHERE members_mid=?");
        $stmt->bind_param("i", $memberid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_all();
            $resultsArray = $row;
        } else {
            $errMsg = "No Saved Cards";
            $success = false;
        }$stmt->close();
    }
    $conn->close();
}

function getCardDetails($choosenCard) {
    global $memberid, $cardnum, $expdate, $nameCard, $errMsg, $success;

    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
            $config['password'], "travel"); //$config['dbname']
    if ($conn->connect_error) {
        $errMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        $stmt = $conn->prepare("SELECT * FROM creditcard WHERE members_mid=? AND cardnum=?");
        $stmt->bind_param("is", $memberid, $choosenCard);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $cardnum = $row["cardnum"];
            $expdate = $row["expdate"];
            $nameCard = $row["nameoncard"];
        } else {
            $errMsg = "Card Not Found";
            $success = false;
        }$stmt->close();
    }
    $conn->close();
}
?>

<html>
    <head>
        <title>CHECKOUT</title>
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
    </head>
    <body>
        <!--        <div class="padding">
            <div class="row">
                <div class="container-fluid d-flex justify-content-center">
                    <div class="col-sm-8 col-md-6">
                        <div class="card">
                            <form>
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6"> <span>CREDIT/DEBIT CARD PAYMENT</span> </div>
                                    <div class="col-md-6 text-right" style="margin-top: -5px;"> <img src="https://img.icons8.com/color/36/000000/visa.png"> <img src="https://img.icons8.com/color/36/000000/mastercard.png"> <img src="https://img.icons8.com/color/36/000000/amex.png"> </div>
                                </div>
                            </div>
                            <div class="card-body" style="height: 350px">
                                <div class="form-group"> <label for="cc-number" class="control-label">CARD NUMBER</label> <input id="cc-number" type="tel" class="input-lg form-control cc-number" autocomplete="cc-number" placeholder="•••• •••• •••• ••••" required> </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="cc-exp" class="control-label">CARD EXPIRY</label> <input id="cc-exp" type="tel" class="input-lg form-control cc-exp" autocomplete="cc-exp" placeholder="•• / ••" required> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="cc-cvc" class="control-label">CARD CVC</label> <input id="cc-cvc" type="tel" class="input-lg form-control cc-cvc" autocomplete="off" placeholder="••••" required> </div>
                                    </div>
                                </div>
                                <div class="form-group"> <label for="numeric" class="control-label">CARD HOLDER NAME</label> <input type="text" class="input-lg form-control"> </div>
                                <div class="form-group"> <input value="MAKE PAYMENT" type="submit" class="btn btn-success btn-lg form-control" style="font-size: .8rem;"> </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
        <div class="container">
            <div class="row">
                <div class="col-md-4 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Your cart</span>
<!--                        <span class="badge badge-secondary badge-pill">3</span>-->
                    </h4>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">Product name</h6>
                                <small class="text-muted">Brief description</small>
                            </div>
                            <span class="text-muted">$12</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">Second product</h6>
                                <small class="text-muted">Brief description</small>
                            </div>
                            <span class="text-muted">$8</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">Third item</h6>
                                <small class="text-muted">Brief description</small>
                            </div>
                            <span class="text-muted">$5</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (USD)</span>
                            <strong>$20</strong>
                        </li>
                    </ul>
                </div>
                <div class="col-md-8 order-md-1">
                    <h4 class="mb-3">Contact Information</h4>
                    <form class="needs-validation" id="checkoutform" action="booknow_process.php" method="POST" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName">First name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="" required>
                                <div class="invalid-feedback">
                                    Valid first name is required.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName">Last name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="" required>
                                <div class="invalid-feedback">
                                    Valid last name is required.
                                </div>
                            </div>
                        </div>
                        <label for="phoneNo">Phone Number: </label>
                        <div class="row">
                            <div class="form-group col-md-4 mb-2">
                                <select class="custom-select" name="countrycode" id="countrycode">
                                    <option value="+44">England (+44)</option>
                                    <option value="+33">France (+33)</option>
                                    <option value="+39">Italy (+39)</option>
                                    <option value="+31">Netherland (+31)</option>
                                </select>
                            </div>
                            <div class="form-group col-md-8 mb-4">
                                <input class="form-control" type="number" id="phoneNo" name="phoneNo" required>  <!--pattern="\+65[6|8|9]\d{7}"-->
                                <div class="invalid-feedback" style="width: 100%;">
                                    Your phone number is required.
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="country">Country: </label>
                            <select class="custom-select" id="country" name="country">
                                <option value="england">England</option>
                                <option value="france">France</option>
                                <option value="italy">Italy</option>
                                <option value="netherland">Netherland</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
                            <div class="invalid-feedback">
                                Please enter a valid email address.
                            </div>
                        </div>
                        <hr class="mb-4">
                        <h4 class="mb-3">Payment</h4>
                        <h5>Saved Cards</h5>
                        <!--' onclick='displayRadioValue()' for JS ONCLICK RADIO BUTTON-->
                        <?php
                        if ($success) {
                            echo "RESULT ARRAY: " . count($resultsArray) . "<br>";
                            foreach ($resultsArray as $values) {
//                            foreach ($values as $val => $card){
//                                echo "$val = $card<br>";
                                echo "
                            <input type='radio' id='card' name='card' value='" . $values[1].">
                            <label for='html'>".MaskCreditCard($values[1])."</label><br>";
                            }
//                        }
//            }
                        } else {
                            echo "<h2>Oops!</h2>";
                            echo "<p>" . $errorMsg . "</p>";
                        }
                        ?>
<!--                        <button type="button" onclick="displayRadioValue()">
                            Choose Card
                        </button>-->
                        
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
                                <!--                                <div class="validation">
                                                                    Error!
                                                                </div>-->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="ccexp">Expiration</label>
                                <input type="text" class="form-control ccexp" id="ccexp" name="ccexp" placeholder="•• / ••" required value=>
                                <div class="invalid-feedback">
                                    Expiration date required
                                </div>
                                <!--                                <div class="validation">
                                                                    Error!
                                                                </div>-->
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="cccvc">CVV</label>
                                <input type="text" class="form-control cccvc" id="cccvc" name="cccvc" placeholder="•••" required>
                                <div class="invalid-feedback">
                                    Security code required
                                </div>
                                <!--                                <div class="validation">
                                                                    Error!
                                                                </div>-->
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="ccbrand">Card Type</label>
                                <p class="ccbrand" id="ccbrand">
                                    <!--                                <div class="invalid-feedback">
                                                                        Security code required
                                                                    </div>-->
                            </div>
                        </div>
                        <div class="form-group form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="savecard">Save this card
                            </label>
                        </div>
<!--                        <input type="checkbox" class="form-check" id="saveinfo" name="saveinfo" required>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="saveinfo" name="saveinfo">
                            <label class="custom-control-label" for="save-info">Save this card</label>
                        </div>-->
                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block" id="submitBtn" type="submit">Continue to checkout</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
