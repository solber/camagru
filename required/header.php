<?php 
if (session_status() == PHP_SESSION_NONE) { session_start(); } 

?>

<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <title>
      Camagru - wnoth
    </title>
  </head>
  <body>
    <header id="header">
      <div class="container">
        <h1><a href="index.php" style="color: white;">
          Camagru
        </a></h1>
        <nav id="nav">
          <ul>
            <li>
              <a href="index.php">Home</a>
            </li>
            <?php if(isset($_SESSION['auth'])): ?>
              <li>
                <a href="like_list.php">Liked</a>
              </li>
              <li>
                <a href="add_cam.php">Add</a>
              </li>
              <li>
                <a href="account.php">Account</a>
              </li>
              <li>
                <a href="logout.php">Logout</a>
              </li>
            <?php else: ?>
              <li>
                <a href="login.php">Signin</a>
              </li>
              <li>
                <a href="register.php">Signup</a>
              </li>
            <?php endif; ?>
          </ul>
        </nav>
      </div>
      <div class="container">
        <?php require_once "required/flash.php"; ?>
      </div>
    </header>
