<?php
	//the question: https://stackoverflow.com/questions/73933438/inner-workings-of-array-push-and-count

	function array_append(&$arr,...$vals){
		$i=0;
		foreach($arr as $k => $v)
			if(is_numeric($k)&&$k>$i) $i=$k;
		foreach($vals as $val)
			$arr[++$i]=$val;
	}
	function elem_quantity($a,$m=0){
		if(!is_array($a)) return 1;
		$o=0;
		foreach($a as $e)
			if($m)
				$o+=elem_quantity($a,$m);
			else
				$o++;
		return $o;
	}
?>