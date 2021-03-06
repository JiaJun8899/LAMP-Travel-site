<?php
session_start();
$email = $oldpwd = $fname = $lname = $newpwd = $errorMsg = "";
$success = true;
$phone = 0;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
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
    if (empty($_POST["fname"])) {
        $errorMsg .= "First Name is required.<br>";
        $success = false;
    } else {
        $fname = sanitize_input($_POST["fname"]);
    }
    if (!empty($_POST["lname"])) {
        $lname = sanitize_input($_POST["lname"]);
    }
    if (empty($_POST["oldpwd"])) {
        $errorMsg .= "Password is required to update profile.<br>";
        $success = false;
    } else {
        $oldpwd = password_hash($_POST["oldpwd"], PASSWORD_DEFAULT);
    }
    if (!empty($_POST["newpwd"])) {
        if (!empty($_POST["connewpwd"])) {
            if ($success === password_chk($_POST["newpwd"], $_POST["connewpwd"])&& validatepwd($_POST["newpwd"])) {
                $newpwd = password_hash($_POST["newpwd"], PASSWORD_DEFAULT);
            } else {
                $errorMsg .= "There are some issues with the passwords.<br>";
                $success = false;
            }
        } else {
            $errorMsg .= "Password confirm is required.<br>";
            $success = false;
        }
    }
    if (empty($_POST["phone"])) {
        $errorMsg .= "Phone Number is required.<br>";
        $success = false;
    } else {
        $phone = filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT);
        if (!validate_mobile($phone)) {
            $errorMsg .= "A valid contact number is required.<br>";
            $success = false;
        }
    }
    if ($success) {
        update_data();
    }
} else {
    $_SESSION["errormsg"] = "Unauthorised Access!";
    header("Location: http://35.187.229.58/project/index.php");
    exit();
}

function update_data() {
    global $email, $oldpwd, $fname, $lname, $newpwd, $errorMsg, $success, $phone;
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        $stmt = $conn->prepare("SELECT * FROM members WHERE email=?");
        $stmt->bind_param("s", $_SESSION['user']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $pwd = $row["password"];
            if (!password_verify($_POST["oldpwd"], $pwd)) {
                $errorMsg = "Email not found or password doesn't match";
                $success = false;
            } else {
                if (empty($newpwd)) {
                    $newpwd = $oldpwd;
                }
                $stmt = $conn->prepare("UPDATE members SET fname=?,lname=?, email=?, phoneno=? ,password=?, cart_cartid = ? WHERE email =?");
                $stmt->bind_param("sssisis", $fname, $lname, $email, $phone, $newpwd, $phone, $_SESSION['user']);
                $stmt->execute();
                if (!$stmt->execute()) {
                    $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                    $success = false;
                }
                $_SESSION['user'] = $email;
            }
        } else {
            $errorMsg = "Email not found or password doesn't match...";
            $success = false;
        }
        $stmt->close();
    }
    $conn->close();
}

function validate_mobile($mobile) {
    return preg_match('/^[0-9]{8}$/', $mobile);
}

function validatepwd($password) {
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);

    if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
        return false;
    } else {
        return true;
    }
}

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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include 'header.inc.php';
        ?>
        <title></title>
    </head>
    <body>
        <?php
        include "nav.inc.php";
        ?>
        <main class="container">
            <?php
            if ($success) {
                echo 'yay';
            } else {
                echo $errorMsg;
            }
            ?>
        </main>
    </body>
    <?php
    include 'footer.inc.php';
    ?>
</html>