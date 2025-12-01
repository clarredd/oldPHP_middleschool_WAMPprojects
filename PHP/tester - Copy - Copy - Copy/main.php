<?php
//echo $_SERVER["REQUEST_METHOD"];

$komanda=json_decode($_GET["komanda"]);//oznacava podatke o testu

echo "<style>td{text-align:center;}</style>";

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
	echo "<form action='preprocesor.php' id='test'><table border='1'><tbody><tr><th>Pitanje</th><th>Odgovor</th></tr>";
	$indexPodatka=0;
	foreach($komanda as $podatak){
		echo "<tr><td>".$podatak->pitanje."</td>";
		echo "<td><select name='odgovor_".$indexPodatka."' form='test'>";
		$podrazumevanoSelektovanIndex=rand(0,count($podatak->odgovori));
		$trenutanIndex=0;
		foreach($podatak->odgovori as $odgovor){
			echo "<option value='".$odgovor."'".($trenutanIndex===$podrazumevanoSelektovanIndex?" selected":"").">".$odgovor."</option>";
			$trenutanIndex++;
		}
		echo "</select></tr>";
		$indexPodatka++;
	}
	echo "</tbody></table>";
	echo "<input type='hidden' name='komanda' value='".json_encode($komanda)."'>";
	echo "<br><br>";
	echo "<input type='submit' value='Završi'></form>";
}else{
	echo "<h1 style='color:red;'>Zahtev pogrešan!</h1> <br><br> <a href='main.html'>Povratak</a>";
}
?>