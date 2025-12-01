<?php // content="text/plain; charset=utf-8"

//var_dump($_GET['width']);exit;

require_once ('jpgraph-4.3.5/src/jpgraph.php');
require_once ('jpgraph-4.3.5/src/jpgraph_pie.php');

$data=json_decode(urldecode($_GET["data"]));

//$graph=new PieGraph(intval($_GET["width"]),intval($_GET["height"]));
$graph=new PieGraph($_GET["width"],$_GET["height"]);

//$theme_class="DefaultTheme";
//$graph->SetTheme(new $theme_class());
//$graph->SetTheme(new AquaTheme);

$graph->title->Set(urldecode($_GET["title"]));
$graph->SetBox(true);


$p1 = new PiePlot($data);
$graph->Add($p1);

$p1->setLabels(json_decode(urldecode($_GET["labels"])));//,"auto");

$p1->ShowBorder();
//$p1->SetColor('black');
//$p1->SetSliceColors(array('#1E90FF','#2E8B57','#ADFF2F','#DC143C','#BA55D3'));
$graph->Stroke();
?>