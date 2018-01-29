<?php require 'required/header.php'; require 'required/functions.php'; iNotConnected();

	if (!empty($_POST))
	{
		//changing username
		if (isset($_POST['change_username']))
		{
			//verif format username field
			if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']))
				put_flash('danger', "Invalid username. Allowed char : a-z A-Z 0-9", "/account.php");

			//empty username
			if (empty($_POST['username']))
				put_flash('danger', "Fill username field.", "account.php");

			//changing username
			require_once 'required/database.php';
			$req = $pdo->prepare('UPDATE users SET username = ? WHERE id = ?');

			if ($req->execute([$_POST['username'], $_SESSION['auth']->id]))
			{
				$_SESSION['auth']->username = $_POST['username'];
				put_flash('success', "Username changed !", "/account.php");
			}
			else
			{
				put_flash('danger', "Error while querying the DB.", "/account.php");
			}
		}

		//changing email
		if (isset($_POST['change_email']))
		{
			//empty mail
			if (empty($_POST['change_email']))
				put_flash('danger', "Fill email field.", "/account.php");

			//changing mail
			require_once 'required/database.php';
			$req = $pdo->prepare('UPDATE users SET mail = ? WHERE id = ?');
			
			if ($req->execute([$_POST['mail'], $_SESSION['auth']->id]))
			{
				$_SESSION['auth']->mail = $_POST['mail'];
				put_flash('success', "Mail has been changed !", "/account.php");
			}
			else
			{
				put_flash('danger', "Error while querying the DB.", "/account.php");
			}
		}

		//changing password
		if (isset($_POST['change_password']))
		{
			//empty psw
			if (empty($_POST['password']) || empty($_POST['password-repeat']))
				put_flash('danger', "Fill all fields.", "/account.php");

			//matching chqr
			if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['password']) || !preg_match('/^[a-zA-Z0-9]+$/', $_POST['password-repeat']))
				put_flash('danger', "Invalid password. Allowed char : a-z A-Z 0-9", "/account.php");

			//matching siwe
			if (strlen($_POST['password']) < 6 || strlen($_POST['password']) > 10)
				put_flash('danger', "Invalid password size. Minimum 6 Maximum 10.", "/account.php");

			//changing password
			require_once 'required/database.php';
			$req = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
			$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
			
			if ($req->execute([$password, $_SESSION['auth']->id]))
			{
				$_SESSION['auth']->password = $password;
				put_flash('success', "Password has been changed !", "/account.php");
			}
			else
			{
				put_flash('danger', "Error while querying the DB.", "/account.php");
			}
		}

		if (!empty($_POST['mailable']))
		{
			require_once 'required/database.php';
			if ($_POST['mailable'] === "Turn ON mail")
			{
				$req = $pdo->prepare('UPDATE users SET mailable = 1 WHERE id = ?');
				
				if ($req->execute([$_SESSION['auth']->id]))
				{
					$_SESSION['auth']->mailable = 1;
					put_flash('success', "Mail notifications turned ON", "/account.php");
				}
				else
				{
					put_flash('danger', "Error while querying the DB.", "/account.php");
				}
			}
			else if ($_POST['mailable'] === "Turn OFF mail")
			{
				$req = $pdo->prepare('UPDATE users SET mailable = 0 WHERE id = ?');
				
				if ($req->execute([$_SESSION['auth']->id]))
				{
					$_SESSION['auth']->mailable = 0;
					put_flash('success', "Mail notifications turned OFF", "/account.php");
				}
				else
				{
					put_flash('danger', "Error while querying the DB.", "/account.php");
				}
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