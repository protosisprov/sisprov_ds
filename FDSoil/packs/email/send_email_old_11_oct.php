<?php
function correo_enviar($email,$nombre,$nueva_clave){

include_once('../../../FDSoil/packs/email/phpmailer.class.php');
include_once('../../../FDSoil/packs/email/smtp.class.php');
$mail = new phpmailer();
$mail->PluginDir = "";
$mail->Mailer = "smtp";//Con la propiedad Mailer le indicamos que vamos a usar un servidor smtp
$mail->Host = "correo.mincomercio.gob.ve";//Asignamos a Host el nombre de nuestro servidor smtp 
$mail->SMTPAuth = true; //Le indicamos que el servidor smtp requiere autenticacion
$mail->Username = "ed.hidalgo"; //Le decimos cual es nuestro nombre de usuario y password
$mail->Password = "17876692";//ragde14153091
$direccion=$email;//$direccion="cumacos@gmail.com";//Indicamos cual es nuestra direcci�n de correo y el nombre que 
$mail->AddAddress("$direccion");  //Indicamos cual es la direcci�n de destino del correo
$mail->From = "ed.hidalgo@mincomercio.gob.ve";//queremos que vea el usuario que lee nuestro correo
$mail->FromName = "Ministerio del Poder Popular para el Comercio";
$mail->Timeout=30;//el valor por defecto 10 de Timeout es un poco escaso dado que voy a usar una cuenta gratuita, por tanto lo pongo a 30  
$mail->Subject = "Sistema de registro de inventario para la industria y el comercio";//Asignamos asunto y cuerpo del mensaje
$mail->Body = "<b>Atencion Sr(a): $nombre </b><br></br><br>El Ministerio del Poder Popular para el Comercio, cumple con informarle que ha restablecido con &eacute;xito la contraseña de acceso para el sistema SIREIC.</br><br>Debe ingresar a la p&aacute;gina web http://www.mincomercio.gob.ve/ con el siguiente contrase&ntilde;a</br><br><br></br><br><b>Contrase&ntilde;a:&nbsp;$nueva_clave</b> &nbsp; </br>";//El cuerpo del mensaje lo ponemos en formato html, haciendo //que se vea en negrita
$mail->AltBody = "Mensaje de prueba mandado con phpmailer en formato solo texto";//Definimos AltBody por si el destinatario del correo no admite email con formato html 
//se envia el mensaje, si no ha habido problemas  //la variable $exito tendra el valor true
	$exito = $mail->Send(); //echo $exito ; die();
	$intentos=1; 
	while (($exito!=1) && ($intentos < 4)){	//Si el mensaje no ha podido ser enviado se realizaran 4 intentos mas como mucho para intentar enviar el mensaje, 
		sleep(5);			//cada intento se hara 5 segundos despues del anterior, para ello se usa la funcion sleep
     		$exito = $mail->Send();
     		$intentos=$intentos+1;	
		//echo $mail->ErrorInfo;
   	}
	if($exito == 1){
		//echo "Problemas enviando correo electr�nico a ".$valor;//echo "<br>".$mail->ErrorInfo;
		$msj = 4;
                header("Location: ../../../FDSoil/packs/msj/index.php?msj=$msj&np=2");
   	}
   	else{
		$msj = 93;
                header("Location: ../../../FDSoil/packs/msj/index.php?msj=$msj&np=2");
   	} 
}
?>
