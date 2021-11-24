<?php
session_start();
if($_SESSION["user"]==NULL){
    $_SESSION["errormsg"] = "Please log in first!";
    header("Location: http://35.187.229.58/project/index.php");
    exit();
}
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
                                <h4 class="text-center">Profile Settings</h4>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label class="labels">First Name</label>
                                    <input type="text" class="form-control" placeholder="First Name">
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">Last Name</label>
                                    <input type="text" class="form-control" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="labels">Phone Number</label>
                                    <input type="text" class="form-control" placeholder="Phone Number">
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Address</label>
                                    <input type="text" class="form-control" placeholder="Address">
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Email</label>
                                    <input type="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 form-group rounded">
                                    <label for="country" class="labels">Country</label>
                                    <select id="country" name="country" class="form-control">
                                        <option value="singapore">Singapore</option>
                                        <option value="malaysia">Malaysia</option>
                                        <option value="china">China</option>
                                    </select>
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