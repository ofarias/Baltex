<?php
require_once 'app/model/cxc.database.php';

class modelCxC extends databaseCxC{
	
	function sincParam(){
		$data=array();
		$this->query="SELECT * FROM FTC_SINC";
		$res=$this->EjecutaQuerySimple();
		while($tsArray=ibase_fetch_object($res)){
			$data[]=$tsArray;
		}
		foreach($data as $d){
			$emp = $d->EMPRESA; 

		}
		return $data;
	}

	function datos($info){
		foreach ($info as $key => $value){
			switch ($key) {
				case 'CuenM':
					$this->insrtCuenM($value);
					break;
				case 'CuenD':

					break;
				case 'Facturas':

					break;
				case 'Notas':

					break;
				case 'conceptos ':

					break;
				default:
					// code...
					break;
			}
			echo '<p><b>Tabla: '. $key.'</b></p>';
		}
	}

	function insrtCuenM($info){
		foreach ($info as $key ){
			echo '<br/>Valor de la cuenta'.print_r($key);
			$this->query="INSERT INTO FTC_CUENTAS (CVE_CLIE, REFER, NUM_CPTO, NUM_CARGO, CVE_OBS, NO_FACTURA, DOCTO, IMPORTE, FECHA_APLI, FECHA_VENC, AFEC_COI, STRCVEVEND, NUM_MONED, TCAMBIO, IMPMON_EXT, FECHAELAB, CTLPOL, CVE_FOLIO, TIPO_MOV, CVE_BITA, SIGNO, CVE_AUT, USUARIO, ENTREGADA, FECHA_ENTREGA, STATUS, REF_SIST, UUID, VERSION_SINC) VALUES('$key->CVE_CLIE', '$key->REFER', $key->NUM_CPTO, $key->NUM_CARGO, $key->CVE_OBS, '$key->NO_FACTURA', '$key->DOCTO', $key->IMPORTE, '$key->FECHA_APLI', '$key->FECHA_VENC', '$key->AFEC_COI', '$key->STRCVEVEND', $key->NUM_MONED, $key->TCAMBIO, $key->IMPMON_EXT, '$key->FECHAELAB', $key->CTLPOL, '$key->CVE_FOLIO', '$key->TIPO_MOV', $key->CVE_BITA, $key->SIGNO, $key->CVE_AUT, $key->USUARIO, '$key->ENTREGADA', $key->FECHA_ENTREGA, '$key->STATUS', '$key->REF_SIST', '$key->UUID', '$key->VERSION_SINC')";
			echo $this->query;
			$this->grabaBD();
			die;
		}
	}


	
}?>


  
