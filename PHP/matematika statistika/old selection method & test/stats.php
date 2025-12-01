<?php 
	//declare(strict_types=1);
	
	function pie_graph(array $data,array $labels,int $width,int $height,string $title):void{
		/*
		$width=min($width,$height);
		$height=$width;
		*/
		
		//echo '<img src="graph.php?data='.urlencode(json_encode($data)).'&labels='.urldecode(str_replace('"',"'",json_encode($labels))).'&width='.$width.'&height='.$height.'&title='.urldecode($title).'">';
		echo "<img src='graph.php?data=".urlencode(json_encode($data)).'&labels='.urlencode(json_encode($labels)).'&width='.$width.'&height='.$height.
		'&title='.urlencode($title)."'>";
	}

	require "json_library.php";
	
	$pool_structure=json_get("pool_structure.json");
	//$data=json_get("stats_data.json");
	
	const checked_by_default=true;//false;
	//define("checked_by_default",true);
	
	echo "<!DOCTYPE html><html><head><title>STATS</title></head><body>";
	
	echo "<h1>".$pool_structure->title."</h1>";
	
	echo "<form action='stats_action.php'>";
	
	$question_index=0;
	foreach($pool_structure->questions as $question){
		echo "<p>".($question_index+1)."."."</p>";
		echo "<p>".$question->title."</p>";
		$option_index=0;
		foreach($question->content as $option){
			echo "<p>".$option->text."</p>";
			$answer_index=0;
			foreach($option->answers as $answer){
				$indentifier=$question_index."_".$option_index."_".$answer_index;
				echo "<input type='checkbox' id='id".$indentifier."'value='"./*$answer_index*/"checked"."' name='".$indentifier."'".(checked_by_default?" checked":"").">";
				echo "<label for='id".$answer."'>".$answer."</label>";
				echo "<br>";
				$answer_index++;
			}
			$option_index++;
		}
		$question_index++;
	}
	
	echo "<br><br><input type='submit'>";
	
	echo "</form>";
	echo "</body></html>";
?>