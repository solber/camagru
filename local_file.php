<?php require_once 'required/header.php'; 

	if (!isset($_SESSION['auth'])) 
	{
		$_SESSION['flash']['danger'] = "You cannot acces this page.";
		header('Location: index.php');
		exit();
	}

	$uploadfile = "";
	if (!empty($_POST))
	{

		if ($_FILES['mon_fichier']['error'] > 0)
		{
			$_SESSION['flash']['danger'] = "Error while uploqding.";
			header('Location: local_file.php');
			exit();
		}

		if ($_FILES['mon_fichier']['size'] > intval($_POST['MAX_FILE_SIZE']))
		{
			$_SESSION['flash']['danger'] = "File too big.";
			header('Location: local_file.php');
			exit();
		}

		$extensions_valides = array('png');

		$extension_upload = strtolower(substr(strrchr($_FILES['mon_fichier']['name'], '.'), 1));
		if (!(in_array($extension_upload,$extensions_valides)))
		{
			$_SESSION['flash']['danger'] = "Wrong extension.";
			header('Location: local_file.php');
			exit();
		}

		require_once 'required/functions.php';

		$uploaddir = 'img/tmp/' .$_SESSION['auth']->id;

		if (!is_dir($uploaddir))
			mkdir($uploaddir, 0777);

		$uploadfile = $uploaddir ."/" .basename($_FILES['mon_fichier']['name']);

		if (file_exists($uploadfile))
			unlink($uploadfile);

		if (move_uploaded_file($_FILES['mon_fichier']['tmp_name'], $uploadfile)) {
		    $path = $uploadfile;
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$data = file_get_contents($path);
			$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
			rename($uploadfile, "img/tmp/" .$_SESSION['auth']->id ."/result1.png");
		} else {
			$_SESSION['flash']['danger'] = "Error while uploqding.";
			header('Location: local_file.php');
			exit();
		}

	}

?>
	<link rel="stylesheet" type="text/css" href="css/list.css">

	<div class="content">
		<div class="container">
			<?php if(empty($_POST)) { ?>
				<center><h1>No file selected</h1></center>
					<center>
					<form method="POST" action="local_file.php" enctype="multipart/form-data">
					     <label for="icone">File (PNG | 5 Mo) :</label> 
					     <input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
					     <input type="file" name="mon_fichier" id="mon_fichier" /><br><br>
					     <input class="btn-commenta" type="submit" name="submit" value="Upload" />
					</form><br>
					</center>
			<?php }else{ ?>
				<br><br>
				<center>
					<img class="imgmask" id="mask" src="" alt="">
					<img src="<?php echo "img/tmp/" .$_SESSION['auth']->id ."/result1.png"; ?>" width="35%">
					<form method="POST">
					  <img src="img/filter/cadre.png" width="5%" onclick="cadre_fnc();">
					  <img src="img/filter/moon.png" width="5%" onclick="moon_fnc();">
					  <img src="img/filter/mlg.png" width="5%" onclick="mlg_fnc();"><br>
					</form>
					<br>
					<input type="submit" class="btn-commenta" id="snap" value="Snap" onclick="save_img();" disabled>
				</center>
			<?php } ?>
				<!--
				<form method="POST">
				  <img src="img/filter/cadre.png" width="5%" onclick="cadre_fnc();">
				  <img src="img/filter/moon.png" width="5%" onclick="moon_fnc();">
				  <img src="img/filter/mlg.png" width="5%" onclick="mlg_fnc();"><br>
				</form>
				<br>
				<br>
				<label id="selec">Selected :</label>
				<br>
				<input type="submit" class="btn-commenta" id="snap" value="Snap" onclick="save_img();" disabled>
				</center>
				-->
		</div>
	</div>
	<script type="text/javascript">
		var selected_mask = "";
		function save_img()
		{
			var nb = 1;
			var myimg = "<?= $base64 ?>";
			$.ajax({
		        url: 'test.php',
		        type: 'POST',
		        data: {
		            img: myimg,
		            nb: nb,
		            mask: selected_mask,
		        },
		        success: function(data) {
		        	alert('success');
		        }
		    });
		}
	</script>
	<script>
		function cadre_fnc()
		{
			selected_mask = "cadre";
			document.getElementById("snap").disabled = false;
			document.getElementById("mask").src="img/filter/cadre.png";
		}
		function moon_fnc()
		{
			selected_mask = "moon";	
			document.getElementById("snap").disabled = false;
			document.getElementById("mask").src="img/filter/moon.png";
		}
		function mlg_fnc()
		{
			selected_mask = "mlg";
			document.getElementById("snap").disabled = false;
			document.getElementById("mask").src="img/filter/mlg.png";
		}
	</script>
  </body>
</html>