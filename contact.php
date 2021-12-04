<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include 'header.inc.php';
        ?>
        <title>Contact Us</title>
    </head>
    <body>
        <?php
        include "nav.inc.php";
        ?>
        <header class="contactheader">
            <div class="contacttext-box">
                <h1>Contact Us</h1>
            </div>
        </header>
        <main class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-9 mx-auto">
                    <div class="card flex-row my-5 border-0 shadow rounded-3">
                        <div class="card-body p-4 p-sm-5">
                            <h2 class="card-title text-center mb-5 fw-light fs-5">Contact Us</h2>
                            <form action="process_contact.php" method="post">
                                <div class="form-group mb-3">
                                    <label for="email">Email</label>
                                    <input class="form-control" type="email" id="email"               
                                           name="email" required placeholder="Enter email" 
                                           maxlength="45">
                                    <h6 id="emailerror"></h6>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Name</label>
                                    <input class="form-control" type="text" id="name"               
                                           name="name" placeholder="Enter your name" 
                                           maxlength="45">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="subject">Subject</label>
                                    <input class="form-control" id="subject"               
                                           name="subject" required placeholder="Subject" 
                                           maxlength="45">
                                </div>
                                <div class="form-group">
                                    <label for="message">Feedback</label>
                                    <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                                </div>
                                <div class="d-grid mb-2 mx-auto">
                                    <button class="btn btn-lg btn-primary " type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mx-auto">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6">
                        <h2>You can find us at:</h2>
                        <p>Address: 10 Dover Dr, Singapore 138683</p>
                        <p>Our Contact number: 6592 1189</p>
                        <h2>Our Opening Hours:</h2>
                        <p>Monday to Saturday: 08.30 AM to 6 PM</p>
                    </div>
                    <div class="col-lg-6">
                        <iframe width="400" height="300" id="gmap_canvas" src="https://maps.google.com/maps?q=Singapore%20Institute%20of%20Technology&t=k&z=17&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php
    include 'footer.inc.php';
    ?>
</body>
</html>