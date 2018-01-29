<?php require 'required/header.php'; require 'required/functions.php'; iNotConnected();
	require_once 'required/database.php';

	if (!isset($_GET) || !isset($_GET['img_id']))
		put_flash('danger', "Invalid ID", "/index.php");
	$img_id = $_GET['img_id'];

	if(!is_numeric($img_id))
		put_flash('danger', "Invalid ID", "/index.php");

	if ($req = $pdo->query('SELECT * FROM images WHERE id = ' .intval($img_id)))
	{
		$info = $req->fetch();
	}
	else
	{
		put_flash('danger', "Error while querying the DB.", "/index.php");
	}

	$res = split('/', $info->img_path)[3];
	unlink('img/user/' .$_SESSION['auth']->id .'/' .$res);

	if (!$pdo->query('DELETE FROM images WHERE id = ' .intval($img_id)))
		put_flash('danger', "Error while querying the DB.", "/index.php");
	if (!$pdo->query('DELETE FROM likes WHERE img_id = ' .intval($img_id)))
		put_flash('danger', "Error while querying the DB.", "/index.php");
	if (!$pdo->query('DELETE FROM comments WHERE img_id = ' .intval($img_id)))
		put_flash('danger', "Error while querying the DB.", "/index.php");
	
	put_flash('info', "Image deleted successfully.", "/index.php");
?>