<?php require 'required/header.php'; require 'required/functions.php'; iConnected();

	if(!empty($_POST))
	{
		if(!empty($_POST['username']))
		{
			require_once 'required/database.php';
			require_once 'required/functions.php';
		    $req = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");

		    $rnd = str_random(10);
		    $password = password_hash($rnd, PASSWORD_BCRYPT);
		    $req->execute([$password, $_POST['username']]);

		    $req = $pdo->prepare("SELECT * FROM users WHERE username = :username AND verified = 'Y'");
        	$req->execute(['username' => $_POST['username']]);
        	$user = $req->fetch();

        	if($user){
        		send_mail($user->mail, "Account modification", "Hi, there is your new password :\n" .$rnd);	
        		$_SESSION['flash']['success'] = "SUCCESS - An email has been sent !";
		    	header('Location: login.php');
		    	exit();
        	}   
        	else
        	{
        		$_SESSION['flash']['danger'] = "Invalid username !";
		    	header('Location: reset.php');
		    	exit();
        	}
		}else{
			$_SESSION['flash']['danger'] = "ERROR - please fill all field !";
	   		header('Location: reset.php');
	   		exit();
		}
	}   
?>

<div class="content">
      <div class="container">

      	<center><h1>Reset password</h1></center>
      	<form method="POST">
	      	<div>
	      		<input class="input-register username-login" type="text" name="username" placeholder="Username...">
	      	</div>
	      	<br>
	      	<center><button type="submit">Reset</button></center>
	    </form>
      </div>
    </div>
  </body>
</html>