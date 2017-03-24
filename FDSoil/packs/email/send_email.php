<?php

session_start();

function correo_enviar($nombre,$usuario,$clave_simple, $email_destino, $tipo_mensaje) {
     
include_once('../../../FDSoil/packs/email/phpmailer.class.php');
include_once('../../../'.$_SESSION['app'].'/config/email.php');

    $mail = new phpmailer(); 
    $mail->PluginDir = ""; 
    $mail->Helo = $email['web'];
    $mail->Mailer = "smtp"; //Con la propiedad Mailer le indicamos que vamos a usar un servidor smtp
    $mail->Host = $email['host']; //Asignamos a Host el nombre de nuestro servidor smtp 
    $mail->SMTPAuth = true; //Le indicamos que el servidor smtp requiere autenticacion
    $mail->Username = $email['email_origen']; //Le decimos cual es nuestro nombre de usuario y password
    $mail->Password = $email['clave_envio']; //clave del correo origen
    $direccion = $email_destino; //$direccion="cumacos@gmail.com";//Indicamos cual es nuestra direcci�n de correo y el nombre que 
    $mail->AddAddress($direccion);  //Indicamos cual es la direcci�n de destino del correo
    $mail->From = $email['email_origen']; //queremos que vea el usuario que lee nuestro correo
    $mail->FromName = $email['FromName'];
    $mail->Timeout=30; //el valor por defecto 10 de Timeout es un poco escaso dado que voy a usar una cuenta gratuita, por tanto lo pongo a 30  
    $mail->Subject = $email['Subject']; //Asignamos asunto y cuerpo del mensaje
    $mail->Body = "<b>Atencion Sr(a):". $nombre." </b><br></br><br>".$email[$tipo_mensaje]."</br><br><br></br><b>Usuario:&nbsp;".$usuario."</b></br><br><b>Contrase&ntilde;a:&nbsp;".$clave_simple."</b> &nbsp; </br>";
    $mail->AltBody = "Mensaje en formato solo texto"; //Definimos AltBody por si el destinatario del correo no admite email con formato html 
//se envia el mensaje, si no ha habido problemas  //la variable $exito tendra el valor true
    
    $exito = $mail->Send(); //echo $exito ;
    $intentos = 1;
    
    
    while ((!$exito) && ($intentos < 4)) { //Si el mensaje no ha podido ser enviado se realizaran 4 intentos mas como mucho para intentar enviar el mensaje, 
        sleep(5);   //cada intento se hara 5 segundos despues del anterior, para ello se usa la funcion sleep
        $exito = $mail->Send();
        $intentos = $intentos + 1;
        //echo $mail->ErrorInfo;
    }
    if (!$exito) {
        
         header("Location: ../../../FDSoil/packs/msj/index.php?msj=91&np=2");
    }
}

?>