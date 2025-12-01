<?php
require "json_library.php";

$keys=array_keys($_GET);
$questions_number=0;
while(in_array("odgovor_".$questions_number."_0",$keys)){
	$questions_number++;
}

$data=array($questions_number);
for($iter=0;$iter<$questions_number;$iter++){
	$question_lenght=0;
	while(in_array("odgovor_".$iter."_".$question_lenght,$keys)){
		$question_lenght++;
	}
	$data[$iter]=array($question_lenght);
	for($iter2=0;$iter2<$question_lenght;$iter2++){
		$data[$iter][$iter2]=intval($_GET["odgovor_".$iter."_".$iter2]);
		//$data[$iter][$iter2]=$_GET["odgovor_".$iter."_".$iter2];
	}
}

$old_data=json_get("stats_data.json");
array_push($old_data,$data);
json_write("stats_data.json",$old_data);

echo "Pool data is saved. ";
echo "<script>window.location.replace(\"index.html\");</script>";
?>