<?php

$country = $city = $price = $desc = $id = $errorMsg = $ldesc = "";
$success = true;
if (empty($_POST["country"])) {
    $errorMsg .= "Email is required.<br>";
    $success = false;
} else {
    $country = $_POST["country"];
}
if (empty($_POST["city"])) {
    $errorMsg .= "Password is required.<br>";
    $success = false;
} else {
    $city = $_POST["city"];
}
if (empty($_POST["price"])) {
    $errorMsg .= "Password is required.<br>";
    $success = false;
} else {
    $price = (int) $_POST["price"];
}
if (empty($_POST["price"])) {
    $errorMsg .= "Password is required.<br>";
    $success = false;
} else {
    $price = $_POST["price"];
}
if (empty($_POST["desc"])) {
    $errorMsg .= "Password is required.<br>";
    $success = false;
} else {
    $desc = $_POST["desc"];
}
if (empty($_POST["ldesc"])) {
    $errorMsg .= "Password is required.<br>";
    $success = false;
} else {
    $ldesc = $_POST["ldesc"];
}
if (empty($_POST["id"])) {
    $errorMsg .= "Email is required.<br>";
    $success = false;
} else {
    $id = $_POST["id"];
}
if ($success) {
//    echo 'Country: '.$country.'<br>City: '. $city.'<br>Price: '. $price.'<br>Long: '. $ldesc.'<br>Short: '. $desc.'<br>ID: '. $id;
    updateadmin();
    header("Location: http://35.187.229.58/project/admin.php");
}
echo $errorMsg . $country . $desc;

function updateadmin() {
    global $country, $city, $price, $desc, $id, $errorMsg, $ldesc;
//    echo 'in function:<br> Country: '.$country.'<br>City: '. $city.'<br>Price: '. $price.'<br>Long: '. $ldesc.'<br>Short: '. $desc.'<br>ID: '. $id.'<br>';
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
        $stmt = $conn->prepare("UPDATE tour_packages SET country = ?, city = ?, price = ?, short_description = ?, long_description = ? WHERE pid = ?");
//        "UPDATE tour_packages SET country=?, city=?, price=?, long_description=?, short_description=? WHERE pid =?"
        // Bind & execute the query statement:
        $stmt->bind_param("ssissi", $country, $city, $price, $desc, $ldesc, $id);
        $stmt->execute();
        if (!$stmt->execute()) {
//            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $errorMsg = "Something went wrong!";
            $success = false;
        }
        $stmt->close();
    }
    ////Update images codes !
//        $conn->close();
//        echo '<br>file name: '.$_POST["image"].'<br>';
//        echo '<br>file name: '.$_FILES["image"]["name"].'<br>';
//        if (!empty($_FILES["image"]["name"])) {
//            // Get file info 
//            $fileName = basename($_FILES["image"]["name"]);
//            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
//
//            // Allow certain file formats 
//            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
//            if (in_array($fileType, $allowTypes)) {
//                $image = $_FILES['image']['tmp_name'];
//                echo '$IMAGE: ' . $image;
//                $imgContent = file_get_contents(addslashes($image));
//
//                // Insert image content into database 
//                $stmt = $conn->prepare("UPDATE tour_packages SET img = ? WHERE pid = ?");
//                $stmt->bind_param("bi", null, $id); //$imgContent
//                $stmt->send_long_data(0, $imgContent);
//                $stmt->execute();
//                $stmt->close();
//
//                if ($stmt) {
//                    $status = 'success';
//                    $statusMsg = "File uploaded successfully.";
//                } else {
//                    $statusMsg = "File upload failed, please try again.";
//                }
//            } else {
//                $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
//            }
//        } else {
//            $statusMsg = 'Please select an image file to upload.';
//        }
//    }
}

?>