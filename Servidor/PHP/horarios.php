<?php
include_once("Conexion.php"); // Se incluye la conexion de la base de datos

//Función para obtener la informacion de los horarios
function obtenerHorarios()
{
    try {
        $sql = "SELECT * FROM horario ORDER BY defHorarios ASC";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute();
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos .= $row['id'] . "*" . $row['defHorarios'] . "*" . $row['turno'] . "--";
        }
        echo $datos;
    } catch (Exception $e) {
        $e->getMessage();
    }
}

function guardarHorario()
{
    try {        
        $id = $_POST["idHorario"];
        $turno = $_POST["selecTurno"];
        $horarios = $_POST["horarios"];
        $horariosAux = "";
        $horarios = explode("/", $horarios);
        $tamano = sizeof($horarios);
        unset($horarios[$tamano - 1]);
        $horariosAux = $horarios[0];
        for ($i = 1; $i < sizeof($horarios); $i++) {
            $horariosAux .= "/" . $horarios[$i];
        }
        //$check = ("SELECT * FROM horario WHERE defHorarios = ?");
        //$statement = Conexion::getConexion()->prepare($check);
        //$res = $statement->execute([$horariosAux]);
        //return "Resultado"; 
        //if($res>0){
            //echo "Horario ya existe";
        //} else {
            if ($id == "")
                $sql = "INSERT INTO horario(turno,defHorarios) VALUES (?,?)";
            else
                $sql = "UPDATE horario SET turno=?,defHorarios=? WHERE id=$id";
        //}
        $statement = Conexion::getConexion()->prepare($sql);
        $res = $statement->execute([$turno, $horariosAux]);
        if ($res) {
            //return $turno;
            return "Registro guardado correctamente";
        }
        return "Ocurrio un problema intente nuevamente";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function eliminarHorario()
{
    try {
        $id = $_POST["id"];
        $sql = "DELETE FROM horario WHERE id=?";
        $statement = Conexion::getConexion()->prepare($sql);
        $res = $statement->execute([$id]);
        return $res;
        if ($res) {
            return "Registro eliminado correctamente";
        }
        return "Ocurrio un problema intente nuevamente";
    } catch (Exception $e) {
        $e->getMessage();
    }
}

function obtenerHorario()
{
    try {
        $id = $_POST["id"];
        $sql = "SELECT * FROM horario WHERE id=?";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$id]);
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos .= $row['id'] . "*" . $row['turno'] . "*" . $row['defHorarios'];
        }
        echo $datos;
    } catch (Exception $e) {
        $e->getMessage();
    }
}

function obtenerHorarioEmpleado($valor){
    try {
        $turno = "";
        if ($valor != 0) {
            $sql = "SELECT defHorarios FROM horario WHERE turno=?";
            $statement = Conexion::getConexion()->prepare($sql);
            $statement->execute([$valor]);
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $turno = $row["turno"];
            }
        } else {
            $turno = $_POST["turno"];
        }
        $sql = "SELECT id, defHorarios  FROM horario WHERE turno=?"; // DESC
        //Se realiza el SELECT de forma descendente 
        
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$turno]);
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos .=
            $row["id"] . "*"
                . $row["defHorarios"] . "#";
        }
        $datos .= "%" . $turno;
        return $datos;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function obtenerHorarioV(){
    try {
        $idHorario = $_POST["idHorario"];
        //$sql = "SELECT nombre FROM adscripcion WHERE clave = ?";
        $sql = "SELECT * FROM horario WHERE id = ?";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$idHorario]);
        $datos = "";
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $datos .=
                     $row["defHorarios"];
            }
            echo $datos;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function obtenerTurnoPorId(){
    try {
    $id = $_POST["id"];
    //print_r($id);
    $sql = "SELECT turno FROM horario WHERE id = ?";
    $statement = Conexion::getConexion()->prepare($sql);
    $statement->execute([$id]);
    $datos = "";
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $datos .=
            $row["turno"];
    }
    echo $datos;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

$funcion = $_POST["numFuncion"];
switch ($funcion) {
    case 1:/* Funcion para obtener todos los horarios */
        obtenerHorarios();
        break;
    case 2:/* Funcion para agregar o registrar un horario*/
        echo guardarHorario();
        break;
    case 3:/* Funcion para eliminar un horario */
        echo eliminarHorario();
        break;
    case 4: /*Funcion para obtener un solo horario */
        obtenerHorario();
        break;
    case 5: /*Funcion para obtener el horario del empleado */
        echo obtenerHorarioEmpleado(0);
        break;
    case 6:
        obtenerHorarioV();
        break;
    case 7:
        obtenerTurnoPorId();
        break;
}
