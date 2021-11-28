<?php
session_start();
if ($_SESSION["user"] == NULL) {
    $_SESSION["errormsg"] = "Please log in first!";
    header("Location: http://35.187.229.58/project/index.php");
    exit();
}
global $success, $fname, $lname, $phone, $email;
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'],
        $config['password'], $config['dbname']);
if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
    $success = false;
} else {
    $stmt = $conn->prepare("SELECT * FROM members WHERE email=?");
    $stmt->bind_param("s", $_SESSION['user']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Note that email field is unique, so should only have one row in the result set.
        $row = $result->fetch_assoc();
        $fname = $row["fname"];
        $lname = $row["lname"];
        $phone = $row["phoneno"];
        $email = $row["email"];
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include 'header.inc.php';
        ?>
        <title>My Profile</title>
    </head>
    <body class="registerpage">
        <?php
        include "nav.inc.php";
        ?>
        <main>
            <div class="container rounded">
                <div class="row justify-content-center align-self-center">
                    <div class="col-5 bg-white">
                        <div class="p-3 py-5">
                            <div class="justify-content-between align-items-center mb-3">
                                <h4 class="text-center">Profile Settings</h4>
                            </div>
                            <form action="process_update.php" method="post">
                            <div class="row mt-2">
                                <div class="col-6">
                                    <label class="labels">First Name</label>
                                    <?php echo'<input required type="text" name="fname" class="form-control" placeholder="First Name" value="'.$fname.'">';?>
                                </div>
                                <div class="col-6">
                                    <label class="labels">Last Name</label>
                                    <?php echo '<input required type="text" name="lname" class="form-control" placeholder="Last Name" value="' . $lname . '">';?>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <label class="labels">Phone Number</label>
                                    <?php echo '<input required type="text" name="phone" class="form-control" placeholder="Phone Number" value="'. $phone. '">';?>
                                </div>
                                <div class="col-12">
                                    <label class="labels">Email</label>
                                    <?php echo '<input required type="email" name="email" class="form-control" placeholder="Email" value="'. $email .'">';?>
                                </div>
                                <div class="col-12">
                                    <label class="labels">Current Password</label>
                                    <input required type="password" name="oldpwd" class="form-control" placeholder="Current Password">
                                </div>
                                <div class="col-12">
                                    <label class="labels">New Password</label>
                                    <input type="password" name="newpwd" class="form-control" placeholder="New Password">
                                </div>
                                <div class="col-12">
                                    <label class="labels">Confirm Password</label>
                                    <input type="password" class="form-control" placeholder="Confirm New Password" name="connewpwd">
                                </div>
                            </div>
                            <div class="mt-5 text-center">
                                <button class="btn btn-primary profile-button" type="submit">Update Profile</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
    <?php
    include 'footer.inc.php';
    ?>
</html>