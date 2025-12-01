<?php 
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
$korisnicko_ime=$_REQUEST["ime"];
$podaci=json_decode(fread(fopen("userlist.json","r"),filesize("userlist.json")));
if(in_array($korisnicko_ime,$podaci)){
    echo "data: user already exits\n\n";
}else{
    array_push($podaci,$korisnicko_ime);
    fwrite(fopen("userlist.json","w"),json_encode($podaci));
    fwrite(fopen("userdata_".$korisnicko_ime.".json","w"),"[]");
    echo "data: ok\n\n";
}
flush();
?>