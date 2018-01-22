<?php require 'required/header.php'; require 'required/functions.php'; iNotConnected(); ?>
    <div class="content">
    	<div class="container">
    		<?php
    			require_once 'required/database.php';
    			$req = $pdo->prepare('SELECT * FROM likes WHERE owner_like_id = ?');
    			$req->execute([$_SESSION['auth']->id]);
    			$result = $req->fetchall();
    			if ($result)
    			{
    				foreach ($result as $key) {
    					$req = $pdo->prepare('SELECT * FROM images WHERE id = ?');
    					$req->execute([$key->img_id]);
    					$img = $req->fetch();
    					$req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    					$req->execute([$img->owner_id]);
    					$name = $req->fetch();

    					echo '<center><p>You liked image of : '.$name->username .' <img src="' .$img->img_path .'" width="5%" style="position: relative; top: 20px"></p></center>';
    				}
    			}

    		?>
    	</div>
    </div>