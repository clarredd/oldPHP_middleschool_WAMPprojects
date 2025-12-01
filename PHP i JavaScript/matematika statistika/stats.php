<?php
	require "json_library.php";
	
	$pool_structure=file_read("pool_structure.json");
	$data=file_read("stats_data.json");
	
	$pool_structure=str_replace(array("\n","\t","\""),array("","","'"),$pool_structure);
	$data=str_replace(array("\n"),"",$data);
	
	echo "window.location.replace('stats.html?pool_structure=".$pool_structure."&data=".$data."');";
	
	echo "Data is forwarded to the filter application. ";
	echo "<script>window.location.replace(\"stats.html?pool_structure=".$pool_structure."&data=".$data."\");</script>";
?>