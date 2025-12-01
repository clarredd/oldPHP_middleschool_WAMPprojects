<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
echo "data: ".fread(fopen("userlist.json"),filesize("userlist.json"))."\n\n";
flush();
?>