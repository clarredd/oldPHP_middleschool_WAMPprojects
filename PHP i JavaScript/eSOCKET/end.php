<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
$korisnicko_ime=$_REQUEST["ime"];
$podaci=json_decode(fread(fopen("userlist.json","r"),filesize("userlist.json")));
if(in_array($korisnicko_ime,$podaci)){
    array_splice($podaci,array_search($korisnicko_ime,$podaci),1);
    fwrite(fopen("userlist.json","w"),json_encode($podaci));
    unlink("userdata_".$korisnicko_ime.".json");
    echo "data: ok\n\n";
}else{
    echo "data: user hasn't found\n\n";
}
flush();
?>