<?php
include_once("Conexion.php"); // Se incluye la conexion de la base de datos

//Función para obtener la informacion de los horarios
function obtenerFestivo(){
    try {
        $sql = "SELECT TOP 15 * FROM festividad";//SE visualizan las primeras 15 festividades |Sujeto a cambios|
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute();
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos .= $row['id'] . "*" . $row['nombreFestividad'] . "*" . $row['fecha'] . "--";
        }
        echo $datos;
    } catch (Exception $e) {
        $e->getMessage();
    }
}

function guardarFestivo(){
    try {
        $id = $_POST["idFestio"];
        $fecha = $_POST["FechFest"];
        $nombreFestividad = $_POST["Festividad"];

        $sq = "SELECT fecha FROM festividad WHERE fecha=?";
        $statement = Conexion::getConexion()->prepare($sq);
        $res = $statement->execute([$fecha]);
        $res = $statement->fetch(); //Fecha del dia festivo si es que existe una
        if ($id == ""){ //Si la id se encuantra vacia, se trata de una nueva fecha
            if($fecha == $res['fecha']){
                return "Este dia ya ocupa una festividad, escoger otro"; //Los dias festivos no pueden compratir la misma fecha
            }
            $sql = "INSERT INTO festividad (nombreFestividad,fecha) VALUES (?,?)";
        }else{ //Si la id se encuentra llena, se trata de una modificaion a una fecha
            $sql = "UPDATE festividad SET nombreFestividad=?,fecha=? WHERE id=$id";
        }
        $statement = Conexion::getConexion()->prepare($sql);
        $res = $statement->execute([$nombreFestividad, $fecha]);
        if ($res) {
            return "Festividad guardada correctamente";
        }
        return "Ocurrio un problema intente nuevamente";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function eliminarFestivo(){
    try {
        date_default_timezone_set("America/Mexico_City");
        $fechaActual = date("Y-m-d H:i:s"); //Se establece la fecha actual
        $id = $_POST["id"];
        $sq = "SELECT fecha FROM festividad WHERE id=?";
        $statement = Conexion::getConexion()->prepare($sq);
        $res = $statement->execute([$id]);
        $res = $statement->fetch();
        if($res['fecha'] > $fechaActual){
            $sql = "DELETE FROM festividad WHERE id=?";
            $statement = Conexion::getConexion()->prepare($sql);
            $res = $statement->execute([$id]);
            if ($res) {
                return "Festividad eliminada correctamente";
            }
            return "Ocurrio un problema intente nuevamente";
        }else{
            return "Festividad pasada, no es posible eliminarla";
        }
    } catch (Exception $e) {
        $e->getMessage();
    }
}

function modificarFestivo()
{
    try {
        $id = $_POST["id"];
        $sql = "SELECT * FROM festividad WHERE id=?";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$id]);
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos .= $row['id'] . "*" . $row['nombreFestividad'] . "*" . $row['fecha'];
        }
        echo $datos;
    } catch (Exception $e) {
        $e->getMessage();
    }
}

function compararFestividades(){
// Obtener las fechas de inicio y fin de las vacaciones ingresadas por el usuario
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
     // Verificar si las fechas están definidas
     if (!empty($fechaInicio) && !empty($fechaFin)) {
        // Obtener las festividades de la base de datos
        $sql = "SELECT fecha FROM festividad";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute();

        // Recorrer las festividades y comparar con las fechas de vacaciones
        $esFestivo = false;
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $fechaFestivo = $row['fecha'];
            // Convertir las fechas a objetos DateTime para comparar
            $fechaInicioSuplencia = new DateTime($fechaInicio);
            $fechaFinSuplencia = new DateTime($fechaFin);
            $fechaFestivo = new DateTime($fechaFestivo);

            // Realizar la comparación
            if ($fechaFestivo >= $fechaInicioSuplencia && $fechaFestivo <= $fechaFinSuplencia) {
                // La fecha festiva está dentro del rango de vacaciones
                $esFestivo = true;
                break;
            }
        }
        // Verificar si alguna fecha festiva coincide con las vacaciones
        if ($esFestivo) {
            echo "Existen festividades durante tus vacaciones.";
        } else {
            echo "No hay festividades durante tus vacaciones.";
        }
    } else {
        echo "Por favor, ingresa la fecha de inicio y la fecha fin de tus vacaciones.";
    }
}

