<?php

// session_start();

if (isset($_POST["date"]))
{
    $errorMsg = "";
    
    // check if logged in
    //if ($_SESSION["user"] == NULL)
    {
        // if not logged in, go to login page
        
    }
    //else
    {
        // else
        // get selected date
        $date = $_POST["date"];
        echo "<script>console.log(\"date: " . $date . "\");</script>";
        $pid = $_POST["package_id"];
        echo "<script>console.log(\"pid: " . $pid . "\");</script>";
        $add_quantity = $_POST["quantity"];
        echo "<script>console.log(\"quantity: " . $quantity . "\");</script>";

        // insert into database
        $mid = 19; // to get from logged in user
        $cart_id = 0;

        // Create database connection.
        $config = parse_ini_file('../../private/db-config.ini');
        $conn = new mysqli($config['servername'], $config['username'],
        $config['password'], $config['dbname']);

        // from member table, get member's cart id + mid
        // Prepare the statement
        $stmt = $conn->prepare("SELECT cart_cartid FROM travel.members WHERE mid=?"); // modify to get member id + cart id from logged in email
        // Bind & execute the query statement:
        $stmt->bind_param("i", $mid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $cart_id = $row["cart_cartid"];
            echo "<script>console.log(\"member: ". $mid . ": cartid " . $cart_id . "\");</script>";
        }
        else
        {
            $errorMsg .= "Member not found...";
            $success = false;
        }
        $stmt->close();

        // from cart, find if cart id and add 1 to quantity
        $stmt = $conn->prepare("SELECT cartid FROM travel.cart WHERE cartid=?");
        // Bind & execute the query statement:
        $stmt->bind_param("i", $cart_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows <= 0)
        {
            echo "<script>console.log(\"created new cart\");</script>";
            // cart does not exist, create cart in cart table
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO travel.cart cartid VALUES ?");
            // Bind & execute the query statement:
            $default_amt = 0;
            $stmt->bind_param("i", $cart_id);
            if (!$stmt->execute())
            {
                echo "<script>console.log(\"insert into cart failed\");</script>";
                $errorMsg = "Execute failed: (" . $stmt->error . ") " . $stmt->error;
                $success = false;
            }
    //        $row = $result->fetch_assoc();
    //        $quantity = $row["quantity"];
    //        echo "<script>console.log(\"quantity: " . $quantity . "\");</script>";
    //        
    //        // update new quantity
    //        $stmt->close();
    //        $new_quantity = $quantity + $add_quantity;
    //        $stmt = $conn->prepare("UPDATE travel.cart SET quantity='$new_quantity' WHERE cartid='$cart_id'");
    //        // execute the query statement:
    //        $result = $stmt->execute();
    //        if ($result == true)
    //        {
    //            echo "<script>console.log(\"updated quantity\");</script>";
    //        }
    //        else
    //        {
    //            $errorMsg .= "could not update cart quantity";
    //        }
        }
        $stmt->close();

        // from cart_id_has_tour_packages, find cartid and pid
        $stmt = $conn->prepare("SELECT quantity FROM travel.cart_has_tour_packages WHERE cart_cartid=? AND tour_packages_pid=? AND date=?");
        // Bind & execute the query statement:
        $stmt->bind_param("iis", $cart_id, $pid, $date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0)
        {
            // if found, update quantity

            // get current quantity
            $row = $result->fetch_assoc();
            $quantity = $row["quantity"];
            $new_quantity = $quantity + $add_quantity;
            $stmt->close();

            // update
            $stmt = $conn->prepare("UPDATE travel.cart_has_tour_packages SET quantity='$new_quantity' WHERE cart_cartid='$cart_id' AND tour_packages_pid='$pid' AND date='$date'");
            // execute the query statement:
            $result = $stmt->execute();
            if ($result == true)
            {
                echo "<script>console.log(\"updated cart_has_tour_packages quantity\");</script>";
            }
            else
            {
                $errorMsg .= "could not update cart quantity";
            }

            echo "<script>console.log(\"update cart_has_tour_packages quantity from: " . $quantity . " to " . $new_quantity . "\");</script>";
        }
        else
        {
            // if cart does not have tour package yet, insert
            echo "<script>console.log(\"created new cart_has_tour_packages\");</script>";
            // cart does not exist, create cart in cart table
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO travel.cart_has_tour_packages (cart_cartid, tour_packages_pid, quantity, date) VALUES (?, ?, ?, ?)");
            // Bind & execute the query statement:
            $default_amt = 0;
            $stmt->bind_param("iiis", $cart_id, $pid, $add_quantity, $date);
            if (!$stmt->execute())
            {
                echo "<script>console.log(\"insert into cart_has_tour_packages failed\");</script>";
                $errorMsg = "Execute failed: (" . $stmt->error . ") " . $stmt->error;
                $success = false;
            }
        }

        $conn->close();

        echo "<script>console.log(\"" . $errorMsg . "\");</script>";

    }
}

?>
