<?php require 'required/header.php'; require 'required/functions.php'; iNotConnected();

	if (!empty($_POST))
	{
		//changing username
		if (isset($_POST['change_username']))
		{
			//verif format username field
			if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']))
			{ 
				$_SESSION['flash']['danger'] = "Invalid username. Allowed char : a-z A-Z 0-9";
				header('Location: account.php');
				exit();
			}

			//empty username
			if (empty($_POST['username']))
			{
				$_SESSION['flash']['danger'] = "Fill username field.";
				header('Location: account.php');
				exit();
			}

			//changing username
			require_once 'required/database.php';
			$req = $pdo->prepare('UPDATE users SET username = ? WHERE id = ?');
			$req->execute([$_POST['username'], $_SESSION['auth']->id]);
			$_SESSION['auth']->username = $_POST['username'];
			$_SESSION['flash']['success'] = "Username changed !";
			header('Location: account.php');
			exit();
		}

		//changing email
		if (isset($_POST['change_email']))
		{
			//empty mail
			if (empty($_POST['change_email']))
			{
				$_SESSION['flash']['danger'] = "Fill email field.";
				header('Location: account.php');
				exit();
			}

			//changing mail
			require_once 'required/database.php';
			$req = $pdo->prepare('UPDATE users SET mail = ? WHERE id = ?');
			$req->execute([$_POST['mail'], $_SESSION['auth']->id]);
			$_SESSION['auth']->mail = $_POST['mail'];
			$_SESSION['flash']['success'] = "Mail changed !";
			header('Location: account.php');
			exit();

		}

		//changing password
		if (isset($_POST['change_password']))
		{
			//empty psw
			if (empty($_POST['password']) || empty($_POST['password-repeat']))
			{
				$_SESSION['flash']['danger'] = "Fill all fields.";
				header('Location: account.php');
				exit();
			}

			//matching chqr
			if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['password']) || !preg_match('/^[a-zA-Z0-9]+$/', $_POST['password-repeat']))
			{ 
				$_SESSION['flash']['danger'] = "Invalid password. Allowed char : a-z A-Z 0-9";
				header('Location: account.php');
				exit();
			}

			//matching siwe
			if (strlen($_POST['password']) < 6 || strlen($_POST['password']) > 10)
			{
				$_SESSION['flash']['danger'] = "Invalid password size. Minimum 6 Maximum 10.";
				header('Location: account.php');
				exit();
			}

			//changing password
			require_once 'required/database.php';
			$req = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
			$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
			$req->execute([$password, $_SESSION['auth']->id]);
			$_SESSION['auth']->password = $password;
			$_SESSION['flash']['success'] = "Password changed !";
			header('Location: account.php');
			exit();
		}

		if (!empty($_POST['mailable']))
		{
			require_once 'required/database.php';
			if ($_POST['mailable'] === "Turn ON mail")
			{
				$req = $pdo->prepare('UPDATE users SET mailable = 1 WHERE id = ?');
				$req->execute([$_SESSION['auth']->id]);
				$_SESSION['auth']->mailable = 1;
				$_SESSION['flash']['success'] = "mail ON !";
				header('Location: account.php');
				exit();
			}
			else if ($_POST['mailable'] === "Turn OFF mail")
			{
				$req = $pdo->prepare('UPDATE users SET mailable = 0 WHERE id = ?');
				$req->execute([$_SESSION['auth']->id]);
				$_SESSION['auth']->mailable = 0;
				$_SESSION['flash']['success'] = "mail OFF !";
				header('Location: account.php');
				exit();
			}
		}
	}
?>

<div class="content">
	<div class="container">
		<div class="box-account" style="height: 370px!important">
			<center><h4><?php echo "Welcome " .$_SESSION['auth']->username ." !"?></h2></center>
			<form method="POST">
				<h4 style="position: relative; left: 5%;">Change username :</h4>
				<input class="input-account" type="text" name="username" placeholder="<?php echo $_SESSION['auth']->username; ?>">
				<input class="btn-account" type="submit" name="change_username" value="Change">
			</form>
			<form method="POST">
				<h4 style="position: relative; left: 5%;">Change E-mail :</h4>
				<input class="input-account" type="email" name="mail" placeholder="<?php echo $_SESSION['auth']->mail; ?>">
				<input class="btn-account" type="submit" name="change_email" value="Change">
			</form>
			<form method="POST">
				<h4 style="position: relative; left: 5%;">Change password :</h4>
				<input class="input-account" type="password" name="password" placeholder="New password">
				<input class="input-account" type="password" name="password-repeat" placeholder="Repeat password">
				<input class="btn-account" type="submit" name="change_password" value="Change">
			</form>
			<br>
			<form method="POST">
				<input name="check" value="check" style="display: none;">
				<?php 
					if($_SESSION['auth']->mailable)
						echo '<input class="btn-account" type="submit" name="mailable" value="Turn OFF mail">';
					else
						echo '<input class="btn-account" type="submit" name="mailable" value="Turn ON mail">';
				?>
			</form>
		</div>
    </div>
</div>
  </body>
</html>