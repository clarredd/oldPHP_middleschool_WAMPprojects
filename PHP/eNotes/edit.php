<?php
$user=$_GET["korisnicko_ime"];
$note=$_GET["beleska"];
$passwd=$_GET["lozinka"];
$podaci=json_decode(fread(fopen("users.json","r"),filesize("users.json")),true);
$podaci[$user]["beleska"]=$note;
if(!($passwd==="")){
	$podaci[$user]["lozinka"]=$passwd;
}
fwrite(fopen("users.json","w"),json_encode($podaci));
echo "Promena izvrsena. ";
echo "<script>location.replace('logged.php?korisnicko_ime=".$user."');</script>";
?>