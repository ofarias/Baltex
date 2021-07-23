<?php
require_once('app/model/pegaso.model.php');
require_once('app/fpdf/fpdf.php');
require_once('app/views/unit/commonts/numbertoletter.php');

class pegaso_controller{
	//var $contexto_local = "http://SERVIDOR:8081/pegasoFTC/app/";
	//var $contexto = "http://SERVIDOR:8081/pegasoFTC/app/";
	/*Obtiene y carga el template*/
	function load_template($title='Sin Titulo'){
		$pagina = $this->load_page('app/views/master.php');
		$header = $this->load_page('app/views/sections/s.header.php');
		$pagina = $this->replace_content('/\#HEADER\#/ms' ,$header , $pagina);
		$pagina = $this->replace_content('/\#TITLE\#/ms' ,$title , $pagina);		
		return $pagina;
	}
	
	/*Header para login*/
	function load_templateL($title='Sin Titulo'){
		$pagina = $this->load_page('app/views/master.php');
		$header = $this->load_page('app/views/sections/header.php');
		$pagina = $this->replace_content('/\#HEADER\#/ms' ,$header , $pagina);
		$pagina = $this->replace_content('/\#TITLE\#/ms' ,$title , $pagina);		
		return $pagina;
	}

	/*Header para los popup?*/
	function load_template_popup($title='Ferretera Pegaso'){
		$pagina = $this->load_page('app/views/master.php');
		$header = $this->load_page('app/views/sections/s.header2.php');
		$pagina = $this->replace_content('/\#HEADER\#/ms' ,$header , $pagina);
		$pagina = $this->replace_content('/\#TITLE\#/ms' ,$title , $pagina);		
		return $pagina;
	}

	function CSesion(){
		session_destroy($_SESSION['user']);
		session_unset($_SESSION['user']);
		$e = "Session Finalizada";
		header('Location: index.php?action=login&e='.urlencode($e)); exit;
	}
	/* METODO QUE CARGA UNA PAGINA DE LA SECCION VIEW Y LA MANTIENE EN MEMORIA
		INPUT
		$page | direccion de la pagina 
		OUTPUT
		STRING | devuelve un string con el codigo html cargado
	*/	
   private function load_page($page){
		return file_get_contents($page);
	}
   
   /* METODO QUE ESCRIBE EL CODIGO PARA QUE SEA VISTO POR EL USUARIO
		INPUT
		$html | codigo html
		OUTPUT
		HTML | codigo html		
	*/
   private function view_page($html){
		echo $html;
	}
   
   /* PARSEA LA PAGINA CON LOS NUEVOS DATOS ANTES DE MOSTRARLA AL USUARIO
		INPUT
		$out | es el codigo html con el que sera reemplazada la etiqueta CONTENIDO
		$pagina | es el codigo html de la pagina que contiene la etiqueta CONTENIDO
		OUTPUT
		HTML 	| cuando realiza el reemplazo devuelve el codigo completo de la pagina
	*/
   private function replace_content($in='/\#CONTENIDO\#/ms', $out,$pagina){
		 return preg_replace($in, $out, $pagina);	 	
	}
	
	function Login(){
			$pagina = $this->load_templateL('Login');
			$html = $this->load_page('app/views/modules/m.login.php');
			$pagina = $this->replace_content('/\#CONTENIDO\#/ms', $html, $pagina);
			$this->view_page($pagina);
	}

	function Autocomp(){
		$arr = array('prueba1', 'trata2', 'intento3', 'prueba4', 'prueba5');
		echo json_encode($arr);
		exit;
	}

	function LoginA($user, $pass){
		$data = new pegaso;
			$_SESSION['emp']=1;
			$rs = $data->AccesoLogin($user, $pass);
				if(isset($rs) > 0){					
					$r = $data->CompruebaRol($user, $pass);
					switch ($r->USER_ROL){
						case 'admin':
							$this->MenuAdmin();
							break;
						case 'xml':
							$this->xmlMenu();
		        			break;
		        		case 'facturacion':
		       	 			$this->MenuFacturacion();
		        			break;
						default:
						$e = "Error en acceso 1, favor de revisar usuario y/o contraseña";
						header('Location: index.php?action=login&e='.urlencode($e)); exit;
						break;
						}

				}else{
					$e = "Error en acceso 2, favor de revisar usuario y/o contraseña";
						header('Location: index.php?action=login&e='.urlencode($e)); exit;
				}
	}

