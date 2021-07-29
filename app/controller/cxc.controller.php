<?php
require_once('app/model/cxc.model.php');
require_once('app/model/pegaso.model.php');
require_once('app/fpdf/fpdf.php');
require_once('app/views/unit/commonts/numbertoletter.php');
require_once('app/Classes/PHPExcel.php');

class controllerCxC{
	//var $contexto_local = "http://SERVIDOR:8081/pegasoFTC/app/";
	//var $contexto = "http://SERVIDOR:8081/pegasoFTC/app/";
	/*Obtiene y carga el template*/
	function load_template($title='Sin Titulo'){
		$pagina = $this->load_page('app/views/cxc.master.php');
		$header = $this->load_page('app/views/sections/cxc.s.header.php');
		$pagina = $this->replace_content('/\#HEADER\#/ms' ,$header , $pagina);
		$pagina = $this->replace_content('/\#TITLE\#/ms' ,$title , $pagina);		
		return $pagina;
	}
	
	function load_templateL($title='Sin Titulo'){
		$pagina = $this->load_page('app/views/cxc.master.php');
		$header = $this->load_page('app/views/sections/cxc.header.php');
		$pagina = $this->replace_content('/\#HEADER\#/ms' ,$header , $pagina);
		$pagina = $this->replace_content('/\#TITLE\#/ms' ,$title , $pagina);		
		return $pagina;
	}

