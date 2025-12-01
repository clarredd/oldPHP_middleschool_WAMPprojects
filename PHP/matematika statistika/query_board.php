<?php
	require "json_library.php";
	require "table_class.php";
	
	//require "utils.php";//already included in table_class.php , no clue why it hasn't stopped working earlier ;;; the reason a was very confused
	
	/*
	function to_make_new(string $class_name):callable{
		return new ReflectionClass($class_name)->getConstructor();
	}
	*/
	function get_last_elem(array $arr){
		return $arr[count($arr)-1];
	}
	
	$query=json_get_arr("queries.json")[$_GET["target"]];
	$THIS=$_GET["target"];
	
	$queries=json_get_arr("queries.json");
	$query_index=array_search($THIS,array_keys($queries));
	const form_start='<form action="query_action.php">';
	
	echo '
		<!DOCTYPE html>
		<html>
			<head>
				<title>QUERY_BOARD FOR \''.$THIS.'\'</title>
				<!--style>
					body,input:not([disabled])/*[type]:not([type="number"])*/{
						/*
						background-color: #00aaaa;
						color: #ffff00;
						*/
						background-color: khaki;
						color: brown;
					}
					input:hover:not([disabled]):not(:focus),summary:hover{
						cursor: pointer;
					}
					label{
						cursor: text;
					}
					body{
						/*cursor: url(myBall.cur),auto;*/
						padding: 8px; /* default margin */
						margin: 0px;
					}
				</style-->
				<link rel="stylesheet" href="query_board_style.css">
				<!--script>
					location.reload();//history.back from query_action.php doesn\'t refresh automatically
				</script-->
				<script src="query_board_script.js"></script>
			</head>
			<body>
				<h1>QUERY_BOARD FOR \''.$THIS.'\'</h1>
				<!--p>QUERY_BOARD FOR \''.$THIS.'\'</p-->
				<br>
				<a href="dash.php">Dashboard</a>
				<br>
				<br>
				<!--form action="query_action.php"-->
				<!--table style="border:1px solid black;"-->
				<table border="1">
					<tbody>
	';//heredoc playings;nowdoc <-- check them out!!!
	
	/*
	function table_start($table_attr){
		echo "<table".($table_attr?" ":"").$table_attr."><tbody>";
	}
	*/
	
	function block_to_string($block){
		//return "type: ".$block->type." ,value: ".$block->value;
		if($block->type==="pool_reference"){
			return $block->type." ,value: ".$block->value;
		}
		return $block->type;
	}
	
	if(!empty($query)){
	$blocks_number=count($query);
	echo "<tr><th>Index</th><th>Value</th><th>Options</th></tr>";
	echo "<tr><td>0</td>";
	echo '<td rowspan="'.$blocks_number.'">';
	echo "<table><tbody>";
	foreach($query as $block){
		echo "<tr><td>";
		$instance=table::just_line(array_merge(homo_array("⇥",$block->depth),array(block_to_string($block))));
		$instance->build();
		get_last_elem($instance->table_elem->get_children()[0]->get_children()[0]->get_children())->add_attr("style","border: 1px solid black;");
		echo $instance->to_string();
		//the old '↹ '  ;  which one to use??
		echo "</td></tr>";////////// bilo pre samo </td> ////////////////////////
	}
	echo "</tbody></table>";
	echo '<td rowspan="'.$blocks_number.'">';
	//$table2_buffer=array();
	//const form_start='<form action="query_action.php">';
	echo "<table><tbody>";
	//$queries=json_get_arr("queries.json");
	//$query_index=array_search($THIS,array_keys($queries));
	$block_index=0;
	foreach($query as $block){
		$name="block_".$query_index."_".$block_index;
		/*
		array_push($table2_buffer,array('<input type="submit" name="'.$name.'" value="$depth--;"'.($block->depth===0?'disabled':'').'>',
		'<input type="submit" name="'.$name.'" value="$depth++;">','<input type="submit" name="'.$name.'" value="set/change value">',
		'<input type="submit" name="'.$name.'" value="delete">','<input type="number" name="new_index_'.$index.'" placeholder="Enter the new index here. ">',
		'<input type="submit">'));
		*/
		$row=array('<input type="submit" name="'.$name.'" value="$depth--;"'.($block->depth===0?'disabled':'').'>',
		'<input type="submit" name="'.$name.'" value="$depth++;">','<input type="submit" name="'.$name.'" value="set/change value"'.
		($block->type==="pool_reference"?"":" disabled").'>',
		'<input type="submit" name="'.$name.'" value="delete">','<input type="number" name="new_index_'.$query_index.'_'.$block_index.
		'" placeholder="Enter the new index here. ">','<input type="submit">');
		unset($name);
		echo "<tr>";
		$cell_index=0;
		echo form_start;
		foreach($row as $cell){
			if($cell_index===4){
				echo "</form>".form_start;
			}
			echo "<td>".$cell."</td>";
			$cell_index++;
		}
		unset($cell_index,$row);
		echo "</form>";
		echo "</tr>";
		$block_index++;
	}
	unset($block_index);
	//echo (new table($table2_buffer))->to_string();
	echo "</tbody></table>";
	for($i=1;$i<$blocks_number;$i++){
		echo "<tr><td>".$i."</td></tr>";
	}
	unset($i);
	echo "</td></tr></tbody></table>";//</form>";
	unset($blocks_number);
	}
	//require "utils.php";
	//*const*/ $open=from_str($_GET["open"]);//true;
	//USE $_COOKIE - impossible but doing it with Javascript accomplished
	
	const open=false;
	
	echo "<br><br>";
	echo '<details'.(open?' open':'').'><summary>Add a new block</summary><fieldset>';//<form action="query_action.php">';
	echo form_start;
	const types=array("pool_reference","AND","OR","NOT","XOR");
	$chosen_index=rand(0,count(types)-1);
	$type_index=0;
	foreach(types as $type){
		echo '<input type="radio" name="new_block_type_'.$query_index.'" id="'.$type.'" value="'.$type.'"'.($type_index===$chosen_index?" checked":"").'>';
		echo '<label for="'.$type.'">'.$type.'</label>';
		echo "<br>";
		$type_index++;
	}
	unset($chosen_index,$type_index);
	echo "<br>";
	echo '<input type="submit">';
	echo "</form></fieldset></details>";
	
	echo "<br><br>";
	echo form_start;
	echo "<p>Rename:</p>";
	echo '<input name="rename_'.$query_index.'" placeholder="Enter the new name here. "><input style="margin-left: 10px;" type="submit">';
	//////////////////////////////////////////////// use table here maybe //////////////////////////////////
	echo "</form>";
	echo "<br><br>";
	echo form_start;
	$name="action_".$query_index;
	echo '<input type="submit" name="'.$name.'" value="Delete">';
	echo '<input style="margin-left:10px;" type="submit" name="'.$name.'" value="Evaluate!">';
	
	echo '</form></body></html>';
	
	//type of class in php, aka generics; so you create a function get_new<T>():callable or Closure??;
?>