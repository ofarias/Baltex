<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');

// Some data
$datax = array("Ene-2020","Feb-2020","Mar-2020","Abr-2020","May-2020","Jun-2020");
//$datay = array(28,13,24,"",90,11);
$data2y = array(10355999,41,"-",33,"-",63);
$data3y = array(641496,25,"-",60,8,43);
$data4y = array(1162575,25,"-",60,8,43);
$data5y = array(159856,25,"-",60,8,43);
$data6y = array(11291412,25,"-",60,8,43);
$data7y = array(7396423,25,"-",60,8,43);

// Setup graph
$graph = new Graph(1400,450);
$graph->clearTheme();
$graph->img->SetMargin(100,150,40,80);
$graph->SetScale("textlin");
$graph->SetShadow();

//Setup title
$graph->title->Set("Line plot with null values");

// Use built in font
$graph->title->SetFont(FF_ARIAL,FS_NORMAL,14);

// Slightly adjust the legend from it's default position
$graph->legend->Pos(0.01,0.5,"right","center");
$graph->legend->SetFont(FF_FONT1,FS_BOLD);

// Setup X-scale
$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8);
$graph->xaxis->SetLabelAngle(45);

// Create the first line
//$p1 = new LinePlot($datay);
//$p1->mark->SetType(MARK_FILLEDCIRCLE);
//$p1->mark->SetFillColor("red");
//$p1->mark->SetWidth(4);
//$p1->SetColor("blue");
//$p1->SetCenter();
//$p1->SetLegend("Undefined\nvariant 1");
//$graph->Add($p1);

$valor2 =7396423.4;
// ... and the second
$p2 = new LinePlot($data2y);
$p2->mark->SetType(MARK_STAR);
$p2->mark->SetFillColor("red");
$p2->mark->SetWidth(4);
$p2->SetColor("red");
$p2->SetCenter();
$p2->SetLegend("1 a 30 dias $ ".number_format($valor2,2));
$graph->Add($p2);

$valor3 =10355999.02;
// ... and the third
$p3 = new LinePlot($data3y);
$p3->mark->SetType(MARK_FILLEDCIRCLE);
$p3->mark->SetFillColor("blue");
$p3->mark->SetWidth(4);
$p3->SetColor("blue");
$p3->SetCenter();
$p3->SetLegend("31 a 60 dias ".number_format($valor3,2));
$graph->Add($p3);

$valor4 =641492.9;
// ... and the third
$p4 = new LinePlot($data4y);
$p4->mark->SetType(MARK_SQUARE);
$p4->mark->SetFillColor("yellow");
$p4->mark->SetWidth(4);
$p4->SetColor("yellow");
$p4->SetCenter();
$p4->SetLegend("61 a 90 dias $ ".number_format($valor4,2));
$graph->Add($p4);

$valor5 =1162575.7;
// ... and the third
$p5 = new LinePlot($data5y);
$p5->mark->SetType(MARK_CIRCLE);
$p5->mark->SetFillColor("brown");
$p5->mark->SetWidth(4);
$p5->SetColor("brown");
$p5->SetCenter();
$p5->SetLegend("91 a 120 dias $ ".number_format($valor5,2));
$graph->Add($p5);

$valor6 =159856.6;
// ... and the third
$p6 = new LinePlot($data6y);
$p6->mark->SetType(MARK_CROSS);
$p6->mark->SetFillColor("purple");
$p6->mark->SetWidth(4);
$p6->SetColor("purple");
$p6->SetCenter();
$p6->SetLegend("Mayor a 121 dias $ ".number_format($valor6,2));
$graph->Add($p6);

$valor7 =11291412.5;
// ... and the third
$p7 = new LinePlot($data7y);
$p7->mark->SetType(MARK_UTRIANGLE);
$p7->mark->SetFillColor("pink");
$p7->mark->SetWidth(4);
$p7->SetColor("pink");
$p7->SetCenter();
$p7->SetLegend("Corriente $ ".number_format($valor7,2));
$graph->Add($p7);

// Output line
$graph->Stroke();

?>
