<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include 'header.inc.php';
        ?>
        <title>My Profile</title>
    </head>
    <body class="registerpage">
        <?php
        include "nav.inc.php";
        ?>
        <main class="container">
            <div class="container rounded">
                <div class="row justify-content-center">
                    <div class="col-5 bg-white">
                        <div class="p-3 py-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right">Profile Settings</h4>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label class="labels">Name</label>
                                    <input type="text" class="form-control" placeholder="first name" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">Surname</label>
                                    <input type="text" class="form-control" value="" placeholder="surname">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="labels">PhoneNumber</label>
                                    <input type="text" class="form-control" placeholder="enter phone number" value="">
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Address</label>
                                    <input type="text" class="form-control" placeholder="enter address" value="">
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Email ID</label>
                                    <input type="text" class="form-control" placeholder="enter email id" value="">
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Education</label>
                                    <input type="text" class="form-control" placeholder="education" value="">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="labels">Country</label>
                                    <input type="text" class="form-control" placeholder="country" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">State/Region</label>
                                    <input type="text" class="form-control" value="" placeholder="state">
                                </div>
                            </div>
                            <div class="mt-5 text-center">
                                <button class="btn btn-primary profile-button" type="button">Save Profile</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
    <?php
    include 'footer.inc.php';
    ?>
</html>