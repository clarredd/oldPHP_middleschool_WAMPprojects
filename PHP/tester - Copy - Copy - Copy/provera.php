<?php

/*
echo "<h1>Stranica u fazi pravljenja</h1><br>";
echo "Podaci: ".$_GET["podaci"]."<br>Odgovori: ".$_GET["odgovori"]."<br><br>";
*/

echo "<style>td{text-align:center;}</style>";

echo "<h1>Rezultati</h1><br><br>";
echo "<table border='1'><tbody>".
"<tr><th>Pitanje</th><th>Tačan odgovor</th><th>Dat odgovor</th><th>Je li tačno</th></tr>";

$podaci=json_decode($_GET["podaci"],false);
$odgovori=json_decode($_GET["odgovori"]);

$brojTacnih=0;
$brojNetacnih=0;

for($index=0;$index<count($podaci);$index++){
	$pitanje=$podaci[$index]->pitanje;
	$tacanOdgovor=$podaci[$index]->tacanOdgovor;
	$odgovor=$odgovori[$index];
	$jeLiOdgovorTacan=$odgovor===$tacanOdgovor;
	$boja=$jeLiOdgovorTacan?"green":"red";
	
	if($jeLiOdgovorTacan){
		$brojTacnih++;
	}else{
		$brojNetacnih++;
	}
	
	$stilArgument=" style='background-color:".$boja.";color:white;'";
	echo "<tr><td".$stilArgument.">".$pitanje."</td><td".$stilArgument.">".$tacanOdgovor."</td><td".$stilArgument.">".$odgovor."</td><td".$stilArgument.">".($jeLiOdgovorTacan?"DA":"NE")."</td></tr>";
}

echo "</tbody></table><br><br>";

$suma=$brojTacnih+$brojNetacnih;
if($suma===0){
	echo "<h1 style='color:red;'>Nema dovoljno podataka za obradu po procentima</h1>";
}else{
	echo "<table border='1'><tbody>";
	echo "<tr><th>Tip odgovora</th><th>Broj odgovora</th><th>Udeo</th><th>Prikaz</th></tr>";
	echo "<tr><td>tačan</td><td>".$brojTacnih."</td><td>".(($brojTacnih/$suma)*100)."%</td><td><progress value='".$brojTacnih."' max='".$suma."'></progress></td></tr>";
	echo "<tr><td>netačan</td><td>".$brojNetacnih."</td><td>".(($brojNetacnih/$suma)*100)."%</td><td><progress value='".$brojNetacnih."' max='".$suma."'></progress></td></tr>";
	echo "</tbody></table>";
}

echo "<br><br><a href='main.html'>Povratak</a>";
?>