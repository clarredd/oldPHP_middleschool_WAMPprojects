<?php
	require "json_library.php";
	
	function no_err_substr(string $str,int $start,int $end){//[start,end]
		assert($start<=$end);
		if($end>=count($str)-1) return '';
		return substr($str,$start,$end-$start+1);
	}
	function bye_bye(){
		global $queries;
		
		json_write(filename,$queries);
		echo '<script>window.location=document.referrer;//history.back();</script>';
		die;
	}
	function bye_bye_dash(){
		global $queries;
		
		json_write(filename,$queries);
		echo '<script>location.replace("dash.php");</script>';
		die;
	}
	function py_print(...$args){
		for($i=0;$i<count($args);$i++){
			echo $args[$i].($i===count($args)-1?"<br>":" ");
		}
	}

	//var_dump($_GET);
	
	assert(count($_GET)===1);
	
	$key=array_keys($_GET)[0];
	$value=$_GET[$key];
	
	const filename="queries.json";
	$queries=json_get_arr(filename);
	
	if(preg_match("/block_[0-9]_[0-9]/",$key)){
		//echo "general block actions";
		
		$sep_ed=explode('_',$key);
		$query_index=intval($sep_ed[1]);//(int)$sep_ed[1];
		$block_index=intval($sep_ed[2]);//(int)$sep_ed[2];
		unset($sep_ed);
		
		$block=$queries[array_keys($queries)[$query_index]][$block_index];
		
		//var_dump($block);//die;
		
		//echo " : ";
		
		if($value==='$depth--;'){
			//echo "\$depth--;";
			$block->depth--;
			
			bye_bye();
		}
		if($value==='$depth++;'){
			//echo "\$depth++;";
			$block->depth++;
			
			bye_bye();
		}
		if($value==="set/change value"){
			//echo "set/change value";
			
			if($block->type!=="pool_reference"){//No need, because the button on these blocks is recently changed to be disabled disabled. 
				//trigger_error("Value can be changed!!!",E_USER_ERROR);
				//ob_clean();
				echo "Value can't be changed!!!";
				echo '<br><br><br><button onclick="history.back();">Go back</button>';
				die;
			}
			
			verify_json("pool_structure.json",array("title"=>"string","questions"=>"array"),true);
			$data=json_get("pool_structure.json",true);
			
			echo "<!DOCTYPE html></html><head><title>unos</title><meta charset=\"utf-8\"><!--style>h1,td{text-align: center;}</style--></head><body>";
			
			$query_name=array_keys($queries)[$query_index];
			echo '<h1><a href="#" onclick="history.back();"><i>'.$query_name.'</i></a>';
			
			echo '<h1 style="text-align: center;">'.$data["title"]."</h1>";
			//echo "<form action=\"new_value_write.php?query_index=$query_index&block_index=$block_index\">";
			echo "<form action=\"new_value_write.php\">";
			echo '<input type="hidden" name="query_index" value="'.$query_index.'">';
			echo '<input type="hidden" name="block_index" value="'.$block_index.'">';
			
			
			$data=$data["questions"];
			
			echo "<ol>";
			
			$radio_selected1=rand(0,count($data)-1);
			$radio_selected2=rand(0,count($data[$radio_selected1]["content"])-1);
			
			for($iter=0;$iter<count($data);$iter++){
				$elem=$data[$iter];//pitanje
				verify($elem,array("title"=>"string","content"=>"array"));
				echo "<li>";
				if(!empty($elem["title"])){
					echo "<p>".$elem["title"]."</p>";
				}
				echo "<table border=\"1\"><tbody><tr><th>Redni broj</th><th>Izbor</th><th>Pitanje</th><th>Odgovor</th></tr>";
				$elem=$elem["content"];//potpitanja
				for($iter2=0;$iter2<count($elem);$iter2++){
					$elem2=$elem[$iter2];
					verify($elem2,array("text"=>"string","answers"=>"array"));
					echo "<tr><td>".($iter2+1).".</td>";
					echo '<td><input type="radio" name="new_value_q" value="'.$iter.'_'.$iter2.'"'.
					($iter===$radio_selected1&&$iter2===$radio_selected2?" checked":"").'></td>';
					echo "<td>".$elem2["text"]."</td>";
					echo "<td><select name=\"odgovor_".$iter."_".$iter2."\">";
					$elem2=$elem2["answers"];
					$selected_index=rand(0,count($elem2)-1);
					for($iter3=0;$iter3<count($elem2);$iter3++){
						echo "<option value=\"".$iter3/*$elem2[$iter3]*/."\"".($iter3===$selected_index?" selected":"").">".$elem2[$iter3]."</option>";
					}
					echo "</td>";
					echo "</tr>";
				}
				echo "</tbody></table><br></li>";
			}

			echo "</ol><br><input type=\"submit\"></form></body></html>";
			
			
			//bye_bye();
			die;
		}
		if($value==="delete"){
			//echo "delete";
			
			array_splice($queries[array_keys($queries)[$query_index]],$block_index,1);
			
			bye_bye();
		}
		
		//bye_bye();
	}
	if(preg_match("/new_index_[0-9]_[0-9]/",$key)){
		//echo "new index";
		
		if(empty($value)){
			echo "The new index field is empty. ";
			echo '<br><br><br><button onclick="history.back();">Go back</button>';
			die;
		}
		
		$sep_ed=explode('_',$key);
		$query_index=intval($sep_ed[2]);
		$block_index=intval($sep_ed[3]);
		$query_name=array_keys($queries)[$query_index];
		
		//var_dump($queries);
		
		/*
		array_splice($queries[$query_name],intval($value)+intval(intval($value)>=$block_index),0,array($queries[$query_name][$block_index]));
		array_splice($queries[$query_name],$block_index+intval($block_index>=intval($value)),1);
		*/
		
		$temp=$queries[$query_name][$block_index];
		array_splice($queries[$query_name],$block_index,1);
		array_splice($queries[$query_name],$value,0,array($temp));
		
		bye_bye();
	}
	if(preg_match("/new_block_type_[0-9]/",$key)){
		//echo "new block";
		
		$query_name=array_keys($queries)[intval(explode('_',$key)[3])];
		$new_block=array("depth"=>0,"type"=>$value);
		if($value==="pool_reference")
			$new_block["value"]="&lt;not set&gt;";
		
		array_push($queries[$query_name],$new_block);
		
		bye_bye();
	}
	if(preg_match("/rename_[0-9]/",$key)){
		//echo "rename";
		
		require "utils.php";
		
		if(empty(trim($value))){
			echo "NO NAME GIVEN ¯\_(ツ)_/¯ ";
			echo '<br><br><br><button onclick="history.back();">Try again</button>';
			die;
		}
		if(in_array(trim($value),iter_func_on('trim',array_keys($queries)))){
			echo "NAME ALREADY TAKEN :(";
			echo '<br><br><br><button onclick="history.back();">Try again</button>';
			die;
		}
		//history.back() doesn't matter because no change has been made
		
		$query_index=intval(explode('_',$key)[1]);
		$query_name=array_keys($queries)[$query_index];
		
		$queries[$value]=$queries[$query_name];
		unset($queries[$query_name]);
		
		bye_bye_dash();
	}
	if($value==="Delete"){
		//echo "delete the query";
		
		$query_index=intval(explode('_',$key)[1]);
		$query_name=array_keys($queries)[$query_index];
		
		unset($queries[$query_name]);
		
		bye_bye_dash();
	}
	if($value==="Evaluate!"){
		//echo "evaluate!";
		
		require "evaluate.php";
		
		evaluate();
		echo '<br><br><br><button onclick="history.back();">Go back</button>';
		die;
		
		//bye_bye();
	}
	
	echo "Request unrecognised, unhandled. :(";
?>