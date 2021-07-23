<?php
session_start();
date_default_timezone_set('America/Mexico_City');
require_once('app/controller/pegaso.controller.php');
$controller = new pegaso_controller;

if(isset($_GET['action'])){
$action = $_GET['action'];
}else{
	$action = '';
}
if (isset($_POST['usuario'])){
	$controller->InsertaUsuarioN($_POST['usuario'], $_POST['contrasena'], $_POST['email'], $_POST['rol'], $_POST['letra']);	
}elseif (isset($_POST['cambioSenia'])){
	$nuevaSenia=$_POST['nuevaSenia'];
	$actual = $_POST['actualSenia'];
	$usuario=$_POST['u'];
	$controller->cambioSenia($nuevaSenia, $actual, $usuario );
}elseif(isset($_POST['user']) && isset($_POST['contra'])){
	$controller->LoginA($_POST['user'], $_POST['contra']);
}elseif(isset($_POST['actualizausr'])){
	$controller->actualiza($_POST['mail'], $_POST['usuario1'], $_POST['contrasena1'], $_POST['email1'], $_POST['rol1'], $_POST['estatus']);
}elseif($action == 'modifica'){
	$controller->ModificaU($_GET['e']);
}elseif (isset($_POST['reporte'])){
	$controller->reporte($_POST['emp'],$_POST['opcion'], $_POST['doc']);
}elseif (isset($_POST['invDia'])) {
	$controller->invDia($_POST['emp'],$_POST['inicio'],$_POST['fin']);
}elseif(isset($_POST['cuadre'])){
	$controller->cuadre($_POST['emp'], $_POST['doc']);
}elseif (isset($_POST['pzas_totales'])) {
	$controller->pzas_totales($_POST['emp'],$art=$_POST['art']);
}elseif(isset($_POST['cancelar'])){
	$controller->cancelar($_POST['emp'],$fact=$_POST['fact'], $comp=$_POST['comp'], $docu=$_POST['docu'], $articulo = $_POST['articulo'], $cant=$_POST['cant']);
}elseif(isset($_POST['realizaCEP'])){
	$folios = $_POST['fol'];
	//exit('Realiza el CEP: '.$folios );
	$controller->realizaCEP($folios);
	exit();
}elseif(isset($_POST['selPago'])){
	$res=$controller->selPago($_POST['idp'], $_POST['tipo']);
	echo json_encode($res);
	exit();	
}elseif (isset($_POST['cargaXML'])) {
	$res=$controller->cargaXML();
	echo json_encode($res);
	exit();
}elseif(isset($_POST['enviar'])){
	$res=$controller->enviarComp($_POST['docu'], $_POST['correo'], $_POST['adi'], $_POST['doc']);
	echo json_encode($res);
	exit();
}
else{switch ($_GET['action']){
	case 'login':
		$controller->Login();
		break;
	case 'inicio':
		$controller->Inicio();
		break;
	case 'CambiarSenia':
		$controller->CambiarSenia();
		break;
	case 'madmin':
		$controller->MenuAdmin();
		break;
	case 'empresa':
		$controller->empresa($_GET['emp']);
		break;
	case 'reporte':
		$controller->reporte($_GET['emp'], $opcion='a', $doc='');
		break;
	case 'invDia':
		$controller->invDia($_GET['emp'], $inicio='a', $fin=false);
		break;
	case 'cuadre':
		$controller->cuadre($_GET['emp'],$doc='a');
		break;
	case 'pzas_totales':
		$controller->pzas_totales($_GET['emp'],$art='a');
		break;
	case 'cancelar':
		$controller->cancelar($_GET['emp'],$fact='a', $comp=false, $docu=false, $articulo = false, $cant=false);
		break;
	case 'verPagos':
		$controller->verPagos();
		break;
	case 'verComprobantes':
		$controller->verComprobantes($_GET['tipo']);
		break;
	case 'enviar':
		$res=$controller->enviarComp($_GET['docu'], $_GET['correo'], $_GET['adi'], $_GET['doc']);
		break;
	default: 
	header('Location: index.php?action=login');
	break;
	}

}
?>