<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include 'header.inc.php';
        ?>
        <title>Travel</title>
    </head>
    <body class="registerpage">
        <?php
        include "nav.inc.php";
        ?>
        <main class="container">
            <section>
                <div class="row justify-content-center">
                    <div class="col-6 signup rounded">
                        <h1>Sign Up</h1>
                        <form action="process_register.php" method="post">
                            <div class="form-group row mt-3">
                                <div class="col-md-6 form-group rounded">
                                    <label for="fname" class="labels">First Name</label>
                                    <input required type="text" class="form-control" name="fname" placeholder="First Name">
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">Last Name</label>
                                    <input required type="text" class="form-control" name="lname" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-sm-2 col-form-label">Phone Number</label>
                                <div class="col-sm">
                                    <input required type="number" class="form-control" id="phone" name="phone" placeholder="Phone Number">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm">
                                    <input required type="email" class="form-control" id="email" name="email" placeholder="Email">
                                    <h6 id="emailerror"></h6>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pwd" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm">
                                    <input required type="password" class="form-control" id="pwd" name="pwd" placeholder="Password">
                                    <small id="passwordHelpBlock" class="form-text text-muted">
                                        Your password must be at 8-20 characters long, contain letters, numbers, and a special characters.
                                    </small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="conpwd" class="col-sm-2 col-form-label"> Confirm Password</label>
                                <div class="col-sm" style="margin-top: 13px;">
                                    <input required type="password" class="form-control" name="pwd_confirm" id="conpwd" placeholder="Confirm Password">
                                    <h6 id="conpwderror"></h6>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><input type="checkbox" name="agree" required> Agree to <a href="index.php" target="_blank">terms and conditions</a>.</label>
                            </div>
                            <button id="regibtn" class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </section>
        </main>
    </body>
    <?php
    include 'footer.inc.php';
    ?>
</html>