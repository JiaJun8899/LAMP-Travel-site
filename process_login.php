<?php
session_start();
$email = $pwd = $errorMsg = "";
$success = true;
if (empty($_POST["log_email"])) {
    $errorMsg .= "Email is required.<br>";
    $success = false;
} else {
    $email = sanitize_input($_POST["log_email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg .= "Invalid email format.<br>";
        $success = false;
    }
}
if (empty($_POST["log_pwd"])) {
    $errorMsg .= "Password is required.<br>";
    $success = false;
}
if ($success) {
    authenticateUser();
}
if ($success) {
    $_SESSION["user"] = $email;
    echo "<h4>Your Login is successful!</h4>";
    echo "<p>Welcome back <p>";
    echo"<div><a href ='index.php' class='btn btn-success'>Return home</a></div>";
} else {
    echo '<h3>OOPS!</h3>';
    echo "<h4>The following input errors were detected:</h4>";
    echo "<p>" . $errorMsg . "</p>";
    echo"<a href ='login.php' class= 'btn btn-danger'>Return to Login</a>";
}

//Helper function that checks input for malicious or unwanted content.
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function authenticateUser() {
    global $fname, $lname, $email, $pwd, $errorMsg, $success;
    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        // Prepare the statement:
        $stmt = $conn->prepare("SELECT * FROM travel_members WHERE email=?");
        // Bind & execute the query statement:
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Note that email field is unique, so should only have one row in the result set.
            $row = $result->fetch_assoc();
            $fname = $row["fname"];
            $lname = $row["lname"];
            $pwd = $row["password"];
            // Check if the password matches:
            if (!password_verify($_POST["log_pwd"], $pwd)) {
                // Don't be too specific with the error message - hackers don't need to know which one they got right or wrong. :)
                $errorMsg = "Email not found or password doesn't match...";
                $success = false;
            }
        } else {
            $errorMsg = "Email not found or password doesn't match...";
            $success = false;
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
        <title>Log in</title>
    </head>
    <body>
        <?php
        include 'nav.inc.php';
        ?>
        <main class="container">

        </main>
        <?php
        include "footer.inc.php";
        ?>
    </body>