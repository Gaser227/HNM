<?php
/* 
    Se realiza la clase conexion que nos permite realizar el enlace con la base de datos
    La cual requiere de parametros especificos para poder conectarse con el servidor de
    base de datos
 */
class Conexion
{
    static private $user = "sa"; //Se especifica el nombre del usuario del servidor
    static private $host = "DESKTOP-D66BJBK"; //Se especifica el servidor   
    static private $password = "26022022"; //Se especifica la contraseña del usuario del servidor
    static private $dbname = "formatosPrueba"; //Se especifica el nombre de la base de datos

    static private $server = "sqlsrv"; //se especifica que tipo de servidor es, en este caso SQL Server
    static private $dsn = "";
    static private $conexion = null; //Se usa para establecer la conexion

    public static function getConexion() //Metódo implementado para obtener la conexion
    {
        try {
            if (self::$conexion == null) { //Se valida que no exista una conexion ya establecida
                self::$dsn = self::$server . ":server=" . self::$host . ";database=" . self::$dbname;
                self::$conexion = new PDO(self::$dsn, self::$user, self::$password);
            }
            return self::$conexion; //Se retorna la conexion
        } catch (PDOException $e) {
            echo $e->getMessage(); //En caso de algun fallo muestra el error
        }
    }
    /*public static function getConexion(){
        try {
            if (self::$conexion == null) {
                self::$dsn = self::$server . ":server=" . self::$host . ";database=" . self::$dbname;
                self::$conexion = new PDO(self::$dsn, self::$user, self::$password);
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Establecer el atributo de manejo de errores
            }
            return self::$conexion;
        } catch (PDOException $e) {
            echo $e->getMessage();
            // Si ocurre un error en la conexión, puedes lanzar una excepción o manejarlo según tus necesidades.
            // Por ejemplo, puedes lanzar una excepción personalizada:
            // throw new MiExcepcion("Error al conectar a la base de datos");
        }
    }*/
}