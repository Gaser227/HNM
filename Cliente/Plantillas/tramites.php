<?php
session_start();
$_SESSION['empleadoHnmFormatos']['boton'] = 4;
$id = $_SESSION['empleadoHnmFormatos'][0];
?>
<input type="text" id = "idEmpleado" name ="idEmpleado" style="display:none;"value ="<?php echo $id; ?>">

<!--<div class="w3-bar w3-blue" style="display: flex; justify-content: center;">
    <div class="w3-bar-item">
        <h7>TRAMITES PENDIENTES</h7>
    </div>
</div>
<div id="solicitudes" class="w3-col s12" style="width: 100%; height:45%; display: flex; justify-content: space-around; ">
    <table id="tablaSolicitudes" class="w3-table w3-bordered">
        <thead>
            <tr>
                <th>Folio</th>
                <th>Tipo de Solicitud</th>
                <th>Firmas Requeridas</th>
                <th>Firmas Obtenidas</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody id="filas">
        </tbody>
    </table>
</div>-->

<div class="w3-container w3-col s12">
    <div class="w3-half">
        <label class="w3-text-dark" style="font-size: 30px;">TRAMITES PENDIENTES</label>
    </div>
    <table id="tablaSolicitudes" class="w3-table-all w3-left w3-small w3-hoverable">
        <thead>
            <tr class="w3-blue">
                <th>Folio</th>
                <th>Tipo de Solicitud</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Firmas Obtenidas</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody id="tableBody">
        </tbody>
    </table>
</div>