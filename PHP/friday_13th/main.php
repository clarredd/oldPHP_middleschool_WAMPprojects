<?php
function isNum(string $number){
	return strval((int)$number)===$number;
}
$od=$_GET["od"];
$do=$_GET["do"];
echo 
"<html>".
"<head>".
"<style>".
"body{".
"	text-align : center;".
"}".
"</style>".
"<title>Rezultati"." (".$od."-".$do.") "."</title>".
"<meta charset=\"utf-8\">".
"</head>".
"<body>";
try{
//var_dump(!is_int($od));
//echo " ";
//var_dump(!is_int($do));
if(!isNum($od)||!isNum($do)){
	throw new Exception();
}
$od=(int)$od;
$do=(int)$do;
//echo "Data: ".$od." ".$do."<br>";
$rezultat=array();
$broj=0;
for($godina=$od;$godina<=$do;$godina++){
	for($mesec=1;$mesec<=12;$mesec++){
		$datum=mktime(0,0,0,$mesec,13,$godina);
		//echo date("l, d.M.Y, H ( ha ) :i:s",$datum)."<br>";
		if(date("l",$datum)==="Friday"){
			array_push($rezultat,date("M Y.",$datum));
			$broj++;
		}
	}
	array_push($rezultat,"");//razmak posle svake godine
}
//echo "<br>";
echo "<h1>"."Ima ".$broj." datum";
if($broj!==1){
	echo "a";//množina
}
echo ". "."</h1>"."<br><br>";
foreach($rezultat as $element){
	echo "$element"."<br>";
}
}catch(Exception $e){
	echo "<h1 style=\"color:red;\">Podaci nisu odgovarajući!</h1>";
}
echo "<br>"."<a href=\"index.html\">Povratak</a>";
echo "</body></html>";
?>