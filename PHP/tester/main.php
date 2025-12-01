<?php
//echo $_SERVER["REQUEST_METHOD"];

$komanda=json_decode($_GET["komanda"],false);//oznacava podatke o testu
$num=(int)$_GET["num"];//oznacava pitanje na kome je stano

//var_dump((bool)$komanda);
echo "<style>body{text-align:center;}</style>";

function isJSON($string) {
 json_decode($string);
 return json_last_error()===JSON_ERROR_NONE;
}

function validno($komanda){
	$izlaz=true;
	foreach($komanda as $elem){
		$izlaz&=in_array($elem->tacanOdgovor,$elem->odgovori);
	}
	return $izlaz;
}

if(isJSON($_GET["komanda"])&&validno($komanda)){//moguce je da se prevodjenje nije desilo do kraja zbog greske ili tacan odgovor ni nije odgovor
if($num>0){
	$odgovor=$_GET["odgovor"];//oznacava odaberen odgovor
	if($odgovor===$komanda[$num-1]->tacanOdgovor){
		echo "<h2 style='color: lightgreen;'>Tačno! </h2>";
	}else{
		echo "<h2 style='color:red;'>Netačno! Tačan odgovor je bio '".$komanda[$num-1]->tacanOdgovor."'!</h2>";
	}
	echo "<br>";
}else{
	echo "<br><br><br>";
}

if($num===count($komanda)){
	echo "<a href='index.html'>Povratak</a>";
}else{

echo "<h3>".$komanda[$num]->pitanje."</h3>";
echo "<br><br>";

echo "<form action='main.php'>";
echo "<input type='hidden' name='num' value='".($num+1)."'>";//strval($num+1), {$num+1}, (string)($num+1)
echo "<input type='hidden' name='komanda' value='".json_encode($komanda)."'>";

$broj_selektovanog=rand(0,count($komanda[$num]->odgovori)-1);//odgovor koji treba biti podrazumevamo selektovan
//echo $broj_selektovanog;
$broj=0;//broj odgovora koji se stampa
foreach($komanda[$num]->odgovori as $odgovor){
	echo "<input type='radio' name='odgovor'".($broj===$broj_selektovanog?"checked":"")." value='".$odgovor."'>".$odgovor."<br>";
	$broj++;
}
echo "<br><br>"."<input type='submit' value='Nastavak'></form>";
}
}else{
	echo "<h1 style='color:red;'>Zahtev pogrešan!</h1> <br><br> <a href='index.html'>Povratak</a>";
}
?>