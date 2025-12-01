<?php
	var_dump($_GET);
	
	echo "<br><p>TO: go</p><a href='index.html'>back home</a><br></div><a href='stats.php'>to the stats page</a>";

	require "json_library.php";
	
	$pool_structure=json_get("pool_structure.json");
	$data=json_get("stats_data.json");
	
	
?>