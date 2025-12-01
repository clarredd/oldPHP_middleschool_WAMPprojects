<?php 
echo "<!DOCTYPE html><html><head><title>DASHBOARD</title></head><body><h1>DASHBOARD</h1>";

echo '<a href="index.html">Home</a><br><br><br>';

require "json_library.php";
$queries=json_get_arr("queries.json");
foreach(array_keys($queries) as $filename){
	echo "<a href='query_board.php?target=".$filename."'>".$filename."</a><br>";
}
echo "<br><br><p>CREATE NEW</p>";
echo "<form action='create_new.php'><input type='text' name='filename' placeholder='Enter the name here'><input style='margin-left: 10px;' type='submit'></form>";

echo "</body></html>";
?>