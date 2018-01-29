<?php require 'required/header.php'; require 'required/functions.php'; iConnected();

	if (!empty($_POST))
	{
		if(empty($_POST['username']) && empty($_POST['password'])){
        $_SESSION['flash']['danger'] = "Please fill all field !"; 
        header('Location: login.php');
        exit();
	    }
	    if(empty($_POST['username'])){
	        $_SESSION['flash']['danger'] = "Please fill username field."; 
	        header('Location: login.php');
	        exit();
	    }
	    if(empty($_POST['password'])){
	        $_SESSION['flash']['danger'] = "Please fill password field."; 
	        header('Location: login.php');
	        exit();
	    }

	     require_once 'required/database.php';
        $req = $pdo->prepare("SELECT * FROM users WHERE username = :username AND verified = 'Y'");
        
        if (!$req->execute(['username' => $_POST['username']]))
        	put_flash('danger', "Error while querying the DB.", "/index.php");
        $user = $req->fetch();

        if(password_verify($_POST['password'], $user->password)){

            $_SESSION['auth'] = $user;
            $_SESSION['flash']['success'] = "Connexion réussie !";
            //var_dump($_SESSION);
            header('Location: index.php');
            exit();

        }else{

            $_SESSION['flash']['danger'] = "Invalid username or password !";
            header('Location: login.php');
            exit();

        }
	}
?>
<div class="content">
      <div class="container">
      	<div class="box-account">
      		<center>
      		<h1>Login</h1>
	      	<form method="POST">
		      	<input type="text" name="username" style="width: 250px" placeholder="Username...">
		      	<br>
		      	<input type="password" name="password" style="width: 250px" placeholder="Password...">
		      	<br><br>
		      	<input class="btn-account" type="submit" name="login" value="Login" style="left: 0px">
		      	<br>
		      	<a href="reset.php">Forgot password ?</a>
		    </form>
		</center>
	    </div>
      </div>
    </div>
  </body>
</html>