<?php
//echo $_SERVER["REQUEST_METHOD"];

$komanda=json_decode($_GET["komanda"],false);//oznacava podatke o testu
$num=(int)$_GET["num"];//oznacava pitanje na kome je stano
$odgovori=[];

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
	$odgovori=json_decode($_GET["odgovori"]);
	array_push($odgovori,$odgovor);	
}

if($num<count($komanda)){
echo "<br><br><br>";
echo "<h3>".$komanda[$num]->pitanje."</h3>";
echo "<br><br>";

echo "<form action='main.php'>";
echo "<input type='hidden' name='num' value='".($num+1)."'>";//strval($num+1), {$num+1}, (string)($num+1)
echo "<input type='hidden' name='komanda' value='".json_encode($komanda)."'>";
echo "<input type='hidden' name='odgovori' value='".json_encode($odgovori)."'>";

$broj_selektovanog=rand(0,count($komanda[$num]->odgovori)-1);//odgovor koji treba biti podrazumevamo selektovan
//echo $broj_selektovanog;
$broj=0;//index odgovora koji se stampa
foreach($komanda[$num]->odgovori as $odgovor){
	echo "<input type='radio' name='odgovor'".($broj===$broj_selektovanog?"checked":"")." value='".$odgovor."'>".$odgovor."<br>";
	$broj++;
}
echo "<br><br>"."<input type='submit' value='Nastavak'></form>";
}else{
	//echo "Test je zavrsen. kliknite <a href='provera.php?podaci=".json_encode($komanda,false)."&odgovori=".json_encode($odgovori)."'>ovde</a> da biste dobili rezultate. ";
	echo "<script>location.replace('provera.php?podaci=".json_encode($komanda,false)."&odgovori=".json_encode($odgovori)."');</script>";//preusmerava uz pomoc JavaScript
}
}else{
	echo "<h1 style='color:red;'>Zahtev pogrešan!</h1> <br><br> <a href='index.html'>Povratak</a>";
}
?>