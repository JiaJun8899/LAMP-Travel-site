<?php
session_start();
if ($_SESSION["errormsg"] != NULL) {
    $error = $_SESSION["errormsg"];
    echo "<script>alert('$error');</script>";
    unset($_SESSION["errormsg"]);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include 'header.inc.php';
        ?>
        <title>Travel</title>
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
                <h1>Our story</h1>
                <p>Our company was founded by 5 friend's love of Europe and their rich culture</p>
                <a href='' class='hero-btn'>Find out more</a>
            </section>
            <div class="bg-light">
                <section class="py-5 bg-light standard">
                    <h1>What makes us special</h1>
                    <p>We stand out from the rest because</p>
                    <div class="row justify-content-between">
                        <div class="col-3.5 why-col">
                            <h3>Expert Local Guides</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Pellentesque aliquet turpis nulla, eleifend faucibus est
                                sollicitudin ut. Maecenas ut venenatis ex, et dapibus purus
                                Donec sit.</p>
                        </div>
                        <div class="col-3.5 why-col">
                            <h3>Handpicked Adventures</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Pellentesque aliquet turpis nulla, eleifend faucibus est
                                sollicitudin ut. Maecenas ut venenatis ex, et dapibus purus
                                Donec sit.</p>
                        </div>
                        <div class="col-3.5 why-col">
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
                <h1>Popular Destinations</h1>
                <p>These popular Destinations will never leave you disappointed</p>
                <div class="row justify-content-between">
                    <div class="col-3.5 pop-col">
                        <img src="static/paris2.jpg">
                        <div class="layer">
                            <h3>PARIS</h3>
                        </div>
                    </div>
                    <div class="col-3.5 pop-col">
                        <img src="static/london.jpg">
                        <div class="layer">
                            <h3>LONDON</h3>
                        </div>
                    </div>
                    <div class="col-3.5 pop-col">
                        <img src="static/rome.jpg">
                        <div class="layer">
                            <h3>ROME</h3>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div id="indexcarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <?php
                            $indexitem = array();
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
                                for ($i = 0; $i < count($indexitem); $i++) {
                                    $src = $indexitem[$i]["img"];
                                    $alt = $indexitem[$i]["country"];
                                    if ($i == 0) {
                                        echo '<img class="d-block w-100" alt="'. $alt .'" src="data:image/jpeg;base64,' . base64_encode($src) . '"/>';
                                        echo '</div>';
                                    } else {
                                        echo '<div class="carousel-item">';
                                        echo '<img class="d-block w-100" alt="'. $alt .'" src="data:image/jpeg;base64,' . base64_encode($src) . '"/>';
                                        echo '</div>';
                                    }
                                }
                                $stmt->close();
                            }
                            $conn->close();
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
                </div>
            </section>
            <section class="bg-light">
                <section class="py-5 standard">
                    <h1>Testimonial From our customers</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <div class="row justify-content-between">
                        <div class="testimonial-col">
                            <img src="static/user1.jpg">
                            <div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing
                                    elit. Pellentesque aliquet turpis nulla, eleifend
                                    faucibus est sollicitudin ut. Maecenas ut venenatis ex,
                                    et dapibus purus.</p>
                                <h3>Christine Berkley</h3>
                            </div>
                        </div>
                        <div class="testimonial-col">
                            <img src="static/user2.jpg">
                            <div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing
                                    elit. Pellentesque aliquet turpis nulla, eleifend
                                    faucibus est sollicitudin ut. Maecenas ut venenatis ex,
                                    et dapibus purus.</p>
                                <h3>David</h3>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        </main>
    </body>
    <?php
    include 'footer.inc.php';
    ?>
</html>
