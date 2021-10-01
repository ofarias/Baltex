<?php // content="text/plain; charset=utf-8"
require_once ('../../../../app/Classes/lib/jpgraph/src/jpgraph.php');
require_once ('../../../../app/Classes/lib/jpgraph/src/jpgraph_pie.php');

$fi= $_GET['fi'];
$ff= $_GET['ff'];
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

$a=0;$b=0;$c=0;$d=0;$e=0;$f=0;
$legends=array();$values=array();$total=0;

foreach($data1 as $key){
    if($key->TIPO == 'A'){$a+=$key->SALDO;}
    if($key->TIPO == 'B'){$b+=$key->SALDO;}
    if($key->TIPO == 'C'){$c+=$key->SALDO;}
    if($key->TIPO == 'D'){$d+=$key->SALDO;}
    if($key->TIPO == 'E'){$e+=$key->SALDO;}
    if($key->TIPO == 'F'){$f+=$key->SALDO;}
    //array_push($legends, $key->RANGO.' $ '.number_format($key->SALDO,2)); 
    //array_push($values, $key->SALDO);
    $total += $key->SALDO;
}

foreach($data2 as $keyb){
    if($keyb->TIPO == 'A'){$a+=$keyb->SALDO;}
    if($keyb->TIPO == 'B'){$b+=$keyb->SALDO;}
    if($keyb->TIPO == 'C'){$c+=$keyb->SALDO;}
    if($keyb->TIPO == 'D'){$d+=$keyb->SALDO;}
    if($keyb->TIPO == 'E'){$e+=$keyb->SALDO;}
    if($keyb->TIPO == 'F'){$f+=$keyb->SALDO;}
    //array_push($legends, $key->RANGO.' $ '.number_format($key->SALDO,2)); 
    //array_push($values, $key->SALDO);
    $total += $keyb->SALDO;
}

foreach($data1 as $key){
    if($key->TIPO == 'A'){array_push($legends, $key->RANGO.' $ '.number_format($a,2));}
    if($key->TIPO == 'B'){array_push($legends, $key->RANGO.' $ '.number_format($b,2));}
    if($key->TIPO == 'C'){array_push($legends, $key->RANGO.' $ '.number_format($c,2));}
    if($key->TIPO == 'D'){array_push($legends, $key->RANGO.' $ '.number_format($d,2));}
    if($key->TIPO == 'E'){array_push($legends, $key->RANGO.' $ '.number_format($e,2));}
    if($key->TIPO == 'F'){array_push($legends, $key->RANGO.' $ '.number_format($f,2));}
    //array_push($values, $key->SALDO);

    if($key->TIPO == 'A'){array_push($values, $a);}
    if($key->TIPO == 'B'){array_push($values, $b);}
    if($key->TIPO == 'C'){array_push($values, $c);}
    if($key->TIPO == 'D'){array_push($values, $d);}
    if($key->TIPO == 'E'){array_push($values, $e);}
    if($key->TIPO == 'F'){array_push($values, $f);}

}
// Some data
$data = $values;
// Create the Pie Graph.
$graph = new PieGraph(600,300);
$graph->clearTheme();
$graph->SetShadow();
// Set A title for the plot
$graph->title->Set("Cartera al \n mes ".date("m-Y")."\n $ ".number_format($total, 2));
$graph->title->SetFont(FF_FONT1,FS_BOLD);
$num1 = number_format(1299999, 2);
// Create
$p1 = new PiePlot($data);
$p1->SetLegends($legends);
$p1->SetCenter(0.3,0.5);
$p1->SetTheme('pastel');
//"earth" "pastel" "sand" "water" 
//$p1->SetSliceColors(array('red','green','blue',''));
$graph->Add($p1);
$graph->Stroke();

?>
