<?php
require "json_library.php";
verify_json("pool_structure.json",array("title"=>"string","questions"=>"array"),true);
$data=json_get("pool_structure.json",true);

echo "<!DOCTYPE html></html><head><title>unos</title><meta charset=\"utf-8\"><style>h1,td{text-align: center;}</style></head><body>";

echo "<h1>".$data["title"]."</h1>";
echo "<form action=\"unos_write.php\">";

$data=$data["questions"];

echo "<ol>";

for($iter=0;$iter<count($data);$iter++){
	$elem=$data[$iter];//pitanje
	verify($elem,array("title"=>"string","content"=>"array"));
	echo "<li>";
	if(!empty($elem["title"])){
		echo "<p>".$elem["title"]."</p>";
	}
	echo "<table border=\"1\"><tbody><tr><th>Redni broj</th><th>Pitanje</th><th>Odgovor</th></tr>";
	$elem=$elem["content"];//potpitanja
	for($iter2=0;$iter2<count($elem);$iter2++){
		$elem2=$elem[$iter2];
		verify($elem2,array("text"=>"string","answers"=>"array"));
		echo "<tr><td>".($iter2+1).".</td>";
		echo "<td>".$elem2["text"]."</td>";
		echo "<td><select name=\"odgovor_".$iter."_".$iter2."\">";
		$elem2=$elem2["answers"];
		$selected_index=rand(0,count($elem2));
		for($iter3=0;$iter3<count($elem2);$iter3++){
			echo "<option value=\"".$elem2[$iter3]."\"".($iter3===$selected_index?" selected":"").">".$elem2[$iter3]."</option>";
		}
		echo "/td>";
		echo "</tr>";
	}
	echo "</tbody></table><br></li>";
}

echo "<br><input type=\"submit\"></form></body></html>";
?>