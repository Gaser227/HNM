<?php
    include_once "Conexion.php";

    function comprobarFormato($folio){
        $sql = "SELECT folio, id FROM formatos WHERE folio = ? ";
        $statement = Conexion::getConexion()->prepare($sql);
        $res = $statement->execute([$folio]);
        $folioRecuperado = " ";
        $id = " ";
        while ($row = $statement->fetch(PDO::FETCH_NUM)) {
            $folioRecuperado = $row[0];
            $id = $row[1];
        }
        return $id;

        if($folioRecuperado == $folio){
            guardarEntradaSalida($id);
            print_r("folio R: ".$folioRecuperado);
            return false; // funcion que guarda los datos de la seccion solicitud en la tabla entradaSalida
        }else{
            return true;
        }
        /*     print_r($statement->errorInfo()); */
    }
    
    function guardarFormato()// funcion que guarda la solcitud
    {
        try {
            $folio = $_POST["folio"];
            if(comprobarFormato($folio)){
                $tipoSolicitud = "Licencia";
                $estadoSolicitud = "Pendiente";
                $fechaCreacion = date("Y-m-d"); 
                $totalFirmas = 1; 
                $eliminado = 1;
                $idEmpleado = $_POST["idEmpleado"];
                //$idJefe = $_POST["idJefe"]; //Nomina del jefe
                //$idJefe = 120;
                //$cargoEmpleado = $_POST["cargoEmpleado"]; 
                if (isset($_POST['idJefe'])) {
                    $idJefe = $_POST['idJefe']; 
                    //print_r("Si");
                    //print_r($idJefe);
                } else {
                    $idJefe = 0;
                    //print_r("No");
                }
                //return $idJefe;
                //$idJefe = obtenerIdJefe($idEmpleado,$firmaJefe,$cargoJefe);
                //return $idJefe;
                //$sql = "INSERT INTO formatos (folio, tipoSolicitud, estadoSolicitud, fechaCreacion, totalFirmas, idEmpleado, personaQuienAutoriza, eliminado) values (?,?,?,?,?,?,?,?)";
                $sql = "INSERT INTO formatos (folio, tipoSolicitud, estadoSolicitud, fechaCreacion, totalFirmas, idEmpleado, personaQuienAutoriza, eliminado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                //return $sql;
                $statement = Conexion::getConexion()->prepare($sql);
                $res = $statement->execute([$folio, $tipoSolicitud, $estadoSolicitud, $fechaCreacion, $totalFirmas, $idEmpleado, $idJefe, $eliminado]);
                //return $res;
                //print_r($res);
                if($res){
                    guardarLicencia(null); // funcion que guarda los datos de la seccion solicitud en la tabla entradaSalida
                }else{
                    echo "Error: no se pudo guardar";
                }
            }
                //print_r($statement->errorInfo()); 
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function guardarLicencia($id)//funcion que guarda los datos de la seccion solicitud en la tabla
    {
        $goceSueldo = $_POST['sueldo'];
        $observaciones = null;
        $dictamen = null;
        $fechaPeriodoInicio = $_POST['fechaInicioL'];
        $fechaPeriodoFin = $_POST['fechaFinalL'];
        $nominaSuplente = $_POST['nominaSuplenteL'];
        $nombreSuplente = $_POST['nombreSuplenteL'];
        $motivo = $_POST['tipoSalida'];
        $totalDias = $_POST['totalDiasL'];
         if($id != null){ //Si la id esta llena, se realiza un update
            $idFormato = $id;
            $sql = "UPDATE solicitudSuplencia SET fechaPeriodoInicio = ?, fechaPeriodoFin = ?, nominaSuplente = ?, nombreSuplente = ?, motivoSustitucion = ?, diasDisfrutar = ? WHERE idFormato=?";
        }else{ //Si la id esta vacia, se realiza un insert
            $idFormato = obtenerUltimoID(); // obtiene el ultimo id registrado en la tabla formato para usar este id como llave foranea
            $sql = "INSERT INTO solicitudLicencia (goceSueldo, observaciones, nombreSuplente, nominaSuplente, motivo, dictamen, idFormato, fechaInicio, fechaFin, diasDisfrutar) values(?,?,?,?,?,?,?,?,?,?)";
        }
        $statement = Conexion::getConexion()->prepare($sql);
        $res = $statement->execute([$goceSueldo, $observaciones, $nombreSuplente, $nominaSuplente, $motivo, $dictamen, $idFormato, $fechaPeriodoInicio, $fechaPeriodoFin, $totalDias]);
        if($res)
            echo "Guardado con Exito";
        else
            echo "Error: no se pudo guardar2";
            print_r($statement->errorInfo());
          
    }
 
    function consultarFormato(){
         try {
            $folio = $_POST['folio'];
            $sql = 'SELECT  formatos.id,formatos.folio, formatos.tipoSolicitud, formatos.estadoSolicitud, formatos.fechaCreacion, formatos.totalFirmas, formatos.idEmpleado, formatos.personaQuienAutoriza ,
                solicitudLicencia.goceSueldo, solicitudLicencia.nombreSuplente, solicitudLicencia.nominaSuplente, solicitudLicencia.observaciones,solicitudLicencia.motivo,
                solicitudLicencia.fechaInicio,solicitudLicencia.fechaFin,solicitudLicencia.diasDisfrutar,empleado.nomina, empleado.nombre,horario.id, horario.turno, adscripcion.nombre, categoria.nombre,categoria.tipoContrato
             FROM formatos 
            INNER JOIN solicitudLicencia ON formatos.id = solicitudLicencia.idFormato 
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

    function compararCantidadSolicitud(){
        try {
            $anio = date("Y");
            $idEmpleado = $_POST['idEmpleado'];
            $tipoSolicitud = "Licencia";
            /*$sql = "SELECT COUNT(*) AS totalSolicitudes
                    FROM [formatosPrueba].[dbo].[formatos]
                    WHERE idEmpleado = :idEmpleado
                    AND tipoSolicitud = :tipoSolicitud";
                    //Condicianal que busque solo a las del año actual
            $statement = Conexion::getConexion()->prepare($sql);
            $statement->bindValue(':idEmpleado', $idEmpleado);
            $statement->bindValue(':tipoSolicitud', $tipoSolicitud);
            $statement->execute();*/
            $sql = "SELECT COUNT(*) AS totalSolicitudes
                FROM [formatosPrueba].[dbo].[formatos]
                WHERE idEmpleado = :idEmpleado
                AND tipoSolicitud = :tipoSolicitud
                AND YEAR(fechaCreacion) = :anio";

            $statement = Conexion::getConexion()->prepare($sql);
            $statement->bindValue(':idEmpleado', $idEmpleado);
            $statement->bindValue(':tipoSolicitud', $tipoSolicitud);
            $statement->bindValue(':anio', $anio, PDO::PARAM_INT); // Aseguramos que el año sea tratado como entero
            $statement->execute();
            
            // Obtener el resultado
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $totalSolicitudes = $result['totalSolicitudes'];

            // Verificar si el empleado ha realizado 3 o más solicitudes del tipo específico
            if ($totalSolicitudes >= 3) {
                echo "El empleado ha realizado 3 o más solicitudes";
            } else {
                echo "El empleado no ha realizado 3 o más solicitudes";
            }
        } catch (PDOException $e) {
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        }
    }


    $funcion = $_POST["numFuncion"];
    switch ($funcion) {
        case 1:
            guardarFormato(); // funcion para guardar los formatos
            break;
        /*case 2:
            modificarFormato(); // funcion para modificar un formato
            break;*/
        case 3:
            consultarFormato(); // funcion para consultar la informacion de un formato
            break;
        case 4:
            eliminarFormato(); // funcion para eliminar un formato
            break;
        case 5:
            obtenerFolio(); // funcion para consultar el ultimo folio registrado
            break;
        case 6:
            compararCantidadSolicitud(); // funcion para consultar el ultimo folio registrado
            break;
    }