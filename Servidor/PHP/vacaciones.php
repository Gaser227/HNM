<?php
    include_once "Conexion.php";
    function comprobarFormatoVacaciones($folio){
        $sql = "SELECT folio, id, tipoSolicitud FROM formatos WHERE folio = ? ";
        $statement = Conexion::getConexion()->prepare($sql);
        $res = $statement->execute([$folio]);
        $folioRecuperado = " ";
        $id = " ";
        $tipoSolicitud = " ";
        while ($row = $statement->fetch(PDO::FETCH_NUM)) {
            $folioRecuperado = $row[0];
            $id = $row[1];
            $tipoSolicitud = $row[2];
        }
        $solicitud = "Vacaciones";
        if($folioRecuperado == $folio && $solicitud == $tipoSolicitud){
            guardarVacaciones($id);
            return false; // funcion que guarda los datos de la seccion solicitud en la tabla entradaSalida
        }else{
            return true;
        }
        /*     print_r($statement->errorInfo()); */
    }
    function guardarFormatoVacaciones()// funcion que guarda la solcitud
    {
        try {
            $folio = $_POST["folio"];
            if(comprobarFormatoVacaciones($folio)){
                $tipoSolicitud = "Vacaciones";
                $estadoSolicitud = "Pendiente"; // $_POST["estadoSolicitud"]; 
                $fechaCreacion = date("Y-m-d"); 
                $totalFirmas = 4; 
                $eliminado = 1;
                $idEmpleado = $_POST["idEmpleado"];
                if (isset($_POST['idJefe'])) { //Se asegura de que haya un jefe y el campo no quede vacio
                    $idJefe = $_POST['idJefe']; 
                } else {
                    $idJefe = 0;
                }
                $sql = "INSERT INTO formatos (folio, tipoSolicitud, estadoSolicitud, fechaCreacion, totalFirmas, idEmpleado, personaQuienAutoriza, eliminado) values(?,?,?,?,?,?,?,?)";
                $statement = Conexion::getConexion()->prepare($sql);
                $res = $statement->execute([$folio, $tipoSolicitud, $estadoSolicitud, $fechaCreacion, $totalFirmas, $idEmpleado, $idJefe, $eliminado]);
                if($res){
                    guardarVacaciones(null); // funcion que guarda los datos de la seccion solicitud en la tabla entradaSalida
                }else{
                    echo "Error: no se pudo guardar1";
                }
            }
                //print_r($statement->errorInfo()); 
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function guardarVacaciones($id)//funcion que guarda los datos de la seccion solicitud en la tabla 
    {
        $diasDisfrutar = $_POST['diasDisfrutar'];
        $nominaSuplente = $_POST['nominaSuplente'];
        $nombreSuplente = $_POST['nombreSuplente'];
        $fechaInicio = $_POST['fechaInicio'];
        $fechaFin = $_POST['fechaFin'];
        $reinicioLabores = $_POST['reinicioLabores'];
        $diasPendientes = $_POST['diasPendientes'];
        //$observaciones = $_POST['observaciones'];
        if (isset($_POST['observaciones']))
            $observaciones = $_POST['observaciones'];
        else
            $observaciones = "Ninguna";
        if($id != null){
            $idFormato = $id;
            $sql = "UPDATE vacaciones SET diasDisfrutar = ?, fechaInicioVacaciones = ?, fechaReinicioLabores = ?, diasPendientes = ?, nombreSuplente = ?,  
                                nominaSuplente = ?, observaciones = ?, fechaFinVacaciones=? WHERE idFormato=$idFormato";
        }else{
            $idFormato = obtenerUltimoID(); // obtiene el ultimo id registrado en la tabla formato para usar este id como llave foranea
            $sql = "INSERT INTO vacaciones (diasDisfrutar, fechaInicioVacaciones, fechaReinicioLabores, diasPendientes,
                nombreSuplente, nominaSuplente, observaciones, idFormato, fechaFinVacaciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        }
        $statement = Conexion::getConexion()->prepare($sql);
        $res = $statement->execute([$diasDisfrutar,$fechaInicio, $reinicioLabores, $diasPendientes, $nombreSuplente, $nominaSuplente, $observaciones,
                                    $idFormato, $fechaFin]);
        if($res)
            echo "Guardado con Exito";
        else
            echo "Error: no se pudo guardar2";
        print_r($statement->errorInfo());
    }
 
    function consultarFormatoV(){
         try {
            $folio = $_POST['folio'];
            $sql = 'SELECT formatos.id, formatos.folio, formatos.tipoSolicitud, formatos.estadoSolicitud, formatos.fechaCreacion, formatos.totalFirmas, formatos.idEmpleado, formatos.personaQuienAutoriza,
                vacaciones.diasDisfrutar, vacaciones.fechaInicioVacaciones,vacaciones.fechaReinicioLabores, vacaciones.diasPendientes, vacaciones.nombreSuplente, vacaciones.nominaSuplente,
                vacaciones.observaciones, vacaciones.fechaFinVacaciones,empleado.nomina,empleado.nombre,horario.id, horario.turno, adscripcion.nombre, categoria.nombre,categoria.tipoContrato
             FROM formatos 
            INNER JOIN vacaciones ON formatos.id = vacaciones.idFormato 
            INNER JOIN empleado ON empleado.id = formatos.idEmpleado 
            INNER JOIN horario ON empleado.idHorario = horario.id
            INNER  JOIN  adscripcion ON empleado.idAdscripcion = adscripcion.clave 
            INNER JOIN categoria ON empleado.idCategoria = categoria.id 
            WHERE folio = ?';

            $statement = Conexion::getConexion()->prepare($sql);
            $statement->execute([$folio]);
            $datos = "";
            /* if($row = $statement->fetch(PDO::FETCH_ASSOC)){ */
                 while ($row = $statement->fetch(PDO::FETCH_NUM)) {
                    $datos .=
                        $row[0] . "*"
                        . $row[1] . "*"
                        . $row[2] . "*"
                        . $row[3] . "*"
                        . $row[4] . "*"
                        . $row[5] . "*"
                        . $row[6] . "*"
                        . $row[7] . "*"
                        . $row[8] . "*"
                        . $row[9] . "*"
                        . $row[10] . "*"
                        . $row[11] . "*"
                        . $row[12] . "*"
                        . $row[13] . "*"
                        . $row[14] . "*"
                        . $row[15] . "*"
                        . $row[16] . "*"
                        . $row[17] . "*"
                        . $row[18] . "*"
                        . $row[19] . "*"
                        . $row[20] . "*"
                        . $row[21] . "*"
                        . $row[22] . "*";
                 }
                echo $datos;
                //print_r($statement->errorInfo()); 
          /*   }else{
                echo $datos = "Error";
            }
            */
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    function eliminarFormato()// funcion que elimina una solicitud si aun no tiene ninguna firma a excepcion la del empleado
    {
        try {
            
            $id = $_POST["id"];
            $sql = "UPDATE formatos SET eliminado = 0 WHERE id = ?";
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
    function comprobar($id, $folio)// funcion que comprueba si ya se firmo la solicitud. si esta firmada no se puede eliminar ni modificar
    {
        try{
            $sql = "SELECT totalFirmas FROM formato WHERE id = ? AND folio = ?";
            $statement = Conexion::getConexion()->prepare($sql);
            $statement->execute([$id, $folio]);
            if(($row = $statement->fetch(PDO::FETCH_ASSOC))==true){
                $totalFirmas = $row['totalFirmas'];
                if($totalFirmas == 0){
                    return false;
                }else{
                    return true;
                }
            }
        }catch (Exception $e) {
            $e->getMessage();
        }
    }
    function obtenerUltimoID() // funcion que obtiene el ultimo id registrado de la tabla formato
    {
        try{
            $sql = "SELECT TOP(1) id FROM formatos ORDER BY id DESC";
            $statement = Conexion::getConexion()->prepare($sql);
            $statement->execute();
            if(($row = $statement->fetch(PDO::FETCH_ASSOC))==true)
                return $id = $row['id'];
        }catch (Exception $e) {
            $e->getMessage();
        }
        
    }
   
    function obtenerDiasFestivos(){
        $sql = "SELECT fecha FROM festividad";
        $statement = Conexion::getConexion()->prepare($sql);
        $statement->execute([]);
        $datos = "";
        /* if($row = $statement->fetch(PDO::FETCH_ASSOC)){ */
             while ($row = $statement->fetch(PDO::FETCH_NUM)) {
                $datos .=$row[0] . "*";
             }
        
            echo $datos;
            if ($datos===""){
                print_r($statement->errorInfo()); 
                $datos ="error";
            }
    }
    $funcion = $_POST["numFuncion"];
    switch ($funcion) {
        case 1:
            guardarFormatoVacaciones(); // funcion para guardar los formatos.
            break;
        case 2:
            //modificarFormato(); // funcion para modificar un formato.
            break;
        case 3:
            consultarFormatoV(); // funcion para consultar la informacion de un formato.
            break;
        case 4:
            eliminarFormato(); // funcion para eliminar un formato.
            break;
        case 5:
            obtenerFolio(); // funcion para consultar el ultimo folio registrado.
            break;
        case 6:
            obtenerDiasFestivos(); //funcion que obtiene los dias festivos.
    }