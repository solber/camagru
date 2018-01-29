<?php require 'required/header.php'; require 'required/functions.php'; iNotConnected();

	$img_id = intval($_POST['img_id']);

	if (empty($img_id))
	{
		put_flash('danger', "No ID refered.", "/index.php");
	}
	else
	{

		if (!is_numeric($img_id))
			put_flash('danger', "Wrong ID.", "/index.php");

		$img_id = intval($img_id);
		$owner_like = intval($owner_like);

		require_once 'required/database.php';

		$req = $pdo->prepare("SELECT * FROM likes WHERE img_id = :id AND owner_like_id = :own");
        if ($req->execute(['id' => $img_id, 'own' => $_SESSION['auth']->id]))
        {
        	$user = $req->fetch();
        }
        else
        {
        	put_flash('danger', "Error while querying the DB.", "/index.php");
        }
        if($user)
        {
        	$req = $pdo->prepare('DELETE FROM likes WHERE img_id = :id AND owner_like_id = :own');
        	if ($req->execute(['id' => $img_id, 'own' => $_SESSION['auth']->id]))
        	{
        		header('Location: index.php');
				exit();
        	}
        	else
	        {
	        	put_flash('danger', "Error while querying the DB.", "/index.php");
	        }	
        }
        else
        {
        	if ($pdo->query('INSERT INTO likes SET img_id = ' .$img_id .',owner_like_id = ' .intval($_SESSION['auth']->id)))
        	{
        		header('Location: index.php');
				exit();
        	}
        	else
	        {
	        	put_flash('danger', "Error while querying the DB.", "/index.php");
	        }
        }
	}
?>