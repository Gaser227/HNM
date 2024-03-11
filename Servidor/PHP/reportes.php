<?php
include_once "Conexion.php";

function opcion1(){
    require('../fpdf/fpdf.php');
    class PDF extends FPDF{
        // Cabecera de página
        function Header(){
            // Logo
            $this->Image("../../Cliente/Recursos/Imagenes/Logos/hnm.png",6,8,20);
            // Arial bold 15
            $this->SetFont('Arial','B',11);
            // Movernos a la derecha
            $this->Cell(80);
            // Título
            $this->Cell(30,10,'Total Personal',1,0,'C');
            // Salto de línea
            $this->Ln(20);
        
            $this->Cell(100,10,"Contrato/Area",1,0,"C",0);
            $this->Cell(70,10,"Total",1,1,"C",0);
        }
        // Pie de página
        function Footer(){
            // Posición: a 1,5 cm del final
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',8);
            // Número de página
            $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
        }
    }
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    // Obtener los contratos disponibles
    $sql1 = "SELECT clave, nombre FROM tipoContrato";
    $statement1 = Conexion::getConexion()->prepare($sql1);
    $statement1->execute();

    while ($valor = $statement1->fetch(PDO::FETCH_ASSOC)) {
        $nombre = $valor["nombre"];
        $tipoContrato = $valor["clave"];
        $pdf->SetTextColor(91, 44, 111);
        $pdf->Cell(100, 10, $nombre, 1, 1, "C", 0);
        $pdf->SetTextColor(0, 0, 0);
    /*$sql = "SELECT tc.nombre AS contrato, COUNT(e.id) AS total_empleados
        FROM tipoContrato tc
        LEFT JOIN categoria ca ON tc.clave = ca.tipoContrato
        LEFT JOIN empleado e ON ca.id = e.idCategoria
        GROUP BY tc.nombre";
    $statement = Conexion::getConexion()->prepare($sql);
    $statement->execute();

    while ($valor = $statement->fetch(PDO::FETCH_ASSOC)) {
        //$tipoContrato = $valor["clave"];
        $tipoContrato = $valor["contrato"];
        $totalEmpleadosContrato = $valor["total_empleados"];
        $pdf->SetTextColor(91, 44, 111);
        $pdf->Cell(100, 10, $tipoContrato, 1, 0, "C", 0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(70, 10, $totalEmpleadosContrato, 1, 1, "C", 0);*/

        // Obtener las adscripciones y el número de empleados por contrato
        $sql2 = "SELECT c.nombre AS adscripcion, COUNT(*) AS total_empleados 
                FROM empleado e 
                JOIN categoria c ON e.idCategoria = c.id
                WHERE c.tipoContrato = :tipo_contrato
                GROUP BY c.nombre";
        $statement2 = Conexion::getConexion()->prepare($sql2);
        $statement2->bindParam(':tipo_contrato', $tipoContrato);
        $statement2->execute();

        while ($otra = $statement2->fetch(PDO::FETCH_ASSOC)) {
            $adscripcion = $otra["adscripcion"];
            $totalEmpleados = $otra["total_empleados"];
            $pdf->Cell(100, 10, $adscripcion, 1, 0, "C", 0);
            $pdf->Cell(70, 10, $totalEmpleados, 1, 1, "C", 0);
        }
    }
    $pdf->Output();
}  

function opcion2(){
    require('../fpdf/fpdf.php');
    class PDF2 extends FPDF{
        // Cabecera de página
        function Header(){
            // Logo
            $this->Image("../../Cliente/Recursos/Imagenes/Logos/hnm.png",6,8,20);
            // Arial bold 15
            $this->SetFont('Arial','B',11);
            // Movernos a la derecha
            $this->Cell(60);
            // Título
            $this->Cell(60,10,'Cantidad de Solicitudes',1,0,'C');
            // Salto de línea
            $this->Ln(20);
        
            $this->Cell(100,10,"Nombre Solicitud",1,0,"C",0);
            $this->Cell(70,10,"Total",1,1,"C",0);
        }
        // Pie de página
        function Footer(){
            // Posición: a 1,5 cm del final
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',8);
            // Número de página
            $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
        }
    }
    $pdf = new PDF2();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);
    $fechaInicio = $_POST['fechaInicio']; // Obtén la fecha de inicio del período
    $fechaFin = $_POST['fechaFin']; // Obtén la fecha de fin del período

     // Obtener las solicitudes y la cantidad de solicitudes realizadas
     $sql = "SELECT tipoSolicitud, COUNT(*) AS totalSolicitudes
        FROM formatos
        WHERE fechaCreacion BETWEEN :fechaInicio AND :fechaFin
        GROUP BY tipoSolicitud";

    $statement = Conexion::getConexion()->prepare($sql);
    $statement->bindValue(':fechaInicio', $fechaInicio);
    $statement->bindValue(':fechaFin', $fechaFin);
    $statement->execute();

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $tipoSolicitud = $row["tipoSolicitud"];
        $totalSolicitudes = $row["totalSolicitudes"];
        
        $pdf->Cell(100, 10, $tipoSolicitud, 1, 0, "C", 0);
        $pdf->Cell(70, 10, $totalSolicitudes, 1, 1, "C", 0);
    }

    $pdf->Output();
} 

/*function generarGrafica() {
    $sql = "SELECT estadoSolicitud, COUNT(*) AS cantidad
    FROM formatos
    GROUP BY estadoSolicitud";
    $resultado = Conexion::getConexion()->query($sql);
    $resultado->execute();
    // Almacenar los resultados en un arreglo asociativo
    $datos = "";
    while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $datos .=
            $row["estadoSolicitud"] . "*"
            . $row["cantidad"] . "#";
    }
    echo $datos;
}*/
function generarGrafica() {
    $fechaInicio = $_POST['fechaInicio']; // Obtén la fecha de inicio del período
    $fechaFin = $_POST['fechaFin']; // Obtén la fecha de fin del período

    $sql = "SELECT estadoSolicitud, COUNT(*) AS cantidad
            FROM formatos
            WHERE fechaCreacion BETWEEN :fechaInicio AND :fechaFin
            GROUP BY estadoSolicitud";

    $statement = Conexion::getConexion()->prepare($sql);
    $statement->bindValue(':fechaInicio', $fechaInicio);
    $statement->bindValue(':fechaFin', $fechaFin);
    $statement->execute();

    $datos = "";
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $datos .=
            $row["estadoSolicitud"] . "*" . $row["cantidad"] . "#";
    }

    echo $datos;
}

//$funcion = $_POST["numFuncion"];
//$funcion = 3;
$funcion = $_POST["numFuncion"];
switch ($funcion) {
    case 1:/* Funcion para obtener la cantidad empleados por categoria y contrato*/
        opcion1();
        break;
    case 2:/* Funcion para obtener la cantidad de solicitudes en general */
        opcion2();
        break;
    case 3:/* Funcion para obtener la cantidad de solicitudes aceptadas/rechazadas/pendientes */
        generarGrafica();
        break;
    case 4: /**/
        //opcion4();
        break;
}
?>