<?php
include_once('../../../FDSoil/class/postgresql.class.php'); 
class bd_functions extends manejador_bd {
	function __construct($db=null){
        	$this->conectar($db);
	}
        
	function exeQryStr($strSql) {
		return $this->ejecutar($strSql);
    	}

	function getMatrixRegistroQryStr($strSql) {
        	return $this->resultToMatrixRegistro($this->exeQryStr($strSql));
	}
        
        function getMatrixAsociativoQryStr($strSql) {
        	return $this->resultToMatrixAsociativo($this->exeQryStr($strSql));
	}
        
        function getMatrixArregloQryStr($strSql) {
        	return $this->resultToMatrixArreglo($this->exeQryStr($strSql));
	}
        
	function printQryFile($fileSql, $array){
		$function = new functions();
        	return $function->bldQryFile($fileSql, $array);
	}

	/*function exeQryFile($fileSql, $array){
		$function = new functions();
        	return $this->ejecutar($function->bldQryFile($fileSql, $array));
	}*/
        
        function exeQryFile($fileSql, $array, $doAudit=false, $coment=''){
		$function = new functions();
                $qry=$function->bldQryFile($fileSql, $array);                   
        	$return=$this->ejecutar( $qry);
//                if ( $return && $_SESSION['audit'] && $doAudit)
//                    $this->doAudit($qry,$coment);
                return $return;
	}

	function getMatrixRegistroQryFile($fileSql,$array){
        	return $this->resultToMatrixRegistro($this->exeQryFile($fileSql, $array));
    	}
        
        function getMatrixAsociativoQryFile($fileSql,$array){
        	return $this->resultToMatrixAsociativo($this->exeQryFile($fileSql, $array));
    	}
        
        function getMatrixArregloQryFile($fileSql,$array){
        	return $this->resultToMatrixArreglo($this->exeQryFile($fileSql, $array));
    	}

	function resultToMatrixRegistro($result){                
        	$col = $this->num_campos($result);
        	$j = 0;
        	while ($data = $this->extraer_registro($result)){
        		for ($i = 0; $i < $col; $i++)
                            $matrix[$j][$i] = $data[$i];            		
            		$j++;
        	}
        	return $matrix;
    	}        
        
        function resultToMatrixAsociativo($result){                
        	$col = $this->num_campos($result);
        	$j = 0;
        	while ($data = $this->extraer_asociativo($result)){
                        foreach ($data as $key => $value)
                            $matrix[$j][$key] = $value;
            		$j++;
        	}
        	return $matrix;
    	}
        
        function resultToMatrixArreglo($result){                
        	$col = $this->num_campos($result);
        	$j = 0;
        	while ($data = $this->extraer_arreglo($result)){
                        foreach ($data as $key => $value)
                            $matrix[$j][$key] = $value;
            		$j++;
        	}
        	return $matrix;
    	}
        
        function resultToArrayRegistro($result){                
        	$j = 0;
        	while ($data = $this->extraer_registro($result))
                    $matrix[$j++] = $data[0];            		        	
        	return $matrix;
    	}
        
	function resultToString($result,$separate1,$separate2){
		$col = $this->num_campos($result);
		$string='';
		while ($row =$this->extraer_registro($result)){
        		for ($i = 0; $i < $col; $i++) {
				$string.=$row[$i].$separate1; 
            		}
	    		$string=substr($string,0,strlen($string)-1).$separate2;
		}                
		return $string=substr($string,0,strlen($string)-1);
    	}   
        
        function doAudit($qry, $coment){
            $array['remote_addr']=$_SERVER['REMOTE_ADDR'];
            $array['remote_port']=$_SERVER['REMOTE_PORT'];
            $array['id_usuario']=($this->isThereThisKeyInTheArray($_SESSION,'id_usuario'))?$_SESSION['id_usuario']:0;
            //$array['id_usuario']=$_SESSION['id_usuario'];
            $array['script_filename']=$_SERVER['SCRIPT_FILENAME'];
            $array['request_method']=$_SERVER['REQUEST_METHOD'];
            $array['query']=str_replace("'",'"' , $qry);                        
            $array['fecha']= date("Y-m-d");
            $array['hora'] = date("H:i:s");
            $array['coment']=$coment;
            $x= $this->printQryFile("../../../FDSoil/class/sql/auditoria/insert.sql", $array);
            $this->ejecutar($x);
}

	function __destruct() {
        	$this->cerrar();
	}
}

//End of the class
?>
