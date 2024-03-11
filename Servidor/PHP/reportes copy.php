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
    $pdf-> AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','',12);
    //$pdf->Cell(20,10,utf8_decode('¡Hola, Mundo!'));

    $sql1 = "SELECT clave FROM tipoContrato";
    $statement1 = Conexion::getConexion()->prepare($sql1);
    $statement1->execute();
    $val = $statement1->fetchColumn();

    while ($valor = $statement1->fetch(PDO::FETCH_ASSOC)){
        $tipoC = $valor["clave"];
        $pdf->SetTextColor(91,44,111);
        $pdf->Cell(100,10,$tipoC,1,1,"C",0);
        $pdf->SetTextColor(0,0,0); //Linea para regresar el color del texto al original (el color negro)
        $pdf->Cell(70,10,$val,1,1,"C",0);
        
        //$valor = $statement1->fetchColumn(); //Total de empleados por contrato
        // EL total de empleados de cada contrato se debe de optener de la tabla categoria

        $sql2 = "SELECT * FROM categoria"; // WHERE tipoContrato = ?
        $statement2 = Conexion::getConexion()->prepare($sql2);
        $statement2->execute(); //$tipoC
        /*
        $val = $statement2->fetchColumn(); //Total de empleados por categoria
        //Se requiere el tipo de contrato actual para obtener a todos los empleados de la misma categoria
        
        $pdf->SetTextColor(91,44,111); //Color para resaltar/distinguir el contrato
        $pdf->Cell(100,10,$fila["nombre"],1,0,"C",0);
        $pdf->SetTextColor(0,0,0); //Linea para regresar el color del texto al original (el color negro)
        $pdf->Cell(70,10,$valor,1,1,"C",0);
        //$pdf->Cell(70,10,$fila[5],1,1,"C",0);

        while($otra = $statement2->fetch(PDO::FETCH_ASSOC)){
            $pdf->Cell(100,10,$otra["nombre"],1,0,"C",0);
            $pdf->Cell(70,10,$val,1,1,"C",0);
        }
        */
    }
    $pdf->Output();
    /**
     * Obtener los empleados con el mismo contrato y que tengan la misma adscripcion
     * Obtener el total de empleados de un mismo contrato y de las adscripciones correspondientes a su contrato
     */
            /*
            For para poder ingresar la cantidad de empleados de un contrato (i)
            y la catidad de laadscripcion (j)
            *//*
            $this->Cell(40,5,"hola",1);
            $this->Cell(40,5,"hola2",1);
            $this->Cell(40,5,"hola3",1);
            $this->Cell(40,5,"hola4",1);
            $this->Ln();
            $this->Cell(40,5,"linea ",1);
            $this->Cell(40,5,"linea 2",1);
            $this->Cell(40,5,"linea 3",1);
            $this->Cell(40,5,"linea 4",1);
        }*/
    //}
}  
//$funcion = $_POST["numFuncion"];
$funcion = 1;
//$funcion = $_POST["numFuncion"];
switch ($funcion) {
    case 1:/* Funcion para obtener la cantidad empleados por categoria y contrato*/
        opcion1();
        break;
    case 2:/* Funcion para obtener la cantidad de solicitudes en general */
        //opcion2();
        break;
    case 3:/* Funcion para obtener la cantidad de solicitudes aceptadas/rechazadas/pendientes */
        //opcion3();
        break;
    case 4: /**/
        //opcion4();
        break;
}
?>