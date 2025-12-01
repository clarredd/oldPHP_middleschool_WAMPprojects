<?php
	require "json_library.php";
	if(!in_array("new_value_q",array_keys($_GET))){
		echo "NO (SUB)QUESTION SELECTED ¯\_(ツ)_/¯ ";
		echo '<br><br><br><button onclick="history.back();">Try again</button>';
		die;
	}
	if(!(in_array("query_index",array_keys($_GET))&&in_array("block_index",array_keys($_GET)))){
		echo "ESSENTIAL DATA MISSING (X╭╮X) ";
		echo '<br><br><br><button onclick="history.back();">Try again</button>';
		die;
	}
	
	$new_value=$_GET["new_value_q"]."_".$_GET["odgovor_".$_GET["new_value_q"]];
	$query_index=intval($_GET["query_index"]);
	$block_index=intval($_GET["block_index"]);
	
	//var_dump($_SERVER);
	
	$queries=json_get_arr("queries.json");
	$query_name=array_keys($queries)[$query_index];
	$queries[$query_name][$block_index]->value=$new_value;
	
	json_write("queries.json",$queries);
	
	echo "<script>window.location=\"query_board.php?target=".$query_name."\";</script>";
?>