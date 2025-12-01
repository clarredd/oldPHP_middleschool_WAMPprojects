<?php
$user=$_GET["korisnicko_ime"];
$passwd=$_GET["lozinka"];
$podaci=json_decode(fread(fopen("users.json","r"),filesize("users.json")),true);
if(array_key_exists($user,$podaci)){
	echo "Korisnicko ime vec postoji! <br><br>";
	echo "<a href='main.html'>Povratak</a>";
}else{
	$podaci[$user]=array("lozinka"=>$passwd,"beleska"=>"");
	fwrite(fopen("users.json","w"),json_encode($podaci));
	echo "Nalog naprevljen! ";
	echo "<script>location.replace('main.html');</script>";
}
?>