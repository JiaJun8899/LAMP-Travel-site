<?php
session_start();
if($_SESSION["errormsg"]!=NULL){
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
        <header class="header">
            <div class="text-box">
                <h1>Your adventure begins in Europe</h1>
                <p>Making your own adventure is as easy as 1,2,3</p>
                <a href='' class='hero-btn'>Visit us to know more</a>
            </div>
        </header>
        <main>
            <section class="standard">
                <h1>Our story</h1>
                <p>Our company was founded by 5 friend's love of Europe and their rich culture</p>
                <a href='' class='hero-btn'>Find out more</a>
            </section>
            <section class="standard">
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
            <section class="standard">
                <h1>Popular Destinations</h1>
                <p>These popular Destinations will never leave you disapointed</p>
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
            <section class="standard">
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
        </main>
    </body>
<?php
include 'footer.inc.php';
?>
</html>
