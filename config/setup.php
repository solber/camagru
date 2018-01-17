<?php
	require_once 'database.php';
	
	$sql = file_get_contents('camagru.sql');

	$qr = $pdo->exec($sql);
	if (session_status() == PHP_SESSION_NONE) { session_start(); } 
	if (isset($_SESSION['auth']))
		unset($_SESSION['auth']);
	$_SESSION['flash']['success'] = "Database set.";
	header('Location: ../index.php');
?>