	function Inicio(){
		if(isset($_SESSION['user'])){
			$o = $_SESSION['user'];
			switch($o->USER_ROL){
				case 'admin':
					$this->MenuAdmin();
					break;
				case 'xml':
					$this->xmlMenu();
		        	break;
		        case 'facturacion':
		        	$this->MenuFacturacion();
		        	break;
				default:
				$e = "Error en acceso 1, favor de revisar usuario y/o contraseña";
				header('Location: index.php?action=login&e='.urlencode($e)); exit;
				break;
				}
		}
	}
	
	function CambiarSenia(){	
		if(isset($_SESSION['user'])){
			$data= new pegaso;
			$pagina = $this->load_template('Menu Admin');			
			$html = $this->load_page('app/views/pages/p.cambiarSenia.php');
			$pagina = $this->replace_content('/\#CONTENIDO\#/ms', $html, $pagina);
			ob_start();
			$this-> view_page($pagina);
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}

	function cambioSenia($nuevaSenia, $actual, $usuario){
		if(isset($_SESSION['user'])){
			$data=new pegaso;
			$pagina = $this->load_template('Menu Admin');			
			$html = $this->load_page('app/views/pages/p.cambiarSenia.php');
			ob_start();
			$cambio=$data->cambioSenia($nuevaSenia, $actual, $usuario);
			$this->CerrarVentana();
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}	
	}

	/*nuevos menus*/
		
	function MenuAdmin(){    
        if(isset($_SESSION['user'])){
            $pagina = $this->load_template('Menu Admin');
            //$html = $this->load_page('app/views/modules/m.mad.php');
            ob_start();
            $table =ob_get_clean();
            $usuario=$_SESSION['user']->NOMBRE;    
            include 'app/views/modules/m.mad.php';
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
            $this-> view_page($pagina);
        }else{
            $e = "Favor de Revisar sus datos";
            header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
    }
	
	function empresa($emp){
		if(isset($_SESSION['user'])){
            $_SESSION['emp']=$emp;
            $pagina = $this->load_template('');
            ob_start();
            $table =ob_get_clean();
            $usuario=$_SESSION['user']->NOMBRE;    
            include 'app/views/modules/m.mmenu.php';
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
            $this-> view_page($pagina);
        }else{
            $e = "Favor de Revisar sus datos";
            header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
	}

	function reporte($emp, $opcion, $doc){	
		if(isset($_SESSION['user'])){
			if($emp == 1){
				$data = new pegaso;		
			}else{
				$data = new pegaso;		
			}
			if($opcion == 'a'){
				$docs = array();
			}else{
				$docs=$data->reporte($opcion, $doc);
			}
			$pagina=$this->load_template('Menu Admin');				
			include 'app/views/pages/p.reporte.php';
			$html=$this->load_page('app/views/pages/p.reporte.php');
			$table =ob_get_clean();
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
			ob_start();
			$this ->view_page($pagina);
		}else{
			$e = "Favor de iniciar sesión";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}

	function invDia($emp, $inicio, $fin){
		if(isset($_SESSION['user'])){
			if($emp == 1){
				$data = new pegaso;		
			}else{
				$data = new pegaso;		
			}
			if($inicio=='a'){
				$inicio = date("d.m.Y");
				$fin = date("d.m.Y");
				$info=$data->invDia($emp,$inicio, $fin);
				$infoC=$data->invDiaC($emp,$inicio, $fin);
			}else{
				$info=$data->invDia($emp,$inicio, $fin);
				$infoC=$data->invDiaC($emp,$inicio, $fin);
			}
			$pagina=$this->load_template('Menu Admin');				
			include 'app/views/pages/p.invent_dia.php';
			$html=$this->load_page('app/views/pages/p.invent_dia.php');
			$table =ob_get_clean();
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
			ob_start();
			$this ->view_page($pagina);
		}else{
			$e = "Favor de iniciar sesión";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}	
	}

	function cuadre($emp, $docu){
		if(isset($_SESSION['user'])){
			if($emp == 1){
				$data = new pegaso;		
			}else{
				$data = new pegaso;		
			}
			if($docu=='a'){
				$info=array();
				$infoM=array();
			}else{
				$info=$data->cuadre_par($docu);
				$infoM=$data->cuadre_mov($docu);
			}
			$pagina=$this->load_template('Menu Admin');				
			include 'app/views/pages/p.cuadre.php';
			$html=$this->load_page('app/views/pages/p.cuadre.php');
			$table =ob_get_clean();
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
			ob_start();
			$this ->view_page($pagina);
		}else{
			$e = "Favor de iniciar sesión";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}	
	}

	function pzas_totales($emp, $art){
		if(isset($_SESSION['user'])){
			if($emp == 1){
				$data = new pegaso;		
			}else{
				$data = new pegaso;		
			}
			if($art=='a'){
				$info=array();
				$kardex=array();
			}else{
				$info=$data->pzas_totales($art, $emp);
				$kardex=$data->kardex($art, $emp);
			}
			$articulos=$data->traeArticulos($emp);
			$pagina=$this->load_template();				
			include 'app/views/pages/p.pzas_totales.php';
			$html=$this->load_page('app/views/pages/p.pzas_totales.php');
			$table =ob_get_clean();
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
			ob_start();
			$this ->view_page($pagina);
		}else{
			$e = "Favor de iniciar sesión";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}	
	}

	function cancelar($emp, $fact, $comp, $docu, $articulo, $cant){
		if(isset($_SESSION['user'])){
			ob_start();
			if($emp == 1){
				$data = new pegaso;		
			}else{
				$data = new pegaso;		
			}
			if($fact=='a'){
				$info=array();
				$kardex=array();
				$pagina=$this->load_template('Menu Admin');				
				include 'app/views/pages/p.cancelar.php';
				$html=$this->load_page('app/views/pages/p.cancelar.php');
				$table =ob_get_clean();
            	$pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
				$this ->view_page($pagina);
			}else{
				$exec=$data->cancelar($fact, $comp, $docu, $articulo, $cant);
				echo "<script>alert('".$exec."')</script>";
				$redireccionar="cancelar&emp{$emp}";
				$pagina=$this->load_template('Pedidos');
            	$html = $this->load_page('app/views/pages/p.redirectform.php');
            	include 'app/views/pages/p.redirectform.php';
            	$this->view_page($pagina);
			}
			
		}else{
			$e = "Favor de iniciar sesión";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}	
	}

	function verPagos(){
        if($_SESSION['user']){
            $usuario = $_SESSION['user']->NOMBRE; 
            $data = new pegaso;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/p.verPagos.php');
            ob_start();
                $pagos =$data->verPagos();
                include 'app/views/pages/p.verPagos.php';
                $table = ob_get_clean();
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
                $this->view_page($pagina);
        }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
    }

    function realizaCEP($folios){
        if($_SESSION['user']){
            $data= new pegaso;
            $realiza=$data->realizaCEP($folios);
            //$rel = $data->cargaCEP('174');
            //// Primero seleccionamos todos los CEP que se hicieron y que no se han enviado. 
            $sel = $data->cepNoEnviados();
            if(count($sel) >= 0){
            	foreach ($sel as $k) {
            		$fecha= substr($k->FECHA_CERT, 0,10);
            		$documento = $k->RFC.'('.$k->SERIE.$k->FOLIO.')'.substr($fecha,8,2).'-'.substr($fecha,5,2).'-'.substr($fecha,0,4);
            		sleep(3);
            		$this->enviarComp($documento, $k->CORREO , 'genseg@hotmail.com' , $k->CVE_DOC);
            	}
            }
            $this->verPagos();
        }
    }

    function selPago($idp, $tipo){
    	if($_SESSION['user']){
    		$data = new pegaso;
    		$res=$data->selPago($idp, $tipo);
    		return $res;
    	}
    }

    function cargaXML(){
    	if($_SESSION['user']){
    		$data=new pegaso;
    		$res=$data->cargaXML();
    		return $res;
    	}
    }

    function verComprobantes($tipo){
    	if($_SESSION['user']){
            $usuario = $_SESSION['user']->NOMBRE; 
            $data = new pegaso;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/p.verComprobantes.php');
            ob_start();
                $comprobantes =$data->verComprobantes($tipo);
                include 'app/views/pages/p.verComprobantes.php';
                $table = ob_get_clean();
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
                $this->view_page($pagina);
        }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
    }

    function enviarComp($docu, $correo, $adicional, $doc){
    	/*
    	echo 'Se enviara con los siguientes parametros:<br/>';
    	echo 'Documento: '.$docu.'<br/>';
    	echo 'Correo: '.$correo.'<br/>';
    	echo 'Adicional: '.$adicional.'<br/>';
    	echo 'Doc: '.$doc.'<br/>';
		*/
    	$data = new pegaso;
    	$act = $data->actualizaEstado($doc);
    	$_SESSION['docu'] = $docu;
    	$_SESSION['correo']=$correo;
    	$_SESSION['adicional']=$adicional;
    	include 'app/mailer/send.CP.php';

    }


	
}?>

