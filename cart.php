<?php
session_start();
if($_SESSION['user']==NULL){
    $_SESSION["errormsg"] = "You need to login first!";
    header("Location: http://35.187.229.58/project/index.php");
    exit();
}
if (isset($_POST['update'])) {
    $cid = (int) $_POST['cid'];
    $quan = (int) $_POST['quantity'];
    if ($quan == 0) {
        delitem($cid);
    } else {
        updateitem($quan, $cid);
    }
}

$cart_id = $_SESSION['user'];
$cartitem = array();
$cartimg = array();
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
    $count = 0;
    $stmt = $conn->prepare("SELECT pid,img FROM tour_packages");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $pkid = $row["pid"];
        $cartimg[$pkid]['img'] = $row["img"];
    }
    $stmt->close();
}
$conn->close();

function delitem($cid) {
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        $stmt = $conn->prepare("DELETE FROM cart WHERE cid=?");
        $stmt->bind_param("i", $cid);
        if (!$stmt->execute()) {
            $errorMsg = "Connection failed: " . $conn->connect_error;
        }
        $stmt->close();
    }
    $conn->close();
    echo $errorMsg;
}

function updateitem($quan, $cid) {
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        $stmt = $conn->prepare("UPDATE cart SET quantity=? WHERE cid=?");
        $stmt->bind_param("ii", $quan, $cid);
        if (!$stmt->execute()) {
            $errorMsg = "Connection failed: " . $conn->connect_error;
        }
        $stmt->close();
    }
    $conn->close();
    echo $errorMsg;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include 'header.inc.php';
        ?>
        <title>My Cart</title>
    </head>
    <body>
        <?php
        include "nav.inc.php";
        ?>
        <header>
            <div class="jumbotron color-grey-light mt-70">
                <div class="d-flex align-items-center h-100">
                    <div class="container text-center py-5">
                        <h3 class="mb-0">Shopping cart</h3>
                    </div>
                </div>
            </div>
        </header>
        <!--Main layout-->
        <main>
            <div class="container">
                <h4>CART ITEMS</h4>
                <section>
                    <!--Grid row-->
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Card -->
                            <div class="mb-3">
                                <div class="pt-4 wish-list">
                                    <?php
                                    echo '<h5 class="mb-4">Your cart has ' . count($cartitem) . ' items</h5>';
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
                                        echo '<div class="row mb-4">';
                                        echo '<div class="col-md-5 col-lg-3 col-xl-3">';
                                        echo '<img class="img-fluid w-100" alt="' . $country . '" src="data:image/jpeg;base64,' . base64_encode($src) . '"/>';
                                        echo '</div>';
                                        echo '<div class="col-md-7 col-lg-9 col-xl-9">';
                                        echo '<div>';
                                        echo '<div class="d-flex justify-content-between">';
                                        echo '<div>';
                                        echo '<h5>' . $country . '</h5>';
                                        echo '<p>Date: ' . $date . '</p>';
                                        echo '<h6 class="cart-amount">Total: ' . (int) $price * (int) $quantity . '</h6>';
                                        echo '</div>';
                                        echo '<div>';
                                        echo '<form action="cart.php" method="post">';
                                        echo '<input class="quantity" min="0" name="quantity" type="number" value="' . $quantity . '" >';
                                        echo '<input type="hidden" name="cid" value="' . $cid . '">';
                                        echo '<br><button type="submit" class="btn btn-danger.mx-2" name="update">Update</button>';
                                        echo '</form>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '<div class="d-flex justify-content-between align-items-center"></div>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '<hr class = "mb-4">';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- Sub Total card -->
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <div class="pt-4">
                                    <h5 class="mb-3">The total amount </h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                            Total payable:
                                            <?php
                                            echo '<span id ="subtotal">$' . $total . '</span>';
                                            ?>
                                        </li>
                                    </ul>
                                    <a href="checkout.php" class="btn btn-primary btn-block my-3">Check Out</a>             
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>
