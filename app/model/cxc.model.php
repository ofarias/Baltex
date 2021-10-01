<?php
//require_once 'app/model/cxc.database.php';
require_once ('database.php');

class modelCxC extends database{
	
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

	function kpiGrp($param){
		//echo 'Estos son los parametros'.$param;
		return array("status"=>'ok');
	}

	function kpi($fi, $ff, $anio){
		$data=array(); $param='';
    	for($i=1; $i < 3; $i++){
			$_SESSION['emp']=$i;
			$this->query="SELECT TIPO, MAX(RANGO) AS RANGO, SUM(SALDO) AS SALDO FROM SP_ANTIGUEDAD('$fi', '$ff') WHERE SALDO > 2 $param GROUP BY TIPO ";
			//echo $this->query;
			$res=$this->EjecutaQuerySimple();
			while($tsArray=ibase_fetch_object($res)){
				$data[]=$tsArray;
			}
		}
		$A=0;$B=0;$C=0;$D=0;$E=0;$F=0;$total=0;
		foreach($data as $d){
			if($d->TIPO == 'A'){$A+=$d->SALDO; }
			if($d->TIPO == 'B'){$B+=$d->SALDO; }
			if($d->TIPO == 'C'){$C+=$d->SALDO; }
			if($d->TIPO == 'D'){$D+=$d->SALDO; }
			if($d->TIPO == 'E'){$E+=$d->SALDO; }
			if($d->TIPO == 'F'){$F+=$d->SALDO; }
			$total += $d->SALDO;
		}
		$datos=array(
				'de 1 a 30 dias'=>$A,
				'de 31 a 60 dias'=>$B,
				'de 61 a 90 dias'=>$C,
				'de 91 a 120 dias'=>$D,
				'de 121 dias '=>$E,
				'Corriente'=> $F
			);
		return array("datos"=>$datos, "fi"=>$fi, "ff"=>$ff);
	}
	
}?>


  
