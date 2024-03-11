<?php

include "Conexion.php"; //Se incluye la clase conexion
//include "notificacionCorreo.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

/* 
    Funcion para realizar el proceso de inicio de sesión
    requiere de número de nomina y contraseña que llegan por el metodo POST
    está funcion retorna un mensaje indicando si se inicia sesion o hay error
    Si se valida que existe la informacion proporcionada se crea la sesión en la variable de session
*/

function Correo($correo,  $contrasena){
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER; 
    $mail->isSMTP();     // se envia a traves de SMTP
    $mail->Host       = 'smtp.gmail.com'; // se inicializa el  SMTP server 
    $mail->SMTPAuth   = true;   // se activa la autentificacion SMTP 
    $mail->Username   = 'tramiteshnm@gmail.com';//Correo del sistema       
    $mail->Password   = 'hsqbzkxdedumykpi';//Contraseña del correo del sistema
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587; // puerto TCP por el que se conectara
    $mail->setFrom('appTramites@hnm.org', 'Sistema');//Correo del sistema y nombre
    $mail->addAddress($correo,'Usuario'); //A quien va dirigido   
    $mail->isHTML(true);                               
    $mail->Subject = 'Correo de Nueva Contraseña'; //asunto del correo
    $mail->Body = 'Tu nueva contraseña es: ' .$contrasena; // mensaje del correo 
    if(!$mail->Send()){
        echo "Mailer Error: " . $mail->ErrorInfo;
       }
       else{
        return true;
       }
}

function login(){
    try {
        session_start(); //Se inicia una sesión
        $valor = $_POST["nomina"]; //Se obtiene número de nomina
        $contrasena = $_POST["contrasena"]; //Se obtiene contraseña
      
        $sql = "SELECT * FROM empleado WHERE nomina = ? AND contrasena = ? AND estado<>0"; //Se asigna una sentencia SQL
        $statement = Conexion::getConexion()->prepare($sql); //Se obtiene la conexion y se prepara la sentencia
        $statement->execute([$valor, $contrasena]); //Se ejecuta la sentencia
        while ($row = $statement->fetch(PDO::FETCH_NUM)) { //Asignamos y validamos que haya un resultado de la petición
         
            $_SESSION['empleadoHnmFormatos'] = $row; //Se crea la sesión y se almacena la información
            $_SESSION['empleadoHnmFormatos']['boton'] = 0;
            $mensaje = "Sesión Iniciada";
            return $mensaje;
        }
        $mensaje = "Número de nómina o contraseña incorrectos";
        return $mensaje;
    } catch (Exception $e) {
        echo $e->getMessage(); //En caso de fallo se muestra el error
    }
}

function logout()
{
    try {
        session_start();
        session_unset();
        session_destroy();
        return "Sesión Finalizada";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function registrarContrasena()
{
    try {
        $valor = $_POST["nomina"];
        $contrasena = $_POST["contrasena"];
        $cambiaContrasena = 0;
        $sql = "SELECT cambiaContrasena FROM empleado WHERE nomina = ?";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$valor]);
        while ($row = $statement->fetch(PDO::FETCH_NUM)) {
            $cambiaContrasena = $row[0];
        }
        if ($cambiaContrasena == 1) {
            $sql = "UPDATE empleado SET contrasena=?,cambiaContrasena=0 WHERE nomina = ?";
            $statement = Conexion::getConexion()->prepare($sql);
            $res = $statement->execute([$contrasena, $valor]);
            if ($res) {
                return "Se registro su contraseña correctamente";
            }
        } else {
            return "Ya has registrado tu contraseña";
        }
        return "Ocurrio un error";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function recuperarContrasena(){
    try {        
        $valor = $_POST["nomina"];
        $query = "SELECT * FROM empleado WHERE nomina=?";
        $statement = Conexion::getConexion()->prepare($query);
        $statement->execute([$valor]);
        $val = $statement->fetchColumn();
        if($val > 0){ //Si se encuentra una nomina, se realiza el proceso
            $contrasena = rand(10000,50000); //Contraseña aleatorea
            $sql = "SELECT correo FROM empleado WHERE nomina=?";
            $statement = Conexion::getConexion()->prepare($sql);
            $statement->execute([$valor]);
            $correo = $statement->fetch(); //Se optiene el correo del empleado
            if ($sql){
                    $sqlD = "UPDATE empleado SET contrasena=? WHERE nomina=?";
                    $statement = Conexion::getConexion()->prepare($sqlD);
                    $res = $statement->execute([$contrasena, $valor]);
                    if ($res) {
                        Correo($correo['correo'],$contrasena); //Se manda a llamar a la funcion correo
                        return "Revise su correo para obtener su nueva contraseña";                      
                    }
            }else{
                return "No se encontro un correo";
            }
            return "Ocurrio un error";
            }else{
                return "No se encontro su usuario";
            }
        } catch (Exception $e) {
            echo $e->getMessage(); 
    }
}

function cabioContraseña()
{
    try {  
        session_start();
        $ses = $_SESSION['empleadoHnmFormatos'][1]; //Nomina
        $val = $_POST["contrasenaCambio"]; //Contraseña actual ingresada por el usuario
        $nuevaContrasena = $_POST["nuevaContraseña"]; //Nueva contraseña
        $nuevaContrasena2 = $_POST["nuevaContraseñaC"]; //Confirmacion de la nueva contraseña |Posiblemente se borre puesto que, la comparacion de la contraseña se realiza en AJAX|
        
        $con = "SELECT contrasena FROM empleado WHERE nomina = ?";
        $statement = Conexion::getConexion()->prepare($con);            ///Validacion
        $statement->execute([$ses]);
        $conActual = $statement->fetch(); //COntraseña actual
            if ($con) {
                $sqlD = "UPDATE empleado SET contrasena=? WHERE nomina=?";
                $statement = Conexion::getConexion()->prepare($sqlD);
                $res = $statement->execute([$nuevaContrasena, $ses]);
                if ($res) {
                    return "Se realizo el cambio de contraseña correctamente";
                } else{
                    return "Ocurrio un error";
                }
            } else {
                return "Ocurrio un error";
            }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

$funcion = $_POST["numFuncion"];
switch ($funcion) {
    case 1:/* funcion para realizar el login al sistema */
        $mensaje = login();
        echo $mensaje;
        break;
    case 2:/* funcion para realizar el logout del sistema */
        $mensaje = logout();
        echo $mensaje;
        break;
    case 3:/* funcion para registrar la contraseña del empleado */
        $mensaje = registrarContrasena();
        echo $mensaje;
        break;
    case 4:/* funcion para recuperar la contraseña del empleado */
        $mensaje = recuperarContrasena();
        echo $mensaje;
        break;
    case 5:/* funcion para el cambio de contraseña */
        $mensaje = cabioContraseña();
        break;
}
