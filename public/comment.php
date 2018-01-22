<?php require 'required/header.php'; require 'required/functions.php'; iNotConnected();

	$comment = htmlspecialchars($_POST['comment']);

	if (empty($_POST['img_id']) || empty($_POST['comment']) || !is_numeric($_POST['img_id']))
	{
		$_SESSION['flash']['danger'] = "Invalid informations.";
		header('Location: index.php');
		exit();
	}
	else
	{
		//doign actions here
		$img_id = intval($_POST['img_id']);

		require_once 'required/database.php';
		 require_once 'required/functions.php';

		$req = $pdo->prepare('INSERT INTO comments SET img_id = ?, owner_comment = ?, comment_text = ?');
		$req->execute([$img_id, $_SESSION['auth']->id, $comment]);

		$req = $pdo->prepare('SELECT owner_id FROM images WHERE id = ?');
		$req->execute([$img_id]);
		$userid = $req->fetch();
		if ($userid)
		{
			$req = $pdo->prepare('SELECT mail, mailable FROM users WHERE id = ?');
			$req->execute([$userid->owner_id]);
			$mailto = $req->fetch();
			if ($mailto)
			{
				if ($mailto->mailable)
					send_mail($mailto->mail, "New comment", "Hi, you receive a new comment !\n Comment : $comment");
				header('Location: index.php');
				exit();
			}
			else
			{
				$_SESSION['flash']['danger'] = "User does not exists anymore.";
				header('Location: index.php');
				exit();
			}
		}
		else
		{
			$_SESSION['flash']['danger'] = "Error while sending mail to user.";
			header('Location: index.php');
			exit();
		}
	}
?>