<?php
	function pie_graph(array $data,array $labels,int $width,int $height,string $title):void{
		/*
		$width=min($width,$height);
		$height=$width;
		*/
		
		//echo '<img src="graph.php?data='.urlencode(json_encode($data)).'&labels='.urldecode(str_replace('"',"'",json_encode($labels))).'&width='.$width.'&height='.$height.'&title='.urldecode($title).'">';
		echo "<img src='graph.php?data=".urlencode(json_encode($data)).'&labels='.urlencode(json_encode($labels)).'&width='.$width.'&height='.$height.
		'&title='.urlencode($title)."'>";
	}
	
	//require "json_library.php"; <-- already used in the file which includes this one to evaluate
	require "utils.php";
	
	function block_to_string(object $block):string{
		switch($block->type){
			case "AND":
				return "&&";
			case "OR":
				return "||";
			case "NOT":
				return "!";
			case "XOR":
				return "^";
			case "pool_reference":
				$parts=explode("_",$block->value);
				if(count($parts)<3){//do ob_clean
					//trigger_error("A pool reference is not set set. ",E_USER_ERROR);
					echo "A pool reference is not set. ";
					echo '<br><br><br><button onclick="history.back();">Go back</button>';//copy from query_action.php
					die;
				}
				//return "&lt;pool reference here&gt;";//////////////////////////////////////77
				return '$answers['.$parts[0].']['.$parts[1].']=='.$parts[2];
			default:
				//ob_clean();
				//echo '<p style="color:red;">Unrecognised block of type \''.$block->type.'\'. </p>';
				echo "Unrecognised block of type '$block->type'";
				echo '<br><br><br><button onclick="history.back();">Go back</button>';
				die;//exit;
		}
	}
	function query_to_f_str(object $query):string{
		$in_php="";
		echo $in_php;
		$cur_depth=0;
		foreach($query as $block){
			if($cur_depth<$block->depth)
				$in_php.=homo_string('(',$block->depth-$cur_depth);
			else
				$in_php.=homo_string(')',$cur_depth-$block->depth);
			$cur_depth=$block->depth;
			$in_php.=block_to_string($block);
		}
		$in_php.=homo_string(')',$cur_depth);
		return $in_php;
	}
	function filter_f_from_query(object $query):callable{
		$in_php=query_to_f_str($query);
		try{
			//$output=create_function('array $answers',"return $in_php;");
			$output=eval("return function(array \$answers){return $in_php;};");
		}catch(ParseError $e){//$e not used
			//ob_clean();
			//trigger_error("The query is not syntaxically correct. :(",E_USER_ERROR);
			echo "The query is not syntaxically correct. :(";
			echo '<br><br><br><button onclick="history.back();">Go back</button>';//copy from query_action.php
			die;
		}
		return $output;
	}
	function filtered(callable $func,array $stats_data):array{//Closure?
		$output=array();
		foreach($stats_data as $answers)
			if($func($answers))
				array_push($output,$answers);
		return $output;
	}
	function draw_graph_for_stats_data(array $stats_data):void{
		verify_json("pool_structure.json",array("title"=>"string","questions"=>"array"),true);
		$data=json_get("pool_structure.json",true);
		//$data=json_get_arr("pool_structure.json");
		
		echo "<!DOCTYPE html></html><head><title>Evaluate! DONE</title><meta charset=\"utf-8\"><!--style>h1,td{text-align: center;}</style--></head><body>";
		echo '<h1 style="text-align:center;">'.$data["title"]."</h1>";
		
		$data=$data["questions"];
		
		echo "<ol>";
		
		for($iter=0;$iter<count($data);$iter++){
			$elem=(array)$data[$iter];//pitanje
			verify($elem,array("title"=>"string","content"=>"array"));
			echo "<li>";
			if(!empty($elem["title"])){
				echo "<p>".$elem["title"]."</p>";
			}
			$elem=$elem["content"];//potpitanja
			echo "<ol>";
			for($iter2=0;$iter2<count($elem);$iter2++){
				$elem2=$elem[$iter2];
				verify($elem2,array("text"=>"string","answers"=>"array"));
				echo '<li style="display: inline;">';
				//echo "<td>".$elem2["text"]."</td>";
				/*echo "<td><select name=\"odgovor_".$iter."_".$iter2."\">";
				/*$elem2=$elem2["answers"];
				$selected_index=rand(0,count($elem2));
				for($iter3=0;$iter3<count($elem2);$iter3++){*/
					//echo "<option value=\"".$iter3/*$elem2[$iter3]*/."\"".($iter3===$selected_index?" selected":"").">".$elem2[$iter3]."</option>";
				//}
				$chart_data=array_fill(0,count($elem2["answers"]),0);
				foreach($stats_data as $form)
					$chart_data[$form[$iter][$iter2]]++;
				
				$width=8*strlen($elem2["text"]);
				$height=max($width*.75,100);
				
				pie_graph($chart_data,$elem2["answers"],$width,$height,$elem2["text"]);
				echo "</li>";
			}
			echo "</ol>";
		}
		echo "</ol>";
		//echo "<br><button onclick=\"history.back();\">Go back!</button></body></html>";
	}
	
	//const width=500;
	//const height=300;
	
	function evaluate(){
		//use global for some variables?
		$queries=json_get_arr("queries.json");
		$stats_data=json_get_arr("stats_data.json");
		
		if($stats_data===array()){
			//ob_clean();
			echo "No data to do actions on(generally). :(";
			echo '<br><br><br><button onclick="history.back();">Go back</button>';//copy from query_action.php
			die;
		}
			
		
		$query_index=intval(explode('_',array_keys($_GET)[0])[1]);
		$query_name=array_keys($queries)[$query_index];
		$query=$queries[$query_name];
		
		//echo "&lt;evaluate&gt;";
		//filter_f_from_query((object)$query);
		//filter_f_from_query($query_name,(object)$query);
		
		echo '<h1><a href="#" onclick="history.back();"><i>'.$query_name.'</i></a>';// - ".query_to_f_str($query)."</h1><br><br>";//show the "header"
		echo "</h1>";
		draw_graph_for_stats_data(filtered(filter_f_from_query((object)$query),$stats_data));
	}
	//Suggestion, use query_to_f_str fro preview on QUERY_BOARD as previously planned
	//Remove json_get_arr entirely. 
?>