<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.88.1">
        <title>Europe Tour Packages</title>

        <!--Temporary header import due to main.css clashes-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" 
            crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
        <!-- Fonts style sheets -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
        <script defer src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous">
        </script>
        <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"
            integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"
            crossorigin="anonymous">
        </script>
        <script defer src="js/main.js"></script>
        <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
        <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/blog/">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--import ends here-->
        
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        
        <!-- Custom styles for this template -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap">
        <!-- Custom styles for this template -->
        <link rel="stylesheet" href="css/tour_package.css">
        
        <script defer src="js/tour_packages.js"></script>
    </head>
    
    <body>
        <main class="container">
            
        <?php
            include "nav.inc.php";

            // create dynamic tour packages from database
            
            // read from database
            // Create database connection.
            $config = parse_ini_file('../../private/db-config.ini');
            $conn = new mysqli($config['servername'], $config['username'],
            $config['password'], $config['dbname']);

            $errorMsg = "";
            
            // Check connection
            if ($conn->connect_error)
            {
                $errorMsg = "Connection failed: " . $conn->connect_error;
                $success = false;
            }
            else
            {
                // testing with just id 1
                $pid = 2;
                
                // Prepare the statement:
                $stmt = "SELECT * FROM travel.tour_packages";
                //$stmt = $conn->prepare("SELECT * FROM travel.tour_packages WHERE pid=?");
                // Bind & execute the query statement:
//                $stmt->bind_param("i", $pid);
//                $stmt->execute();
//                $result = $stmt->get_result();
                $result = $conn->query($stmt);
                //$all_rows = $conn->fetch_all($result, MYSQL_ASSOC);
                
                // fetch all rows into array
                $array = array();
                $array_count = 0;
                while ($row = $result->fetch_assoc())
                {
                    // add rows as array into array
                    $array[$array_count] = array();
                    $array[$array_count]["pid"] = $row["pid"];
                    $array[$array_count]["country"] = $row["country"];
                    $array[$array_count]["city"] = $row["city"];
                    $array[$array_count]["price"] = $row["price"];
                    $array[$array_count]["short_description"] = $row["short_description"];
                    $array[$array_count]["long_description"] = $row["long_description"];
                    $array[$array_count]["image_link"] = $row["image_link"];
                    $array[$array_count]["img"] = $row["img"];
                    $array_count += 1;
                }
                
                // display tour package header
                echo "<div class=\"p-4 p-md-5 mb-4 text-white rounded bg-secondary\">";
                    echo "<div class=\"col-md-6 px-0\">";
                        echo "<h1 class=\"display-4 fst-italic\">Europe;</h1>";
                        echo "<p class=\"lead my-3\">second smallest of the world's continents, composed of the westward-projecting peninsulas of Eurasia (the great landmass that it shares with Asia) and occupying nearly one-fifteenth of the world's total land area.</p>";
                        echo "<p class=\"lead mb-0\"><a href=\"#\" class=\"text-white fw-bold\">View our tour packages below!</a></p>";
                    echo "</div>";
                echo "</div>";
                
                // display rows
                $row_count = 0;
                for ($i = 0; $i < count($array); $i++)
                {
                    $col_count += 1; // new col count
                    $pid = $array[$i]["pid"];
                    $country = $array[$i]["country"];
                    $city = $array[$i]["city"];
                    $price = $array[$i]["price"];
                    $short_description = $array[$i]["short_description"];
                    $long_description = $array[$i]["long_description"];
                    $img = $array[$i]["img"];
                    
                    // create html card
                    
                    if ($col_count == 1) // if first column, open row
                    {
                        echo "<div class=\"row mb-2\">";
                    }
                    
                    echo "<div class=\"col-md-6\">";
                        echo "<div class=\"row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative\">";
                            echo "<div class=\"col p-4 d-flex flex-column position-static\">";
                                echo "<strong class=\"d-inline-block mb-2 text-success country\">" . $country . "</strong>";
                                echo "<h3 class=\"mb-0 city\">" . $city . "</h3>";
                                echo "<div class=\"mb-1 text-muted price\"$>" . $price . "</div>";
                                echo "<p class=\"card-text mb-auto short-description\">" . $short_description . "</p>";
                                echo "<p class=\"long-description\">" . $long_description . "</p>";
                                echo "<p class=\"image-link\">data:image/jpeg;base64," . base64_encode($img) . "</p>";
                                echo "<button id=\"" . $pid . "\" onclick=\"popUp(this)\" type=\"button\" class=\"stretched-link button-link\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\">View Details</button>";
                            echo "</div>";
                            echo "<div class=\"col-auto d-none d-lg-block\">";
                                echo "<svg class=\"bd-placeholder-img\" width=\"200\" height=\"250\" xmlns=\"http://www.w3.org/2000/svg\" role=\"img\" aria-label=\"". $country ."\" preserveAspectRatio=\"xMidYMid slice\" focusable=\"false\">";
                                    echo "<image class=\"thumbnail\" href=\"data:image/jpeg;base64," . base64_encode($img) . "\"/>";
                                echo "</svg>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                    
                    // if second column, close row
                    if ($col_count == 2 || $i == (count($array) - 1))
                    {
                        echo "</div>";
                        $col_count = 0;
                    }
                }
                //$stmt->close();
            }
            $conn->close();
        ?>
            
            <!--dynamic pop up, content changes based on what was clicked-->
            <div class="modal fade bd-example-modal-xl" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="Pop Up" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content" id="popup-content">
                        <div class="modal-header">
                            <h4 class="modal-title popup-country" id="popup-country">Country</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="tour_packages.php" method="post" id="package-form">
                            <div class="modal-body row">
                                <div class="col col-xl-9">
                                    <h5 id="popup-city">City<br></h5>
                                    <img class="popup-thumbnail" id="popup-thumbnail" src="images/"/>
                                    <br>
                                    <p id="popup-long-description">Description Here</p>
                                </div>
                                <!--Calendar-->
                                <div class="col col-xl-3 form-group">
                                    <h5 id="popup-price">$</h5>
                                    <br>
                                    <label for="date">Start Date: </label>
                                    <input type="date" id="date" name="date" required> <!--might not work for safari-->
                                
                                    <!-- Quantity -->
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button type="button" onclick="quantity_change(0)" class="quantity-left-minus btn btn-danger btn-number"  data-type="minus" data-field="">
                                                -
                                            </button>
                                        </span>
                                        <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1">
                                        <span class="input-group-btn">
                                            <button type="button" onclick="quantity_change(1)" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
                                                +
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer form-group">
                                <input type="hidden" id="package_id" name="package_id" value="0">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <input type="submit" name="submit" value="Add to Cart" class="btn btn-primary cartButton">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </main>
        <?php
            include "footer.inc.php";
        ?>
    </body>
</html>
