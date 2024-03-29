<?php // content="text/plain; charset=utf-8"
require_once ('../../../Classes/lib/jpgraph/jpgraph.php');
require_once ('../../../Classes/lib/jpgraph/jpgraph_bar.php');
/// Traer por tipo ejemplo: 
//print_r($d);
//die;
//print_r($x);
//die;
$sta = new statics;
$importes = array(0,41760,0,0);
/// Aqui van los datos.

// Create the graph. These two calls are always required
$graph = new Graph(1800,850,'auto');
$graph->SetScale("textlin");
// set major and minor tick positions manually
$graph->yaxis->SetTickPositions(array(10000,25000,60000,90000,120000,200000), array(1000,24000,50000,80000, 100000, 190000), array("1k","20k","30k","40k","50k","60k"));
$graph->SetBox("red", "blue");
$graph->ygrid->SetColor('gray');
//$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels(array('Q1','Q2: '."$ 41,760",'Q3'));
//$graph->xaxis->SetTickLabels($x);
$graph->xaxis->SetFont(FF_FONT2);
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

// Create the bar plots
$b1plot = new BarPlot($importes);

// ...and add it to the graPH
$graph->Add($b1plot);

$b1plot->SetColor("white");
$b1plot->SetFillGradient("#0A0F00","white",GRAD_LEFT_REFLECTION);
$b1plot->SetWidth(40);
$graph->title->Set("Facturación ".$titulo);

// Display the graph
$graph->Stroke();

?>
