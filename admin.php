<?php
session_start();
if ($_SESSION["user"] != "admin@admin.com") {
    $_SESSION["errormsg"] = "Unauthorised Access!";
    header("Location: http://35.187.229.58/project/index.php");
    exit();
}
$adminitem = array();
$count = 0;
// Create database connection
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
    $success = false;
    $conn->close();
} else {
    // Prepare the statement:
    $stmt = $conn->prepare("SELECT * FROM tour_packages");
    // Bind & execute the query statement:
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        // add rows as array into array
        $adminitem[$count] = array();
        $adminitem[$count]["id"] = $row["pid"];
        $adminitem[$count]["country"] = $row["country"];
        $adminitem[$count]["city"] = $row["city"];
        $adminitem[$count]["price"] = $row["price"];
        $adminitem[$count]["l_desc"] = $row["long_description"];
        $adminitem[$count]["img"] = $row["img"];
        $adminitem[$count]["desc"] = $row["short_description"];
        $count += 1;
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include 'header.inc.php';
        ?>
        <title>Admin Page</title>
    </head>
    <body>
        <?php
        include 'nav.inc.php';
        ?>
        <main class="container">
            <h3>Upload New Packages</h3>
            <form method="post" action="updatedatabase_process.php" enctype="multipart/form-data">
                <input type="file" name="file"/>
                <input type="submit" class="btn btn-primary" name="submit_file"/>
            </form>
            <hr>
            <h3>Update Packages</h3>
            <?php
            for ($i = 0; $i < count($adminitem); $i++) {
                $id = $adminitem[$i]["id"];
                $src = $adminitem[$i]["img"];
                $alt = $adminitem[$i]["country"];
                $city = $adminitem[$i]["city"];
                $price = $adminitem[$i]["price"];
                $desc = $adminitem[$i]["desc"];
                $ldesc = $adminitem[$i]["l_desc"];
                echo '<div class="card">';
                echo '<img class="card-img-top" alt="' . $alt . '" src="data:image/jpeg;base64,' . base64_encode($src) . '"/>';
                echo '<div class="card-body">';
                echo '<form action="process_admin.php" method="post" enctype="multipart/form-data">';
                echo '<input type="text" name="id" class="form-control" readonly="true" value="' . $id . '">';
                echo '<input type="text" name="country" class="form-control" value="' . $alt . '">';
                echo '<input type="text" name="city" class="form-control" value="' . $city . '">';
                echo '<input type="text" name="price" class="form-control" value="' . $price . '">';
                echo '<input type="text" name="desc" class="form-control" value="' . $desc . '">';
                echo '<input type="text" name="ldesc" class="form-control" value="' . $ldesc . '">';
//                echo '<input type="file" name="image" id="image">';
                echo '<button class="btn btn-primary profile-button my-3" type="submit">Update</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </main>
    </body>
</html>