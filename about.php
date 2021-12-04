<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include 'header.inc.php';
        ?>
        <title>About Us</title>
    </head>
    <body>
        <?php
        include "nav.inc.php";
        ?>
        <header class="aboutheader">
            <div class="abouttext-box">
                <h1>About Us</h1>
            </div>
        </header>
        <main>
            <div class="bg-light">
                <section class="py-5 aboutstandard">
                    <h2>Our Motto</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Pellentesque aliquet turpis nulla, eleifend faucibus est
                        sollicitudin ut. Maecenas ut venenatis ex, et dapibus purus
                        Donec sit.</p>
                </section>
            </div>
            <section class="py-5 aboutstandard">
                <h2>Our mission</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Pellentesque aliquet turpis nulla, eleifend faucibus est
                    sollicitudin ut. Maecenas ut venenatis ex, et dapibus purus
                    Donec sit.</p>
            </section>
            <div class="bg-light">
                <section class="py-5 aboutstandard">
                    <h2>Meet the team</h2>
                    <div class= "row justify-content-between">
                        <div class="mtt col">
                            <h3>Chen JiaJun</h3>
                            <p>Student ID: 2101351</p>
                        </div>
                        <div class="mtt col">
                            <h3>Ellynn Teo </h3>
                            <p>Student ID: 2102530</p>
                        </div>
                        <div class="mtt col">
                            <h3>Sam Tay</h3>
                            <p>Student ID: 2100928</p>
                        </div>
                        <div class="mtt col">
                            <h3>Sophie Wong</h3>
                            <p>Student ID: 2102284</p>
                        </div>
                    </div>
                </section>
            </div>
        </main>
        <?php
        include 'footer.inc.php';
        ?>
    </body>
</html>