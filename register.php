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
                    <div class="col-6 signup">
                        <h1>Sign Up</h1>
                        <form action="process_register.php" method="post">
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                    <h6 id="emailerror"></h6>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pwd" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm">
                                    <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password">
                                    <h6 id="pwderror"></h6>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-2 col-form-label"> Confirm Password</label>
                                <div class="col-sm" style="margin-top: 13px;">
                                    <input type="password" class="form-control" name="pwd_confirm" id="conpwd" placeholder="Confirm Password">
                                    <h6 id="conpwderror"></h6>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><input type="checkbox" name="agree" required> Agree to <a href="index.php">terms and conditions</a>.</label>
                            </div>
                            <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </section>
        </main>
    </body>
    <?php
    include 'footer.inc.php';
    ?>
</html>