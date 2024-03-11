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
            if(comprobarFormato($folio)){ //Se busca si la solicitud cuenta con un folio
                $tipoSolicitud = "Entrada-Salida";
                $estadoSolicitud = "Pendiente";
                $fechaCreacion = date("Y-m-d"); 
                $totalFirmas = 1; 
                $eliminado = 1;
                $idEmpleado = $_POST["idEmpleado"];
                if (isset($_POST['idJefe'])) { //Se asegura de que haya un jefe y el campo no quede vacio
                    $idJefe = $_POST['idJefe']; 
                } else {
                    $idJefe = 0;
                }
                $sql = "INSERT INTO formatos (folio, tipoSolicitud, estadoSolicitud, fechaCreacion, totalFirmas, idEmpleado, personaQuienAutoriza, eliminado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $statement = Conexion::getConexion()->prepare($sql);
                $res = $statement->execute([$folio, $tipoSolicitud, $estadoSolicitud, $fechaCreacion, $totalFirmas, $idEmpleado, $idJefe, $eliminado]);
                if($res){
                    guardarEntradaSalida(null); // funcion que guarda los datos de la seccion solicitud en la tabla entradaSalida
                }else{
                    echo "Error: no se pudo guardar";
                }
            }
                //print_r($statement->errorInfo()); 
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function guardarEntradaSalida($id)//funcion que guarda los datos de la seccion solicitud en la tabla entradaSalida
    {
        $tipoEntradaSalida = $_POST['tipoSolicitud'];
        $tiempoTotal = $_POST['totalTiempo'];
        $horaEntradaSalida = $_POST['horaEntradaSalida'];
        //return $horaEntradaSalida;
        $horario = $_POST['horario'];
        if (isset($_POST['tipoEntrada']))
            $tipoMotivo = $_POST['tipoEntrada'];
        else
            $tipoMotivo = $_POST['tipoSalida'];
        if (isset($_POST['inputDias']))
            $diasLaborales = $_POST['inputDias'];
        else
            $diasLaborales = $_POST['selectDias'];

        if (isset($_POST['horaRegreso'])) 
             $horaRegreso = $_POST['horaRegreso'];
        else
            $horaRegreso = "00:00";
        
        if (isset($_POST['asunto'])){
            $asunto = $_POST['asunto'];
        }else{
            $asunto = "--";
        }
       if (isset($_POST['eventualBase'])){
            $tipoPase = $_POST['eventualBase'];
        }else if(isset($_POST['cambioPorOficio'])){
             $tipoPase = $_POST['cambioPorOficio'];
        }else if(isset($_POST['regimenLey'])){
             $tipoPase = $_POST['regimenLey'];
        }else{
            $tipoPase ="--";
        }
        if (isset($_POST['horaEntradaCubrir'])){
            $horaEntradaCubrir = $_POST['horaEntradaCubrir'];
        }else{
            $horaEntradaCubrir = "";
        }
        if (isset($_POST['horaSalidaCubrir'])){
            $horaSalidaCubrir = $_POST['horaSalidaCubrir'];
        }else{
            $horaSalidaCubrir = "";
        }
        if (isset($_POST['departamento'])){
            $departamento = $_POST['departamento'];
        }else{
            $departamento = "--";
        }
        $horaEntradaCO = "00:00";
        $horaSalidaCO = "00:00";
        $observacionesCO = "--";
        $fechaJustificada = $_POST['fechaJustificada'];
         if($id != null){ //Si la id esta llena, se realiza un update
            //print_r("update");
            $idFormato = $id;
            $sql = "UPDATE entradaSalida SET horaEntradaCubrir = ?, horaSalidaCubrir = ?, tipoEntradaSalida = ?, tipoMotivo = ?, horaEntradaSalida = ?, horaRegreso = ?, 
                                tiempoTotal = ?, asunto = ?, horaEntradaCO = ?, horaSalidaCO = ?, observacionesCO = ?, fechaJustificada = ?, departamento = ?, tipoPase = ?, 
                                diasLaborales = ?, horario = ? WHERE idFormato=?";
        }else{ //Si la id esta vacia, se realiza un insert
            //print_r("insert");
            $idFormato = obtenerUltimoID(); // obtiene el ultimo id registrado en la tabla formato para usar este id como llave foranea
            $sql = "INSERT INTO entradaSalida (horaEntradaCubrir, horaSalidaCubrir, tipoEntradaSalida, tipoMotivo, horaRegreso, 
                                tiempoTotal, asunto, horaEntradaCO, horaSalidaCO, observacionesCO, fechaJustificada, idFormato, horaEntradaSalida,
                                departamento, tipoPase, diasLaborales, horario ) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        }
        $statement = Conexion::getConexion()->prepare($sql);
        $res = $statement->execute([$horaEntradaCubrir, $horaSalidaCubrir, $tipoEntradaSalida, $tipoMotivo, $horaRegreso, $tiempoTotal,
                                     $asunto, $horaEntradaCO, $horaSalidaCO, $observacionesCO, $fechaJustificada, $idFormato, $horaEntradaSalida, $departamento ,$tipoPase, $diasLaborales, $horario]);
        if($res)
            echo "Guardado con Exito";
        else
            echo "Error: no se pudo guardar2";
            //print_r($statement->errorInfo());
    }
 
    function consultarFormato(){
         try {
            $folio = $_POST['folio'];
           
            $sql = 'SELECT  formatos.id,formatos.folio, formatos.tipoSolicitud, formatos.estadoSolicitud, formatos.fechaCreacion, formatos.totalFirmas, formatos.idEmpleado, formatos.personaQuienAutoriza ,
                entradaSalida.horaEntradaCubrir, entradaSalida.horaSalidaCubrir, entradaSalida.tipoEntradaSalida, entradaSalida.tipoMotivo,entradaSalida.horaEntradaSalida,
                entradaSalida.horaRegreso,entradaSalida.tiempoTotal,entradaSalida.asunto, entradaSalida.horaEntradaCO, entradaSalida.horaSalidaCO,entradaSalida.observacionesCO, 
                entradaSalida.fechaJustificada, entradaSalida.departamento,entradaSalida.tipoPase, entradaSalida.diasLaborales, entradaSalida.horario, 
                empleado.nomina, empleado.nombre,horario.id, horario.turno, adscripcion.nombre, categoria.nombre,categoria.tipoContrato
             FROM formatos 
            INNER JOIN entradaSalida ON formatos.id = entradaSalida.idFormato 
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
                        . $row[22] . "*"
                        . $row[23] . "*"
                        . $row[24] . "*"
                        . $row[25] . "*"
                        . $row[26] . "*"
                        . $row[27] . "*"
                        . $row[28] . "*"
                        . $row[29] . "*"
                        . $row[30] . "*";
                 }
                echo $datos;
                 print_r($statement->errorInfo()); 
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
    }   