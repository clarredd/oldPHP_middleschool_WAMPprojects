<?php
session_start();
$user=$_GET["korisnicko_ime"];
$podaci=json_decode(fread(fopen("users.json","r"),filesize("users.json")),true);
array_splice($podaci,array_search($user,array_keys($podaci)),1);
fwrite(fopen("users.json","w"),json_encode($podaci));
session_unset();
session_destroy();
echo "Nalog obrisan. ";
echo "<script>location.replace('main.html');</script>";
?>