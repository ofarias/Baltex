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


if($t == 'd'){/// valor predeterminado sin filtros.
    /// definimos la fecha inicial como 01 01 2000
    $fi = '01.01.2000';
    //// definimos la fecha final como el ultimo dia del mes.
    $ff = new DateTime();
    $ff->modify('last day of this month');
    $meses = $ff->format('n');
    $ff= $ff->format('d.m.Y');
    $anio = 2021;
    //// 
    for ($i=1; $i <= $meses; $i++) { 
        //echo '<br/>Obtiene info del mes '.$i; 
        $fecha = '2021-'.$i.'-01';
        $fin= new DateTime($fecha);
        $fin->modify('last day of this month');
        $fin= $fin->format('d.m.Y');
        //// corre la consulta del primer mes: 
        $host="baltex.dyndns.org:C:\\Program Files (x86)\\Common Files\\Aspel\\Sistemas Aspel\\SAE7.00\\Empresa01\\Datos\\SAE70EMPRE01.FDB";
        $cnx=ibase_connect($host, $usr, $pwd);
        if(!$cnx){ echo 'Acceso denegado'; exit;}
        $query="SELECT TIPO, MAX(RANGO) AS RANGO, SUM(SALDO) AS SALDO FROM SP_ANTIGUEDAD('$fi', '$fin') WHERE SALDO > 2 GROUP BY TIPO ";
        $res=ibase_query($cnx,$query);
        if(!$res){echo "No se puede mostrar los datos de la consulta $query";exit;}        
        while($tsArray = ibase_fetch_object($res)){
            $data1[]=$tsArray;
        }

        $host="baltex.dyndns.org:C:\\Program Files (x86)\\Common Files\\Aspel\\Sistemas Aspel\\SAE7.00\\Empresa02\\Datos\\SAE70EMPRE02.FDB";
        $cnx=ibase_connect($host, $usr, $pwd);
        if(!$cnx){ echo 'Acceso denegado'; exit;}
        $query="SELECT TIPO, MAX(RANGO) AS RANGO, SUM(SALDO) AS SALDO FROM SP_ANTIGUEDAD('$fi', '$ff') WHERE SALDO > 2 GROUP BY TIPO ";
        $res=ibase_query($cnx,$query);
        while($tsArray = ibase_fetch_object($res)){
            $data2[]=array("mes"=>$i, "anio"=>$anio, "datos"=>$tsArray);
        }
        //echo '<br/> Fecha final es de '.$fin;
        //echo 'Consulta : '.$query;
        $info_mensual1[] = $data1; 
        $info_mensual2[] = $data2;
        unset ($data1);
    }
    echo 'numero de meses'.count($info_mensual2);
    $arr=0;
    foreach ($info_mensual1 as $key){
        //echo '<br>Arreglo: '.$arr++.'<br/>';
        //print_r($key);
        //exit;
    }
    //echo 'Los meses que vamos a recorrer son '.$meses;
    //print_r($data1);
    foreach ($info_mensual2 as $key2){
        echo '<br>Arreglo empresa 2 : '.$arr++.'<br/>';
        print_r($key2);

        //echo '<br/>Mes ='.$key2[0]['mes'].' AÑO: '.$key2[0]['anio'];
        //echo '<br/>>Datos: <br/>';
        //print_r($key2[0]);
        exit;
    }

    die();




}

$usr = "SYSDBA";
$pwd = "masterkey";
$host="baltex.dyndns.org:C:\\Program Files (x86)\\Common Files\\Aspel\\Sistemas Aspel\\SAE7.00\\Empresa01\\Datos\\SAE70EMPRE01.FDB";
$cnx=ibase_connect($host, $usr, $pwd);
if(!$cnx){ echo 'Acceso denegado'; exit;}
$query="SELECT TIPO, MAX(RANGO) AS RANGO, SUM(SALDO) AS SALDO FROM SP_ANTIGUEDAD('$fi', '$ff') WHERE SALDO > 2 GROUP BY TIPO ";
$res=ibase_query($cnx,$query);

if(!$res){echo "No se puede mostrar los datos de la consulta $query";exit;}

while($tsArray = ibase_fetch_object($res)){
    $data1[]=$tsArray;
}

$host="baltex.dyndns.org:C:\\Program Files (x86)\\Common Files\\Aspel\\Sistemas Aspel\\SAE7.00\\Empresa02\\Datos\\SAE70EMPRE02.FDB";
$cnx=ibase_connect($host, $usr, $pwd);
if(!$cnx){ echo 'Acceso denegado'; exit;}
$query="SELECT TIPO, MAX(RANGO) AS RANGO, SUM(SALDO) AS SALDO FROM SP_ANTIGUEDAD('$fi', '$ff') WHERE SALDO > 2 GROUP BY TIPO ";
$res=ibase_query($cnx,$query);
while($tsArray = ibase_fetch_object($res)){
    $data2[]=$tsArray;
}
///

$a=0;$b=0;$c=0;$d=0;$e=0;$f=0;
$legends=array();$values=array();$total=0;

// Some data
$datay1=array(100,100,50,60);
$datay2=array(35,90,100,0);
///$datay3=array(20,60,70,140);
///$datay4=array(20,60,70,140);
///
// Create the basic graph
$graph = new Graph(450,250,'auto');
$graph->clearTheme();
$graph->SetScale("textlin");
$graph->img->SetMargin(40,80,30,40);

// Adjust the position of the legend box
$graph->legend->Pos(0.02,0.15);

// Adjust the color for theshadow of the legend
$graph->legend->SetShadow('darkgray@0.5');
$graph->legend->SetFillColor('lightblue@0.3');

// Get localised version of the month names
$graph->xaxis->SetTickLabels($gDateLocale->GetShortMonth());

// Set a nice summer (in Stockholm) image
$graph->SetBackgroundImage('logoBaltex.jpg',BGIMG_COPY);

// Set axis titles and fonts
$graph->xaxis->title->Set('Year 2002');
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
//$bplot3 = new BarPlot($datay3);
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

//$gbarplot = new GroupBarPlot(array($bplot1,$bplot2,$bplot3, $bplot4));
$gbarplot = new GroupBarPlot(array($bplot1, $bplot2));
$gbarplot->SetWidth(0.6);
$graph->Add($gbarplot);

$graph->Stroke();
?>
