<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
$mail = new PHPMailer(true);
$correo = $_POST['correo']; // datos de la notificacion
$mensaje = $_POST['mensaje'];
$asunto = $_POST['asunto'];
try {
    //Server settings
    
    $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER; 
    $mail->isSMTP();     // se envia a traves de SMTP
    $mail->Host       = 'smtp.gmail.com'; // se inicializa el  SMTP server 
    $mail->SMTPAuth   = true;   // se activa la autentificacion SMTP 
    $mail->Username   = 'appTramites@gmail.com';//Correo del sistema       
    $mail->Password   = 'tramitesHNM';//Contraseña del correo del sistema    
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587; // puerto TCP por el que se conectara
    //Recipients
    $mail->setFrom('appTramites@hnm.org', 'Sistema');//Correo del sistema y nombre
    $mail->addAddress($correo);//A quien va dirigido     
    // Attachments
    $mail->addAttachment('');       // archivos adjuntos
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    
    // Contentenido
    $mail->isHTML(true);                               
    $mail->Subject = $asunto; //asunto del correo
    $mail->Body    = $mensaje; // mensaje del correo
    //$mail->AltBody = ''-,
    $mail->send();
    echo 'Mensaje enviado correctamente';
} catch (Exception $e) {
    echo "No se pudo enviar: {$mail->ErrorInfo}";
}
 