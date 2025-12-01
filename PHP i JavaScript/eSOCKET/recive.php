<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
$korisnicko_ime=$_REQUEST["ime"];
$podaci_o_korisnicima=json_decode(fread(fopen("userlist.json","r"),filesize("userlist.json")));
if(in_array($korisnicko_ime,$podaci_o_korisnicima)){
	$podaci=json_decode(fread(fopen("userdata_".$korisnicko_ime.".json","r"),filesize("userdata_".$korisnicko_ime.".json")),true);
    if(count($podaci)>0){
		$poruka=$podaci[0];
		array_splice($podaci,0,1);
		fwrite(fopen("userdata_".$korisnicko_ime.".json","w"),json_encode($podaci));
        echo "data: ".json_encode(array("posiljalac"=>$poruka["sender"],"poruka"=>$poruka["message"]))."\n\n";
	}else{
        echo "data: none\n\n";
    }
}else{
    echo "data: user hasn't found\n\n";
}
flush();
?>