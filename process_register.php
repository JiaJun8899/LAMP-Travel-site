<?php
session_start();
$email = $pwd = $errorMsg = "";
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
    if (empty($_POST["pwd"])) {
        $errorMsg .= "Password is required.<br>";
        $success = false;
    } else if (empty($_POST["pwd_confirm"])) {
        $errorMsg .= "Password confirm is required.<br>";
        $success = false;
    } else {
        if ($success === password_chk($_POST["pwd"], $_POST["pwd_confirm"])) {
            $pwd = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
        } else {
            $errorMsg .= "Password do not match.<br>";
            $success = false;
        }
    }
    saveMemberToDB();
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

function password_chk($pwd, $con_pwd) {
    if ($pwd === $con_pwd) {
        return true;
    } else {
        return false;
    }
}

function saveMemberToDB() {
    global $email, $errorMsg, $success, $pwd;
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
        $stmt = $conn->prepare("INSERT INTO travel_members (email, password) VALUES (?, ?)");
        // Bind & execute the query statement:
        $stmt->bind_param("ss", $email, $pwd);
        if (!$stmt->execute()) {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
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
        <title>Registration</title>
    </head>
    <body>
        <?php
        if ($success) {
            echo "<h4>Your registration successful!</h4>";
            echo "<p>Thank you for signing up </p>";
            echo"<div><a href ='index.php' class='btn btn-success'>Return home</a></div>";
        } else {
            echo '<h3>OOPS!</h3>';
            echo "<h4>The following input errors were detected:</h4>";
            echo "<p>" . $errorMsg . "</p>";
            echo"<a href ='register.php' class= 'btn btn-danger'>Return to Sign-up</a>";
        }
        ?>
    </body>
    <?php
    include 'footer.inc.php';
    ?>
</html>