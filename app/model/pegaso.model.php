<?php
require_once 'app/model/database.php';

class pegaso extends database{
	/*Comprueba datos de login*/
	function AccesoLogin($user, $pass){
		$u = $user;
			$this->query = "SELECT USER_LOGIN, USER_PASS, USER_ROL, LETRA, LETRA2, LETRA3, LETRA4, LETRA5, LETRA6, NUMERO_LETRAS, NOMBRE, CC, CR, aux_comp, COORDINADOR_COMP, USER_EMAIL
						FROM PG_USERS 
						WHERE USER_LOGIN = '$u' and USER_PASS = '$pass' and user_status = 'alta'"; /*Contraseña va encriptada con MD5*/
		 	$res = $this->EjecutaQuerySimple();
		 	$log = ibase_fetch_object($res);
			if(isset($log) > 0){
				/*Creamos variable de sesion*/
					$_SESSION['user'] = $log;
					$logFtc=$this->registroLogin();
					return $_SESSION['user'];				
			}else{
				echo 'Retorna: 0';
				return 0;
			}
	}

	function CompruebaRol($user){
		$this->query = "SELECT USER_ROL FROM PG_USERS WHERE USER_LOGIN = '$user'";/*Falta Tabla*/
		 $log=$this->QueryObtieneDatos();
			//exit();
			if(isset($log)){
				return $log;
			}else{
				return 0;
			}
			
	}


	function cambioSenia($nuevaSenia, $actual, $usuario){
		$this->query="SELECT IIF(USER_PASS IS NULL, 0, USER_PASS) AS PASSWORD, IIF(ID IS NULL, 0 , ID) AS ID FROM PG_USERS WHERE USER_LOGIN = '$usuario'";
		$rs=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($rs);
		$pass = $row->PASSWORD;
		$id=$row->ID;
		if( $pass == $actual){
			$this->query="UPDATE PG_USERS SET user_pass = '$nuevaSenia' where id = $id";
			$this->EjecutaQuerySimple();
		}
		return;
	}
///// Lista los pedidos PENDIENTES.

	function registroLogin(){
		$usuario =$_SESSION['user']->USER_LOGIN;
		$nombre = $_SESSION['user']->NOMBRE;
		$ip= $_SERVER['REMOTE_ADDR'];
		$equipo=php_uname();
		$this->query="INSERT INTO FTC_INICIO_LOGS (ID, USR_LOGIN, USR_NOMBRE, USR_EQUIPO, FECHA, STATUS, IP )
							VALUES (null, '$usuario', '$nombre', '$equipo',current_timestamp, 'I','$ip')";
		$this->grabaBD();
		return;
	}

	function get_client_ip_env() {
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	        $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}
	/// LISTA TODOS LOS PEDIDOS.

	function reporte($opcion, $doc){
		$data=array();
		$doc = strtoupper($doc);
		if($opcion == "factf01" or $opcion == "factr01" or $opcion=="factp01"){
			$par="par_factf01";
			$clipro="clie01";
			$this->query="SELECT b.fecha_doc as fecha, b.cve_doc as documento, c.nombre as nombre, a.cve_art as articulo, d.descr as descripcion, a.cant as cantidad, a.prec as costo, a.tot_partida as subtotal, e.camplib1 as pzas
						FROM $par a
						JOIN $opcion b on (a.cve_doc=b.cve_doc)
						JOIN $clipro c on (b.cve_clpv=c.clave)
						JOIN inve01 d on (a.cve_art=d.cve_art)
						JOIN par_factf_clib01 e on (a.cve_doc=e.clave_doc and a.num_par=e.num_part)
						WHERE trim(b.cve_doc) = trim('$doc')";
				$rs=$this->EjecutaQuerySimple();
		}else{
			$par="par_compc01";
			$clipro="prov01";
			$this->query="SELECT b.fecha_doc as fecha, b.cve_doc as documento, c.nombre as nombre, a.cve_art as articulo, d.descr as descripcion, a.cant as cantidad, a.prec as costo, a.tot_partida as subtotal, e.camplib1 as pzas
					FROM $par a JOIN $opcion b
					on (a.cve_doc=b.cve_doc)
					JOIN $clipro c
					on (b.cve_clpv=c.clave)
					JOIN inve01 d
					on (a.cve_art=d.cve_art)
					JOIN par_compc_clib01 e
					on (a.cve_doc=e.clave_doc and a.num_par=e.num_part)
					WHERE TRIM(b.cve_doc) = TRIM($doc)";
			$rs= $this->EjecutaQuerySimple();
		}
		while ($tsArray=ibase_fetch_object($rs)) {
			$data[]=$tsArray;
		}
		return $data;
	}

