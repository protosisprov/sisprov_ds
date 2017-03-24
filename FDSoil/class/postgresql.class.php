<?php
include_once('../../../FDSoil/class/functions.class.php'); 
class manejador_bd  extends functions {
        // pg_last_error();
//                  
    	private $conexion;
        
	function conectar($db=null) {
	       	include '../../../'.$_SESSION['app'].'/config/db.php';  
                
                $_SESSION['base_datos']=$db;
                switch ($db) {
                    case "sqlsrv":
                        $connectionInfo = array( "Database"=>$dbname, "UID"=>$usuario, "PWD"=>$password);
//                        $conn = sqlsrv_connect($servidor, $connectionInfo);
                        $this->conexion = sqlsrv_connect($servidor,$connectionInfo);
                    break;
                    case "mssql":
//                        include '../../../'.$_SESSION['app'].'/config/db.php';  
//                        $con = mssql_connect($servidor,$usuario,$password);
                        $this->conexion = mssql_connect($servidor,$usuario,$password);
                        $base= mssql_select_db($dbname,$this->conexion);
                    break;
                    case "mysql":
                        $this->conexion = mysql_connect($servidor,$usuario,$password);
                        $base= mysql_select_db($dbname,$this->conexion);
                    break;
                    case "oracle":
                        $this->conexion = oci_connect($usuario,$password,$servidor);
//                        $base = ocilogon($usuario,$password,$dbname); 
                    break;
                    default:
                        $_SESSION['base_datos']="";
                        $this->conexion = pg_connect("host=$servidor port=$port dbname=$dbname user=$usuario password=$password");
                }
                
                return (!$this->conexion) ? false : $this->conexion;
	}
        
	function cerrar() { 
            if (!empty($this->conexion)) {
                switch ($_SESSION['base_datos']) {
                    case "sqlsrv":
                        sqlsrv_close($this->conexion);
                    break;
                    case "mssql":
                        mssql_close($this->conexion);
                    break;
                    case "mysql":
                        mysql_close($this->conexion);
                    break;
                    case "oracle":
                        oci_close($this->conexion);
                    break;
                    default:
                        pg_close($this->conexion);
                }
            }
	}

	function ejecutar($sql) {
            switch ($_SESSION['base_datos']) {
                case "sqlsrv":
                    return sqlsrv_query($sql);
                break;
                case "mssql":
                    return mssql_query($sql);
                break;
                case "mysql":
                    return mysql_query($sql);
                break;
                case "oracle":
                    $stmt = oci_parse($this->conexion, $sql);
                    oci_execute($stmt, OCI_DEFAULT);
                    return $stmt;
                break;
                default:
                    return pg_query($sql);
            }
    	}
        
	function extraer_resultado($result) {
            switch ($_SESSION['base_datos']) {
                case "sqlsrv":
                    return sqlsrv_fetch_array($result);
                break;
                case "mssql":
                    return mssql_fetch_assoc($result);
                break;
                case "mysql":
                    return mysql_fetch_assoc($result);
                break;
                case "oracle":
                    return oci_fetch_assoc($result);
                break;
                default:
                    return pg_fetch_result($result);
            }
	}

	function extraer_registro($result){
            switch ($_SESSION['base_datos']) {
                case "sqlsrv":
                    return sqlsrv_fetch($result);
                break;
                case "mssql":
                    return mssql_fetch_row($result);
                break;
                case "mysql":
                    return mysql_fetch_row($result);
                break;
                case "oracle":
                    return oci_fetch_row($result);
                break;
                default:
                    return pg_fetch_row($result);
            }
    	}

	function extraer_arreglo($result){
            switch ($_SESSION['base_datos']) {
                case "sqlsrv":
                    return sqlsrv_fetch_array($result);
                break;
                case "mssql":
                    return mssql_fetch_array($result);
                break;
                case "mysql":
                    return mysql_fetch_array($result);
                break;
                case "oracle":
                    return oci_fetch_array($result,OCI_BOTH);
                break;
                default:
                    return pg_fetch_array($result);
            }
	}

	function extraer_asociativo($result){
            switch ($_SESSION['base_datos']) {
                case "sqlsrv":
                    return sqlsrv_fetch($result);
                break;
                case "mssql":
                    return mssql_fetch_assoc($result);
                break;
                case "mysql":
                    return mysql_fetch_assoc($result);
                break;
                case "oracle":
                    return oci_fetch_assoc($result, OCI_BOTH);
                break;
                default:
                    return pg_fetch_assoc($result);
            }
	} 
        
	function  extraer_todo($result){
		return pg_fetch_all($result);
	}

	function  num_registros($result){
            switch ($_SESSION['base_datos']) {
                case "sqlsrv":
                    return sqlsrv_num_rows($result);
                break;
                case "mssql":
                    return mssql_num_rows($result);
                break;
                case "mysql":
                    return mysql_num_rows($result);
                break;
                case "oracle":
                    return oci_num_rows($result);
                break;
                default:
                    return pg_num_rows($result);
            }
	}

	function num_campos($result){
            switch ($_SESSION['base_datos']) {
                case "sqlsrv":
                    return sqlsrv_num_fields($result);
                break;
                case "mssql":
                    return mssql_num_fields($result);
                break;
                case "mysql":
                    return mysql_num_fields($result);
                break;
                case "oracle":
                    return oci_num_fields($result);
                break;
                default:
                    return pg_num_fields($result);
            }
    	}
}//Fin clase
?>
