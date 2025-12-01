<?php
session_start();
echo "Preusmeravanje u toku. ";
if(in_array("korisnicko_ime",array_keys($_SESSION))){
	echo "<script>location.replace('logged.php?korisnicko_ime=".$_SESSION["korisnicko_ime"]."');</script>";
}else{
	echo "<script>location.replace('main.html');</script>";
}
?>