<?php
$user=$_GET["korisnicko_ime"];
echo "Ulogovani ste kao <i>".$user."</i> . ";
$podaci=(object)(json_decode(fread(fopen("users.json","r"),filesize("users.json")),true)[$user]);


echo "<hr>";
echo "<textarea name='beleska' form='obrazac' placeholder='Unesite belesku ovde. ' style='width:100%; height:50%;'>".$podaci->beleska."</textarea>";
echo "<form action='edit.php' id='obrazac'>";
echo "<input type='hidden' name='korisnicko_ime' value='".$user."'>";
echo "<input type='password' name='lozinka' placeholder='Unesite novu lozinku. '>";
echo "<br>";
echo "<input type='submit' value='Izvrsi promenu'>";
echo "</form>";
echo "<hr>";


echo "<a href='delete.php?korisnicko_ime=".$user."'>Obrisi nalog</a><br>";
echo "<a href='logout.php'>Odloguj se</a>";
?>