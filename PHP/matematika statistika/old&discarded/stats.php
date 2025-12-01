<?php
	/*
	echo chr(ord("ž"));
	echo "ž";
	exit;
	*/

	require "json_library.php";
	
	$pool_structure=file_read("pool_structure.json");
	$data=file_read("stats_data.json");
	
	$pool_structure=str_replace(array("\n","\r","\t"),array("","",""),$pool_structure);
	$data=str_replace(array("\n","\r"),array("",""),$data);
	
	echo "window.location.replace('stats.html?pool_structure=".$pool_structure."&data=".$data."');";
	
	echo "<br><br>";
	echo "Data is forwarded to the filter application. ";
	
	echo "<script>window.location.replace('stats.html?pool_structure=".$pool_structure."&data=".$data."');</script>";
	
	exit;
	
	echo "<br><br>";
	for($index=800;$index<=820;$index++)
		echo $pool_structure[$index];
	
	//echo substr($pool_structure,800,20);
	
	//Months later I added removal of \r (not sure it was needed) and replaced ' with " in the <script> tag because JSON was saying that ' is  not a valid token. 
?>