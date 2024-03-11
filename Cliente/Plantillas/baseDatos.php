<?php
session_start();
$_SESSION['empleadoHnmFormatos']['boton'] = 7;
?>

<div class="w3-container w3-padding-21">
    <div class="w3-row-padding">
        <div class="w3-half w3-btn" id="btnRespaldoBD" style="height: auto;">
            <img src="../Cliente/Recursos/Imagenes/BackUpDB.png" height="300px" style="margin:px">
            <div class="w3-bar-item">
                <p>Realizar respaldo de base de datos</p>
            </div>
        </div> 
        <div class="w3-half w3-btn" id="btnRestauraciones" style="height: auto;">
            <img src="../Cliente/Recursos/Imagenes/RestoreDB.png" height="300px" style="margin:px">
            <div class="w3-bar-item">
                <p>Restaurar base de datos</p>
            </div>
        </div>
    </div>
</div>