<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (isset($_POST["submit_file"])) {
    $file = $_FILES["file"]["tmp_name"];
    $file_open = fopen($file, "r");

    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
            $config['password'], $config['dbname']);

    while (($csv = fgetcsv($file_open, 1000, ",")) !== false) {
        $country = $csv[0];
        $city = $csv[1];
        $price = $csv[2];
        $short_desc = $csv[3];
        $long_desc = $csv[4];
        $pid = $csv[5];
//        $img = $csv[5];
//        echo 'name: ' . $today;
//        mysql_query("INSERT INTO employee VALUES ('$name','$age','$country')");
        // Check connection
        if ($conn->connect_error) {
            $errorMsg = "Connection failed: " . $conn->connect_error;
            $success = false;
        } else {
// Prepare the statement:
            $stmt = $conn->prepare("INSERT INTO tour_packages (pid, country, city, price, short_description, long_description) VALUES (?,?,?,?,?,?)");
// Bind & execute the query statement:
            $stmt->bind_param("ississ", $pid, $country, $city, $price, $short_desc, $long_desc);
            if (!$stmt->execute()) {
                $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                $success = false;
            }
        }
    }
    $stmt->close();
}
$conn->close();
header("Location: http://35.187.229.58/project/admin.php")
?>

<html>
    <body>
<?php
echo $success;
echo $errorMsg;
?>
    </body>
</html>
