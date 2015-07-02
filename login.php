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

        $stmt = $connexion->prepare("select * from login where password=? AND username=?");
        $stmt->execute(array($password, $username));
		$rows = $stmt->rowCount();

        if ($rows == 1) {
            $_SESSION['login_user'] = $username;
            header("location: home.php");
        } else {
            $error = "Username or Password is invalid";
        }
        unset($connexion);
    }
}
?>