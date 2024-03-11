<?php 
 include_once "Conexion.php";
    function consultarFormatos()// funcion que obtiene todos los formatos de un solo empleado
    {
        try {
            $id = $_POST['idEmpleado'];
           
            $sql =' SELECT * FROM formatos where idEmpleado = ? AND eliminado = 1';
            $statement = Conexion::getConexion()->prepare($sql);
            $statement->execute([$id]);
            $datos = "";
            /* if($row = $statement->fetch(PDO::FETCH_ASSOC)){ */
                 while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    $datos .=
                        $row['id'] . "*"
                        . $row['folio'] . "*"
                        . $row['tipoSolicitud'] . "*"
                        . $row['estadoSolicitud'] . "*"
                        . $row['fechaCreacion'] . "*"
                        . $row['idEmpleado'] . "*" . "/";
                 }
             
                echo $datos;
          /*   }else{
                echo $datos = "Error";
            }
            */
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
   
    function obtenerFolio() //funcion para consultar el ultimo folio registrado
    { 
        try{
            $sql = "SELECT TOP(1) folio FROM formatos ORDER BY id DESC";
            $statement = Conexion::getConexion()->prepare($sql);
            $statement->execute();
            if(($row = $statement->fetch(PDO::FETCH_ASSOC))==true)
                echo $folio = $row['folio'];
            else
                echo $folio = 0;
        }catch (Exception $e) {
            $e->getMessage();
        }
            
        
    }

    function consultarTramites()// funcion que obtiene todos los formatos de un solo empleado
    {
        try {
            $nomina = $_POST['nomina'];
            $sql =' SELECT * FROM formatos where personaQuienAutoriza = ? AND eliminado = 1';
            $statement = Conexion::getConexion()->prepare($sql);
            $statement->execute([$nomina]);
            $datos = "";
            /* if($row = $statement->fetch(PDO::FETCH_ASSOC)){ */
                 while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    $datos .=
                        $row['id'] . "*"
                        . $row['folio'] . "*"
                        . $row['tipoSolicitud'] . "*"
                        . $row['estadoSolicitud'] . "*"
                        . $row['fechaCreacion'] . "*"
                        . $row['totalFirmas'] . "*"
                        . $row['personaQuienAutoriza'] . "*" . "/";
                 }
             
                echo $datos;
          /*   }else{
                echo $datos = "Error";
            }
            */
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function aceptarSolicitud() //funcion para consultar el ultimo folio registrado
    { 
        try{
            $folio = $_POST['folio'];
            $sql = "UPDATE formatos SET estadoSolicitud = 'Aceptada', totalFirmas = 2 WHERE folio = ?";
            $statement = Conexion::getConexion()->prepare($sql);
            $statement->execute([$folio]);
            
            if($statement){
                echo "La solicitud ha sido aceptada.";
            } else{
                echo "Error.";

            }
            // Agregar mensaje de éxito
        }catch (Exception $e) {
            $e->getMessage();
        }    
    }

    function denegarSolicitud() 
    { 
        try{
            //print_r("Entro");
            $folio = $_POST['folio'];
            $sql = "UPDATE formatos SET estadoSolicitud = 'Denegada', totalFirmas = 2 WHERE folio = ?";
            $statement = Conexion::getConexion()->prepare($sql);
            $statement->execute([$folio]);
            
            if($statement){
                echo "La solicitud no ha sido aceptada.";
            } else{
                echo "Error.";

            }
            //print_r($statement->errorInfo());
            // Agregar mensaje de éxito
        }catch (Exception $e) {
            $e->getMessage();
        }     
    }

    $funcion = $_POST["numFuncion"];
    switch ($funcion) {
        case 1:
            consultarFormatos();  // funcion para consultar la informacion de todos los formatos del empleado
            break;
        case 2:
            obtenerFolio(); // funcion para consultar la informacion de un formato de entrada salida
            break;
        case 3:
            consultarTramites();
            break;
        case 4:
            aceptarSolicitud();
            break;
        case 5:
            denegarSolicitud();
            break;
    }