<?php
    include('session.php');
?>
<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <style type="text/css">
        ul>li, a{cursor: pointer;}
        </style>
        <title>Reading challenge administration</title>
    </head>
    <body>
        <div class="navbar navbar-default" id="navbar">
            <div class="container" id="navbar-container">
            <div class="navbar-header">
                <a href="http://pierrefourreau.fr" class="navbar-brand">
                    <small>
                        Reading Challenge administration by Pierre Fourreau
                    </small>
                </a>
                <a href="#" class="navbar-brand">
                    <small>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        Welcome <i><?php echo $login_session; ?></i>
                    </small>
                </a>
                <a href="logout.php" class="navbar-brand">
                    <small>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <i class="glyphicon glyphicon-log-out"></i>
                        Log Out
                    </small>
                </a>
            </div>
            </div>
        </div>

        <div>
            <div class="container">
                <br/>
                <blockquote>
                    <h4>
                        Administration of the reading challenge data
                    </h4>
                </blockquote>
                <br/>
                <div ng-view="" id="ng-view"></div>
                   
            </div>
        </div>

        <script src="js/angular.min.js"></script>
        <script src="js/angular-route.min.js"></script>
        <script src="app/app.js"></script>    

    </body>
</html>