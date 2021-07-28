<?php
session_start();
date_default_timezone_set('America/Mexico_City');
require_once('app/controller/cxc.controller.php');
$controller = new controllerCxC;

if(isset($_GET['action'])){
$action = $_GET['action'];
}else{
	$action = '';
}
if (isset($_POST['usuario'])){
	$controller->InsertaUsuarioN($_POST['usuario'], $_POST['contrasena'], $_POST['email'], $_POST['rol'], $_POST['letra']);	
}elseif (isset($_POST['report'])) {
	$res=$controller->menuCxC($_POST['t'].$_POST['opc']);echo json_encode($res); exit();
}
else{switch ($_GET['action']){
	case 'menuCxC':
		$opc=isset($_GET['opc'])? $_GET['opc']:'';
		$controller->menuCxC($opc);
		break;
	default: 
	header('Location: index.php?action=login');
	break;
	}

}
?>