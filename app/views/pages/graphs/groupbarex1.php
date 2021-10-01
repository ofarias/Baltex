<?php // content="text/plain; charset=utf-8"
// $Id: groupbarex1.php,v 1.2 2002/07/11 23:27:28 aditus Exp $
require_once ('../../../../app/Classes/lib/jpgraph/src/jpgraph.php');
require_once ('../../../../app/Classes/lib/jpgraph/src/jpgraph_bar.php');

$datay1=array(35,160,0,0,0,300, 30);
$datay2=array(35,190,190,190,190,190, 60);
$datay3=array(20,70,70,140,230,260, 90);
$datay4=array(20,70,70,140,230,260, 120);
$datay5=array(20,70,70,140,230,260, 150);
$datay6=array(20,70,70,140,230,260, 180);
$datay7=array(20,70,70,140,230,260, 210);

$graph = new Graph(450,200,'auto');
$graph->clearTheme();
$graph->SetScale("textlin");
$graph->SetShadow();
$graph->img->SetMargin(40,30,40,40);
$graph->xaxis->SetTickLabels($gDateLocale->GetShortMonth());

$graph->xaxis->title->Set('Year 2002');
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

$graph->title->Set('Group bar plot');
$graph->title->SetFont(FF_FONT1,FS_BOLD);

$bplot1 = new BarPlot($datay1);
$bplot1->SetFillColor("yellow");
$bplot2 = new BarPlot($datay2);
$bplot2->SetFillColor("brown");
$bplot3 = new BarPlot($datay3);
$bplot3->SetFillColor("darkgreen");
$bplot4 = new BarPlot($datay4);
$bplot4->SetFillColor("blue");
$bplot5 = new BarPlot($datay5);
$bplot5->SetFillColor("red");
$bplot6 = new BarPlot($datay6);
$bplot6->SetFillColor("green");
$bplot7 = new BarPlot($datay7);
$bplot7->SetFillColor("orange");


$bplot1->SetShadow();
$bplot2->SetShadow();
$bplot3->SetShadow();

$bplot1->SetShadow();
$bplot2->SetShadow();
$bplot3->SetShadow();

$gbarplot = new GroupBarPlot(array($bplot1,$bplot2,$bplot3,$bplot4,$bplot5,$bplot6,$bplot7));
$gbarplot->SetWidth(0.6);
$graph->Add($gbarplot);

$graph->Stroke();
?>
