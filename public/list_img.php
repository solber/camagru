<ul>
<?php
	if (session_status() == PHP_SESSION_NONE) { session_start(); } 
	$img_dir = "img/tmp/" .$_SESSION['auth']->id ."/";

	$images = scandir($img_dir);

	$html = '';
	foreach($images as $img) 	{ 
			if($img === '.' || $img === '..') {continue;} 		

				if (  (preg_match('/.jpg/',$img))  ||  (preg_match('/.gif/',$img)) || (preg_match('/.tiff/',$img)) || (preg_match('/.png/',$img)) ) {				

				 $html .='<li><img src="'.$img_dir.$img.'" width="10%"></li>' ; 
				} else { continue; }	
		} 

	echo $html ;

?>
</ul>
