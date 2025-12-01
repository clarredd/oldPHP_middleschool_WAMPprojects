<?php

$zahtev=$_REQUEST["req"];

echo
"<!DOCTYPE html>".
"<html>".
"<head>".
"<style>".
"th,td{".
	"text-align: center; ".
"}".
".bigText{".
	"font-size: 3em; ".
"}".
"h1{".
	"color: red; ".
"}".
"</style>".
"<title>Rezultati (".$zahtev.")</title>".
"<meta charset=\"utf-8\">".
"</head>".
"<body>";
function LogickiIzrazKonvertor($formula){
	return zameni($formula,[
		//"~"=>"!",//kasnije -|
		"!"=>"¬",
		"&&"=>"&",//kasnije /\
		"&"=>"∧",
		"||"=>"|",//kasnije \/
		"|"=>"∨",
		//"^"=>"⊕",
	]);
}
function zameni($string,$data){
	foreach($data as $kljuc=>$vrednost){
		//echo "$kljuc - $vrednost <br>";
		$string=str_replace($kljuc,$vrednost,$string);
	}
	return $string;
}
function broj_pojavljivanja_u_nizu($element,$niz){
	$izlaz=0;
	foreach($niz as $elem){
		if($elem===$element){
			$izlaz++;
		}
	}
	//echo $izlaz;
	return $izlaz;
}
function pozicija_u_nizu($element,$niz,$zaustaviti_posle_prvog=true){//strpos i strrpos su samo za stringove
	$izlaz=-1;
	for($index=0;$index<count($niz);$index++){
		if($niz[$index]===$element){
			$izlaz=$index;
			if($zaustaviti_posle_prvog){
				break;
			}
		}
	}
	return $izlaz;
}
function PrikaziTablicu($zahtev){
	echo "<table border=\"1\"><tbody>";
	/*
	$variable=Array();
	foreach(str_split($zahtev) as $karakter){
		if(!($karakter==="|"||$karakter==="!"||$karakter==="&"||$karakter==="("||$karakter===")")){
			if(!in_array($karakter,$variable)){
				array_push($variable,$karakter);
			}
		}
	}
	*/
	$variable=preg_split("/[\!\&\|\(\)\^]/",$zahtev);//regularni izraz koji izdvaja variable iz specijalnih karaktera
	//var_dump($variable);
	while(in_array("",$variable)){
		//echo array_search("",$variable)."<br>";
		array_splice($variable,array_search("",$variable),1);
		//var_dump($variable);
	}
	foreach($variable as $variabla){//uklanja višestruka pojavljivanja
		while(broj_pojavljivanja_u_nizu($variabla,$variable)>1){
			array_splice($variable,pozicija_u_nizu($variabla,$variable,false),1);
		}
	}

	echo "<tr><th colspan=\"".(count($variable)+1)."\">"."<label class='bigText'>".LogickiIzrazKonvertor($zahtev).
	"</label>"."( ".$zahtev." )"."</th></tr>";
	ob_start(); //zbog brisanja u slučaju greške
	echo "<tr>";
	foreach($variable as $variabla){
		echo "<th>$variabla</th>";
	}
	echo "<th>".LogickiIzrazKonvertor($zahtev)."</th>";
	echo "</tr>";

	for($kombinacija=2**count($variable)-1;$kombinacija>=0;$kombinacija--){//traži kombinacije
		echo "<tr>";
		$kod=str_pad(decbin($kombinacija),count($variable),"0",STR_PAD_LEFT);//dodaje nule (11 10 01 00)
		$zahtev_copy=$zahtev;
		for($index=0;$index<count($variable);$index++){
			$T_F=T_ili_F(str_split($kod)[$index]==="1");
			echo $T_F;

			$logickaVrednost=str_split($kod)[$index]==="1"?"true":"false";
			$zahtev_copy=str_replace($variable[$index],$logickaVrednost,$zahtev_copy);

			$zahtev_copy=str_replace(str_replace($variable[$index],$logickaVrednost,"true"),"true",$zahtev_copy);//moguce je da se a zameni i u 'false'-u
			$zahtev_copy=str_replace(str_replace($variable[$index],$logickaVrednost,"false"),"false",$zahtev_copy);//----------||---------
		}
		try{
			eval("\$rezultat=$zahtev_copy;");
			echo T_ili_F($rezultat);
			echo "</tr>";
		}catch(Exception $e){
			ob_get_clean();
			echo "<tr><td><h1>Komanda neodgovarjuća</h1></td></tr>";// u headeru je stil:'h1{color: red; }'
		}
	}

	echo "</tbody></table>";
	//echo $zahtev."<br>";
}
function T_ili_F($bool){
	if($bool){
		return "<td style=\"color: white; background-color: green;\">T</td>";
	}else{
		return "<td style=\"color: white; background-color: red;\">F</td>";
	}
}
foreach(explode(";",str_replace(" ","",$zahtev)) as $pojedinacanIzraz){
	PrikaziTablicu($pojedinacanIzraz);
	echo "<br>";
}
echo "<br><br>"."<a href=\"index.html\">Povratak</a>";
echo
"</body>".
"</html>";
?>