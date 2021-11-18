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
        <main class="container">
            <h1>Member Login</h1>
            <p>For new members, please go to the <a href="register.php">registration page</a>.</p>
            <form action="process_login.php" method="post">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input class="form-control" type="email" id="log_email" required maxlength="45" name="log_email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input class="form-control" type="password" id="log_pwd" required maxlength="45" name="log_pwd" placeholder="Enter password">
                </div>
                <button class="btn btn-primary" type="submit">Submit</button>
            </form>
        </main>
        <?php
            include "footer.inc.php";
        ?>
    </body>
</html>