<?php
    abstract class databaseCxC{
    	private static $usr = "SYSDBA";
		private static $pwd = "masterkey";
		private $cnx;
		protected $query;
		
		private function AbreCnx(){
			$host = "C:\\xampp\\htdocs\\baltex.FDB";
			$this->cnx = ibase_connect($host, self::$usr, self::$pwd);
		}		
		
		private function CierraCnx(){
			ibase_close($this->cnx);
		}

		protected function EjecutaQuerySimple(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			return $rs;
			unset($this->query);
			$this->CierraCnx();
		}

		protected function queryActualiza(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			ibase_commit();
			$rows=ibase_affected_rows();
			unset($this->query);
			$this->CierraCnx();
			return $rows;
		}

		function NumRows($result){
		if(!is_resource($result)) return false;
		return ibase_fetch_row($result);
		}


		protected function grabaBD(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			ibase_commit();
			return $rs;
			unset($this->query);
			$this->CierraCnx();
		}

		protected function QueryObtieneDatos(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			return $this->FetchAs($rs);
			unset($this->query);	
			$this->CierraCnx();
		}
		
		protected function QueryObtieneDatosN(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			return $rs;
			unset($this->query);	
			$this->CierraCnx();
		}

		protected function QueryDevuelveAutocomplete(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			while($row = ibase_fetch_object($rs)){
				$row->CLAVE = htmlentities(stripcslashes($row->CLAVE));
				$row->NOMBRE = htmlentities(stripcslashes($row->NOMBRE));
				$row_set[] = $row->CLAVE." : ".$row->NOMBRE;
			}
			return $row_set;
			unset($this->query);	
			$this->CierraCnx();
		}

		protected function QueryDevuelveAutocompletePFTC(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			while($row = ibase_fetch_object($rs)){
				$row->CLAVE = htmlentities(stripcslashes($row->CLAVE));
				$row->NOMBRE = htmlentities(stripcslashes($row->NOMBRE));
				$row->COSTO_VENTAS = htmlentities(stripcslashes($row->COSTO_VENTAS));
				$row->PROVEEDOR = htmlentities(stripcslashes($row->PROVEEDOR));
				$row_set[] = $row->CLAVE." : ".$row->NOMBRE." COSTO: ".$row->COSTO_VENTAS;
			}
			return $row_set;
			unset($this->query);	
			$this->CierraCnx();	
		}
		
		
		protected function QueryDevuelveAutocompleteP(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			while($row = ibase_fetch_object($rs)){
				$row->CVE_ART = htmlentities(stripcslashes($row->CVE_ART));
				$row->DESCR = htmlentities(stripcslashes(utf8_decode($row->DESCR)));
				$row_set[] = $row->CVE_ART." : ".$row->DESCR;
			}
			return $row_set;
			unset($this->query);	
			$this->CierraCnx();
		}
		
		protected function QueryDevuelveAutocompleteC(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			while($row = ibase_fetch_object($rs)){
				$row->CVE_PROD_SERV = htmlentities(stripcslashes($row->CVE_PROD_SERV));
				$row->DESCRIPCION = htmlentities(stripcslashes(utf8_decode($row->DESCRIPCION)));
				$row_set[] = $row->CVE_PROD_SERV." : ".$row->DESCRIPCION;
			}
			return $row_set;
			unset($this->query);	
			$this->CierraCnx();
		}		
	
		function FetchAs($result){
			if(!is_resource($result)) return false;
				return ibase_fetch_object($result); //cambio de fetch_assoc por fetch_row
		}

   }

?>