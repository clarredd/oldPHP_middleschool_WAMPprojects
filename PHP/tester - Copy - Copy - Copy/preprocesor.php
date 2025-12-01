<?php
//var_dump($_GET);
$komanda=json_decode($_GET["komanda"]);
$odgovori=[];
for($index=0;$index<count($komanda);$index++){
	array_push($odgovori,$_GET["odgovor_".$index]);
}
echo "<script>location.replace('provera.php?podaci=".json_encode($komanda)."&odgovori=".json_encode($odgovori)."');</script>";
?>