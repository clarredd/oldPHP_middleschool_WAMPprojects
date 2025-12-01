<?php
	require "utils.php";

	if(empty(trim($_GET["filename"]))){//trim() removes all space characters
		echo "NO NAME TO ASSIGN ¯\_(ツ)_/¯ ";
		echo "<br><br><br><a href='dash.php'>Try again</a>";
		exit;
	}
	
	require "json_library.php";
	
	$data=json_get_arr("queries.json");
	if(in_array(trim($_GET["filename"]),iter_func_on('trim',array_keys($data)))){
		echo "NAME ALREADY TAKEN :(";
		echo "<br><br><br><a href='dash.php'>Try again</a>";
		exit;
	}
	//$data[$_GET["filename"]]=array("depth" => 0,"type" => "none", "value" => "undefined");
	//$data[$_GET["filename"]]=array(array("depth" => 0,"type" => "none", "value" => "undefined"));
	$data[$_GET["filename"]]=array();
	json_write("queries.json",$data);
	echo "OPERATION SUCCESS!";
	echo "<script>location.replace('dash.php');</script>";
?>