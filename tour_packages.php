<?php
session_start();
if (isset($_POST['submit'])) {
    $success = true;
    if ($_SESSION['user'] != NULL) {
        $cartid = $_SESSION['user'];
        $price = preg_replace('/[^A-Za-z0-9\-]/', '', $_POST["cprice"]);
        $country = $_POST['ccountry'];
        $date = $_POST['date'];
        $current = date("Y-m-d");
        if($date<$current){
            $success = false;
        }
        $quantity = $_POST['quantity'];
        if($quantity>100 || $quantity<1){
            $success = false;
        }
        $pid = $_POST['package_id'];
//        echo $cartid . ' ' . $price . ' ' . $country . ' ' . $date . ' ' . $pid . ' ' . $quantity;
        if($success){
        cartbd($cartid, $price, $country, $date, $quantity, $pid);
        } else {
            echo "<script>alert('There was an error with some fields!');</script>";
        }
    } else {
        echo "<script>alert('You have to Login first!');</script>";
    }
}

function cartbd($cartid, $price, $country, $date, $quantity, $pid) {
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        $stmt = $conn->prepare("INSERT INTO cart (cartid, price, country, quantity, package_id,date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisiis", $cartid, $price, $country, $quantity, $pid, $date);
        if (!$stmt->execute()) {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
        }
        $stmt->close();
    }
    $conn->close();
    echo $errorMsg;
}
?>
<!doctype html>
<html lang="en" class="package">
    <head>
        <?php
        include 'header.inc.php';
        ?>
        <title>Europe Tour Packages</title>
    </head>
    <body>
        <?php
        include "nav.inc.php";
        ?>
        <main class="container">
            <?php
            // create dynamic tour packages from database
            // read from database
            $config = parse_ini_file('../../private/db-config.ini');
            $conn = new mysqli($config['servername'], $config['username'],
                    $config['password'], $config['dbname']);
            $errorMsg = "";
            // Check connection
            if ($conn->connect_error) {
                $errorMsg = "Connection failed: " . $conn->connect_error;
                $success = false;
            } else {
                // Prepare the statement:
                $stmt = "SELECT * FROM travel.tour_packages";
                $result = $conn->query($stmt);
                // fetch all rows into array
                $array = array();
                $array_count = 0;
                while ($row = $result->fetch_assoc()) {
                    // add rows as array into array
                    $array[$array_count] = array();
                    $array[$array_count]["pid"] = $row["pid"];
                    $array[$array_count]["country"] = $row["country"];
                    $array[$array_count]["city"] = $row["city"];
                    $array[$array_count]["price"] = $row["price"];
                    $array[$array_count]["short_description"] = $row["short_description"];
                    $array[$array_count]["long_description"] = $row["long_description"];
                    $array[$array_count]["image_link"] = $row["image_link"];
                    $array[$array_count]["img"] = $row["img"];
                    $array_count += 1;
                }
                // display tour package header
                echo "<div class=\"p-4 p-md-5 mb-4 text-white rounded bg-dark\">";
                echo "<div class=\"col-md-6 px-0\">";
                echo "<h1 class=\"display-4 fst-italic\">Europe;</h1>";
                echo "<p class=\"lead my-3\">second smallest of the world's continents, composed of the westward-projecting peninsulas of Eurasia (the great landmass that it shares with Asia) and occupying nearly one-fifteenth of the world's total land area.</p>";
                echo "<p class=\"lead mb-0\"><a href=\"#\" class=\"text-white fw-bold\">View our tour packages below!</a></p>";
                echo "</div>";
                echo "</div>";
                // display rows
                $row_count = 0;
                for ($i = 0; $i < count($array); $i++) {
                    $col_count += 1; // new col count
                    $pid = $array[$i]["pid"];
                    $country = $array[$i]["country"];
                    $city = $array[$i]["city"];
                    $price = $array[$i]["price"];
                    $short_description = $array[$i]["short_description"];
                    $long_description = $array[$i]["long_description"];
                    $img = $array[$i]["img"];
                    // create html card
                    if ($col_count == 1) { // if first column, open row
                        echo "<div class=\"row mb-2\">";
                    }
                    echo "<div class=\"col-md-6\">";
                    echo "<div class=\"row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative\">";
                    echo "<div class=\"col p-4 d-flex flex-column position-static\">";
                    echo "<strong class=\"d-inline-block mb-2 text-success country\">" . $country . "</strong>";
                    echo "<h3 class=\"mb-0 city\">" . $city . "</h3>";
                    echo "<div class=\"mb-1 text-muted price\">$" . $price . "</div>";
                    echo "<p class=\"card-text mb-auto short-description\">" . $short_description . "</p>";
                    echo "<p class=\"long-description\">" . $long_description . "</p>";
                    echo "<p class=\"image-link\">data:image/jpeg;base64," . base64_encode($img) . "</p>";
                    echo "<button id=\"" . $pid . "\" onclick=\"popUp(this)\" type=\"button\" class=\"stretched-link button-link\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\">View Details</button>";
                    echo "</div>";
                    echo "<div class=\"col-auto d-none d-lg-block\">";
                    echo "<svg class=\"bd-placeholder-img\" width=\"200\" height=\"250\" role=\"img\" aria-label=\"" . $country . "\" preserveAspectRatio=\"xMidYMid slice\" focusable=\"false\">";
                    echo "<image class=\"thumbnail\" width=\"500px\" height=\"250px\" href=\"data:image/jpeg;base64," . base64_encode($img) . "\"/>";
                    echo "</svg>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    // if second column, close row
                    if ($col_count == 2 || $i == (count($array) - 1)) {
                        echo "</div>";
                        $col_count = 0;
                    }
                }
                //$stmt->close();
            }
            $conn->close();
            ?>
            <!--dynamic pop up, content changes based on what was clicked-->
            <div class="modal fade bd-example-modal-xl" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content" id="popup-content">
                        <div class="modal-header">
                            <h4 class="modal-title popup-country" id="popup-country">Country</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="tour_packages.php" method="post" id="package-form">
                            <div class="modal-body row">
                                <div class="col col-xl-9">
                                    <h5 id="popup-city">City<br></h5>
                                    <input type="hidden" id="ccountry" name="ccountry" value="0">
                                    <img class="popup-thumbnail" id="popup-thumbnail" src="images/" alt="popup_image"/>
                                    <br>
                                    <p id="popup-long-description">Description Here</p>
                                </div>
                                <!--Calendar-->
                                <div class="col col-xl-3 form-group">
                                    <h5 id="popup-price">$</h5>
                                    <input type="hidden" id="cprice" name="cprice" value="">
                                    <br>
                                    <label for="date">Start Date: </label>
                                    <input type="date" id="date" name="date" required> <!--might not work for safari-->
                                    <!-- Quantity -->
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button type="button" onclick="quantity_change(0)" class="quantity-left-minus btn btn-danger btn-number"  data-type="minus" data-field="">
                                                -
                                            </button>
                                        </span>
                                        <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" readonly="readonly" aria-label="quantity">
                                        <span class="input-group-btn">
                                            <button type="button" onclick="quantity_change(1)" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
                                                +
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer form-group">
                                <input type="hidden" id="package_id" name="package_id" value="0">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <input type="submit" name="submit" value="Add to Cart" class="btn btn-primary cartButton">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>
