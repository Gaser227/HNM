<?php
session_start();
$_SESSION['empleadoHnmFormatos']['boton'] = 3;
?>

<div class="w3-container w3-padding-16">
    <div class="w3-row-padding">
        <div class="w3-half">
            <button class="w3-btn w3-green" id="btnAgregarContrato" onclick="mostrarFormContrato();">Agregar Contrato</button>
        </div>
        <div class="w3-half">
            <button class="w3-btn w3-green" id="btnAgregarCategoria" onclick="mostrarFormCategoria();">Agregar Categoria</button>
        </div>
    </div>
</div>

<br>

<div class="w3-container w3-col s6">
    <div class="w3-half">
        <label class="w3-text-dark" style="font-size: 30px;">Contratos</label>
    </div>
    <table id="tablaContratos" class="w3-table-all w3-left w3-small w3-hoverable">
        <thead>
            <tr class="w3-blue">
                <th>Clave</th>
                <th>Nombre</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody id="tableBody">
        </tbody>
    </table>
</div>

<div class="w3-container w3-col s6">
    <div class="w3-half">
        <label class="w3-text-dark" style="font-size: 30px;">Categorias</label>
    </div>
    <table id="tablaCategorias" class="w3-table-all w3-centered w3-small w3-hoverable">
        <thead>
             <tr class="w3-blue">  
                <th>Nombre</th>
                <th>Tipo Contrato</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody id="tableBody">
        </tbody>
    </table>
</div>