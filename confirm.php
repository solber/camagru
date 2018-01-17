<?php

if (session_status() == PHP_SESSION_NONE) { session_start(); }
if (isset($_SESSION['auth'])) 
{
	$_SESSION['flash']['danger'] = "You cannot acces this page.";
	header('Location: index.php');
	exit();
}

$user_id = $_GET['id'];
$token = $_GET['token'];

require_once 'required/database.php';

$req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$req->execute([$user_id]);
$user = $req->fetch();

if ($user->verified == 'N')
{
	if($user && $user->token == $token){
		

		$req = $pdo->prepare("UPDATE users SET verified = 'Y' WHERE id = ?")->execute([$user_id]);

		$_SESSION['flash']['success'] = "Account verified successfully !";
		$_SESSION['auth'] = $user;
		header('Location: index.php');
		exit();

	}else{
		$_SESSION['flash']['danger'] = "Invalid token";
		header('Location: index.php');
		exit();
	}
}
else
{
	$_SESSION['flash']['danger'] = "Account already verified !";
	header('Location: index.php');
	exit();
}

?>