	function invDia($emp, $inicio, $fin){
		$data=array();
		$fecha =$inicio;
		$fecha2 = $fin;
		$this->query="SELECT b.fecha_doc as fecha, b.cve_doc as documento,
						c.nombre as nombre, a.cve_art as articulo, d.descr as descripcion,
 						a.cant as cantidad, a.prec as costo, a.tot_partida as total, a.totimp4 as impuesto,
  						e.camplib1 as pzas, f.nombre as agente, a.comi as comision, c.clave as clave
						FROM par_factf0$emp a
						JOIN factf0$emp b on (a.cve_doc=b.cve_doc)
						JOIN clie0$emp c on (b.cve_clpv=c.clave)
						JOIN inve0$emp d on (a.cve_art=d.cve_art)
						JOIN par_factf_clib0$emp e on (a.cve_doc=e.clave_doc and a.num_par=e.num_part)
						JOIN vend0$emp f on (b.cve_vend=f.cve_vend)
						WHERE b.fecha_doc between '$fecha' and '$fecha2' ORDER BY b.cve_doc";
		$res=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($res)) {
			$data[]=$tsArray;
		}
		return $data;
	}

	function invDiaC($emp, $inicio, $fin){
		$data=array();
		$fecha =$inicio;
		$fecha2 = $fin;
		$this->query="SELECT b.fecha_doc as fecha, b.cve_doc as documento, c.nombre as nombre, a.cve_art as articulo, 
					d.descr as descripcion, a.cant as cantidad, a.cost, a.tot_partida as total,a.totimp4 as Impuesto, 
					e.camplib1 as pzas, c.clave as clave
					FROM par_compc0$emp a
					JOIN compc0$emp b
					on (a.cve_doc=b.cve_doc)
					JOIN prov0$emp c
					on (b.cve_clpv=c.clave)
					JOIN inve0$emp d
					on (a.cve_art=d.cve_art)
					JOIN par_compc_clib0$emp e
					on (a.cve_doc=e.clave_doc and a.num_par=e.num_part)
					WHERE b.fecha_doc between '$fecha' and '$fecha2' and b.status != 'C' ORDER BY b.cve_doc";
		$res=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($res)) {
			$data[]=$tsArray;
		}
		return $data;
	}


	function cuadre_par($docu){
		$data=array();
		$this->query="SELECT a.fecha_doc, a.cve_doc, b.num_par, b.cve_art, b.cant, b.numpzas  
						FROM factf01 a 
						JOIN par_factf01 b on (a.cve_doc=b.cve_doc) 
						WHERE a.cve_doc='$docu'";
		$res=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($res)) {
			$data[]=$tsArray;
		}
		return $data;
	}

	function cuadre_mov($docu){
		$data=array();
		$this->query="SELECT a.fecha_docu, a.refer, a.cve_art, b.num_par, a.cant as mov, b.cant, b.numpzas, a.numpzas as pieza_mov
                    FROM minve01 a 
                    JOIN par_factf01 b on (a.refer=b.cve_doc and a.num_mov = b.num_mov)
                    WHERE refer = '$docu'";
		$res=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($res)) {
			$data[]=$tsArray;
		}
		return $data;
	}

	function traeArticulos($emp){
		$this->query="SELECT * FROM INVE0$emp";
		$res=$this->EjecutaQuerySimple();

		while ($tsArray=ibase_fetch_object($res)) {
			$data[]=$tsArray;
		}
		return $data;
	}

	function pzas_totales($art, $emp){
		$data=array();
		$this->query="SELECT cve_art, descr, camplib7 FROM inve0$emp a JOIN inve_clib0$emp b on (a.cve_art=b.cve_prod) WHERE a.cve_art = '$art'";
		$res=$this->EjecutaQuerySimple();
		//echo $this->query;
		while ($tsArray=ibase_fetch_object($res)) {
			$data[]=$tsArray;
		}
		return $data;
	}

	function kardex($art, $emp){
		$data=array();
		$this->query="SELECT * FROM minve0$emp a WHERE  a.cve_art = '$art' order BY num_mov DESC";
		$res=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($res)) {
			$data[]=$tsArray;
		}
		return $data;
	}

	function cancelar($fact, $comp, $docu, $articulo, $cant){
		if ( $fact == "on" ){
			$this->query = "UPDATE inve_clib01 SET camplib7=(camplib7+$cant) WHERE cve_prod = '$articulo'";
			$result = $this->queryActualiza();
			if($result == 0){
				$mensaje="No se pudo realizar lo operación por favor intenta nuevamente y verifica los datos.";
			}else{
				$mensaje="Cambio Realiado Correctamente.";
			}
		}elseif($comp == "on"){
			$this->query = "UPDATE inve_clib01 SET camplib7=(camplib7-$cant) WHERE cve_prod = '$articulo'";
			$result = $this->queryActualiza();
			
			if($result == 0){
				$mensaje="No se pudo realizar lo operación por favor intenta nuevamente y verifica los datos.";
			}else{
				$mensaje="Cambio Realiado Correctamente.";
			}
		}
		return $mensaje;
	}


	function verPagos(){
        $data=array();
        $ffin =date('d.m.Y');
        //$ffin = '01.12.2019';
        $this->query="SELECT cu.CVE_BITA AS IDP, cl.nombre, CP.NUM_CPTO, CP.DESCR, CP.FORMADEPAGOSAT, FECHA_APLI, FECHAELAB, CU.CVE_CLIE, DOCTO, IMPORTE, REFER, NO_FACTURA,
	        NUM_MONED, CVE_DOC_COMPPAGO,
	        (select METODODEPAGO
	         from FACTF01
	         where CVE_DOC = NO_FACTURA), CP.descr AS NOM_CPTO,
	        (select importe from factf01 where cve_doc = NO_FACTURA) as importe_doc,
	        ( (select importe from factf01 where cve_doc = NO_FACTURA) - (SELECT SUM(si.importe) from CUEN_DET01 si where si.refer = cu.refer and si.cve_clie = cu.cve_clie and si.fecha_apli <= cu.fecha_apli)  ) as saldoIns, 
	        cu.cve_aut as seleccion
			from CUEN_DET01 CU
			left join CONC01 CP on CP.NUM_CPTO = CU.NUM_CPTO
			left join clie01 cl on cl.clave = cu.cve_clie
			where FECHAELAB >= '01.09.2018' and
	      	FECHA_APLI between '01.02.2019' and '$ffin' and
	      	(CVE_DOC_COMPPAGO is null OR  CVE_DOC_COMPPAGO = '') and
	      	CP.FORMADEPAGOSAT is not null AND CP.formadepagosat != '' and cp.formadepagosat != '04'
	      	and	(select METODODEPAGO from FACTF01 where CVE_DOC = NO_FACTURA) = 'PPD' 
		order by CVE_CLIE, DOCTO";
        $res=$this->EjecutaQuerySimple();
        //echo $this->query;

        while ($tsarray=ibase_fetch_object($res)){
            $data[]=$tsarray;
        }
        return $data;
    }

    function selPago($idp, $tipo){
    	$this->query="UPDATE CUEN_DET01 SET CVE_AUT=$tipo WHERE CVE_BITA =$idp";
    	//echo $this->query;
    	$res=$this->queryActualiza();
    	if($res == 1 and $tipo==1){
    		return array("mensaje"=>'Se selecciono correctamente...');
    	}elseif($res == 1 and $tipo ==0){
    		return array("mensaje"=>'Se des-selecciono correctamente...');
    	}else{
    		return array("mensaje"=>'No se pudo procesar favor de intentarlo mas tarde o comunicarse con el departamento de IT. Gracias y disculpe las molestias');
    	}
    }

    /*function realizaCEP($folios){
        $folios = explode(",", $folios);
        $docs= "";
        for ($i=0; $i < count($folios); $i++) { 
            $doc = $folios[$i];
            $docs = explode(":", $doc);
            $d=$docs[0];
            $c=$docs[1];
            $this->query="INSERT INTO FTC_CEP_PASO (ID, CLIENTE, DOCUMENTO, MARCA ) VALUES (NULL,'$c','$d',  0)";
            $this->grabaBD();
        }
        $this->query="SELECT count(documento) AS DOCS, MIN(DOCUMENTO) AS DOC, cliente
                        FROM FTC_CEP_PASO 
                        group by cliente order by cliente";
        $res=$this->EjecutaQuerySimple();
        while ($tsArray=ibase_fetch_object($res)){
            $data0[]=$tsArray;
        }

        foreach ($data0 as $key){
            $t = $key->DOCS;
            if($t==1){
                $this->query="SELECT cve_clie, refer, FECHAELAB as fecha_elab, max(FECHA_APLI) as fecha_apli, sum(IMPORTE) AS monto, NUM_CPTO FROM CUEN_DET01 
                      WHERE NO_FACTURA IN ('$key->DOC') 
                      group by cve_clie, refer, FECHAELAB, NUM_CPTO";
                $res=$this->EjecutaQuerySimple();
                while ($tsarray=ibase_fetch_object($res)) {
                    $data[]=$tsarray;
                }
                foreach ($data as $k) {
                    $this->realizaJson($k, $t);
                }           
            }elseif($t>1){
                echo 'El cliente tiene mas de 2 documentos';
                $this->query="SELECT * FROM FTC_CEP_PASO WHERE CLIENTE = '$key->CLIENTE'";
                $r=$this->EjecutaQuerySimple();
                while ($tsarray=ibase_fetch_object($r)) {
                    $data3[]=$tsarray;
                }
                foreach ($data3 as $x){
                    $this->query="SELECT cve_clie, refer, FECHAELAB as fecha_elab, max(FECHA_APLI) as fecha_apli, sum(IMPORTE) AS monto, NUM_CPTO FROM CUEN_DET01 
                                    WHERE NO_FACTURA = '$x->DOCUMENTO' 
                                    group by cve_clie, refer, FECHAELAB, NUM_CPTO";
                    $res=$this->EjecutaQuerySimple();
                    while ($tsarray=ibase_fetch_object($res)) {
                        $data2[]=$tsarray;
                    }
                }
                $this->realizaJson2($k=$data2, $t);
                $this->query="DELETE FROM FTC_CEP_PASO WHERE ID > 0";
                $this->grabaBD();
            }
        }

    }
	*/
    function realizaCEP(){
    	//$d=$this->leerDir();
    	//exit('model');
    	$data =array();
    	$this->query="SELECT CVE_CLIE FROM CUEN_DET01 WHERE CVE_AUT = 1 AND (CVE_DOC_COMPPAGO IS NULL or CVE_DOC_COMPPAGO = '') group BY CVE_CLIE";
    	$res=$this->EjecutaQuerySimple();
    	while ($tsArray=ibase_fetch_object($res)) {
    		$data[]=$tsArray;
    	}
    	foreach ($data as $cl ){
    		$this->query="SELECT cu.CVE_BITA AS IDP, cl.nombre, CP.NUM_CPTO, CP.DESCR, CP.FORMADEPAGOSAT, FECHA_APLI, FECHAELAB, CU.CVE_CLIE, DOCTO, IMPORTE, REFER, NO_FACTURA, NUM_MONED, CVE_DOC_COMPPAGO, (select METODODEPAGO from FACTF01 where cVE_DOC = NO_FACTURA), CP.descr AS NOM_CPTO, (select importe from factf01 where cve_doc = NO_FACTURA) as importe_doc,
        ( (select importe from factf01 where cve_doc = NO_FACTURA) - (SELECT SUM(si.importe) from CUEN_DET01 si where si.refer = cu.refer and si.cve_clie = cu.cve_clie and si.fecha_apli <= cu.fecha_apli)  ) as saldoIns, cu.cve_aut as seleccion,
        (select SERIE from factf01 where cve_doc = NO_FACTURA) as serie, 
        (select folio from factf01 where cve_doc = NO_FACTURA) as folio,
        (select uuid from CFDI01 where cve_doc = NO_FACTURA) as UUIDf,
        cu.ID_MOV, cu.NUM_CARGO 
		from CUEN_DET01 CU
		left join CONC01 CP on CP.NUM_CPTO = CU.NUM_CPTO
		left join clie01 cl on cl.clave = cu.cve_clie
		where CU.CVE_CLIE = '$cl->CVE_CLIE' and cve_aut = 1 and (cu.CVE_DOC_COMPPAGO is null or cu.CVE_DOC_COMPPAGO = '') 
		order by CVE_CLIE, DOCTO"; // se agrega el condicionante cve_doc_comppago para que elimine los que ya tienen complemento de pago.... 
			$rs=$this->EjecutaQuerySimple();
			while ($tsarray=ibase_fetch_object($rs)){
				$depositos[]=$tsarray;
			}
			$cep=$this->relizaCepJson($cl->CVE_CLIE, $depositos);
			$this->actCuenDet($depositos, $cep);
			unset($depositos);
    	}
    }

    function actCuenDet($depositos, $cep){
    	foreach($depositos as $key){
    		$this->query="UPDATE CUEN_DET01 SET CVE_DOC_COMPPAGO = '$cep' where CVE_CLIE = '$key->CVE_CLIE' AND REFER = '$key->REFER' AND ID_MOV = $key->ID_MOV and NUM_CARGO = $key->NUM_CARGO and (CVE_DOC_COMPPAGO is null or CVE_DOC_COMPPAGO = '') ";
    		$this->queryActualiza();
    	}
    	return;
    }

    function relizaCepJson($cli, $depositos){
    	$this->query="SELECT * FROM CLIE01 WHERE CLAVE = '$cli'";
    	$res=$this->EjecutaQuerySimple();
    	$rowCl=ibase_fetch_object($res);
    		$datosCliente = array(
                    "id"=>"$cli",
                    "nombre"=>utf8_encode($rowCl->NOMBRE),
                    "rfc"=>$rowCl->RFC,
                    "UsoCFDI"=>'P01'
            );
    	$this->query="SELECT * FROM FOLIOSF01 WHERE TIP_DOC = 'G' AND SERIE = 'CP'";
    	$res=$this->EjecutaQuerySimple();
    	$rowComp=ibase_fetch_object($res);
    	$serie=$rowComp->SERIE;
    	$folio=$rowComp->ULT_DOC +1;
    	$cep=$serie.str_pad($folio, "0",6,STR_PAD_LEFT); // este es el CEP.
    		$this->query="UPDATE FOLIOSF01 SET ULT_DOC = $folio where TIP_DOC = 'G' AND SERIE = 'CP'";
    		$this->queryActualiza();

    	$conceptos = array(
                "ClaveProdServ"=>"84111506",
                "ClaveUnidad"=>"ACT",
                "Importe"=>"0",
                "Cantidad"=>"1",
                "descripcion"=>"Pago",
                "ValorUnitario"=>"0"
        );

        foreach($depositos as $p){
        	$saldoAnt=$p->SALDOINS + $p->IMPORTE;
        	$si = number_format($p->SALDOINS,2,".","");
        	$saldoAnt=number_format($saldoAnt,2,".","");
        	$imp=number_format($p->IMPORTE,2,".","");
            $documento=array (
                        "IdDocumento"=>$p->UUIDF,
                        "Serie"=>"$p->SERIE",
                        "Folio"=>"$p->FOLIO",
                        "MonedaDR"=>"MXN",
                        "MetodoDePagoDR"=>"PPD",
                        "NumParcialidad"=>"1",
                        "ImpSaldoAnt"=>"$saldoAnt",
                        "ImpPagado"=>"$imp",
                        "ImpSaldoInsoluto"=>"$si"
                    );    
            $DocsRelacionados[]=$documento;
        	$aplica[]= array(
                    "FechaPago"=>substr($p->FECHA_APLI,0,10).'T12:00:00',
                    "FormaDePagoP"=>"$p->FORMADEPAGOSAT",
                    "MonedaP"=>"MXN",
                    "Monto"=>"$imp",
                    "NumOperacion"=>"1",
                    "DoctoRelacionado"=>$DocsRelacionados
            );
            $datosCEP[] = $aplica;
            unset($DocsRelacionados);
            unset($aplica);
        }

        $datosFactura = array(
                "Serie"=>"$serie",
                "Folio"=>"$folio",
                "Version"=>"3.3",
                "RegimenFiscal"=>"601",
                "LugarExpedicion"=>"06720",
                "Moneda"=>"XXX",
                "TipoDeComprobante"=>"P",
                "numero_de_pago"=>"1",
                "cantidad_de_pagos"=>"1"
        );

        $Complementos[] = array("Pagos"=>array("Pago"=>$datosCEP)); 
                $cep = array (
                    "id_transaccion"=>"0",
                    "cuenta"=> "gba070517cc5",
					"user"=>"administrador",
					"password"=> "$1OMht51",
                    "getPdf"=>true,
                    "conceptos"=>[$conceptos],
                    "datos_factura"=>$datosFactura,
                    "method"=>"nueva_factura",
                    "cliente"=>$datosCliente,
                    "Complementos"=>$Complementos
                );

        unset($conceptos);
        unset($Complementos);
        unset($aplica);
        unset($datosCEP);
        unset($DocsRelacionados);

        $location="C:\\xampp\\htdocs\\Facturas\\entrada\\";
        $json=json_encode($cep, JSON_UNESCAPED_UNICODE);
        $nameFile = $serie.$folio;      
        $theFile = fopen($location.$nameFile.".json", 'w');
        fwrite($theFile, $json);
        fclose($theFile);
        sleep(10);
        $nf=$serie.str_pad($folio,6,"0",STR_PAD_LEFT);
        $location2 = "C:\\xampp\\htdocs\\Facturas\\timbradas\\";
        $nameFile=$rowCl->RFC.'('.$serie.$folio.')'.date('d-m-Y').'.xml';
        $file=$location2.$nameFile; 
        echo '<br/> Archivo ya timbrado: '.$file.'<br/>';
        $this->InsertaDocSAE($nf,$rowCl->CLAVE, $rowCl->RFC, $serie, $folio, $rowCl->CVE_VEND, $file, $fecha=substr($p->FECHA_APLI,0,10).'T12:00:00');
        //$locationXML="C:\\xampp\\htdocs\\Facturas\\entrada\\";/// Localizar el archivo timbrado. o no ... ya esta el codigo en leerDir.
        //exit('Revisar Info'.$theFile);
        return $nf;
    }

    function InsertaDocSAE($nameFile, $cve_clie, $rfc, $serie, $folio, $ven, $file, $fecha){
    	$this->query="INSERT into factg01 (TIP_DOC, CVE_DOC, CVE_CLPV, STATUS, DAT_MOSTR, CVE_VEND, CVE_PEDI, FECHA_DOC, FECHA_ENT, FECHA_VEN, FECHA_CANCELA, CAN_TOT, IMP_TOT1, IMP_TOT2, IMP_TOT3, IMP_TOT4, DES_TOT, DES_FIN, COM_TOT, CONDICION, CVE_OBS, NUM_ALMA, ACT_CXC, ACT_COI, ENLAZADO, TIP_DOC_E, NUM_MONED, TIPCAMB, NUM_PAGOS, FECHAELAB, PRIMERPAGO, RFC, CTLPOL, ESCFD, AUTORIZA, SERIE, FOLIO, AUTOANIO, DAT_ENVIO, CONTADO, CVE_BITA, BLOQ, FORMAENVIO, DES_FIN_PORC, DES_TOT_PORC, IMPORTE, COM_TOT_PORC, METODODEPAGO, NUMCTAPAGO, TIP_DOC_ANT, DOC_ANT, TIP_DOC_SIG, DOC_SIG, UUID, VERSION_SINC, FORMADEPAGOSAT, USO_CFDI)
		    values ('G', '$nameFile', '$cve_clie', 'E', 0 , '$ven', '', CURRENT_DATE, CURRENT_DATE, CURRENT_DATE, NULL, 0,0,0,0,0,0,0,0,NULL, 0, 1, 'S','N','O','O',1,1,1,current_timestamp, 0, '$rfc', 0, 'T', 0,
		    '$serie', $folio, '', 0, 'N', 0, 'N','A', 0, 0, 0, 0,null, NULL, '', '', null, NULL, 'UUID', current_timestamp, null,  'P01')";
		    $this->grabaBD();

		    $this->query="INSERT into FACTG_CLIB01 (CLAVE_DOC ) VALUES ( '$nameFile')";
		    $this->grabaBD();

		    $this->query="INSERT INTO PAR_FACTG01 (CVE_DOC, NUM_PAR, CVE_ART, CANT, PXS, PREC, COST, IMPU1, IMPU2, IMPU3, IMPU4, IMP1APLA, IMP2APLA, IMP3APLA, IMP4APLA, TOTIMP1, TOTIMP2, TOTIMP3, TOTIMP4, DESC1, DESC2, DESC3, COMI, APAR, ACT_INV, NUM_ALM, POLIT_APLI, TIP_CAM, UNI_VENTA, TIPO_PROD, CVE_OBS, REG_SERIE, E_LTPD, TIPO_ELEM, NUM_MOV, TOT_PARTIDA, IMPRIMIR, MAN_IEPS, APL_MAN_IMP, CUOTA_IEPS, APL_MAN_IEPS, MTO_PORC, MTO_CUOTA, CVE_ESQ, DESCR_ART, UUID, VERSION_SINC)
		                 VALUES ('$nameFile', 1, 'SERV-PAGO', 1, 1, 0, 0, 0, 0, 0, 16, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 1, NULL, 1, 'ACT', 'S', 0, 1, 1, 'N', 0, 0, 'S', 'N', 1, 0, 'C', 0, 0, 1, NULL, NULL, current_timestamp)";
		    $this->grabaBD();
		if(file_exists($file)){
			$xml_doc=fopen($file, "r");
			$r=$this->cargaCEP($folio);
		}
	}
	
	/*
	function leerDir(){
			$directorio="C:\\xampp\\htdocs\\Facturas\\timbradas\\";
			$rep = opendir($directorio); 
		    while ($arc = readdir($rep)) {
		   		if($arc != '..' && $arc !='.' && $arc !='' && $arc !='index.php' && strtoupper(substr($arc, -3)) == 'XML'){
		     		print  "<a href=".$directorio."/".$arc." target='_blank'>".$arc."</a><br />";
		     		$archivo = "C:\\xampp\\htdocs\\Facturas\\timbradas\\".$arc;
		     		for($i=156; $i<=162; $i++){
		     			$this->cargaCEP($i);		
		    	 		$cargadas = "C:\\xampp\\htdocs\\Facturas\\cargadas\\".$arc;
		     			rename($archivo, $cargadas);
		     		}
		     	}
 			} 
			closedir($rep);    
			clearstatcache();
	}
	*/

	function cargaXML(){
		$res=$this->cargaCEP($cep = false);
		print_r($res);
		exit();
		return $res;
	}

	function cargaCEP($cep){
		$path='C:\\xampp\\htdocs\\Facturas\\timbradas\\';
		//$path = 'C:\\xampp\\htdocs\\Facturas\\nocargadas\\';
    	$files = array_diff(scandir($path), array('.', '..'));
    	foreach($files as $file){
		    $data = explode(".", $file);
		    $fileName = $data[0];
		    $fileExtension = $data[1];
		    if(strtoupper($fileExtension) == 'XML' and strpos($fileName, 'CP') !== false){
		    	if(strpos($fileName, 'CP'.$cep) !== false){
		    	    $file = $path.$fileName.'.'.$fileExtension;
		    	    $myFile = fopen($file, "r") or die("No se ha logrado abrir el archivo ($file)!");
	        	    $myXMLData = fread($myFile, filesize($file));
	        	    $xml = simplexml_load_string($myXMLData) or die("Error: No se ha logrado crear el objeto XML ($file)");
	        	    $ns = $xml->getNamespaces(true);
	        	    $xml->registerXPathNamespace('c', $ns['cfdi']);
	        	    $xml->registerXPathNamespace('t', $ns['tfd']);

	        	     foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
			               $fechaT = $tfd['FechaTimbrado']; 
			               $fechaT = str_replace("T", " ", $fechaT); 
			               $uuid = $tfd['UUID'];
			               $noNoCertificadoSAT = $tfd['NoCertificadoSAT'];
			               $RfcProvCertif=$tfd['RfcProvCertif'];
			               $SelloCFD=$tfd['SelloCFD'];
			               $SelloSAT=$tfd['SelloSAT'];
			               $versionT = $tfd['Version'];
			               $rfcprov = $tfd['RfcProvCertif'];
			        }
	        	    foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){
            		  	$version = $cfdiComprobante['version'];
					  	if($version == ''){
					  		$version = $cfdiComprobante['Version'];
					  	}
					  	if($version == '3.2'){
					    }elseif($version == '3.3'){
					      	$serie = $cfdiComprobante['Serie'];                  
	        	          	$folio = $cfdiComprobante['Folio'];
	        	          	$total = $cfdiComprobante['Total'];
	        	          	$tipo = $cfdiComprobante['TipoDeComprobante'];
						  	$moneda = $cfdiComprobante['Moneda'];
						  	$lugar = $cfdiComprobante['LugarExpedicion'];
						  	$Certificado = $cfdiComprobante['Certificado'];
						  	$Sello = $cfdiComprobante['Sello'];
						  	$noCert = $cfdiComprobante['NoCertificado'];
						  	$fecha = $cfdiComprobante['Fecha'];
						  	$fecha = str_replace("T", " ", $fecha);
						  	$subtotal = $cfdiComprobante['SubTotal'];
					  	}
					}
					foreach ($xml->xpath('//cfdi:Emisor') as $emi){
            		  	if($version == '3.2'){
					    }elseif($version == '3.3'){
					      	$rfce=$emi['Rfc'];
	        	        	$emisor=$emi['Nombre'];
	        	        	$rf = $emi['RegimenFiscal'];
	        	        }
					}
					foreach ($xml->xpath('//cfdi:Receptor') as $rec){
            		  	if($version == '3.2'){
					    }elseif($version == '3.3'){
					      	$rfcr=$rec['Rfc'];
	        	        	$recep=$rec['Nombre'];
	        	        	$UsoCFDI = $rec['UsoCFDI'];
	        	        }
					}
					if($tipo == 'P'){
						$doc = $serie.str_pad($folio,6,"0", STR_PAD_LEFT); 
						//$myXMLData = $myXMLData, ENT_QUOTES, "UTF-8");
						$this->query = "SELECT coalesce(count(*),0) as val FROM CFDI01 WHERE CVE_DOC = '$doc'";
						$res=$this->EjecutaQuerySimple();
						$row=ibase_fetch_object($res);
						if( $row->VAL == 0 ){
						$myXMLData = str_replace("'", " ", $myXMLData);
							$this->query="INSERT INTO CFDI01 (TIPO_DOC, CVE_DOC, VERSION, UUID, NO_SERIE, FECHA_CERT, FECHA_CANCELA, XML_DOC, DESGLOCEIMP1, DESGLOCEIMP2, DESGLOCEIMP3, DESGLOCEIMP4, MSJ_CANC, PENDIENTE)
    				        VALUES ('G', '$doc', '1.1', '$uuid', '$noNoCertificadoSAT', '$fecha', '', '$myXMLData','S', 'N', 'N', 'S', NULL, 'N')";
            				$this->grabaBD();
						}
						//$this->query="UPDATE CUEN_DET01 SET CVE_DOC_COMPPAGO = '$doc' where ";
						//$this->queryActualiza();
					}
		    	}else{
		    	}
		    }
		}
		/// aqui despues de que se carge que se envie el documento:

		
		return array("status"=>'ok',"mensaje"=>'Se ha guardado el archivo', "archivo"=>'no');
	}
    
    function verComprobantes($tipo){
    	$data= array();
    	if($tipo == 'T'){
    		$this->query="SELECT c.*, cl.NOMBRE AS NOMBRE, cl.RFC AS rfc, cl.emailpred as correo, g.cve_doc, g.serie, g.folio, g.METODODEPAGO FROM CFDI01 c left join factg01 g on g.cve_doc = c.cve_doc left join clie01 cl on cl.clave = g.cve_clpv WHERE tipo_doc = 'G' ORDER BY C.CVE_DOC DESC";
	    	$res=$this->EjecutaQuerySimple();
	    	while ($tsarray=ibase_fetch_object($res)){
	    		$data[]=$tsarray;
	    	}
    	}
    	return $data;
    }

    function actualizaEstado($doc){
    	$this->query="UPDATE FACTG01 SET METODODEPAGO = 'Correo' where cve_doc = '$doc'";
    	$this->queryActualiza();
    	return;
    }

    function cepNoEnviados(){
    	$data=array();
    	$this->query="SELECT F.*, CL.emailpred AS CORREO, (SELECT FIRST 1 FECHA_CERT FROM CFDI01 X WHERE X.CVE_DOC= F.CVE_DOC AND TIPO_DOC = 'G') AS FECHA_CERT FROM FACTG01 F left join CLIE01 CL ON CL.CLAVE = F.CVE_CLPV WHERE (F.METODODEPAGO != 'Correo' OR F.METODODEPAGO IS NULL) and fecha_doc >= CURRENT_DATE and F.STATUS = 'E' AND (CL.emailpred != '' OR CL.emailpred IS NOT NULL) ";
    	$res=$this->EjecutaQuerySimple();
    	while($tsArray = ibase_fetch_object($res)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function datos($ctrlFacF1, $ctrlFacF2,$ctrlFacD1,$ctrlFacD2){
    	/// SE PUEDE UTILIZAR CVE_AUT O REF_SIST PARA CONTROLAR la sincronizacion.
    	$cuenM=array();$cuenD=array();$facturas=array();$notas=array();$conceptos=array();$folio=array();
    	$tablas=["cuenM"=>"CUEN_M0", "cuenD"=>"CUEN_DET0", "facturas"=>"FACTF0", "notas"=>"FACTD0", "conceptos"=>"CONM0"];
    	foreach($tablas as $key => $value){
    		$param='';$param2='';
    		for ($i=1; $i <3 ; $i++) { 
	    		switch ($value) {
	    			case 'CUEN_M0':
	    				$campo = 'CVE_AUT';
	    				$param = ' where CVE_AUT IS NULL';
	    				$param2 = ' where CVE_CLIE is not null ';
	    				break;
	    			case 'CUEN_DET0':
	    				$campo = 'CTLPOL';
	    				$param = ' where CTLPOL is null ';
	    				$param2 = ' where CVE_CLIE is not null ';
	    				break;
	    			case 'FACTF0':
	    				$campo = 'DAT_MOSTR';
	    				$param = " where DAT_MOSTR > ".${"ctrlFacF".$i};
	    				$param2 = ' where cve_clpv is not null';
	    				break;
	    			case 'FACTD0':
	    				$campo = 'CVE_BITA';
	    				$param = " where CVE_BITA > ".${"ctrlFacD".$i};
	    				$param2 = ' where cve_clpv is not null ';
	    				break;
	    			case 'CONM0':
	    				$campo = '';
	    				$param = '';
	    				break;
	    			default:
	    				// code...
	    				break;
	    		}
	    		$_SESSION['emp']=$i;
	    		$tabla = $value.$i;
		    	$this->query="SELECT c.* FROM $tabla c  $param";
			    $res=$this->EjecutaQuerySimple();
		    	while($tsArray=ibase_fetch_object($res)){
		    		$$key[]=$tsArray;
		    	}
		    	if(!empty($param2)){
			    	$this->query="SELECT COALESCE(MAX($campo), 0) as f_sinc FROM $tabla $param2";
			    	//echo '<br/>'.$this->query;
			    	$res=$this->EjecutaQuerySimple();
			    	$row=ibase_fetch_object($res);
			    	$folio = $row->F_SINC;
		    	}
	    	}
    	}
    	return array("CuenM"=>$cuenM, "CuenD"=>$cuenD, "Facturas"=>$facturas, "Notas"=>$notas, "conceptos"=>$conceptos, "folios"=>$folio);
    }

    function clientes($opc){
    	$data=array(); $param=''; 
    	$opc = substr($opc, 1);
    	@$opc = explode(":", $opc);
    	if(count($opc)>1){
    		if(!empty($opc[0])){ /// Cliente
    			$param .= " and cliente = '".$opc[0]."'";
    		}
    		if(!empty($opc[1])){ /// Vendedor
    			$param .= " and vendedor = '".$opc[1]."'";
    		}
    		if(!empty($opc[2])){ /// Fecha inicial
    			$param .= " and fecha_doc >= '".$opc[2]."'";
    		}
    		if(!empty($opc[3])){ /// Fecha Final
    			$param .= " and fecha_doc <= '".$opc[3]."'";
    		}
    		if($opc[4]!=3){ /// Empresa
    			$param .= " and empresa = '".$opc[4]."'";
    		}
    	}
    	//echo $param;
    	for ($i=1; $i <3 ; $i++) { 
    		$_SESSION['emp']=$i;
	    	//$tabla = $value.$i;
	    	$this->query="SELECT ID_CLIENTE, MAX(CLIENTE) as cliente, sum(SALDO) as saldo, COUNT(DOCUMENTO) AS documentos, min(fecha_doc) as fmin, max(fecha_doc) as fmax, min(empresa) AS empresa, (select max(diascred) from clie0$i cl where cl.clave = id_cliente) as diascred, cast(list(DISTINCT vendedor) as varchar(500)) AS VENDEDOR FROM FACTURAS_SALDO where id_cliente is not null $param group BY ID_CLIENTE";
    		$res=$this->EjecutaQuerySimple();
    		while($tsArray=ibase_fetch_object($res)){
    			$data[]=$tsArray;
    		}
    	}
    	return $data;
    }

    function documentos($opc){
    	$data=array();$param='';
    	$opc = substr($opc, 1);
    	@$opc = explode(":", $opc);
    	if(count($opc)>1){
    		if(!empty($opc[0])){ $param .= " and cliente = '".$opc[0]."'";}///cliente
    		if(!empty($opc[1])){ $param .= " and vendedor = '".$opc[1]."'";}/// Vendedor
    		if(!empty($opc[2])){ $param .= " and fecha_ven  >= '".$opc[2]."'";}/// Fecha inicial
    		if(!empty($opc[3])){ $param .= " and fecha_ven <= '".$opc[3]."'";}/// Fecha Final
    		if($opc[4]!=3){ $param .= " and empresa = '".$opc[4]."'";}/// Empresa
    		if(isset($opc[5])){
    			$doctos='';
    			$docs = explode(",",$opc[5]);
    			print_r($docs);
    			for ($i=0; $i < count($docs) ; $i++) { 
    				$doctos .= "'".$docs[$i]."', ";
    			}
    			$doctos = substr($doctos, 0, strlen($doctos)-2);
    			$param = " and documento in (".$doctos.")";
    		}
    	}
    	
    	for ($i=1; $i <3 ; $i++) { 
    		$_SESSION['emp']=$i;
	    	$this->query="SELECT * FROM FACTURAS_PENDIENTES WHERE SALDO >= 2 AND STATUS != 'C' $param";
    		$res=$this->EjecutaQuerySimple();
    		while($tsArray=ibase_fetch_object($res)){
    			$data[]=$tsArray;
    		}
    	}
    	return $data;	
    }

    function clientesAuto($cliente){
    	$res=array();
    	for ($i=1; $i <3 ; $i++) { 
    		$_SESSION['emp']=$i;
	        $this->query = "SELECT CLIENTE, ID_CLIENTE FROM FACTURAS_SALDO 
	                        WHERE (CLIENTE||' '|| ID_CLIENTE) CONTAINING '$cliente' group by CLIENTE, ID_CLIENTE";
	        $result = $this->devuelveAutoClie();
	        while($tsArray=ibase_fetch_object($result)){
	        	$res[]=utf8_decode($tsArray->CLIENTE);
	        }

	        //$_SESSION['emp']=2;
	        //$this->query = "SELECT CLIENTE, ID_CLIENTE FROM FACTURAS_SALDO 
	        //                WHERE (CLIENTE||' '|| ID_CLIENTE) CONTAINING '$cliente' group by CLIENTE, ID_CLIENTE";
	        //$result = $this->devuelveAutoClie();
	        //while($tsArray=ibase_fetch_object($result)){
	        //	$res[]=$tsArray->CLIENTE;
	        //}
	        //var_dump($res);
	    }
        return $res;
    }

	function vendedoresAuto($vendedor){
		$res=array();
		for ($i=1; $i <3 ; $i++) { 
    		$_SESSION['emp']=$i;
	        $this->query = "SELECT ID_VENDEDOR, vendedor FROM FACTURAS_SALDO 
	                        WHERE (VENDEDOR||' '|| ID_VENDEDOR ) CONTAINING '$vendedor' group by ID_VENDEDOR, VENDEDOR";
	        $result = $this->devuelveAutoVend();
	        while($tsArray=ibase_fetch_object($result)){
	        	$res[]=$tsArray->VENDEDOR;
	        }
	    }
        return $res;
    }

}?>