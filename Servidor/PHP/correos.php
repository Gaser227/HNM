<?php
include "Conexion.php"; //Se incluye la clase conexion

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

function Jefe($correo, $empleado, $solicitud, $nomina, $fecha){
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER; 
    $mail->isSMTP();     // se envia a traves de SMTP
    $mail->Host       = 'smtp.gmail.com'; // se inicializa el  SMTP server 
    $mail->SMTPAuth   = true;   // se activa la autentificacion SMTP 
    $mail->Username   = 'tramiteshnm@gmail.com';//Correo del sistema       
    //$mail->Password   = '4ppHNM2022';//Contraseña del correo del sistema   
    $mail->Password   = 'hsqbzkxdedumykpi';//Contraseña del correo del sistema
    #$mail->Username   = 'sonicjos.ys@gmail.com';//Correo del sistema       
    #$mail->Password   = 'dncnqwtsiytuyrtl';//Contraseña del correo del sistema     
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587; // puerto TCP por el que se conectara
    //Recipients
    $mail->setFrom('appTramites@hnm.org', 'Sistema');//Correo del sistema y nombre
    #$mail->setFrom('sonicjos.ys@gmail.com', 'Sistema');//Correo del sistema y nombre
    #$mail->addAddress('appTramites@hnm.org', 'Sistema');
    $mail->addAddress($correo,'Usuario'); //A quien va dirigido   
    // Attachments
    #$mail->addAttachment('');       // archivos adjuntos
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    
    // Contentenido
    $mail->isHTML(true);                               
    $mail->Subject = 'Notificacion'; //asunto del correo
    $mail->Body = 'El empleado: ' .$empleado. ' Con nomina: ' .$nomina. ' Realizo la siguiente solicitud: ' .$solicitud. ' Con fecha: ' .$fecha; // mensaje del correo 
    //$mail->AltBody = ''-,
    if(!$mail->Send()){
        echo "Mailer Error: " . $mail->ErrorInfo;
       }
       else{
        #echo "Message has been sent";
        return true;
       }
}

function Empleado($correo, $empleado, $folio, $nomina, $estado, $fecha){
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER; 
    $mail->isSMTP();     // se envia a traves de SMTP
    $mail->Host       = 'smtp.gmail.com'; // se inicializa el  SMTP server 
    $mail->SMTPAuth   = true;   // se activa la autentificacion SMTP 
    $mail->Username   = 'tramiteshnm@gmail.com';//Correo del sistema       
    //$mail->Password   = '4ppHNM2022';//Contraseña del correo del sistema   
    $mail->Password   = 'hsqbzkxdedumykpi';//Contraseña del correo del sistema
    #$mail->Username   = 'sonicjos.ys@gmail.com';//Correo del sistema       
    #$mail->Password   = 'dncnqwtsiytuyrtl';//Contraseña del correo del sistema     
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587; // puerto TCP por el que se conectara
    //Recipients
    $mail->setFrom('appTramites@hnm.org', 'Sistema');//Correo del sistema y nombre
    #$mail->setFrom('sonicjos.ys@gmail.com', 'Sistema');//Correo del sistema y nombre
    #$mail->addAddress('appTramites@hnm.org', 'Sistema');
    $mail->addAddress($correo,'Usuario'); //A quien va dirigido   
    // Attachments
    #$mail->addAttachment('');       // archivos adjuntos
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    
    // Contentenido
    $mail->isHTML(true);                               
    $mail->Subject = 'Notificacion'; //asunto del correo
    $mail->Body = 'El empleado: ' .$empleado. ' Con nomina: ' .$nomina. ' Realizo un cambio en la solicitud con folio: ' .$folio. ' Esta cambio a: ' .$estado. ' Con fecha: ' .$fecha; // mensaje del correo 
    //$mail->AltBody = ''-,
    if(!$mail->Send()){
        echo "Mailer Error: " . $mail->ErrorInfo;
       }
       else{
        #echo "Message has been sent";
        return true;
       }
}

function notificarJefe(){
    try {
        $fechaActual = date("Y-m-d");
        $tipoSolicitud = $_POST['solicitud'];
        $idJefe = $_POST['idJefe'];
        $idEmpleado = $_POST['idEmpleado'];
        $sql = "SELECT correo FROM empleado WHERE nomina=?";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$idJefe]);
        $correo = $statement->fetch(); 
        $sql1 = "SELECT nombre FROM empleado WHERE nomina=?";
        $statement1 = Conexion::getConexion()->prepare($sql1);
        $statement1->execute([$idEmpleado]);
        $nombre = $statement1->fetch(); 
        Jefe($correo['correo'], $nombre['nombre'], $tipoSolicitud, $idEmpleado, $fechaActual); //Se manda a llamar a la funcion correo
        return "Se ha notificado al jefe"; 
        } catch (Exception $e) {
            echo $e->getMessage();
             
    }
}

function notificarEmpleado(){
    try {
        $fechaActual = date("Y-m-d");
        $folio = $_POST['folio'];
        $nomina = $_POST['nomina'];
        if($_POST['estado'] == 1){
            $estado = "Aceptada";
        }else{
            $estado = "Denegada";
        }
        $sql = "SELECT e.nombre, e.correo
          FROM empleado e
          JOIN formatos f ON e.id = f.idEmpleado
          WHERE f.folio = :folio";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$folio]);
        $datos = $statement->fetch(); 
        Empleado($datos['correo'], $datos['nombre'],$folio, $nomina, $estado, $fechaActual); //Se manda a llamar a la funcion correo
        return "Se ha notificado al jefe"; 
        } catch (Exception $e) {
            echo $e->getMessage();
             
    }
}

$funcion = $_POST["numFuncion"];
switch ($funcion) {
    case 1:
        $mensaje = notificarJefe();
        echo $mensaje;
        break;
    case 2:
        $mensaje = notificarEmpleado();
        echo $mensaje;
        break;
}
?>