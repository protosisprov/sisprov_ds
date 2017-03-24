<?php

include_once('roles.model.php');

class usuario extends rol {

    function tipoLogin(){
         
        if ($_POST['opcion'] == 1){
            $array['usuario'] = $_POST['rif1'].$_POST['rif2'].$_POST['rif3'];
            $array['campo'] = 'rif';
        }
        else if ($_POST['opcion'] == 2){
            $array['usuario'] = $_POST['nacionalidad'].$_POST['cedula'];
            $array['campo'] = 'cedula';
        }
        else if ($_POST['opcion'] == 3){
            $array['usuario'] = $_POST['correo'];
            $array['campo'] = 'correo';
        }
        else if ($_POST['opcion'] == 4){
            $array['usuario'] = $_POST['user'];
            $array['campo'] = 'usuario';
        }        
        return $array;
    }
    
    
    function inicioSession($row){ 
        $_SESSION['usuario']=$row['usuario'];
        $_SESSION['id_rol']=$row['id_rol'];
        $_SESSION['nombre_apellido']=$row['nombre'].', '.$row['apellido'];
        $_SESSION['id_usuario']=$row['id_usuario'];
        $_SESSION['cedula']=$row['cedula'];
        $_SESSION['ultimo']=$row['ultima'];
        $_SESSION['dependencia']=$row['dependencia'];
        $array['remote_addr']=$_SERVER['REMOTE_ADDR'];
        $array['id_usuario']=($this->isThereThisKeyInTheArray($_SESSION,'id_usuario'))?$_SESSION['id_usuario']:0;
        $array['fecha']= date("Y-m-d");
        $array['hora']= date("H:i:s");
        $array['accion']  = "INICIO DE SESSION";
        $x= $this->printQryFile("../../../FDSoil/class/sql/auditoria/insert.sql", $array);
            $this->ejecutar($x);

    }
    
    function cerrarSession($usuario){
        $array['remote_addr']=$_SERVER['REMOTE_ADDR'];
        $array['id_usuario']=$usuario;
//        $array['id_usuario']=($this->isThereThisKeyInTheArray($_SESSION,'id_usuario'))?$_SESSION['id_usuario']:0;
        $array['fecha']= date("Y-m-d");
        $array['hora']= date("H:i:s");
        $array['accion']  = "CERRAR SESSION";
        $x= $this->printQryFile("../../../FDSoil/class/sql/auditoria/insert.sql", $array);
            $this->ejecutar($x);

    }
    
    function listar() {
        return $this->exeQryFile("../../../FDSoil/class/sql/usuario/select.sql", null);
    }

    function valPswdOld() {
        //echo $this->printQryFile("../../../FDSoil/class/sql/usuario/val_pswd_old_select.sql", $_POST); die();
        $row=$this->extraer_registro($this->exeQryFile("../../../FDSoil/class/sql/usuario/val_pswd_old_select.sql", $_POST));
        return $row[0];
    }
    
    function validarAcceso($Post) {
//        echo $this->printQryFile("../../../FDSoil/class/sql/usuario/select_acceso.sql", $Post, true, 'INICIO DE SESION'); die();
       return $this->exeQryFile("../../../FDSoil/class/sql/usuario/select_acceso.sql", $Post, true, 'INICIO DE SESION');
    }
    
    function consultarUsuario($Post) { //consultar usuario para recordar contraseña
        return $this->exeQryFile("../../class/sql/usuario/select_usuario.sql", $Post);
    }    
        
    function preguntaSecreta($Post) { //si      
       //echo $this->printQryFile('../../class/sql/usuario/select_pregunta_secreta.sql', $Post); die();
       $row = $this->extraer_registro($this->exeQryFile("../../class/sql/usuario/select_pregunta_secreta.sql", $Post));
       return $row[0];
    }
    
    function resetContrasenia() { //si      
        //echo $this->printQryFile('../../class/sql/usuario/reset_contrasena.sql', $_POST);
        $sql = $this->extraer_registro($this->exeQryFile("../../class/sql/usuario/reset_contrasena.sql", $_POST));
        return $sql[0];
    }
    
    function comprobarDisponibilidad($Post) {//consulta usuario para comprobar que no este repetido el nombre
        $row = $this->extraer_arreglo($this->exeQryFile("../../../FDSoil/class/sql/usuario/select_disponible.sql", $Post));
        return $row[0];
    }
    function listarPreguntaSeguridad(){
       return $this->exeQryFile("../../../FDSoil/class/sql/usuario/select_pregunta_seguridad.sql", null);
    }
    function guardauserweb(){
        //echo $this->printQryFile("../../../FDSoil/class/sql/usuario/row_guarda_web.sql", $_POST);die();        
        $sql=$this->extraer_arreglo($this->exeQryFile("../../../FDSoil/class/sql/usuario/row_guarda_web.sql", $_POST));
       
        return $sql[0];
    }
    
