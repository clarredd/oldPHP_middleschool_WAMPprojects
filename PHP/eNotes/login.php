<?php
$user=$_GET["korisnicko_ime"];
$passwd=$_GET["lozinka"];
$podaci=json_decode(fread(fopen("users.json","r"),filesize("users.json")),true);
if(array_key_exists($user,$podaci)){
	if(((object)$podaci[$user])->lozinka===$passwd){
		echo "Uspesno ste ulogovani. <br><br><a href='logged.php?korisnicko_ime=".$user."'>Nastaviti</a><br>";
		session_start();
		$_SESSION["korisnicko_ime"]=$user;
	}else{
		echo "Pogresna lozinka! <br><br>";
	}
}else{
	echo "Korisnicko ime ne postoji! <br><br>";
}
echo "<a href='main.html'>Povratak</a>";
?>