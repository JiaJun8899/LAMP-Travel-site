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
        <main class="mx-auto registerpage overflow-hidden">
            <section class="row">
                <div class="col-lg-10 col-xl-9 mx-auto">
                    <div class="card flex-row my-5 border-0 shadow rounded-3">
                        <div class="card-body p-4 p-sm-5">
                            <h1 class="card-title text-center mb-5 fw-light fs-5">Login in</h1>
                            <form action="process_update.php" method="post">
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <label class="labels" for="fname">First Name</label>
                                        <?php echo'<input required type="text" name="fname" class="form-control" placeholder="First Name" value="' . $fname . '">'; ?>
                                    </div>
                                    <div class="col-6">
                                        <label class="labels" for="lname">Last Name</label>
                                        <?php echo '<input required type="text" name="lname" class="form-control" placeholder="Last Name" value="' . $lname . '">'; ?>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="labels">Phone Number</label>
                                    <?php echo '<input required type="text" name="phone" class="form-control" placeholder="Phone Number" value="' . $phone . '">'; ?>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="labels">Email</label>
                                    <?php echo '<input required id ="email" type="email" name="email" class="form-control" placeholder="Email" value="' . $email . '">'; ?>
                                    <h6 id="emailerror"></h6>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="labels">Current Password</label>
                                    <input required type="password" name="oldpwd" class="form-control" placeholder="Current Password">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="labels">New Password</label>
                                    <input id="pwd" type="password" name="newpwd" class="form-control" placeholder="New Password">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="labels">Confirm Password</label>
                                    <input id="conpwd"type="password" class="form-control" placeholder="Confirm New Password" name="connewpwd">
                                </div>
                                <div class="mt-5 text-center">
                                    <button class="btn btn-primary profile-button" type="submit">Update Profile</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </body>
    <?php
    include 'footer.inc.php';
    ?>
</html>