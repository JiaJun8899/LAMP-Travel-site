<nav class="navbar sticky-top navbar-expand-sm navbar-custom">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <a class="navbar-brand" href="index.php">
            <img src="static/logo_yellow.png" width="50" height="50" alt="">
        </a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="about.php">About us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="tour_packages.php">Tour Package</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact Us</a>
            </li>
        </ul>
        <?php
        if ($_SESSION["user"] == NULL) {
            echo
            '<ul class="navbar-nav ml-auto">'
            . '<li class="nav-item">'
            . '<a class="nav-link" href="register.php">'
            . '<span class="material-icons">account_circle</span>Register'
            . '</a>'
            . '</li>'
            . '<li class="nav-item">'
            . '<a class="nav-link" title="Log In" href="login.php">'
            . '<span class="material-icons">login</span>Login'
            . '</a>'
            . '</li>'
            . '</ul>';
        } else {
            echo '<ul class = "navbar-nav ml-auto">';
            echo '<li class="nav-item">';
            echo '<a class="nav-link" href="cart.php">'
            . '<span class="material-icons">shopping_cart</span>Cart'
            . '</a>';
            echo '</li>';
            echo '<li class = "nav-item">';
            if ($_SESSION["user"] == "admin@admin.com") {
                echo '<a class="nav-link" href="admin.php">';
            } else {
                echo '<a class= "nav-link" href="profile.php">';
            }
            echo '<span class="material-icons">account_circle</span>Profile'
            . '</a>'
            . '</li>';
            echo '<li class ="nav-item">'
            . '<a class="nav-link" href="logout.php">Logout'
            . '</a>'
            . '</li>'
            . '</ul>';
        }
        ?>
    </div>
</nav>