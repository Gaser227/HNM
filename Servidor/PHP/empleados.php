<?php
include_once "Conexion.php";
 
function obtenerEmpleado()
{
    /*  try { */
    $nomina = $_POST["nomina"];

    $sql = "SELECT * FROM empleado where nomina = ?";
    $statement = Conexion::getConexion()->prepare($sql);
    $statement->execute([$nomina]);
    $datos = "";
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $datos =
            $row["nomina"] . "*"
            . $row["nombre"] . "*"
            . $row["estatus"] . "*"
            /* .$row["turno"]."*"
        .$row["horario"]. "*" */
            /*    .$row["diasLaborales"]. "*" */
            . $row["adscripcion"] . "*"
            . $row["categoria"] . "*"
            . $row["tipoContrato"] . "*"
            . $row["firmaEmpleado"];
        echo $datos;
        /* var_dump($row); */
    }
    return $datos;
}

function obtenerFirma()
{
    try {
        $nomina = $_POST["nomina"];
        $password = $_POST["password"];
        $sql = "SELECT nomina , contrasena, firmaEmpleado FROM empleado WHERE nomina = ? AND contrasena = ?";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$nomina, $password]);
        $datos = "No coincide la contraseña o el usuario.";
        if (($row = $statement->fetch(PDO::FETCH_ASSOC)) == true) {
            $datos = $row['firmaEmpleado'];
            echo $datos;
        } else {
            echo "Error";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function obtenerHorario()
{

    try {
        $id = $_POST["id"];
        $sql = "SELECT nombreHorario,turno,defHorarios FROM horario WHERE id = ?";

        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$id]);
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos .= $row['nombreHorario'] . "*" .
                $row['turno'] . "*" .
                $row['defHorarios'] . "--";
        }
        echo $datos;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function obtenerDatosHorario()
{

    try {
        $nomina = $_POST["nomina"];
        $nombreHorario = $_POST['nombreHorario'];
        $sql = "SELECT turno, diasLaborales, horaEntrada, horaSalida FROM horario AS h INNER JOIN empleado_horario ON h.id = empleado_horario.idHorario
        INNER JOIN empleado ON empleado.id = empleado_horario.idEmpleado WHERE empleado.nomina = ? and h.nombreHorario = ?";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$nomina, $nombreHorario]);
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos .= $row['turno'] . "*" . $row['diasLaborales'] . "*" . substr($row['horaEntrada'], 0, 5) . " a " . substr($row['horaSalida'], 0, 5);
        }
        echo $datos;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function obtenerJefes()
{
    try {
        $sql = "SELECT empleado.nomina, empleado.nombre, adscripcion.nombreCompleto FROM empleado INNER JOIN adscripcion ON empleado.idAdscripcion = adscripcion.clave WHERE 
        adscripcion.nombre = 'Dirección General' or 
        adscripcion.nombre = 'Dirección de División Médica' or
        adscripcion.nombre = 'Dirección de División Administrativa' or
        adscripcion.nombre = 'Coordinación de Área de Administración de Personal' or
        adscripcion.nombre = 'Dirección Operativa'";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([]);
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos .= $row['nombre'] . "*" . $row['nombreCompleto'] . "*" . $row['nomina'] ."/";
        }
        echo $datos;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function obtenerEmpleados()
{
    try {
        $nomina = $_POST["nomina"];
        $estado = $_POST["estado"];
        $sql = "SELECT empleado.*, horario.defHorarios FROM empleado INNER JOIN horario ON empleado.idHorario=horario.id WHERE empleado.estado<>?";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$estado]);
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos .=
                $row['id'] . "*"
                . $row['nomina'] . "*"
                . $row['nombre'] . "*"
                . $row['defHorarios'] . "*"
                . $row['idAdscripcion'] . "-";
        }
        echo $datos;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function guardarEmpleado()
{
    try {
        $id = $_POST["idEmpleado"];
        $cambiaFirma = $_POST["cambiaFirma"];
        $nomina = $_POST["nomina"];
        //return $nomina;
        $imagen = $_POST["firmaImg"];
        $nombreFirma = $imagen;
        if ($cambiaFirma == 1 || $id == "") {
            $imagen = str_replace('data:image/png;base64,', '', $imagen);
            $firma = base64_decode($imagen);
            $nombreFirma = "firma_" . $nomina . ".png";
            $directorio = $_SERVER['DOCUMENT_ROOT'] . '/HNM/Servidor/Firmas/';
        }
        $nombre = $_POST["nombre"];
        $telefono = $_POST["telefono"];
        $correo = $_POST["correo"];
        $sexo = $_POST["sexo"];
        //return $sexo;
        $tipoEmpleado = $_POST["tipoEmpleado"];
        $fechaInicio = $_POST["fechaInicio"];
        $fechaRegistro = $_POST["fechaRegistro"];
        $registro = $_POST["registro"];
        $horario = $_POST["horario"]; 
        //return $horario;
        $adscripcion = $_POST["adscripcion"];
        $categoria = $_POST["categoria"];
        if ($fechaRegistro != "") {
            $fecha = explode("/", $fechaRegistro);
            $fechaRegistro = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
        }
        if ($id == "") 
            $sql = "INSERT INTO empleado (nomina,nombre,telefono,correo,sexo,tipoEmpleado,fechaInicio,fechaRegistro,registro,firmaEmpleado,contrasena,cambiaContrasena,estado,idHorario,idAdscripcion,idCategoria) VALUES (?,?,?,?,?,?,?,?,?,?,'',1,1,?,?,?)";
        else
            $sql = "UPDATE empleado SET nomina=?,nombre=?,telefono=?,correo=?,sexo=?,tipoEmpleado=?,fechaInicio=?,fechaRegistro=?,registro=?,firmaEmpleado=?,idHorario=?,idAdscripcion=?,idCategoria=? WHERE id='$id'";
        $statement = Conexion::getConexion()->prepare($sql);
        $res = $statement->execute([$nomina, $nombre, $telefono, $correo, $sexo, $tipoEmpleado, $fechaInicio, $fechaRegistro, $registro, $nombreFirma, $horario, $adscripcion, $categoria]);
        //return $res;
        if ($res) {
            if ($cambiaFirma == 1 || $id == "") {
                $dir = opendir($directorio);
                file_put_contents($directorio . $nombreFirma, $firma);
                closedir($dir);
            }
            return "Registro guardado correctamente";
        }
        return "Ocurrio un problema intente nuevamente";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function habilitarEmpleado()
{
    try {
        $idEmpleado = $_POST["idEmpleado"];
        $sql = "UPDATE empleado SET estado=1 WHERE id=?";
        $statement = Conexion::getConexion()->prepare($sql);
        $res = $statement->execute([$idEmpleado]);
        if ($res) {
            return "Se habilito el empleado";
        }
        return "No se pudo realizar la operación";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function eliminarEmpleado()
{
    try {
        //$fechaTermino = date("d/m/Y");
        //$fechaTermino = date("y/m/d");
        $idEmpleado = $_POST["idEmpleado"];
        //$sql = "UPDATE empleado SET fechaTermino=?,estado=0 WHERE id=?";
        $sql = "UPDATE empleado SET estado=0 WHERE id=?";
        $statement = Conexion::getConexion()->prepare($sql);
        //$res = $statement->execute([$fechaTermino, $idEmpleado]);
        $res = $statement->execute([$idEmpleado]);
        //print_r($res);
        if ($res) {
            return "Se inhabilito el empleado";
        }
        print_r($statement->errorInfo());
        return "No se pudo realizar la operación";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    //print_r($statement->errorInfo());
}

function obtenerAdscripcion()
{
    try {
        $sql = "SELECT * FROM adscripcion";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute();
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos .=
                $row["clave"] . "*"
                . $row["nombre"] . "#";
        }
        return $datos;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function obtenerCategoria($valor)
{
    try {
        $tipoC = "";
        if ($valor != 0) {
            $sql = "SELECT tipoContrato  FROM categoria WHERE id=?";
            $statement = Conexion::getConexion()->prepare($sql);
            $statement->execute([$valor]);
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $tipoC = $row["tipoContrato"];
            }
        } else {
            $tipoC = $_POST["tipoContrato"];
        }
        $sql = "SELECT id,nombre  FROM categoria WHERE tipoContrato=?";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$tipoC]);
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos .=
                $row["id"] . "*"
                . $row["nombre"] . "#";
        }
        $datos .= "%" . $tipoC;
        return $datos;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
 
function obtenerTurno()
{
    try {
       //s $turno = $_POST['turno'];
        $idHorario = $_POST['idHorario'];
            $sql = "SELECT turno,defHorarios FROM horario WHERE id=?";
            //$sql = "SELECT * FROM horario WHERE id=?";
            $statement = Conexion::getConexion()->prepare($sql);
            $statement->execute([$idHorario]);
            //$statement->execute();
            $datos = "";
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $datos .= $row['turno'] . "*" . $row['defHorarios'] ."/";
            }
            return $datos; 
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function obtenerDatosEmpleado()
{
    try {
        if(isset($_POST["id"])){
            $valor = $_POST["id"];
            $sql = "SELECT *  FROM empleado WHERE id = ?";
        }else{
            $valor = $_POST["nomina"];
            $sql = "SELECT *  FROM empleado WHERE nomina = ?";
        }
        
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$valor]);
        $categoria = 0;
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos =
                $row["id"] . "*"
                . $row["nomina"] . "*"
                . $row["nombre"] . "*"
                . $row["telefono"] . "*"
                . $row["correo"] . "*"
                . $row["sexo"] . "*"
                . $row["tipoEmpleado"] . "*"
                . $row["fechaInicio"] . "*"
                . $row["fechaRegistro"] . "*"
                . $row["registro"] . "*"
                . $row["firmaEmpleado"] . "*"
                . $row["idHorario"] . "*"
                . $row["idAdscripcion"] . "*"
                . $row["idCategoria"] . "*"
                . $row["autoriza"] . "%";
            $categoria = $row["idCategoria"];
        } 
        $datos .= obtenerAdscripcion();
        $datos .= "%";
        $datos .= obtenerCategoria($categoria);
        $datos .= "*";
        $datos .= obtenerContratos($categoria);
        return $datos;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function verificarNomina()
{
    try {
        $nomina = $_POST["nomina"];
        $sql = "SELECT COUNT(nomina) FROM empleado WHERE nomina = ?";
        $statement = Conexion::getConexion()->prepare($sql);
        $res = $statement->execute([$nomina]);
        if ($res) {
            $row = $statement->fetch(PDO::FETCH_NUM);
            return $row[0];
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function obtenerJefe(){
    try { 
        $adscripcion = $_POST["adscripcion"];
        $sql = "SELECT empleado.nomina, empleado.nombre, adscripcion.nombreCompleto FROM empleado INNER JOIN adscripcion ON empleado.idAdscripcion = adscripcion.clave WHERE 
        adscripcion.nombre = ? AND empleado.tipoEmpleado = 3";
        $statement = Conexion::getConexion()->prepare($sql);
        $res = $statement->execute([$adscripcion]);
        $datos = "";
        if($res){
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $datos .= $row['nomina'] . "*" . $row['nombre'] . "*" . $row['nombreCompleto'] . "/"; //
            }
            return $datos;
        }else{
            return NULL;
        }
        //echo "EsteJefe*EstePuesto/"; 
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function obtenerContratos($valor){
    try {
        $tipoC = "";
        if ($valor != 0) {
            $sql = "SELECT tipoContrato  FROM categoria WHERE id=?";
            $statement = Conexion::getConexion()->prepare($sql);
            $statement->execute([$valor]);
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $tipoC = $row["tipoContrato"];
            }
        } else {
            $tipoC = $_POST["tipoContrato"];
        }

        $sql = "SELECT clave,nombre FROM tipoContrato WHERE clave=?";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$tipoC]);
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos .=
                $row["nombre"];
        }
        //$row["clave"] . "*"
        //. 
        $datos .= "%" . $tipoC;
        return $datos;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function obtenerFormatoJefe(){
    try { 
        $idJefe = $_POST["idJefe"];
        $sql = "SELECT empleado.nomina, empleado.nombre, adscripcion.nombreCompleto FROM empleado INNER JOIN adscripcion ON empleado.idAdscripcion = adscripcion.clave WHERE 
        empleado.nomina = ? AND empleado.tipoEmpleado = 3";
        $statement = Conexion::getConexion()->prepare($sql);
        $res = $statement->execute([$idJefe]);
        $datos = "";
        if($res){
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $datos .= $row['nomina'] . "*" . $row['nombre'] . "*" . $row['nombreCompleto'] . "/"; //
            }
            return $datos;
        }else{
            return NULL;
        }
        //echo "EsteJefe*EstePuesto/"; 
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function obtenerAdscripcionV(){
    try {
        $clave = $_POST["clave"];
        //$sql = "SELECT nombre FROM adscripcion WHERE clave = ?";
        $sql = "SELECT * FROM adscripcion WHERE clave = ?";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$clave]);
        $datos = "";
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $datos .=
                    $row["clave"] . "*"
                    . $row["nombre"] . "#";
            }
            echo $datos;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function ObtenerCategoriaV(){
    try {
        $idCategoria = $_POST["idCategoria"];
        //$sql = "SELECT nombre FROM adscripcion WHERE clave = ?";
        $sql = "SELECT * FROM categoria WHERE id = ?";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$idCategoria]);
        $datos = "";
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $datos .=
                     $row["nombre"];
            }
            echo $datos;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function obtenerDatosSuplente()
{
    try {
    
        $valor = $_POST["id"];
        //print_r($valor);
        $sql = "SELECT empleado.nomina, empleado.nombre, adscripcion.nombreCompleto FROM empleado INNER JOIN adscripcion ON empleado.idAdscripcion = adscripcion.clave WHERE 
        empleado.nomina = ?";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$valor]);
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos .= $row['nomina'] . "*" . $row['nombre'] . "*" . $row['nombreCompleto'] . "/"; //
        }
        if($datos){
            echo $datos;
        }else{
            echo "Usuario no encontrado o no disponible";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function obtenerDatosSu()
{
    try {
        if(isset($_POST["id"])){
            $valor = $_POST["id"];
            $sql = "SELECT * FROM empleado WHERE nomina = ?";
        }else{
            return "Nomina invalida";
        }
        
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$valor]);
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos =
                $row["id"] . "*"
                . $row["nomina"] . "*"
                . $row["nombre"] . "*"
                . $row["estado"] . "*"
                . $row["idHorario"] . "*"
                . $row["idAdscripcion"] . "*"
                . $row["idCategoria"];
            //$categoria = $row["idCategoria"];
            //$adscripcion = $row["idAdscripcion"];
        } 
        /*
        $datos .= obtenerAdscripcion();
        $datos .= "%";
        $datos .= obtenerCategoria($categoria);
        $datos .= "*";
        $datos .= obtenerContratos($categoria);*/
        return $datos;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function obtenerAdscripcionSuplente()
{
    try {
        $id =  $_POST["id"];
        //return $id;
        $sql = "SELECT * FROM adscripcion WHERE clave = ?";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$id]);
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos .=
                $row["clave"] . "*"
                . $row["nombre"];
        }
        return $datos;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function obtenerCategoriaSuplente()
{
    try {
        $id =  $_POST["id"];
        //return $id;
        $sql = "SELECT * FROM categoria WHERE id = ?";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([$id]);
        $datos = "";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $datos .=
                $row["nombre"] . "*"
                . $row["tipoContrato"] . "%";
            $tipoContrato = $row["tipoContrato"];
        }
        $datos .= obtenerContrato($tipoContrato);
        return $datos;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function obtenerContrato($id){
    $sql = "SELECT * FROM tipoContrato WHERE clave = ?";
    $statement = Conexion::getConexion()->prepare($sql);
    $statement->execute([$id]);
    $datos = "";
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $datos .= $row["clave"] . "*"
            . $row["nombre"];
    }
    return $datos;
}
function obtenerFormatoSuplente(){
    try { 
        $idSuplente = $_POST["idSuplente"];
        $sql = "SELECT empleado.nomina, empleado.nombre, adscripcion.nombreCompleto FROM empleado INNER JOIN adscripcion ON empleado.idAdscripcion = adscripcion.clave WHERE 
        empleado.nomina = ?";
        $statement = Conexion::getConexion()->prepare($sql);
        $res = $statement->execute([$idSuplente]);
        $datos = "";
        if($res){
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $datos .= $row['nomina'] . "*" . $row['nombre'] . "*" . $row['nombreCompleto'] . "/"; //
            }
            return $datos;
        }else{
            return NULL;
        }
        //echo "EsteJefe*EstePuesto/"; 
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

$funcion = $_POST["numFuncion"];
switch ($funcion) {
    case 1:/* Funcion para obtener todos los empleados */
        obtenerEmpleados();
        break;
    case 2:/* Funcion para obtener los empleados a traves de un filtro */
        break;
    case 3:/* Funcion para agregar o registrar un empleado */
        echo guardarEmpleado();
        break;
    case 4:/* Funcion para editar los datos de un empleado*/
        echo habilitarEmpleado();
        break;
    case 5:/* Funcion para eliminar logicamente a un empleado */
        echo (eliminarEmpleado());
        break;
    case 6: /*Funcion para obtener un solo empleado */
        obtenerEmpleado();
        break;
    case 7:
        obtenerFirma();
        break;
    case 8:
        echo obtenerDatosEmpleado();
        break;
    case 9:/* Funcion para obtener los nombres de los horarios*/
        obtenerHorario();
        break;
    case 10:/* Funcion para obtener los  datos de los horarios*/
        /* obtenerDatosHorario(); */
        break;
    case 11:/* Funcion para obtener el nombre de todos los jefes de una categoria en especifico*/
        obtenerJefes();
        break;
    case 12:
        echo obtenerAdscripcion();
        break;
    case 13:
        echo obtenerCategoria(0);
        break;
    case 14:
        echo verificarNomina();
        break;
    case 15:
        echo obtenerJefe();
        break;
    case 16:
        echo obtenerTurno();
        break;
    case 17:
        echo obtenerFormatoJefe();
        break;
    case 18:
        echo obtenerAdscripcionV();
        break;
    case 19:
        ObtenerCategoriaV();
        break;
    case 20:
        echo obtenerDatosSuplente();
        break;
    case 21:
        echo obtenerDatosSu();
        break;
    case 22:
        echo obtenerAdscripcionSuplente();
        break;
    case 23:
        echo obtenerCategoriaSuplente();
        break;
    case 24:
        echo obtenerFormatoSuplente();
        break;
}
 