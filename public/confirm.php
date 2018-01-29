<?php require 'required/header.php'; require 'required/functions.php'; iConnected();

$user_id = $_GET['id'];
$token = $_GET['token'];

require_once 'required/database.php';

$req = $pdo->prepare('SELECT * FROM users WHERE id = ?');

if ($req->execute([$user_id]))
{
	$user = $req->fetch();
}
else
{
	put_flash('danger', "Error while querying the DB.", "/index.php");
}

if ($user->verified == 'N')
{
	if($user && $user->token == $token)
	{
		$req = $pdo->prepare("UPDATE users SET verified = 'Y' WHERE id = ?");

		if ($req->execute([$user_id]))
		{
			$_SESSION['auth'] = $user;
			put_flash('success', "Account verified successfully !", "/index.php");
		}
		else
		{
			put_flash('danger', "Error while querying the DB.", "/index.php");
		}
	}else{
		put_flash('danger', "Can't confirm this account.", "/index.php");
	}
}
else
{
	put_flash('danger', "Can't confirm yet.", "/index.php");
}

?>