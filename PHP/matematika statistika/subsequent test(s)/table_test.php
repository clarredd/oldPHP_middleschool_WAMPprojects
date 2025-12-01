<?php
	require "table_class.php";
	
	define("TITLE","hello;const string php := 'AWESOME';");
	$BODY="";
	
	$t=table::just_line(array("hi","it's","me",",","com.markoJojic"));
	$t->build();
	$t->table_elem->add_attr("border",1);
	
	//var_dump($t->table_elem->get_children()[0]->get_children());
	
	$BODY.=$t->to_string();
	
	$t->table_elem->remove_attr("border");
	
	$BODY.=$t->to_string();
	
	//$t->table_elem->remove_child($t->table_elem->get_children()[0]);
	$tbody=$t->table_elem->get_children()[0];
	$tr=$tbody->get_children()[0];
	//for($i=0;$i<intval($_GET[array_keys($_GET)[0]]);$i++)
	for($i=0;$i<intval(array_keys($_GET)[0]);$i++)
		$tr->remove_child($tr->get_children()[0]);
	$t->table_elem->add_attr("border",1);
	
	$BODY.=$t->to_string();
	
	echo body_wrapper($BODY,TITLE);
	
	//Because of the design, you can't see the to_be_shown part up util the program finali, so if there happen any arrors, only they are destined to be shown
?>