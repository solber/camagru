<?php
	if (!empty($_POST))
	{
		require_once 'required/functions.php';

		if (session_status() == PHP_SESSION_NONE) { session_start(); } 
		$timezone = time() .str_random(10);
		define('UPLOAD_DIR', 'img/tmp/' .$_SESSION['auth']->id .'/');
		define('USER_DIR', 'img/user/' .$_SESSION['auth']->id .'/');

		$img = $_POST['img'];
		$nb = $_POST['nb'];
		$mask = $_POST['mask'];

		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace('data:image/PNG;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = UPLOAD_DIR . $nb . '.png';
		$success = file_put_contents($file, $data);
		print $success ? $file : 'Unable to save the file.';

		$logo=ImageCreateFromPNG("img/filter/" .$mask .".png");
		$back=ImageCreateFromPNG(UPLOAD_DIR . $nb . '.png');
		ImageCopy($back, $logo, 5, 5, 0, 0, 512, 512);
		header("content-type: image/png" );  
		unlink(UPLOAD_DIR . $nb . '.png');
		ImagePNG($back, UPLOAD_DIR . 'result' .$nb .'.png');  
		ImagePNG($back, USER_DIR .$timezone .'.png'); 
		require_once 'required/database.php';

		if (!$pdo->query('INSERT INTO images SET img_path = "' .USER_DIR .$timezone . '.png' .'", owner_id = ' .$_SESSION['auth']->id))
			put_flash('danger', "Error while querying the DB.", "/index.php");
	}
?>