    function verificaruserweb(){
        //echo $this->printQryFile("../../../FDSoil/class/sql/usuario/row_guarda_web.sql", $_POST);die();        
        $sql=$this->extraer_arreglo($this->exeQryFile("../../../FDSoil/class/sql/usuario/row_verificar_web.sql", $_POST));
       
        return $sql[0];
    }
//    function registrarUsuarioWeb($Post){
//        $row = $this->extraer_arreglo($this->exeQryFile("../../../FDSoil/class/sql/usuario/row_web.sql", $Post, true, 'REGISTRO USUARIO WEB'));
//        if ($row[0] == 'C') { 
//            include_once('../../../FDSoil/packs/email/send_email.php');            
//            $nombre = $Post['nombre'].' '.$Post['apellido'];
//            $usuario=$Post['usuario'];
//            $clave_simple = $Post['clave_simple'];
//            $email_destino = $Post['correo'];
//            correo_enviar($nombre,$usuario,$clave_simple,$email_destino,'msj_registro');
//        }
//        return $row[0];
//    }
    
    function registrarUsuario($Post){
//        echo $this->printQryFile("../../../FDSoil/class/sql/usuario/row.sql", $Post, true, 'REGISTRO USUARIO'); die();
        $row = $this->extraer_registro($this->exeQryFile("../../../FDSoil/class/sql/usuario/row.sql", $Post, true, 'REGISTRO USUARIO'));
        return $row[0];
    }
    
    function registrarMisDatos($Post){
        return ($this->exeQryFile("../../../FDSoil/class/sql/usuario/mis_datos_update.sql", $Post, true, 'ACTUALIZAR MIS DATOS'))?'A':'Z';
    }    
    
    function usuarioList() {        
        return $this->exeQryFile("../../../FDSoil/class/sql/usuario/list_select.sql", null);
    }
    
    function usuarioRow($Post) {    
//       echo $this->printQryFile("../../../FDSoil/class/sql/usuario/row_select.sql", $Post, true, 'REGISTRO USUARIO'); die();
        return $this->exeQryFile("../../../FDSoil/class/sql/usuario/row_select.sql", $Post);
    }
    
    function usuarioResetKey(){
        $resp='Z';
        //$nueva_clave=$this->randomString(8,true,true,true); 
        $nueva_clave='123456'; 
        $_POST['clave'] = md5($nueva_clave);
        $this->usuarioChangePswdReset($_POST);

        /*if ($this->usuarioChangePswdReset($_POST)){
                include_once('../../../FDSoil/packs/email/send_email.php');    $
                $row=$this->extraer_asociativo($this->exeQryFile("../../../FDSo$
                $nombre=$row['nombre'].', '.$row['apellido'];
                $usuario=$row['usuario'];
                $email_destino=$row['correo'];
                $tipo_mensaje='msj_recuperacion';
                correo_enviar($nombre,$usuario,$nueva_clave,$email_destino,$tip$
                $resp='E';
        }*/
        $resp='E';
        return $resp;
    }

//    function usuarioResetKey(){
//        $resp='Z';
//	$nueva_clave=$this->randomString(8,true,true,true); 
//	$_POST['clave'] = md5($nueva_clave);
//	if ($this->usuarioChangePswdReset($_POST)){
//		include_once('../../../FDSoil/packs/email/send_email.php');		
//		$row=$this->extraer_asociativo($this->exeQryFile("../../../FDSoil/class/sql/usuario/row_select.sql", $_POST));
//		$nombre=$row['nombre'].', '.$row['apellido'];
//		$usuario=$row['usuario'];
//		$email_destino=$row['correo'];
//		$tipo_mensaje='msj_recuperacion';
//		correo_enviar($nombre,$usuario,$nueva_clave,$email_destino,$tipo_mensaje);
//                $resp='E';
//	}
//        return $resp;
//    }

    function recoverPassWord($Post) { 
        return $this->exeQryFile("../../class/sql/usuario/recover_pass_word.sql", $Post, true, 'RECUPERAR CLAVE');
    }

