<?php
session_start();
$_SESSION['empleadoHnmFormatos']['boton'] = 0;
 $id = $_SESSION['empleadoHnmFormatos'][0];

?>
<input type="text" id = "idEmpleado" name ="idEmpleado" style="display:none;"value ="<?php echo $id; ?>">
<div>
    <div class="w3-row-padding">
        <div class="w3-half">
            <button class="w3-btn w3-green" id="tracking" onclick="mostrarFormTracking();">Tracking</button>
        </div>
        <div class="w3-half">
            <label class="w3-text-dark" style="font-size: 30px;">Formatos Enviados</label>
        </div>
    </div>
</div>
<br>
<div class="w3-container">
    <table id="tabla" class="w3-table-all w3-centered w3-small w3-hoverable">
        <thead>
            <tr class="w3-blue">
                <th>Folio</th>
                <th>Tipo de Solicitud</th>
                <th>Estado</th>
                <th>Fecha de Creación</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody id="tableBody">
        </tbody>
    </table>
</div>