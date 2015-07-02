<?php
include('login.php');

if(isset($_SESSION['login_user'])){
header("location: home.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Reading challenge login</title>
        <meta charset="utf-8">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="js/login.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="container" id="formContainer">
                    <form class="form-signin" id="login" role="form" method="post">
                        <h3 class="form-signin-heading">Please sign in</h3>
                        <input type="email" class="form-control" name="username" id="loginEmail" placeholder="Email address" required autofocus>
                        <input type="password" class="form-control" name="password" id="loginPass" placeholder="Password" required>
                        <input class="btn btn-lg btn-primary btn-block" name="submit" type="submit" value=" Sign in ">
                        <?php echo $error; ?>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>