    function validarClaveUsuario(){
	$aId['id']=$_SESSION['id_usuario'];
	$row=$this->extraer_registro($this->exeQryFile("../../class/sql/usuario/status_clave_usuario_select.sql", $aId));
	if ($row[0]!='t'){
		$_SESSION['dp']='../../../FDSoil/modulos/admin_usuario_change_pswd_forced';
		header("Location: ../../../FDSoil/modulos/admin_msj/index.php?msj=Y");
	}
    }

    function validarCedulaId(){	
	$row=$this->extraer_registro($this->exeQryFile("../../class/sql/usuario/validar_cedula_id_select.sql", $_GET));
	return $row[0];
		
    }

    function validarEmail(){
        //echo $this->printQryFile("../../class/sql/usuario/validar_email_select.sql", $_GET); die();
	$row=$this->extraer_registro($this->exeQryFile("../../class/sql/usuario/validar_email_select.sql", $_GET));
	return $row[0];
		
    }
    
    function validarCelular(){	
	$row=$this->extraer_registro($this->exeQryFile("../../class/sql/usuario/validar_celular_select.sql", $_GET));
	return $row[0];		
    }

    function validarRespSeguridad(){	
	$row=$this->extraer_registro($this->exeQryFile("../../class/sql/usuario/validar_resp_seguridad_select.sql", $_GET));
	return $row[0];		
    }
    function cambiocontrasena(){
        //echo $this->printQryFile('../../class/sql/usuario/cambio_contrasena.sql', $_GET); die();
	$row=$this->extraer_registro($this->exeQryFile("../../class/sql/usuario/cambio_contrasena.sql", $_GET));
        return $row[0];		
    }
    function usuarioChangePswdForced(){                 
         return ($this->exeQryFile("../../../FDSoil/class/sql/usuario/change_pswd_update_forced.sql", $_POST,true, 'CAMBIO DE CLAVE FORZADO'))?'F':'Z';    
    }
    
    function usuarioChangePswdReset(){     
         return $this->exeQryFile("../../../FDSoil/class/sql/usuario/change_pswd_update_reset.sql", $_POST, true, 'CAMBIO DE CLAVE RESETEADO');    
    }

    function usuarioChangePswd(){
         //echo $this->printQryFile('../../../FDSoil/class/sql/usuario/change_pswd_update.sql', $_POST); die();
         return ($this->exeQryFile("../../../FDSoil/class/sql/usuario/change_pswd_update.sql", $_POST, true,'CAMBIO DE CLAVE'))?'A':'Z';    
    }
    
    //Funcion para el regsitro de inicio de session de usuario dentro de la tabla de auditoria
    
    function auditoria_usuario($qry, $coment) {
//        echo "aqqqq";
        die();
//    var id_registro_meta  = document.getElementById('id_registro_meta').value;
//    var valores_iniciales = document.getElementById('valores'+id_registro_meta).value;
//    var ip  =$_SERVER['REMOTE_ADDR'];
//    var tabla  = "indicador.metaslograda";
//    var accion  = "DELETE";
//    
//    
//    var comentario  = "SE ELIMINA EL REGISTRO DE LA METRA SEGUN SU FRECUENCIA";
//    var usuario  = document.getElementById('i_usuario').value;
//    var data = 'id_registro_meta='+id_registro_meta+'&valores_iniciales='+valores_iniciales+'&i_ip='+ip+'&tabla='+tabla+'&accion='+accion+'&comentario='+comentario+'&usuario='+usuario;


        $array['remote_addr'] = $_SERVER['REMOTE_ADDR'];
        $array['remote_port'] = $_SERVER['REMOTE_PORT'];
        $array['id_usuario'] = ($this->isThereThisKeyInTheArray($_SESSION, 'id_usuario')) ? $_SESSION['id_usuario'] : 0;
        //$array['id_usuario']=$_SESSION['id_usuario'];
        $array['script_filename'] = $_SERVER['SCRIPT_FILENAME'];
        $array['request_method'] = $_SERVER['REQUEST_METHOD'];
        $array['query'] = str_replace("'", '"', $qry);
        $array['fecha'] = date("Y-m-d");
        $array['hora'] = date("H:i:s");
        $array['coment'] = $coment;
        print_r($array);
        die();
        $x = $this->printQryFile("../../../FDSoil/class/sql/auditoria/insert.sql", $array);
        $this->ejecutar($x);
    }
/*********************************************** OFICINAS *************************************************/
        function listar_direccion(){
//            echo $this->printQryFile("../../class/sql/listar/listar_direccion.sql", $id);die();        
            return $this->exeQryFile('../../class/sql/usuario/listar_direccion.sql', null); 
        }

}

?>
