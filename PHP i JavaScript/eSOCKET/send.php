<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
$posiljalac=$_REQUEST["posiljalac"];
$primalac=$_REQUEST["primalac"];
$poruka=$_REQUEST["poruka"];
$lista_korisnika=json_decode(fread(fopen("userlist.json","r"),filesize("userlist.json")));
if(in_array($posiljalac,$lista_korisnika)){
    if(in_array($primalac,$lista_korisnika)){
        $podaci=json_decode(fread(fopen("userdata_".$primalac.".json","r"),filesize("userdata_".$primalac.".json")));
        array_push($podaci,array("sender"=>$posiljalac,"message"=>$poruka));
        fwrite(fopen("userdata_".$primalac.".json","w"),json_encode($podaci));
        echo "data: ok\n\n";
    }else{
        echo "data: reciver hasn't found\n\n";
    }
}else{
    echo "data: sender hasn't found\n\n";
}
flush();
?>