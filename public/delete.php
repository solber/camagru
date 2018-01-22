<?php require 'required/header.php'; require 'required/functions.php'; iNotConnected();
	require_once 'required/database.php';

	$img_id = $_GET['img_id'];

	if(!is_numeric($img_id))
	{
		$_SESSION['flash']['danger'] = "Invalid ID.";
		header('Location: index.php');
		exit();
	}

	$req = $pdo->query('SELECT * FROM images WHERE id = ' .intval($img_id));
	$info = $req->fetch();

	$res = split('/', $info->img_path)[3];
	unlink('img/user/' .$_SESSION['auth']->id .'/' .$res);

	$pdo->query('DELETE FROM images WHERE id = ' .intval($img_id));
	$pdo->query('DELETE FROM likes WHERE img_id = ' .intval($img_id));
	$pdo->query('DELETE FROM comments WHERE img_id = ' .intval($img_id));
	
	$_SESSION['flash']['info'] = "Image deleted";
	header('Location: index.php');
	exit();
?>