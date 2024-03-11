<?php
include_once("Conexion.php"); // Se incluye la conexion de la base de datos

function guardarContrato(){
    try {
        //Hacer un select para verificar la clave, si existe insert, sino update
        //return $clave;
        //tipoOperacion

        $tipoOperacion = $_POST['tipoOperacion'];

        $nombre = $_POST["nombreContrato"];
        $clave = $_POST["claveContrato"];

        $sq = "SELECT clave FROM tipoContrato WHERE clave=?";
        $statementt = Conexion::getConexion()->prepare($sq);
        $ress = $statementt->execute([$clave]);
        $ress = $statementt->fetch();
        
        if($tipoOperacion == 2){
            $sql = "UPDATE tipoContrato SET clave=?,nombre=? WHERE clave=?";
            $op = 1;
        }else{
            if($clave == $ress['clave']){
                return "Esta clave ya esta ocupada, escoger otro"; 
            }
            $sql = "INSERT INTO tipoContrato(clave,nombre) VALUES (?,?)";
            $op = 0;
        }
        
        $statement = Conexion::getConexion()->prepare($sql);
        if ($op == 1){
            $res = $statement->execute([$clave, $nombre,$clave]);
        }else{
            $res = $statement->execute([$clave, $nombre]);
        }
        
        if ($res) {
            return "Contrato guardado correctamente";
        }
        return "Ocurrio un problema intente nuevamente";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function obtenerContrato(){
    try {
        $sql = "SELECT * FROM tipoContrato";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute();
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos .= 
                $row["clave"] . "*" 
                . $row["nombre"] . "#";
        }
        echo $datos;
        //return $datos;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function eliminarContrato(){
    try {
        $clave = $_POST["claveContrato"];
        $sql = "DELETE FROM tipoContrato WHERE clave=? ";
        $statement = Conexion::getConexion()->prepare($sql);
        $res = $statement->execute([$clave]);
        if ($res) {
            return "Registro eliminado correctamente";
        }
        return "Ocurrio un problema intente nuevamente";
    } catch (Exception $e) {
        $e->getMessage();
    }
}

function modificarContrato(){
    try {
        $clave = $_POST["claveContrato"];
        $sql = "SELECT * FROM tipoContrato WHERE clave=?";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$clave]);
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos .= $row['clave'] . "*" . $row['nombre'];
        }
        echo $datos;
    } catch (Exception $e) {
        $e->getMessage();
    }
}

/*--------------------------------------------------------------------*/

function guardarCategoria(){
    try {
        if (isset($_POST['idCat'])) {
            $id = $_POST['idCat'];
          } else {
            //echo "No hay id";
            $id = '';
          }

        $nombre = $_POST['nombreCategoria'];
        $tipoContrato = $_POST['tipoContrato'];

        $sq = "SELECT nombre FROM categoria WHERE nombre=?";
        $statement = Conexion::getConexion()->prepare($sq);
        $res = $statement->execute([$nombre]);
        $res = $statement->fetch();
    

        if ($id == ""){
            if($nombre == $res['nombre']){
                return "Este nombre ya esta ocupado, escoger otro"; //Los dias festivos no pueden compratir la misma fecha
            } else{
                $sql = "INSERT INTO categoria (nombre,tipoContrato) VALUES (?,?)";
            }
        }else{
            $sql = "UPDATE categoria SET nombre=?,tipoContrato=? WHERE id=$id";
        }
        $statement = Conexion::getConexion()->prepare($sql);
        $res = $statement->execute([$nombre, $tipoContrato]);
        //return $res;
        if ($res) {
            return "Categoria guardada correctamente";
        }
        return "Ocurrio un problema intente nuevamente";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function obtenerCategoria(){
    try {
        $sql = "SELECT * FROM categoria";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute();
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos .= $row['id'] . "*" . $row['nombre'] . "*" . $row['tipoContrato'] . "#";
        }
        echo $datos;
        //return $datos;
    } catch (Exception $e) {
        $e->getMessage();
    }
}

function eliminarCategoria(){
    try {
        $id = $_POST["id"];
        $sql = "DELETE FROM categoria WHERE id=?";
        $statement = Conexion::getConexion()->prepare($sql);
        $res = $statement->execute([$id]);
        if ($res) {
            return "Registro eliminado correctamente";
        }
        return "Ocurrio un problema intente nuevamente";
    } catch (Exception $e) {
        $e->getMessage();
    }
}

function modificarCategoria(){
    try {
        $id = $_POST["id"];
        $sql = "SELECT * FROM categoria WHERE id=?";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$id]);
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos .= $row['id'] . "*" . $row['nombre'] . "*" . $row['tipoContrato'];
        }
        echo $datos;
    } catch (Exception $e) {
        $e->getMessage();
    }
}


$funcion = $_POST["numFuncion"];
switch ($funcion) {
    case 1:/*  */
        echo guardarContrato();
        break;
    case 2:/* */
        echo obtenerContrato();
        break;
    case 3:/*  */
        echo eliminarContrato();
        break;
    case 4: /* */
        modificarContrato();
        break;
    case 5:/*  */
        echo guardarCategoria();
        break;
    case 6:/* */
        obtenerCategoria();
        break;
    case 7:/*  */
        echo eliminarCategoria();
        break;
    case 8: /* */
        modificarCategoria();
        break;
}
