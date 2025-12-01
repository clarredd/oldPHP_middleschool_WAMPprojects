<?php

const length=0x1000;//4096;
const delay=1.5;
$first=true;

for(;;){
	flush();
	sleep(delay);
	echo str_pad(($first?'':"<br>")."Hello World!",length);
	$first=false;
}
?>