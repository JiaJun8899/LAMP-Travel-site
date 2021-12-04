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
        include "nav.inc.php";
        ?>
        <main class="mx-auto registerpage overflow-hidden">
            <section class="row">
                <div class="col-lg-10 col-xl-9 mx-auto">
                    <div class="card flex-row my-5 border-0 shadow rounded-3">
                        <div class="card-body p-4 p-sm-5">
                            <h1 class="card-title text-center mb-5 fw-light fs-5">Sign up with us!</h1>
                            <form action="process_register.php" method="post">
                                <div class="form-group row mt-3">
                                    <div class="col-md form-group rounded">
                                        <label for="fname" class="labels">First Name</label>
                                        <input required type="text" class="form-control" name="fname" id="fname" placeholder="First Name">
                                    </div>
                                    <div class="col-md form-group rounded">
                                        <label class="labels">Last Name</label>
                                        <input required type="text" class="form-control" name="lname" id="lname" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phone" class="col-sm col-form-label">Phone Number</label>
                                    <div class="col-sm">
                                        <input required type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number">
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email" class="col-sm col-form-label">Email</label>
                                    <div class="col-sm">
                                        <input required type="email" class="form-control" id="email" name="email" placeholder="Email">
                                        <h6 id="emailerror"></h6>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="pwd" class="col-sm col-form-label">Password</label>
                                    <div class="col-sm">
                                        <input required type="password" class="form-control" id="pwd" name="pwd" placeholder="Password">
                                        <small id="passwordHelpBlock" class="form-text text-muted">
                                            Your password must be at 8-20 characters long, contain letters, uppercase and lowercase letters, numbers, and a special characters.
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="conpwd" class="col-sm col-form-label"> Confirm Password</label>
                                    <div class="col-sm" style="margin-top: 13px;">
                                        <input required type="password" class="form-control" name="pwd_confirm" id="conpwd" placeholder="Confirm Password">
                                        <h6 id="conpwderror"></h6>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><input type="checkbox" name="agree" required> Agree to <a href="index.php" target="_blank">terms and conditions</a>.</label>
                                </div>
                                <button id="regibtn" class="btn btn-primary mb-1" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <?php
        include 'footer.inc.php';
        ?>
    </body>
</html>