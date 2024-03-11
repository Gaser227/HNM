<?php
session_start();
$_SESSION['empleadoHnmFormatos']['boton'] = 2;
?> 

<div>
    <div class="w3-row-padding">
        <div class="w3-half w3-row">
            <div class="w3-third">
                <button class="w3-btn w3-green" id="btnAgregarEmpleado">Agregar empleado</button>
            </div>
            <div class="w3-third" id="divBtnHabiles" style="display: none;">
                <button class="w3-btn w3-blue" id="btnHabiles">Empleados habilitados</button>
            </div>
            <div class="w3-third" id="divBtnInhabiles">
                <button class="w3-btn w3-gray" id="btnInhabiles">Empleados inhabilitados</button>
            </div>
        </div>
        <div class="w3-half">
            <label class="w3-text-dark" style="font-size: 30px;">Listado de empleados</label>
        </div>
    </div>
</div>
<br>
<div class="w3-container">
    <table id="tablaEmpleados" class="w3-table-all w3-centered w3-small w3-hoverable">
        <thead>
            <tr class="w3-blue">
                <th>Nómina</th>
                <th>Nombre empleado</th>
                <th>Horario</th>
                <th>Adscripción</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody id="tableBody">
        </tbody>
    </table>
</div> 