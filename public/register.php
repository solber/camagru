<?php require 'required/header.php'; require 'required/functions.php'; iConnected();

	if (!empty($_POST))
	{
		if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password-repeat']))
		{
			$_SESSION['flash']['danger'] = "Please fill all fields.";
			header('Location: register.php');
			exit();
		}

		if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']))
		{ 
			$_SESSION['flash']['danger'] = "Invalid username. Allowed char : a-z A-Z 0-9";
			header('Location: register.php');
			exit();
		}

		if ($_POST['password'] != $_POST['password-repeat'])
		{
			$_SESSION['flash']['danger'] = "Password must be the same.";
			header('Location: register.php');
			exit();
		}

		if (strlen($_POST['password']) < 6 || strlen($_POST['password']) > 10)
		{
			$_SESSION['flash']['danger'] = "Invalid password size. Minimum 6 Maximum 10.";
			header('Location: register.php');
			exit();
		}

		//Verify user
		require_once 'required/database.php';
        $req = $pdo->prepare('SELECT id FROM users WHERE username = ?');
        
        if (!$req->execute([$_POST['username']]))
          put_flash('danger', "Error while querying the DB.", "/index.php");
        $user = $req->fetch();
        if($user)
        {
        	$_SESSION['flash']['danger'] = "Username already taken.";
			header('Location: register.php');
			exit();
        }

        //Verify mail
        require_once 'required/database.php';
        $req = $pdo->prepare('SELECT id FROM users WHERE mail = ?');
      
        if (!$req->execute([$_POST['email']]))
          put_flash('danger', "Error while querying the DB.", "/index.php");
        $user = $req->fetch();
        if($user)
        {
        	$_SESSION['flash']['danger'] = "Email already taken.";
			header('Location: register.php');
			exit();
        }

        //register user
        require_once 'required/database.php';
        try
        {
	        $req = $pdo->prepare("INSERT INTO users SET username = ?, password = ?, mail = ?, token = ?");
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $token = str_random(60);
           	
            if (!$req->execute([$_POST['username'], $password, $_POST['email'], $token]))
              put_flash('danger', "Error while querying the DB.", "/index.php");

           	$user_id = $pdo->lastinsertid();

           	send_mail($_POST['email'], "Account confirmation", "Hi, please click on this link to validate your account : \n\nhttp://localhost/confirm.php?id=$user_id&token=$token");

           	mkdir('img/user/' .$user_id, 0777);
           	$_SESSION['flash']['success'] = "SUCCESS - Confirmation email has been sent !";
           	header('Location: login.php');
            exit();
        }
        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
	}
?>

 <div class="content">
      <div class="container">
      	<div class="box-account">
      	<center><h1>Register</h1></center>
      	<form method="POST">
      		<center>
	      		<input type="text" name="username" placeholder="Username..." style="width: 250px"><br>
		   		<input type="email" name="email" placeholder="example@mail.fr..." style="width: 250px"><br>
		   		<input type="password" name="password" placeholder="Password..." style="width: 250px"><br>
		      	<input type="password" name="password-repeat" placeholder="Password repeat..." style="width: 250px">
	     	</center>
	      	<br><br>
	      	<center><input class="btn-account" type="submit" name="register" value="Register" style="left: 0px"></center>
	    </form>
      </div>
    </div>
  </body>
</html>