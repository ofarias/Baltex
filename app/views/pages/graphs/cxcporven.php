<?php // content="text/plain; charset=utf-8"
require_once ('../../../../app/Classes/lib/jpgraph/src/jpgraph.php');
require_once ('../../../../app/Classes/lib/jpgraph/src/jpgraph_bar.php');

$fi = $_GET['fi'];
$ff = $_GET['ff'];
$vnd = isset($_GET['vnd'])? $_GET['vnd']:'';
$cli = isset($_GET['cli'])? $_GET['cli']:'';
$emp = isset($_GET['emp'])? $_GET['emp']:'';
$t = isset($_GET['t'])? $_GET['t']:'d';
$data1 = array();  $data2=array(); $info_mensual1= array(); $info_mensual2= array();
$usr = "SYSDBA";
$pwd = "masterkey";

if($t=='d'){/// valor predeterminado sin filtros.
    /// definimos la fecha inicial como 01 01 2000
    //$fi = '2007-07-01'; $ff= new DateTime('2021-09-15');
    //// definimos la fecha final como el ultimo dia del mes.
    //$ff = new DateTime();
    //$host="baltex2019.dyndns.org:C:\\Program Files (x86)\\Common Files\\Aspel\\Sistemas Aspel\\SAE7.00\\Empresa01\\Datos\\SAE70EMPRE01.FDB";
    $host="C:\\Program Files (x86)\\Common Files\\Aspel\\Sistemas Aspel\\SAE7.00\\Empresa01\\Datos\\SAE70EMPRE01.FDB";
    $cnx=ibase_connect($host, $usr, $pwd);
    if(!$cnx){ echo 'Acceso denegado'; exit;}
        $query="SELECT * FROM FTC_GRAFICA1 where ff between '$fi' and '$ff'";
        $res=ibase_query($cnx,$query);
    if(!$res){echo "No se puede mostrar los datos de la consulta $query";exit;}        
    while($tsArray = ibase_fetch_object($res)){
        $data1[]=$tsArray;
    }
}
//// 

//$a=0;$b=0;$c=0;$d=0;$e=0;$f=0;
//$legends=array();$values=array();$total=0;
$ctrl=0;$datay1=array(); $datay2=array();$datay3=array();
$w=450; $h=300; $meses=array();
foreach($data1 as $d ){
    $ctrl++;
    array_push($datay1, $d->POR_CORRIENTE);
    array_push($datay2, $d->POR_VENCIDO);
    array_push($datay3, 0);
    array_push($meses, $d->NOM.'-'.$d->AN); 
    if($ctrl==24){
        $w=1250; 
        break;
    }
}
//echo $ctrl;
// Some data
//$datay1=array(100,100,100,87.5, 86.81, 75.41, 59.01);
//$datay2=array(0,0,0,12.46,13.18, 24.58, 40.98);
//$datay3=array(20,60,70,90);
///$datay4=array(20,60,70,140);
///
// Create the basic graph
$graph = new Graph($w,$h,'auto');
$graph->clearTheme();
$graph->SetScale("textlin");
$graph->img->SetMargin(40,80,30,40);

// Adjust the position of the legend box
$graph->legend->Pos(0.02,0.15);

// Adjust the color for theshadow of the legend
$graph->legend->SetShadow('darkgray@0.5');
$graph->legend->SetFillColor('lightblue@0.3');

// Get localised version of the month names
//$graph->xaxis->SetTickLabels($gDateLocale->GetShortMonth());
//$meses = array('ene','feb', '');
$graph->xaxis->SetTickLabels($meses);

// Set a nice summer (in Stockholm) image
$graph->SetBackgroundImage('logoBaltex.jpg',BGIMG_COPY);

// Set axis titles and fonts
$graph->xaxis->title->Set('Year 2007');
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetColor('blue');

$graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetColor('blue');

$graph->yaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->SetColor('blue');

//$graph->ygrid->Show(false);
$graph->ygrid->SetColor('blue@0.5');

// Setup graph title
$graph->title->Set("Porcentaje % de lo vencido, \n calculado al ultimo dia del mes \n-");
// Some extra margin (from the top)
$graph->title->SetMargin(3);
$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);

// Create the three var series we will combine
$bplot1 = new BarPlot($datay1);
$bplot2 = new BarPlot($datay2);
$bplot3 =  new BarPlot($datay3);
//$bplot4 = new BarPlot($datay4);

// Setup the colors with 40% transparency (alpha channel)
$bplot1->SetFillColor('orange@0.4');
$bplot2->SetFillColor('brown@0.4');
//$bplot3->SetFillColor('darkgreen@0.4');
//$bplot4->SetFillColor('darkgreen@0.4');

// Setup legends
$bplot1->SetLegend('% corriente');
$bplot2->SetLegend('% vencido');
//$bplot3->SetLegend('Label 3');
//$bplot4->SetLegend('Label 4');

// Setup each bar with a shadow of 50% transparency
$bplot1->SetShadow('black@0.4');
$bplot2->SetShadow('black@0.4');
//$bplot3->SetShadow('black@0.4');
//$bplot4->SetShadow('black@0.4');
$bplot1->SetWidth(20);
$bplot2->SetWidth(20);

//$gbarplot = new GroupBarPlot(array($bplot1,$bplot2,$bplot3, $bplot4));
$gbarplot = new GroupBarPlot(array($bplot1, $bplot2));
$gbarplot->SetWidth(0.8);
$graph->Add($gbarplot);

$graph->Stroke();
?>
