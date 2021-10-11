<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_pie.php');

// Some data
$data = array(15,10,19,25,21,10);

// Create the Pie Graph.
$graph = new PieGraph(600,200);
$graph->clearTheme();
$graph->SetShadow();

// Set A title for the plot
$graph->title->Set("Example 2 Pie plot");
$graph->title->SetFont(FF_FONT1,FS_BOLD);
$num1 = number_format(1299999, 2);
// Create
$p1 = new PiePlot($data);
$p1->SetLegends(array("0 a 30 dias $ ".$num1,"Feb","Mar","Apr","May","Jun","Jul"));
$graph->Add($p1);
$graph->Stroke();

?>
