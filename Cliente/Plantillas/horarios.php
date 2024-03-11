<?php
session_start();
$_SESSION['empleadoHnmFormatos']['boton'] = 5;
?>

<div class="w3-container w3-padding-16">
    <div class="w3-row-padding">
        <div class="w3-half">
            <button class="w3-btn w3-green" id="btnAgregarHorario" onclick="mostrarFormHorario();">Agregar horario</button>
        </div>
        <div class="w3-half">
            <button class="w3-btn w3-green" id="btnAgregarHorario" onclick="mostrarFormFestivo();">Festividades</button>
        </div>
    </div>
</div>

<br>

<div class="w3-container w3-col s6">
    <div class="w3-half">
        <label class="w3-text-dark" style="font-size: 30px;">Horarios registrados</label>
    </div>
    <table id="tablaHorarios" class="w3-table-all w3-centered w3-small w3-hoverable">
        <thead>
            <tr class="w3-blue">
                <th>Horario</th>
                <th>Turno</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody id="tableBody">
        </tbody>
    </table>
</div>
 
<div class="w3-container w3-col s6">
    <div class="w3-half">
        <label class="w3-text-dark" style="font-size: 30px;">Festividades registradas</label>
    </div>
    <table id="tablaFestividades" class="w3-table-all w3-centered w3-small w3-hoverable">
        <thead>
             <tr class="w3-blue">  
                <th>Festividad</th>
                <th>Fecha</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody id="tableBody">
        </tbody>
    </table>
</div>
