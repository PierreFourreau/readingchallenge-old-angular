<?php
	include('api/db.php');
	$connexion = getConnection();
	session_start();

	$user_check=$_SESSION['login_user'];
	$sql = "select username from login where username='$user_check'";    
	$req = $connexion->query($sql);    
	$rows = $req->rowCount();
	$req->closeCursor();

	$sql="select username from login where username='$user_check'";
	$req = $connexion->query($sql);
	$data=$req->fetch(PDO::FETCH_ASSOC); 
	$login_session =$data['username'];

	if(!isset($login_session)){
		unset($connexion);
		header('Location: index.php');
	}
?>