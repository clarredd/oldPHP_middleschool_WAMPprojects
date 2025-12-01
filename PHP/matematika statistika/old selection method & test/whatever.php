<?php
	if(array_key_exists("plain",$_GET))
		header("Content-type:text/plain;");
	
	//echo file_get_contents("https://tryphp.w3schools.com/showphp.php?filename=demo_global_server");
	//echo urlencode(file_get_contents("https://tryphp.w3schools.com/showphp.php?filename=demo_global_server"));
	
	echo file_get_contents($_GET["url"]);
?>