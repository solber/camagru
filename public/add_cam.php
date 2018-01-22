<?php require 'required/header.php'; require 'required/functions.php'; iNotConnected();

	$img_dir = "img/tmp/" .$_SESSION['auth']->id ."/";

	require_once 'required/functions.php';
	if (is_dir($img_dir))
		clearDir($img_dir);
	if (!is_dir("img/user/" .$_SESSION['auth']->id ."/"))
		mkdir("img/user/" .$_SESSION['auth']->id ."/", 0777);
	mkdir($img_dir, 0777);
?>

<link rel="stylesheet" type="text/css" href="css/list.css">

<div class="content">
    <div class="container">
    	<div style="position: relative;">
    		<form method="POST">
			  <input id="cadre" type="radio" name="cqdre" value="cadre" onclick="cadre_fnc();"><img src="img/filter/cadre.png" width="5%" onclick="cadre_fnc();">
			  <input id="moon" type="radio" name="moon" value="moon" onclick="moon_fnc();"><img src="img/filter/moon.png" width="5%" onclick="moon_fnc();">
			  <input id="mlg" type="radio" name="mlg" value="mlg" onclick="mlg_fnc();"><img src="img/filter/mlg.png" width="5%" onclick="mlg_fnc();"><br>
			</form>
			<img id="mask" src="" alt="" style="position: absolute; 
              left: 7%; 
              top: 10%;
              z-index: 2;
              width: 45%;
              height: 85%;
       		">
    		<video id="video" width="60%" height="60%" autoplay></video>
       		<canvas id="canvas" width="512" height="512" style="width: 10%;"></canvas>
       		<br>
       		<input type="submit" class="btn-commenta" id="snap" value="Snap" disabled>
       		<a href="local_file.php"><input class="btn-commenta" type="submit" name="local" value="Local file"></a>

		</div>
		<ul id="menu_horizontal">
			<div name="list"></div>
		</ul>
		
    </div>
</div>
  </body>
</html>

<script>
	var canvas = document.getElementById('canvas');
	var fullquality = canvas.toDataURL('image/png', 1.0);
	var context = canvas.getContext('2d');
	var video = document.getElementById('video');
	var nb = 0;
	var selected_mask = "";

	// Get access to the camera!
	if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
	    // Not adding `{ audio: true }` since we only want video now
	    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
	        video.src = window.URL.createObjectURL(stream);
	        video.play();
	    });
	}

	// Trigger photo take
	document.getElementById("snap").addEventListener("click", function() {
		context.drawImage(video, 0, 0, 512, 512);
		nb++;
		fullquality = canvas.toDataURL('image/png', 1.0);
		save_img();
	});
</script>

<script type="text/javascript">
function save_img()
{
	$.ajax({
        url: 'test.php',
        type: 'POST',
        data: {
            img: fullquality,
            nb: nb,
            mask: selected_mask,
        },
        success: function(data) {
        	jQuery('document').ready(function() {
			      jQuery.ajax({            
			            url: "list_img.php", 
				    type: "POST",          
				    dataType: "HTML", 
			            success: function( data ) { 
			            	jQuery("div[name='list']").empty();
							jQuery("div[name='list']").append(data);
			            },
			            error: function(jqXHR, data ) {        
							alert ('Ajax request Failed.');    
				    	}
					}); 
   			});
        }
    });
}
</script>

<script>
	function cadre_fnc()
	{
		document.getElementById("mask").src="img/filter/cadre.png";
		document.getElementById("snap").disabled = false;
		document.getElementById("cadre").checked = true;
		document.getElementById("moon").checked = false;
		document.getElementById("mlg").checked = false;

		selected_mask = "cadre";
	}
	function moon_fnc()
	{
		document.getElementById("mask").src="img/filter/moon.png";
		document.getElementById("snap").disabled = false;
		document.getElementById("cadre").checked = false;
		document.getElementById("moon").checked = true;
		document.getElementById("mlg").checked = false;

		selected_mask = "moon"	
	}
	function mlg_fnc()
	{
		document.getElementById("mask").src="img/filter/mlg.png";
		document.getElementById("snap").disabled = false;
		document.getElementById("cadre").checked = false;
		document.getElementById("moon").checked = false;
		document.getElementById("mlg").checked = true;

		selected_mask = "mlg"	
	}
</script>