	function load_template_popup($title='Ferretera Pegaso'){
		$pagina = $this->load_page('app/views/cxc.master.php');
		$header = $this->load_page('app/views/sections/cxc.s.header2.php');
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
		
    private function load_page($page){
		return file_get_contents($page);
	}
   
   
    private function view_page($html){
		echo $html;
	}
   
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

	function menuCxC($opc){
		if($_SESSION['user']){
			switch (substr($opc,0,1)) {
				case 'c':
					$this->clientes(substr($opc,1));
					break;
				case 'd':
					$this->documentos(substr($opc,1));
					break;
				case 'x':
					$res=$this->clientesXls(substr($opc,1));
					return $res;
					break;
				case 'y':
					$res=$this->documentosXls(substr($opc,1));
					return $res;
					break;				
				default:
					$pagina = $this->load_template('Menu Admin');			
					$html = $this->load_page('app/views/pages/CxC/p.menuCxC.php');
					$pagina = $this->replace_content('/\#CONTENIDO\#/ms', $html, $pagina);
					ob_start();
					$this-> view_page($pagina);
				break;
			}
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}

	function clientes($opc){
		if($_SESSION['user']){
			$data= new modelCxC;
			$sae = new pegaso;
			$pagina = $this->load_template('Menu Admin');			
			$html = $this->load_page('app/views/pages/CxC/p.clientesCxC.php');
			ob_start();
			$clientes=$sae->clientes($opc);
			include 'app/views/pages/CxC/p.clientesCxC.php';
			$table=ob_get_clean();
			$pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
			//$param = $data->SincParam();
			//$info  = $sae->datos($f1=0, $f2=0,$n1=0,$n2=0, $cm1=0, $cm2=0, $cd1=0, $cd2=0);
			//$datos = $data->datos($info); 
			$this-> view_page($pagina);
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}		
	}

	function documentos($opc){
		if($_SESSION['user']){
			$data= new modelCxC;
			$sae = new pegaso;
			$pagina = $this->load_template('Menu Admin');			
			$html = $this->load_page('app/views/pages/CxC/p.documentosCxC.php');
			ob_start();
			$documentos=$sae->documentos($opc);
			include 'app/views/pages/CxC/p.documentosCxC.php';
			$table=ob_get_clean();
			$pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
			$this-> view_page($pagina);
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}		
	}


	function clientesAuto($cliente){
		$data = new pegaso;
        $exec = $data->clientesAuto($cliente);
        return $exec;
	}

	function vendedoresAuto($vendedor){
		$data = new pegaso;
        $exec = $data->vendedoresAuto($vendedor);
        return $exec;
	}

	function clientesXls($opc){
		$xls= new PHPExcel();
        $sae = new pegaso;
        $info= $sae->clientes($opc);
        $col='A';$ln=9; $i=0;$total=0;
        	foreach ($info as $k) {$total += $k->SALDO;}
            foreach ($info as $row) {
                $i++;$ln++;
                $xls->setActiveSheetIndex()
                        ->setCellValue($col.$ln,number_format(( ($row->SALDO  / $total * 100)),2) )
                        ->setCellValue(++$col.$ln,$row->ID_CLIENTE)
                        ->setCellValue(++$col.$ln,utf8_encode($row->CLIENTE))
                        ->setCellValue(++$col.$ln,$row->SALDO)
                        ->setCellValue(++$col.$ln,$row->DOCUMENTOS)
                        ->setCellValue(++$col.$ln, substr($row->FMIN,0,10).' / '.substr($row->FMAX,0,10))
                        ->setCellValue(++$col.$ln,$row->DIASCRED)
                        ->setCellValue(++$col.$ln,$row->VENDEDOR)
                        ->setCellValue(++$col.$ln,$row->EMPRESA)
                ;
            	$col="A";
            }

            $col="A";
            $ln = 9;
            $xls->setActiveSheetIndex()
            	->setCellValue($col.$ln, '%')
            	->setCellValue(++$col.$ln, 'Clave')
            	->setCellValue(++$col.$ln, 'Nombre')
            	->setCellValue(++$col.$ln, 'Saldo')
            	->setCellValue(++$col.$ln, 'Documentos')
            	->setCellValue(++$col.$ln, 'Doc + Antiguo / Reciente')
            	->setCellValue(++$col.$ln, 'Dias de Credito')
            	->setCellValue(++$col.$ln, 'Vendedor')
            	->setCellValue(++$col.$ln, 'Empresa')
            ;
            
            $xls->setActiveSheetIndex()
                ->setCellValue('A1', "GRUPO BALTEX")
                ->setCellValue('A2', "Reporte Saldos de clientes")
                ->setCellValue('A3', "Fecha de Elaboracion: ")
                ->setCellValue('B3', date("d-m-Y H:i:s" ) )
                ->setCellValue('A4', "Total Clientes:")
                ->setCellValue('B4', count($info))
                ->setCellValue('A5', "Total Saldo:")
                ->setCellValue('B5', number_format($total,2))
                
            ;
            /// CAMBIANDO EL TAMAÑO DE LA LINEA.
            $col = 'A';
            $xls->getActiveSheet()->getColumnDimension($col)->setWidth(10);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(7);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(50);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(30);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(20);

            /// Unir celdas
            $xls->getActiveSheet()->mergeCells('A1:I1');
            // Alineando
            $xls->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
            /// Estilando
            $xls->getActiveSheet()->getStyle('A1')->applyFromArray(
                array('font' => array(
                        'size'=>20,
                    )
                )
            );
            //$xls->getActiveSheet()->getStyle('I10:I102')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            //$xls->getActiveSheet()->mergeCells('A3:F3');
            $xls->getActiveSheet()->getStyle('D3')->applyFromArray(
                array('font' => array(
                        'size'=>15,
                    )
                )
            );
            $xls->getActiveSheet()->getStyle("A9:I9")->applyFromArray(
            	array(
                    'font'=> array(
                        'bold'=>true
                    ),
                    'borders'=>array(
                        'allborders'=>array(
                            'style'=>PHPExcel_Style_Border::BORDER_THIN
                        )
                    ), 
                    'fill'=>array( 
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,             
                            'color'=> array('rgb' => '939AB2' )
                    )   
                )
            );

            $ruta='C:\\xampp\\htdocs\\Reportes_cxc\\';
            if(!file_exists($ruta) ){mkdir($ruta);}
            $nom='Reporte de clientes '.date("d-m-Y H_i_s").'.xlsx';
            $x=PHPExcel_IOFactory::createWriter($xls,'Excel2007');
            $x->save($ruta.$nom);
            ob_end_clean();
            return array("status"=>'ok',"nombre"=>$nom, "ruta"=>$ruta, "completa"=>'..\\..\\Reportes_cxc\\'.$nom, "tipo"=>'x');
	}

	function documentosXls($opc){
		$xls= new PHPExcel();
        $sae = new pegaso;
        $info= $sae->documentos($opc);
        $col='A';$ln=9; $i=0;$total=0;
        	foreach ($info as $k) {$total += $k->SALDO;}
            foreach ($info as $row) {
                $i++;$ln++;
                $xls->setActiveSheetIndex()
                        ->setCellValue($col.$ln,$row->ID_CLIENTE)
                        ->setCellValue(++$col.$ln,utf8_encode($row->CLIENTE))
                        ->setCellValue(++$col.$ln,$row->DOCUMENTO)
                        ->setCellValue(++$col.$ln,$row->DIAS_VENCIDO)
                        ->setCellValue(++$col.$ln,substr($row->FECHA_DOCUMENTO,0 ,10))
                        ->setCellValue(++$col.$ln,substr($row->FECHA_VEN,0 ,10))
                        ->setCellValue(++$col.$ln,$row->TOTAL)
                        ->setCellValue(++$col.$ln,$row->CARGOS)
						->setCellValue(++$col.$ln,$row->PAGOS)
                        ->setCellValue(++$col.$ln,$row->SALDO)
                        ->setCellValue(++$col.$ln,$row->VENDEDOR)
                        ->setCellValue(++$col.$ln,$row->EMPRESA)
                ;
            	$col="A";
            }

            $col="A";
            $ln = 9;
            $xls->setActiveSheetIndex()
            	->setCellValue($col.$ln,   'Clave')
            	->setCellValue(++$col.$ln, 'Nombre')
            	->setCellValue(++$col.$ln, 'Documento')
            	->setCellValue(++$col.$ln, 'Dias Vencimiento')
            	->setCellValue(++$col.$ln, 'Fecha Documento')
            	->setCellValue(++$col.$ln, 'Fecha Vencimiento')
            	->setCellValue(++$col.$ln, 'Importe')
            	->setCellValue(++$col.$ln, 'Cargos')
            	->setCellValue(++$col.$ln, 'Abonos')
            	->setCellValue(++$col.$ln, 'Saldo')
            	->setCellValue(++$col.$ln, 'Vendedor')
            	->setCellValue(++$col.$ln, 'Empresa')
            ;
            
            $xls->setActiveSheetIndex()
                ->setCellValue('A1', "GRUPO BALTEX")
                ->setCellValue('A2', "Reporte Documentos pendientes de Pago")
                ->setCellValue('A3', "Fecha de Elaboracion: ")
                ->setCellValue('B3', date("d-m-Y H:i:s" ) )
                ->setCellValue('A4', "Total Documentos:")
                ->setCellValue('B4', count($info))
                ->setCellValue('A5', "Total Saldo:")
                ->setCellValue('B5', number_format($total,2))
            ;
            /// CAMBIANDO EL TAMAÑO DE LA LINEA.
            $col = 'A';
            $xls->getActiveSheet()->getColumnDimension($col)->setWidth(10);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(40);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(30);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(20);

            /// Unir celdas
            $xls->getActiveSheet()->mergeCells('A1:L1');
            // Alineando
            $xls->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
            /// Estilando
            $xls->getActiveSheet()->getStyle('A1')->applyFromArray(
                array('font' => array(
                        'size'=>20,
                    )
                )
            );
            //$xls->getActiveSheet()->getStyle('I10:I102')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            //$xls->getActiveSheet()->mergeCells('A3:F3');
            $xls->getActiveSheet()->getStyle('D3')->applyFromArray(
                array('font' => array(
                        'size'=>15,
                    )
                )
            );
            $xls->getActiveSheet()->getStyle("A9:L9")->applyFromArray(
            	array(
                    'font'=> array(
                        'bold'=>true
                    ),
                    'borders'=>array(
                        'allborders'=>array(
                            'style'=>PHPExcel_Style_Border::BORDER_THIN
                        )
                    ), 
                    'fill'=>array( 
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,             
                            'color'=> array('rgb' => '939AB2' )
                    )   
                )
            );

            $ruta='C:\\xampp\\htdocs\\Reportes_cxc\\';
            if(!file_exists($ruta) ){mkdir($ruta);}
            $nom='Reporte de Documentos '.date("d-m-Y H_i_s").'.xlsx';
            $x=PHPExcel_IOFactory::createWriter($xls,'Excel2007');
            $x->save($ruta.$nom);
            ob_end_clean();
            return array("status"=>'ok',"nombre"=>$nom, "ruta"=>$ruta, "completa"=>'..\\..\\Reportes_cxc\\'.$nom, "tipo"=>'x');
	}
	
    function kpi($opc){
        if($_SESSION['user']){
			//$data= new modelCxC;
			$sae = new pegaso;
			$pagina = $this->load_template('Menu Admin');			
			$html = $this->load_page('app/views/pages/CxC/p.kpiCxC.php');
			ob_start();
			$kpi=$sae->kpi($opc);
			include 'app/views/pages/CxC/p.kpiCxC.php';
			$table=ob_get_clean();
			$pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
			$this-> view_page($pagina);
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}		
    }

}?>

