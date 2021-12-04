<?php
// Include the database configuration file  

$id = $_POST['id'];
$country = $_POST['country'];
$city = $_POST['city'];
$price = $_POST['price'];
$desc = $_POST['desc'];
$ldesc = $_POST['ldesc'];

$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
// If file upload form is submitted 
$status = $statusMsg = '';
if (isset($_POST["submit"])) {
    $status = 'error';
    $stmt = $conn->prepare("INSERT INTO tour_packages (country,city,price,long_description,short_description) VALUES (?,?,?,?,?)");
    $stmt->bind_param("s,s,i,s,s", $country, $city, $price, $ldesc, $desc);
    $stmt->execute();
    $stmt->close();
    if (!empty($_FILES["image"]["name"])) {
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        // Allow certain file formats 
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            $image = $_FILES['image']['tmp_name'];
            $imgContent = file_get_contents(addslashes($image));

            // Insert image content into database 
            $stmt = $conn->prepare("INSERT INTO tests (img) VALUES (?)");
            $stmt->bind_param("s", $imgContent);
            $stmt->send_long_data(0, $imgContent);
            $stmt->execute();
            $stmt->close();

            if ($stmt) {
                $status = 'success';
                $statusMsg = "File uploaded successfully.";
            } else {
                $statusMsg = "File upload failed, please try again.";
            }
        } else {
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
        }
    } else {
        $statusMsg = 'Please select an image file to upload.';
    }
}

// Display status message 
echo $statusMsg;
?>
<img src='data:image/jpg;charset=utf8;base64,<?php echo base64_encode($imgContent); ?>' />