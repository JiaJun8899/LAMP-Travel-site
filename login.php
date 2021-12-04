
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include 'header.inc.php';
        ?>
        <title>Log in</title>
    </head>
    <body>
        <?php
        include "nav.inc.php";
        ?>
        <main class="mx-auto loginpage overflow-hidden">
            <section class="row">
                <div class="col-lg-10 col-xl-9 mx-auto">
                    <div class="card flex-row my-5 border-0 shadow rounded-3">
                        <div class="card-body p-4 p-sm-5">
                            <h1 class="card-title text-center mb-5 fw-light fs-5">Login in</h1>
                            <form action="process_login.php" method="post">
                                <div class="form-group mb-3">
                                    <label for="log_email">Email</label>
                                    <input class="form-control" type="email" id="email"               
                                           name="log_email" required placeholder="Enter email" 
                                           maxlength="45">
                                    <h6 id="emailerror"></h6>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="log_pwd">Password</label>
                                    <input class="form-control" type="password" id="log_pwd"               
                                           name="log_pwd" placeholder="Enter your password" 
                                           maxlength="45">
                                </div>
                                <div class="d-grid mb-2 mx-auto">
                                    <button class="btn btn-lg btn-primary " type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>