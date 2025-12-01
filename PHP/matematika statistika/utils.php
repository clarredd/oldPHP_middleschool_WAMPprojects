<?php
	function iter_func_on(/*Closure*/callable $func, array $arr):array{//callable $func ???
		for($i=0;$i<count($arr);$i++)
			$arr[$i]=$func($arr[$i]);
		return $arr;
	}
	function from_str(string $str){
		eval("return ".$str.";");
	}
	function homo_array($thing, int $length){//mixed??
		$out=array();
		for($i=0;$i<$length;$i++)
			array_push($out,$thing);
		return $out;
	}
	function homo_array2($thing, int $length){//mixed??
		return array_pad(array(),$length,$thing);
	}
	function homo_string($thing, int $length){//mixed??
		$out="";
		for($i=0;$i<$length;$i++)
			$out.=$thing;
		return $out;
	}
	function homo_string2($thing, int $length){//mixed??
		return str_pad("",$length,$thing);
	}
	function elem_count_in($target,array $arr){
		$out=0;
		foreach($arr as $elem)
			if($elem==$target) $out++;
		return $out;
	}
?>