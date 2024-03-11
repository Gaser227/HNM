<?php
include_once("Conexion.php");
/*try {
    $ruta = "c:\composer\\";
    $nombre = "Formatos-12112020.bak";
    $archivo = fopen("c:\\composer\\$nombre", "w+b");    // Abrir el archivo, creándolo si no existe
    if ($archivo == false)
        echo "Error al crear el archivo";
    else
        echo "El archivo ha sido creado";
    fclose($archivo);   // Cerrar el archivo
    $sql = "BACKUP DATABASE formatos TO DISK = 'c:\composer\\$nombre'";
    $statement = Conexion::getConexion()->prepare($sql);
    $res = $statement->execute();
    if ($res) {
        echo "Respaldo realizado con exito" . $res;
    }
    echo "Ocurrio un problema";
} catch (PDOException $e) {
    echo $e->getMessage();
}
 */


date_default_timezone_set('America/Mexico_City');
$fecha = date("Y-m-d");
$tipo = "Respaldo";
$nombre = $tipo."-".$fecha;
define('RUTA_RESPALDOS', 'C:/xampp/htdocs/Nueva_carpeta/HNM/Servidor/RespaldosBD/');
//define('RUTA_RESPALDOS', 'C:\Respaldos');
$ruta = realpath(RUTA_RESPALDOS) . DIRECTORY_SEPARATOR . $nombre . ".bak";
print_r($ruta);
//$nombre = "Respaldo-" . date("Y-m-d") . "--" . date("H-i-s") . ".bak";
/*$fecha = date("Y-m-d");
$tipo = "Respaldo";
$nombre = $tipo . "--" . $fecha;*///C:\Respaldos
//$ruta = realpath("C:/xampp/htdocs/Nueva_carpeta/HNM/Servidor/RespaldosBD/") . DIRECTORY_SEPARATOR . $nombre . ".bak";
//$ruta = "C:/xampp/htdocs/Nueva_carpeta/HNM/Servidor/RespaldosBD/". $nombre . ".bak";
try {
    //$sql = "INSERT INTO base (fecha, nombre, tipo) VALUES (?,?,?)";
    $sql = "BACKUP DATABASE formatosPrueba TO DISK = '" . $ruta ."'";
    $statement = Conexion::getConexion()->prepare($sql);
    $res = $statement->execute();
    //$res = $statement->execute([$fecha, $nombre, $tipo]);
    if ($res) {
        echo "Se ha realizado el respaldo";
    }
    print_r($statement->errorInfo());
} catch (Exception $e) {
    echo $e->getMessage();
}

/*$query = "
BACKUP DATABASE formatosPrueba TO DISK = N'C:\Apache24\htdocs\practicas\upemor\HNM\servidor\RespaldosBD\\$nombre' 
WITH NOFORMAT, NOINIT, NAME = N'dbname Database Backup Test', 
SKIP, NOREWIND, NOUNLOAD";*/
/*
$query = "
BACKUP DATABASE formatosPrueba TO DISK = N'C:\Apache24\htdocs\practicas\upemor\HNM\servidor\RespaldosBD\\$nombre' 
WITH NOFORMAT, NOINIT, NAME = N'dbname Database Backup Test', 
SKIP, NOREWIND, NOUNLOAD";

$conn = sqlsrv_connect('10.10.15.15', array('UID' => 'formatosPrueba', 'PWD' => 'formatosPrueba', 'Database' => 'formatosPrueba', 'CharacterSet' => 'UTF-8'));
*/
/*if (!$conn) {
    print_r(sqlsrv_errors());
    exit;
}*/
/*
if( $conn === false ) {
    die( print_r( sqlsrv_errors(), true));
}

sqlsrv_configure("WarningsReturnAsErrors", 0);
if (($stmt = sqlsrv_query($conn, $query))) {
    do {
        print_r(sqlsrv_errors());
    } while (sqlsrv_next_result($stmt));
    sqlsrv_free_stmt($stmt);
} else {
    print_r(sqlsrv_errors());
    echo "error";
}
sqlsrv_configure("WarningsReturnAsErrors", 1);
sqlsrv_close($conn);
echo "termino";
//RESTORE VERIFYONLY
//FROM DISK = 'E:\Test\AdventureWorks2012_Full.bak'
*/

/*
$serverName = "DESKTOP-D66BJBK\SQLEXPRESS";
$dbname = "formatosPrueba";
$username = "sa";
$password = "26022022";
*/

/*
$connectionOptions = array(
    "Database" => "formatosPrueba",
    "Uid" => "sa",
    "Pwd" => "26022022"
);*/

// Crear una conexión a la base de datos
//$conn = sqlsrv_connect($serverName, $connectionOptions);

/*
try {
$conn = new PDO("sqlsrv:Server=$serverName;Database=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
*/

/*
// Verificar la conexión
if (!$conn) {
    die(print_r(sqlsrv_errors(), true));
}
*/

/*
$backup_file = "D:/Back/respaldo.bak";
// Query para realizar el respaldo
$sql = "BACKUP DATABASE $dbname TO DISK = '$backup_file'";

$conn->exec($sql);
echo $conn;
if($conn)
    echo "Respaldo de la base de datos realizado correctamente.";
} catch(PDOException $e) {
    echo "Error al respaldar la base de datos: " . $e->getMessage();
}
*/

/*
// Ejecutar el query
$stmt = sqlsrv_query($conn, $sql);

// Verificar si el respaldo se realizó correctamente
if ($stmt) {
    echo "Respaldo realizado correctamente.";
} else {
    echo "Ocurrió un error al realizar el respaldo.";
}
*/

// Cerrar la conexión
//sqlsrv_close($conn);
?>