function compararFestividadesVacaciones(){
    // Obtener las fechas de inicio y fin de las vacaciones ingresadas por el usuario
        $fechaInicio = $_POST['fechaInicio'];
        $fechaFin = $_POST['fechaFin'];
        $reinicioLbores = $_POST['reinicioLabores'];
         // Verificar si las fechas están definidas
         if (!empty($fechaInicio) && !empty($fechaFin) && !empty($reinicioLbores)) {
            // Obtener las festividades de la base de datos
            $sql = "SELECT fecha FROM festividad";
            $statement = Conexion::getConexion()->prepare($sql);
            $statement->execute();
    
            // Recorrer las festividades y comparar con las fechas de vacaciones
            $esFestivo = false;
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $fechaFestivo = $row['fecha'];
    
                // Convertir las fechas a objetos DateTime para comparar
                $fechaInicioSuplencia = new DateTime($fechaInicio);
                $fechaFinSuplencia = new DateTime($fechaFin);
                //$fechaReinicioLabores = new DateTime($reinicioLbores);
                $fechaFestivo = new DateTime($fechaFestivo);
    
                // Realizar la comparación
                if ($fechaFestivo >= $fechaInicioSuplencia && $fechaFestivo <= $fechaFinSuplencia) {
                    // La fecha festiva está dentro del rango de vacaciones
                    $esFestivo = true;
                    break;
                }
            }
            // Verificar si alguna fecha festiva coincide con las vacaciones
            if ($esFestivo) {
                echo "Existen festividades durante tus vacaciones.";
            } else {
                echo "No hay festividades durante tus vacaciones.";
            }
        } else {
            echo "Por favor, ingresa la fecha de inicio y la fecha fin de tus vacaciones.";
        }
    }
function compararFestividadesIntercambio(){
    // Obtener las fechas de inicio y fin de las vacaciones ingresadas por el usuario
    $fechaGuardia = $_POST['cambioGuardiaSuplente'];
        // Verificar si las fechas están definidas
    if (!empty($fechaGuardia)) {
                // Obtener las festividades de la base de datos
        $sql = "SELECT fecha FROM festividad";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute();
                // Recorrer las festividades y comparar con las fechas de vacaciones
        $esFestivo = false;
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $fechaFestivo = $row['fecha'];
                    // Convertir las fechas a objetos DateTime para comparar
            $fechaGuardiaSuplente = new DateTime($fechaGuardia);
            $fechaFestivo = new DateTime($fechaFestivo);
        
                // Realizar la comparación
            if ($fechaFestivo >= $fechaGuardiaSuplente) {
                        // La fecha festiva está dentro del rango de vacaciones
                $esFestivo = true;
                break;
            }
        }
                // Verificar si alguna fecha festiva coincide con las vacaciones
        if ($esFestivo) {
            echo "Existen festividades durante tu intercambio.";
        } else {
                echo "No hay festividades durante tu intercambio.";
        }
    } else {
        echo "Por favor, ingresa la fecha de tu intercambio.";
    }
}

$funcion = $_POST["numFuncion"];
switch ($funcion) {
    case 1:/* Funcion para obtener todos las festividades */
        obtenerFestivo();
        break;
    case 2:/* Funcion para agregar o registrar una festividad*/
        echo guardarFestivo();
        break;
    case 3:/* Funcion para eliminar una festividad */
        echo eliminarFestivo();
        break;
    case 4: /*Funcion para modificar una festividad */
        modificarFestivo();
        break;
    case 5:
        compararFestividades();
        break;
    case 6:
        compararFestividadesVacaciones();
        break;
    case 7:
        compararFestividadesIntercambio();
        break;
}