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

        <!-- Custom styles for this template -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap">
        <!-- Custom styles for this template -->
        <link rel="stylesheet" href="css/tour_package.css">
        
        <script defer src="js/tour_packages.js"></script>
    </head>
    
    <body>
        //<?php
//            include "nav.inc.php";
//        
//            // create dynamic tour packages from database
//            
//            // read from database
//            // Create database connection.
//            $config = parse_ini_file('../../private/db-config.ini');
//            $conn = new mysqli($config['servername'], $config['username'],
//            $config['password'], $config['dbname']);
//
//            // Check connection
//            if ($conn->connect_error)
//            {
//                $errorMsg = "Connection failed: " . $conn->connect_error;
//                $success = false;
//            }
//            else
//            {
//                // testing with just id 1
//                $pid = 1;
//                
//                // Prepare the statement:
//                $stmt = $conn->prepare("SELECT * FROM tour_packages WHERE pid=?");
//                // Bind & execute the query statement:
//                $stmt->bind_param("i", $pid);
//                $stmt->execute();
//                $result = $stmt->get_result();
//                
//                while ($row = $result->fetch_assoc())
//                {
//                    $pid = $row["pid"];
//                    $country = $row["country"];
//                    $city = $row["city"];
//                    $price = $row["price"];
//                    $short_description = $row["short_description"];
//                    $long_description = $row["long_description"];
//                    $image_link = $row["image_link"];
//                    
//                    // create html card
//                    echo "<div class=\"col-md-6\">";
//                        echo "<div class=\"row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative\">";
//                            echo "<div class=\"col p-4 d-flex flex-column position-static\">";
//                                echo "<strong class=\"d-inline-block mb-2 text-success country\">" . $country . "</strong>";
//                                echo "<h3 class=\"mb-0 city\">" . $city . "</h3>";
//                                echo "<div class=\"mb-1 text-muted price\">" . $price . "</div>";
//                                echo "<p class=\"card-text mb-auto short-description\">" . $short_description . "</p>";
//                                echo "<p class=\"long-description\">" . $long_description . "</p>";
//                                echo "<p class=\"image-link\">" . $image_link . "</p>";
//                                echo "<button id=\"" . $pid . "\" onclick=\"popUp(this)\" type=\"button\" class=\"stretched-link button-link\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\">View Details</button>";
//                            echo "</div>";
//                            echo "<div class=\"col-auto d-none d-lg-block\">";
//                              echo "<svg class=\"bd-placeholder-img\" width=\"200\" height=\"250\" xmlns=\"http://www.w3.org/2000/svg\" role=\"img\" aria-label=\"". $country ."\" preserveAspectRatio=\"xMidYMid slice\" focusable=\"false\">";
//                                  echo "<image class=\"thumbnail\" href=\"" . $image_link . "\"/>";
//                              echo "</svg>";
//                            echo "</div>";
//                        echo "</div>";
//                    echo "</div>";
//                }
//            }
//            
//            $stmt->close();
//            $conn->close();
//        ?>
        
        <main class="container">
            <div class="p-4 p-md-5 mb-4 text-white rounded bg-secondary">
                <div class="col-md-6 px-0">
                    <h1 class="display-4 fst-italic">Europe;</h1>
                    <p class="lead my-3">second smallest of the world's continents, composed of the westward-projecting peninsulas of Eurasia (the great landmass that it shares with Asia) and occupying nearly one-fifteenth of the world's total land area.</p>
                    <p class="lead mb-0"><a href="#" class="text-white fw-bold">View our tour packages below!</a></p>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col p-4 d-flex flex-column position-static">
                            <strong class="d-inline-block mb-2 text-success country">France</strong>
                            <h3 class="mb-0 city">Paris</h3>
                            <div class="mb-1 text-muted price">$170</div>
                            <p class="card-text mb-auto short-description">Explore Paris with a captivating sightseeing tour that takes you around the city to enjoy the Eiffel Tower, Seine River Cruise, and more!</p>
                            <p class="long-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In molestie eros tellus, non finibus elit commodo quis. Praesent eu odio ac nibh lobortis placerat id ut urna. Phasellus ac ipsum placerat lectus gravida consectetur. Cras ullamcorper ac nisl in aliquam. Quisque tincidunt urna nec elit maximus, in rutrum massa sodales. Proin sit amet lorem dolor. Fusce nec lacus vitae lorem faucibus feugiat id ut metus. Maecenas nulla leo, lacinia a ex a, imperdiet porttitor velit. Aliquam sit amet erat fringilla, tincidunt justo dictum, eleifend augue.</p> <!--To put long description here when reading from database-->
                            <p class="image-link">static/paris.jpg</p>
                            <!--<a href="#" class="stretched-link" data-toggle="modal" data-target="#exampleModalCenter">View Details</a>-->
                            <button id="1" onclick="popUp(this)" type="button" class="stretched-link button-link" data-toggle="modal" data-target="#exampleModalCenter">View Details</button>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                          <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Paris" preserveAspectRatio="xMidYMid slice" focusable="false">
                              <image class="thumbnail" href="static/paris.jpg"/>
                          </svg>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col p-4 d-flex flex-column position-static">
                            <strong class="d-inline-block mb-2 text-success country">Greece</strong>
                            <h3 class="mb-0 city">Santorini</h3>
                            <div class="mb-1 text-muted price">$150</div>
                            <p class="card-text mb-auto short-description">Visit the supermodel of the Greek islands, with multicolored cliffs soar out of a sea-drowned volcanic crater, topped by whitewashed buildings.</p>
                            <p class="long-description">Hidden text for storing long description!</p>
                            <p class="image-link">static/santorini.jpg</p>
                            <button id="2" onclick="popUp(this)" type="button" class="stretched-link button-link" data-toggle="modal" data-target="#exampleModalCenter">View Details</button>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Santorini" preserveAspectRatio="xMidYMid slice" focusable="false">
                                <image class="thumbnail" href="static/santorini.jpg"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col p-4 d-flex flex-column position-static">
                            <strong class="d-inline-block mb-2 text-success country">Netherlands</strong>
                            <h3 class="mb-0 city">Amsterdam</h3>
                            <div class="mb-1 text-muted price">$170</div>
                            <p class="card-text mb-auto short-description">Cruise down the unique Unesco Heritage listed Golden Age canals of Amsterdam in the classic wooden saloon boat.</p>
                            <p class="long-description">Hidden text for storing long description!</p>
                            <p class="image-link">static/amsterdam.jpg</p>
                            <button id="3" onclick="popUp(this)" type="button" class="stretched-link button-link" data-toggle="modal" data-target="#exampleModalCenter">View Details</button>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                          <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Amsterdam" preserveAspectRatio="xMidYMid slice" focusable="false">
                              <image class="thumbnail" href="static/amsterdam.jpg"/>                        
                          </svg>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col p-4 d-flex flex-column position-static">
                            <strong class="d-inline-block mb-2 text-success country">Italy</strong>
                            <h3 class="mb-0 city">Rome</h3>
                            <div class="mb-1 text-muted price">$120</div>
                            <p class="card-text mb-auto short-description">Rome, the Eternal City, is one of the world greatest cities to visit and packed with tourist sites steeped in history.</p>
                            <p class="long-description">Hidden text for storing long description!</p>
                            <p class="image-link">static/rome.jpg</p>
                            <button id="4" onclick="popUp(this)" type="button" class="stretched-link button-link" data-toggle="modal" data-target="#exampleModalCenter">View Details</button>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                          <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Rome" preserveAspectRatio="xMidYMid slice" focusable="false">
                              <image class="thumbnail" href="static/rome.jpg"/>                        
                          </svg>                      
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col p-4 d-flex flex-column position-static">
                            <strong class="d-inline-block mb-2 text-success country">England</strong>
                            <h3 class="mb-0 city">London</h3>
                            <div class="mb-1 text-muted price">$100</div>
                            <p class="card-text mb-auto short-description">Explore the River Thames as it weaves through the heart of London and discover fascinating history around every bend.</p>
                            <p class="long-description">Hidden text for storing long description!</p>
                            <p class="image-link">static/london.jpg</p>
                            <button id="5" onclick="popUp(this)" type="button" class="stretched-link button-link" data-toggle="modal" data-target="#exampleModalCenter">View Details</button>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                          <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="London" preserveAspectRatio="xMidYMid slice" focusable="false">
                              <image class="thumbnail" href="static/london.jpg"/>                        
                          </svg>                      
                        </div>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col p-4 d-flex flex-column position-static">
                            <strong class="d-inline-block mb-2 text-success country">Scotland</strong>
                            <h3 class="mb-0 city">Edinburgh</h3>
                            <div class="mb-1 text-muted price">$110</div>
                            <p class="card-text mb-auto short-description">A town intimately entwined with its landscape, buildings and monuments perched atop crags and overshadowed by cliffs.</p>
                            <p class="long-description">Hidden text for storing long description!</p>
                            <p class="image-link">static/edinburgh.jpg</p>
                            <button id="6" onclick="popUp(this)" type="button" class="stretched-link button-link" data-toggle="modal" data-target="#exampleModalCenter">View Details</button>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Edinburgh" preserveAspectRatio="xMidYMid slice" focusable="false">
                                <image class="thumbnail" href="static/edinburgh.jpg"/>                        
                            </svg>                        
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col p-4 d-flex flex-column position-static">
                            <strong class="d-inline-block mb-2 text-success country">Spain</strong>
                            <h3 class="mb-0 city">Barcelona</h3>
                            <div class="mb-1 text-muted price">$105</div>
                            <p class="card-text mb-auto short-description">Overlooking the Mediterranean Sea, and famous for Gaudí and other Art Nouveau architecture, Barcelona is one of Europe’s trendiest cities.</p>
                            <p class="long-description">Hidden text for storing long description!</p>
                            <p class="image-link">static/barcelona.jpg</p>
                            <button id="7" onclick="popUp(this)" type="button" class="stretched-link button-link" data-toggle="modal" data-target="#exampleModalCenter" aria-expanded="false">View Details</button>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Barcelona" preserveAspectRatio="xMidYMid slice" focusable="false">
                                <image class="thumbnail" href="static/barcelona.jpg"/>                        
                            </svg>                        
                        </div>
                  </div>
                </div>
            </div>
            
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
                        <form action="">
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
                                    <input type="date" id="date" name="birthday" required> <!--might not work for safari-->
                                </div>
                            </div>
                            <div class="modal-footer form-group">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary cartButton">Add to Cart</button>
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
