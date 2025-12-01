<?php
	function dim_num($a){
        if(!is_array($a)) return 0;
        if(is_array($a)&&!count($a)) return 1;
        $o=array();
        foreach($a as $e)
            array_push($o,dim_num($e)+1);
        return max($o);
    }
    function dim_count($a){
        if(!is_array($a)) return 0;
        $o=1;
        foreach($a as $e){
			$d=dim_count($e)+1;
            if($o>$d) $o=$d;
		}
        return $o;
    }
	
	//assert_options(ASSERT_BAIL,1);
    function matrix_mul($a,$b){
		if(is_numeric($a)&&is_numeric($b))
			return $a*$b;
		if(count($b)===1)
			return matrix_mul($b,$a);
		if(!is_array($a)&&!is_array($b))
			return null;
        $o=array();
        foreach($b as $e)
			array_push($o,matrix_mul($a,$e));
		return $o;
    }
?>