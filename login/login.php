<?php
include('api/db.php');
session_start();
$error = '';
if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "Username or Password is invalid";
    } else {
        $username   = $_POST['username'];
        $password   = $_POST['password'];
        // connexion
        $connexion = getConnection();
        // To protect MySQL injection for Security purpose
        $username   = stripslashes($username);
        $password   = stripslashes($password);
        //$username   = $connection->real_escape_string($username);
        //$password   = $connection->real_escape_string($password);
        // SQL query to fetch information of registerd users and finds user match.

 $stmt = $connexion->prepare("select * from login where password=? AND username=?");
    $stmt->execute(array($password, $username));


		$rows = $stmt->rowCount();

        //$query      = mysql_query("select * from login where password='$password' AND username='$username'", $connection);
        //$rows       = mysql_num_rows($query);
        if ($rows == 1) {
            $_SESSION['login_user'] = $username; // Initializing Session
            header("location: home.php"); // Redirecting To Other Page
        } else {
            $error = "Username or Password is invalid";
        }
        unset($connexion);  // Closing Connection
    }
}
?>