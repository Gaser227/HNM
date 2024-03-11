<?php
session_start();
$_SESSION['empleadoHnmFormatos']['boton'] = 6;
?>

<div class="w3-container w3-padding-16">
    <h3>
        Reportes
    </h3>
</div>
<div class="w3-container w3-col s12">
    <div class="w3-col s5 w3-btn w3-green _blank" id="btnOpcion1" name="btnOpcion1" target="_blank"> <!-- style="width: 90%; height:70%; background:white; margin:auto; margin-left:15px;opacity: 0.7; border-radius:15px;" -->
        <div class="w3-bar-item"> 
            <p>Cantidad Empleados por Categoria</p>
        </div>
    </div>

    <div class="w3-col s2">
       <br>
    </div>

    <div class="w3-col s5 w3-btn w3-green" id="btnOpcion2" name="btnOpcion2">
        <div class="w3-bar-item">
            <p>Cantidad de Solicitudes</p>
        </div>
    </div>
</div>
<div class="w3-container w3-col s12">
    <br>
</div>
<div class="w3-container w3-col s12">
    <div class="w3-col s5 w3-btn w3-green" id="btnOpcion3" name="btnOpcion3">
        <div class="w3-bar-item">
            <p>Solicitudes Aceptadas/Rechazadas/Pendientes</p>
        </div>
    </div>

    <div class="w3-col s2">
       <br>
    </div>

    <div class="w3-col s5 w3-btn w3-green">
        <div class="w3-bar-item">
            <p>Opcion4</p>
        </div>
    </div>
</div>


<div class="w3-modal" id="modalOpcion1" style="display:none;">
    <div class="w3-modal-content w3-card-4 w3-padding-16 w3-animate-zoom w3-light-gray" style="width:40%;border-radius:20px;">
        <div class="w3-bar" style="display: flex; justify-content: flex-start; ">
            <div class="3-bar-item" style="display: flex; justify-content: space-between;">
                    <span id="btnCerrarOpcion1" class="w3-btn w3-display-topright" style="border-top-right-radius: 20px;">&times;</span>
            </div>
        </div>
        <div class="w3-col s6"> 
        <h6>Rrportes</h6>
            <div class="w3-col s5 w3-btn w3-blue"> <!-- style="width: 90%; height:70%; background:white; margin:auto; margin-left:15px;opacity: 0.7; border-radius:15px;" -->
                <div class="w3-bar-item-center">
                    <p>Reporte</p>
                </div>
            </div>  
            <!--
                Tabla donde se ordena por categoria y contrato todo los empleados, esta tabla se podra descargar en formato PDF
            -->
            
        </div>
        <div class="w3-container w3-padding-16" style="text-align: center;">
                <button class="w3-button w3-red">Cancelar</button>
        </div>
    </div>
</div>
 
<div class="w3-modal" id="modalOpcion2" style="display:none;">
    <div class="w3-modal-content w3-card-4 w3-padding-16 w3-animate-zoom w3-light-gray" style="width:40%;border-radius:20px;">
        <div class="w3-bar" style="display: flex; justify-content: flex-start; ">
            <div class="3-bar-item" style="display: flex; justify-content: space-between;">
                    <span id="btnCerrarOpcion2" class="w3-btn w3-display-topright" style="border-top-right-radius: 20px;">&times;</span>
            </div>
        </div>
        <div class="w3-col s12">
            <div class="w3-col s4">
                <div class="w3-container" style="width: 100%; height:80px;">
                    <label for="">Fecha de Inicio:</label> <input type="date" name="fechaInicioP" id="fechaInicioP" class="w3-input w3-border-1">
                </div>
            </div>
            <div class="w3-col s4">
                <div class="w3-container" style="width: 100%; height:80px;">
                    <label for="">Fecha de Final:</label> <input type="date" name="fechaFinalP" id="fechaFinalP" class="w3-input w3-border-1">
                </div>
            </div>
            <div class="w3-col s4">
                <div class="w3-container" style="width: 100%; height:80px;">
                    <input type="submit" id="generarPdf" value="Generar pdf" class="w3-button w3-green" style="margin-bottom:10px">
                </div>
            </div>
        </div>
        <div class="w3-container w3-padding-16" style="text-align: center;">
        </div>
    </div>
</div>

<div class="w3-modal" id="modalOpcion3" style="display:none;">
    <div class="w3-modal-content w3-card-4 w3-padding-16 w3-animate-zoom w3-light-gray" style="width:40%;border-radius:20px;">
        <div class="w3-bar" style="display: flex; justify-content: flex-start; ">
            <div class="3-bar-item" style="display: flex; justify-content: space-between;">
                <span id="btnCerrarOpcion3" class="w3-btn w3-display-topright" style="border-top-right-radius: 20px;">&times;</span>
            </div>
        </div>
        <div class="w3-col s12">
            <div class="w3-col s4">
                <div class="w3-container" style="width: 100%; height:80px;">
                    <label for="">Fecha de Inicio:</label> <input type="date" name="fechaInicioR" id="fechaInicioR" class="w3-input w3-border-1">
                </div>
            </div>
            <div class="w3-col s4">
                <div class="w3-container" style="width: 100%; height:80px;">
                    <label for="">Fecha de Final:</label> <input type="date" name="fechaFinalR" id="fechaFinalR" class="w3-input w3-border-1">
                </div>
            </div>
            <div class="w3-col s4">
                <div class="w3-container" style="width: 100%; height:80px;">
                    <input type="submit" id="generarGrafica" value="Generar Grafica" class="w3-button w3-green" style="margin-bottom:10px">
                </div>
            </div>
            <canvas id="grafica-pastel"></canvas>
            <!-- 
                "Grafica" donde se muestren las solicitudes aceptadas, rechazadas y pendientes
             -->
        </div>
        <div class="w3-container w3-padding-16" style="text-align: center;">
        <br>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@latest"></script>