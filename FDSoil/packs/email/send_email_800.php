<?php

session_start();

function correo_enviar($id, $email_destino, $tipo_mensaje) {
     
include_once('../../../FDSoil/packs/email/class.phpmailer.php');
include_once('../../../FDSoil/packs/email/class.smtp.php');
include_once('../../../'.$_SESSION['app'].'/config/email.php');

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
//$mail->Host = "smtp.gmail.com";
//$mail->Host = "smtp.sh.cantv.com.ve";
$mail->Host = "190.9.128.50";
//$mail->Port = 465;
$mail->Port = 25;
//$mail->Username = "honguitowebgrafico@gmail.com";
$mail->Username = "msuarez@mpptaa.gob.ve";
$mail->Password = "123456-7";


//$mail->From = "honguitowebgrafico@gmail.com";
$mail->From = "msuarez@mpptaa.gob.ve";
$mail->FromName = "Nombre";
$mail->Subject = "Asunto del Email";
$mail->AltBody = "Este es un mensaje de prueba.";
$mail->MsgHTML("<b>PRUEBA NUEVA DE CORREO con el otro host estos son los datos(".$id.")</b>");
$mail->AddAttachment("files/files.zip");
$mail->AddAttachment("files/img03.jpg");
$mail->AddAddress("infoqui@gmail.com", "Destinatario");
$mail->IsHTML(true);
if(!$mail->Send()) {
 echo "Error: " . $mail->ErrorInfo;
} else {
 echo "Mensaje enviado correctamente";
 }

//    $mail = new PHPMailer();
//    
//    $mail->From = "infoqui@gmail.com";
//    $mail->FromName = 'Maru'; //
//    $mail->AddAddress("honguitowebgrafico@gmail.com"); //direccion de correo
//    $mail->IsHTML(true); 
//    $mail->Mailer = 'smtp';
//    $mail->SMTPAuth = true;
//    //$mail->Host = 'smtp.gmail.com';
//    $mail->Host = '190.9.128.50';
//    //$mail->SMTPSecure = 'tls'; 
////    $mail->Port = 465;
//    $mail->Port = 25;
//    $mail->SMTPAuth = true;
//    $mail->Username = 'infoqui@gmail.com';
//    $mail->Password = 'todostenemosunpoder';
//    $mail->Subject = 'Activacion de cuenta de usuario PRUEBA CON MVC'; //titulo
//    $mail->Body = 'Hola <strong> PRUEBA </strong>,' . //cuerpo
//                '<p>Se ha registrado en www.indepabis.gob.ve para activar ' ;
    
//    $mail->PluginDir = ""; 
//    $mail->Helo = $email['web'];
//    $mail->Mailer = "smtp"; //Con la propiedad Mailer le indicamos que vamos a usar un servidor smtp
//    $mail->Host = $email['host']; //Asignamos a Host el nombre de nuestro servidor smtp
//    $mail->Port = $email['port'];
//    $mail->SMTPSecure = $email['secure'];
//    $mail->SMTPAuth = true; //Le indicamos que el servidor smtp requiere autenticacion
//    $mail->Username = $email['email_origen']; //Le decimos cual es nuestro nombre de usuario y password
//    $mail->Password = $email['clave_envio']; //clave del correo origen
//    $direccion = $email_destino; //$direccion="cumacos@gmail.com";//Indicamos cual es nuestra direcci�n de correo y el nombre que 
//    $mail->AddAddress($direccion);  //Indicamos cual es la direcci�n de destino del correo
//    $mail->FromName = $email['FromName'];
//    $mail->From = $email['email_origen']; //queremos que vea el usuario que lee nuestro correo
//    $mail->Timeout=30; //el valor por defecto 10 de Timeout es un poco escaso dado que voy a usar una cuenta gratuita, por tanto lo pongo a 30  
//    $mail->Subject = $email['Subject']; //Asignamos asunto y cuerpo del mensaje
//    $mail->Body = "<b>Atencion Sr(a):". $id." </br><br><br></br><b>MENSAJE:&nbsp;".$email[$tipo_mensaje]."</b> &nbsp; </br>";
//    $mail->AltBody = "Mensaje en formato solo texto"; //Definimos AltBody por si el destinatario del correo no admite email con formato html 
//se envia el mensaje, si no ha habido problemas  //la variable $exito tendra el valor true

//     if(!$mail->Send()) {
//    echo "<br>Mailer Error: " . $mail->ErrorInfo;
//    } else {
//    echo "Message sent!";
//    }
         
            
//    $exito = $mail->Send(); echo $exito ;
//    $intentos = 1;
//    
//  
//    while ((!$exito) && ($intentos < 4)) { //Si el mensaje no ha podido ser enviado se realizaran 4 intentos mas como mucho para intentar enviar el mensaje, 
//        sleep(5);   //cada intento se hara 5 segundos despues del anterior, para ello se usa la funcion sleep
//        $exito = $mail->Send();
//        $intentos = $intentos + 1;
//        echo $mail->ErrorInfo;
//    }
    
//    if (!$exito) {
//        
//         header("Location: ../../../FDSoil/packs/msj/index.php?msj=91&np=2");
//    }
}

?>