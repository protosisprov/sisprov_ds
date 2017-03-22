<?php {
    
    class functions {        

    function getRealIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
           
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
       
        return $_SERVER['REMOTE_ADDR'];
        

    }
        
        public function isThereThisKeyInTheArray($array, $key) {
            $return = false;
            foreach ($array as $c => $v) {
                if ($c == $key) {
                    $return = true;
                    break;
                }
            }
            return $return;
        }

        public function quita_formato_numerico($num) {
            return $num = str_replace(",", ".", str_replace(".", "", $num));
        }

        public function quita_caracteres_especiales($cadena) {
            $cadena = str_replace("'", "", $cadena);
            $cadena = str_replace("_", "", $cadena);
            $cadena = str_replace("@", "", $cadena);
            $cadena = str_replace("\"", "", $cadena);
            return $cadena;
        }

        public function read_txt($file) {
            $texto = "";
            $linea = "";
            $fp = fopen($file, "r");
            while (!feof($fp)) {
                $linea = fgets($fp);
                $texto .= $linea;
            }
            fclose($fp);
            return $texto;
        }

        public function strip_accents($String) {
            $String = ereg_replace("[äáàâãª]", "a", $String);
            $String = ereg_replace("[ÁÀÂÃÄ]", "A", $String);
            $String = ereg_replace("[ÍÌÎÏ]", "I", $String);
            $String = ereg_replace("[íìîï]", "i", $String);
            $String = ereg_replace("[éèêë]", "e", $String);
            $String = ereg_replace("[ÉÈÊË]", "E", $String);
            $String = ereg_replace("[óòôõöº]", "o", $String);
            $String = ereg_replace("[ÓÒÔÕÖ]", "O", $String);
            $String = ereg_replace("[úùûü]", "u", $String);
            $String = ereg_replace("[ÚÙÛÜ]", "U", $String);
            $String = str_replace("^", "", $String);
            $String = str_replace("´", "", $String);
            $String = str_replace("`", "", $String);
            $String = str_replace("¨", "", $String);
            $String = str_replace('\\', "", $String);
            $String = str_replace('\'', "", $String);
            $String = str_replace("~", "", $String);
            $String = str_replace("ç", "c", $String);
            $String = str_replace("Ç", "C", $String);
            $String = str_replace("ñ", "n", $String);
            $String = str_replace("Ñ", "N", $String);
            $String = str_replace("Ý", "Y", $String);
            $String = str_replace("ý", "y", $String);

            return $String;
        }

        public function replace_data($request, $string) {
            if (!empty($string) && !empty($request)) {
                foreach ($request as $campo => $valor) {
                    $fields = "{fld:" . $campo . "}";
                    $string = str_replace($fields, $valor, $string);
                }
            }
            return $string;
        }

        function bldQryFile($fileSql, $array) {
            $Qry = $this->read_txt($fileSql);
            if (is_array($array)) {
                $Qry = $this->replace_data($array, $Qry);
            }
            return $Qry;
        }

        public function change_date_format($fecha) {
            if (substr_count($fecha, '-') > 0) {//si esta en formato AAAA-MM-DD se cambia a DD/MM/AAAA
                $f = explode("-", $fecha);
                $cs = "/"; //$cs="/";
            } else if (substr_count($fecha, '/') > 0) { //si esta en formato DD/MM/AAAA se cambia a AAAA-MM-DD
                $f = explode("/", $fecha);
                $cs = "-";
            }
            return $f[2] . $cs . $f[1] . $cs . $f[0];
        }

        public function explode_string_to_matrix($string, $separate1, $separate2) {
            $array = explode($separate1, $string);
            for ($i = 0; $i < count($array); $i++) {
                $subarray[$i] = explode($separate2, $array[$i]);
            }
            return $subarray;
        }

        public function separate_matrix_to_array($matrix, $key) {
            for ($i = 0; $i < count($matrix); $i++) {
                $array[$i] = $matrix[$i][$key];
            }
            return $array;
        }

        public function reindex_vector($vector) {
            $i = 0;
            foreach ($vector as $c => $v) {
                $return[$i] = $v;
                $i++;
            }
            return $return;
        }

        public function array_to_string($array) {
            $string = '';
            for ($i = 0; $i < count($array); $i++) {
                $string.=$array[$i] . ',';
            }
            return substr($string, 0, strlen($string) - 1);
        }

        function voltearFecha($fecha) {
            return implode("/", array_reverse(explode("-", $fecha)));
        }

       /* function validar_session() {
            //echo $_SERVER['DOCUMENT_ROOT']; 
            //echo $HTTP_SERVER_VARS['DOCUMENT_ROOT'];no trae nada
            //echo $_SERVER['SCRIPT_FILENAME'];die();
            if ($_SESSION == null) {
                header('Location: ../../../FDSoil/modulos/admin_session_closed/');
            } else {
                return;
            }
        }*/
        
        function validar_session() {
            //echo $_SERVER['DOCUMENT_ROOT'];
            //echo $HTTP_SERVER_VARS['DOCUMENT_ROOT'];no trae nada
            //echo $_SERVER['SCRIPT_FILENAME'];die();
            $id['carpeta'] = $_SESSION['app'];
            if (empty($_SESSION['id_usuario'])) {
                header('Location: ../../../FDSoil/modulos/admin_session_closed'+$id);
                die();
            } else {
                return;
            }
        }
        
        
        function seeArray($array){
            echo '<pre>';print_r($array);echo '</pre>';die();
        }
       
        function matrixUnaccentedUppercase($matrix){
            for ($i = 0; $i < count($matrix); $i++){
                foreach($matrix[$i] as $campo=>$valor){		
                    $matrix[$i][$campo]=$this->unaccentedUppercase($valor);
                }
            }
            return $matrix;
        }

        function unaccentedUppercase($cadena){
            $respuesta = $cadena;
            $respuesta = str_replace('á','A', $respuesta);
            $respuesta = str_replace('é','E', $respuesta);
            $respuesta = str_replace('í','I', $respuesta);
            $respuesta = str_replace('ó','O', $respuesta);
            $respuesta = str_replace('ú','U', $respuesta);
            $respuesta = str_replace('Á','A', $respuesta);
            $respuesta = str_replace('É','E', $respuesta);
            $respuesta = str_replace('Í','I', $respuesta);
            $respuesta = str_replace('Ó','O', $respuesta);
            $respuesta = str_replace('Ú','U', $respuesta);  
            return  strtoupper($respuesta);
        }
        
        
        function bldTable($rows,$id){
            $th="";
            $tr="";
            if ($id!=null)
                $idid="id='".$id."'";
            for ($i=0;$i<count($rows);$i++){                
                $tr.='<tr>';    
                foreach ($rows[$i] as $key => $value){
                    if ($i==0) $th.='<th>'.utf8_decode($key).'</th>';                   
                    $tr.='<td>'.utf8_decode($value).'</td>';                   
                }                
                $tr.='</tr>';
            }
            return "<table ".$idid.">".$th.$tr."</table>";                      
        }   
        
        function bldTableCss($rows,$id){
            $th="";
            $tr="";
            $idid="";
            if ($id!=null)
                $idid="id='".$id."'";
            $class_tr="losnone";
            for ($i=0;$i<count($rows);$i++){                
                $tr.="<tr class=".$class_tr.">";    
                foreach ($rows[$i] as $key => $value){
                    if ($i==0) $th.='<th>'.utf8_decode($key).'</th>';                   
                    $tr.='<td>'.utf8_decode($value).'</td>';                   
                }                
                $tr.='</tr>';
                $class_tr=($class_tr=="losnone")?"lospare":"losnone";
            }
            return "<table ".$idid." class='tabla_grid'>".$th.$tr."</table>";                      
        }        
        
        function matrixToString($matrix,$separate1,$separate2){
                $numRow=count($matrix);
		$strMatrix='';
                for ($n=0;$n<count($matrix);$n++){      
                    foreach ($matrix[$n] as $key => $value){
                        $strMatrix.=$value.$separate1;
                    }
                        $strMatrix=substr($strMatrix,0,strlen($strMatrix)-1).$separate2;
                }   
		return substr($strMatrix,0,strlen($strMatrix)-1);
    	}
        
        function sortMatrixBubble($matrix, $sortNumCol){  
            for($i=1;$i<count($matrix)-1;$i++){                  
                for($j=$i+1;$j<count($matrix);$j++){
                    if ($matrix[$i][$sortNumCol]<$matrix[$j][$sortNumCol]){
                        $arrayAux=$matrix[$i];
                        $matrix[$i]=$matrix[$j];
                        $matrix[$j]=$arrayAux;
                    }
                }
             } 
            return $matrix;
        }
        
        function randomString($length=8,$uc=true,$n=true,$sc=false){//echo RandomString(15,TRUE,TRUE,TRUE); 
	    $source = 'abcdefghijklmnopqrstuvwxyz';
	    if($uc==1) 
                $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    if($n==1) 
                $source .= '1234567890';
	    if($sc==1) 
                $source .= '|@$%!()';// OJO: Porque dan error así Â, no incluir aquí estos dos caracteres... ¿ ¬     
	    if($length>0){
	        $rstr = "";
	        $source = str_split($source,1);
	        for($i=1; $i<=$length; $i++){
	            mt_srand((double)microtime() * 1000000);
	            $num = mt_rand(1,count($source));                   
                    //$rstr.=($this->valKey($source[$num-1])==1)?$source[$num-1]:'///';
	            $rstr .= $source[$num-1];                   
	        }
	    }
	    return $rstr;
	}
        /*function valKey($subject){$acepNum=0;$acepCha=0;$acepEsp=0;$respFinal=0;
            if (preg_match('/[0-9]/',$subject))$acepNum=1;
            if (preg_match('/[a-z]/',$subject) || preg_match('/[A-Z]/',$subject))$acepCha=1;
            if (preg_match('/[|@#$%¿!¬()]/',$subject))$acepEsp=1;
            if ($acepNum==1 || $acepCha==1 || $acepEsp==1)$respFinal=1;return $respFinal;}*/
        
    }
}

//fin de la clase
?>
