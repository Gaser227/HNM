<?php
include_once("Conexion.php");
function listarRespaldos()
{
    $archivos = "";
    //$directorio = $_SERVER['DOCUMENT_ROOT'] . '/Nueva_carpeta/HNM/Servidor/RespaldosBD/';
    $directorio = 'C:/xampp/htdocs/Nueva_carpeta/HNM/Servidor/RespaldosBD/';
    if (is_dir($directorio)) { //Comprovamos que sea un directorio Valido
        if ($dir = opendir($directorio)) { //Abrimos el directorio
            while (($archivo = readdir($dir)) !== false) { //Comenzamos a leer archivo por archivo
                if ($archivo != '.' && $archivo != '..') { //Omitimos los archivos del sistema . y ..
                    $archivos .= $archivo . "*"; //simplemente imprimimos el nombre del archivo actual
                }
            }
            closedir($dir); //Se cierra el archivo
            return $archivos;
        }
    }
}

function restaurarBase()
{
    try {
        date_default_timezone_set('America/Mexico_City');
        $fecha = date("Y-m-d");
        $tipo = "Restauracion";
        $nombres = $tipo."-".$fecha;

        $nombre = $_POST["bases"];
        $rutaArchivo = 'C:/xampp/htdocs/Nueva_carpeta/HNM/Servidor/RespaldosBD/' . $nombre;
        $rutaArchivo = realpath($rutaArchivo); // Obtener la ruta real y escapar caracteres especiales

        $serverName = "DESKTOP-D66BJBK"; 
        $dbname = "formatosPrueba";
        $username = "sa";
        $password = "26022022";

        $connectionOptions = array(
            "Database" => $dbname,
            "UID" => $username,
            "PWD" => $password,
            "ReturnDatesAsStrings" => true, // Para manejar fechas como cadenas
        );
        /*
        $conn = new PDO("sqlsrv:Server=$serverName;Database=$dbname", $username, $password);
        $backupPath =$rutaArchivo;

        $query = "USE [master]; RESTORE DATABASE $dbname FROM DISK = '$backupPath' WITH REPLACE;";
        $conn->exec($query);
        echo "Restauración completada correctamente.";
        } catch (PDOException $e) {
            echo "Error al restaurar la base de datos: " . $e->getMessage();
        }*/
    /*
            $sql = "INSERT INTO base (fecha, nombre, nombreArchivo, tipo) VALUES (?,?,?,?)";
            $statement = Conexion::getConexion()->prepare($sql);
            //$res = $statement->execute();
            $res = $statement->execute([$fecha, $nombres, $nombre, $tipo]);
            if ($res) {
                echo "Se ha realizado el respaldo";
            }
            print_r($statement->errorInfo());
        } catch (Exception $e) {
            echo $e->getMessage();
        }*/


        // Establecer la conexión con SQL Server
    /*    $conn = sqlsrv_connect($serverName, $connectionOptions);

        if ($conn === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Consulta parametrizada para realizar la restauración
        $query = "RESTORE DATABASE formatosPrueba FROM DISK = ? WITH REPLACE;";
        $params = array($rutaArchivo);
        $stmt = sqlsrv_prepare($conn, $query, $params);

        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Ejecutar la consulta
        if (sqlsrv_execute($stmt)) {
            echo "Restauración de la base de datos completada con éxito.";
        } else {
            die(print_r(sqlsrv_errors(), true));
        }

        // Cerrar la conexión
        sqlsrv_close($conn);
        }catch (Exception $e) {
            echo "Error al restaurar la base de datos: " . $e->getMessage();
        }*/


            try {
                $conn = sqlsrv_connect($serverName, $connectionOptions);
                $query = "ALTER DATABASE formatosPrueba SET SINGLE_USER WITH ROLLBACK IMMEDIATE";
                $stmt = sqlsrv_query($conn, $query);
                //print_r($conn->errorInfo());
                sqlsrv_close($conn);
            } catch (Exception $e) {
                echo "Error al cerrar conexiones: " . $e->getMessage();
            }

    
        // Intenta restaurar la base de datos
        
        try {
            $conn = sqlsrv_connect($serverName, $connectionOptions);
            $restoreQuery = "USE master; RESTORE DATABASE formatosPrueba FROM DISK = ? WITH REPLACE;";
            $params = array($rutaArchivo);
            
            // Ejecutar la consulta de restauración
            $restoreStmt = sqlsrv_query($conn, $restoreQuery, $params);
        
            // Verificar si la consulta fue exitosa
            if ($restoreStmt === false) {
                echo "Error en la consulta de restauración: " . print_r(sqlsrv_errors(), true);
            } else {
                // Obtener el resultado de la restauración
                $result = sqlsrv_fetch_array($restoreStmt, SQLSRV_FETCH_ASSOC);
                
                // Verificar si la restauración fue exitosa
                if ($result['Command'] == 'RESTORE DATABASE') {
                    echo "Restauración exitosa.";
                } else {
                    echo "La copia de seguridad no se pudo restaurar.";
                }
            }
        
            // Cerrar la conexión
            sqlsrv_close($conn);
        } catch (Exception $e) {
            echo "Error al restaurar la base de datos: " . $e->getMessage();
        }
    }catch (Exception $e) {
        echo "Error" . $e->getMessage();
    }
        /*
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        if (!$conn) {
            print_r(sqlsrv_errors());
            exit;
        }
        $query = "RESTORE DATABASE formatosPrueba FROM DISK = ?";
        $params = array($rutaArchivo);
        $stmt = sqlsrv_prepare($conn, $query, $params);

        if (!$stmt) {
            print_r(sqlsrv_errors());
            exit;
        }

        if (sqlsrv_execute($stmt)) {
            // Restauración exitosa
            echo "Restauración exitosa.";
        } else {
            print_r(sqlsrv_errors());
            echo "Error en la restauración.";
        }

        sqlsrv_configure("WarningsReturnAsErrors", 1);
        sqlsrv_close(Conexion::getConexion()); // Cierra la conexión antes de finalizar la función
        echo "termino";
        }catch (Exception $e) {
            echo "Error al restaurar la base de datos: " . $e->getMessage();
        }*/
}


$funcion = $_POST["numFuncion"];
switch ($funcion) {
    case 1:
        echo listarRespaldos();
        break;
    case 2:
        echo restaurarBase();
        break;
}
