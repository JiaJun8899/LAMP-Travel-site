<?php
session_start();
if ($_SESSION["errormsg"] != NULL) {
    $error = $_SESSION["errormsg"];
    echo "<script>alert('$error');</script>";
    unset($_SESSION["errormsg"]);
}
$indexitem = array();
$testitem = array();
$count = 0;
// Create database connection.
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
// Check connection
if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
    $success = false;
} else {
    // Prepare the statement:
    $stmt = $conn->prepare("SELECT country, img FROM tour_packages");
    // Bind & execute the query statement:
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        // add rows as array into array
        $indexitem[$count] = array();
        $indexitem[$count]["country"] = $row["country"];
        $indexitem[$count]["img"] = $row["img"];
        $count += 1;
    }
    $count = 0;
    $stmt = $conn->prepare("SELECT * FROM indexpage");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        // add rows as array into array
        $testitem[$count] = array();
        $testitem[$count]["username"] = $row["username"];
        $testitem[$count]["testi"] = $row["testi"];
        $testitem[$count]["img"] = $row["img"];
        $count += 1;
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en" class="index">
    <head>
        <?php
        include 'header.inc.php';
        ?>
        <title>Allons-Y</title>
    </head>
    <body>
        <?php
        include 'nav.inc.php';
        ?>
        <header class="mainheader">
            <div class="text-box">
                <h1>Your adventure begins in Europe</h1>
                <p>Making your own adventure is as easy as 1,2,3</p>
                <a href='tour_packages.php' class='hero-btn'>Visit us to know more</a>
            </div>
        </header>
        <main>
            <section class="py-5 standard">
                <h2>Our story</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Pellentesque aliquet turpis nulla, eleifend faucibus est
                    sollicitudin ut. Maecenas ut venenatis ex, et dapibus purus
                    Donec sit.</p>
                <a href='about.php' class='hero-btn'>Find out more</a>
            </section>
            <div class="bg-light">
                <section class="py-5 bg-light standard">
                    <h2>What makes us special</h2>
                    <p>We stand out from the rest because</p>
                    <div class="row justify-content-between">
                        <div class="why-col">
                            <h3>Expert Local Guides</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Pellentesque aliquet turpis nulla, eleifend faucibus est
                                sollicitudin ut. Maecenas ut venenatis ex, et dapibus purus
                                Donec sit.</p>
                        </div>
                        <div class="why-col">
                            <h3>Handpicked Adventures</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Pellentesque aliquet turpis nulla, eleifend faucibus est
                                sollicitudin ut. Maecenas ut venenatis ex, et dapibus purus
                                Donec sit.</p>
                        </div>
                        <div class="why-col">
                            <h3>Hidden Gem Destinations</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Pellentesque aliquet turpis nulla, eleifend faucibus est
                                sollicitudin ut. Maecenas ut venenatis ex, et dapibus purus
                                Donec sit.</p>
                        </div>
                    </div>
                </section>
            </div>
            <section class="py-5 standard">
                <h2>Popular Destinations</h2>
                <p>These popular Destinations will never leave you disappointed</p>
                <div class="row justify-content-between">
                    <?php
                    for ($i = 0; $i < count($indexitem); $i++) {
                        $src = $indexitem[$i]["img"];
                        $alt = $indexitem[$i]["country"];
                        if ($alt == "Greece" || $alt == "Scotland" || $alt == "France") {
                            echo '<div class="pop-col">';
                            echo '<img alt="' . $alt . '" src="data:image/jpeg;base64,' . base64_encode($src) . '"/>';
                            echo '<div class="layer">';
                            echo '<h3>' . $alt . '</h3>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </section>
            <section class="bg-light">
                <h2 class="text-center py-1">Sights from some of our adventures</h2>
                <div id="indexcarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        for ($i = 0; $i < count($indexitem); $i++) {
                            $src = $indexitem[$i]["img"];
                            $alt = $indexitem[$i]["country"];
                            if ($i == 0) {
                                echo '<div class="carousel-item active">';
                                echo '<img class="d-block w-100" alt="' . $alt . '" src="data:image/jpeg;base64,' . base64_encode($src) . '"/>';
                                echo '</div>';
                            } else {
                                echo '<div class="carousel-item">';
                                echo '<img class="d-block w-100" alt="' . $alt . '" src="data:image/jpeg;base64,' . base64_encode($src) . '"/>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <a class="carousel-control-prev" href="#indexcarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#indexcarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </section>
            <section class="py-5 standard">
                <h2>Testimonial From our customers</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <div class="row justify-content-between">
                    <?php
                    for ($i = 0; $i < count($testitem); $i++) {
                        $src = $testitem[$i]["img"];
                        $alt = $testitem[$i]["username"];
                        $testi = $testitem[$i]["testi"];
                        echo '<div class="testimonial-col">';
                        echo '<img alt="user' . $i . '" src="data:image/jpeg;base64,' . base64_encode($src) . '"/>';
                        echo '<div>';
                        echo '<p>' . $testi . '</p>';
                        echo '<h3>' . $alt . '</h3>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </section>
        </main>
        <?php
        include 'footer.inc.php';
        ?>
    </body>
</html>
