<?php require 'required/header.php'; require 'required/functions.php'; iNotConnected();

	$comment = htmlspecialchars($_POST['comment']);

	if (empty($_POST['img_id']) || empty($_POST['comment']) || !is_numeric($_POST['img_id']))
	{
		put_flash('danger', "Invalid informations.", "/index.php");
	}
	else
	{
		//doign actions here
		$img_id = intval($_POST['img_id']);

		require_once 'required/database.php';

		$req = $pdo->prepare('INSERT INTO comments SET img_id = ?, owner_comment = ?, comment_text = ?');
		
		if (!$req->execute([$img_id, $_SESSION['auth']->id, $comment]))
			put_flash('danger', "Error while querying the DB.", "/index.php");

		$req = $pdo->prepare('SELECT owner_id FROM images WHERE id = ?');
		
		if ($req->execute([$img_id]))
		{
			$userid = $req->fetch();
		}
		else
		{
			put_flash('danger', "Error while querying the DB.", "/index.php");
		}
		if ($userid)
		{
			$req = $pdo->prepare('SELECT mail, mailable FROM users WHERE id = ?');
			
			if ($req->execute([$userid->owner_id]))
			{
				$mailto = $req->fetch();
			}
			else
			{
				put_flash('danger', "Error while querying the DB.", "/index.php");
			}
			if ($mailto)
			{
				if ($mailto->mailable)
					send_mail($mailto->mail, "New comment", "Hi, you receive a new comment !\n Comment : $comment");
				header('Location: /index.php');
				exit();
			}
			else
			{
				put_flash('User does not exists anymore.', "/index.php");
			}
		}
		else
		{
			put_flash('Error while sending mail to user.', "/index.php");
		}
	}
?>