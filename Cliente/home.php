<?php
session_start();
if (isset($_SESSION['empleadoHnmFormatos'])) {
    $nombreEmpleado = $_SESSION['empleadoHnmFormatos'][2];
    $nomina = $_SESSION['empleadoHnmFormatos'][1];
    //$tipoUsuario = $_SESSION['empleadoHnmFormatos'][18];
    $tipoUsuario = $_SESSION['empleadoHnmFormatos'][6];

    $boton = $_SESSION['empleadoHnmFormatos']['boton'];
} else {
    header('Location:index.php');
}
?>
<!DOCTYPE html>
<html lang="es_ES">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <!-- Fuente de google -->
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="CSS/jquery.dataTables.min.css">
    <link rel="stylesheet" href="CSS/estilo.css">
    <link rel="stylesheet" href="CSS/w3.css">

    <!--  <link rel="stylesheet" href="CSS/css/all.min.css"> s-->
    <script>
/*function limitar() {
    var tipoUsuario = <?php echo $nomina; ?>
    if (tipoUsuario != '3'){
        var Solicitudes = document.getElementById("btnSolicitudes");
        Solicitudes.disabled = true;
    }
    if (tipoUsuario != '4'){
        var Tramites = document.getElementById("btnTramites");
        Tramites.disabled = true;
    }
    if (tipoUsuario == '2'){
        var Empleados = document.getElementById("btnEmpleados");
        Empleados.disabled = true;
    }
    if (tipoUsuario == '2'){
        var Horarios = document.getElementById("btnHorarios");
        Horarios.disabled = true;
    }
    if (tipoUsuario == '2'){
        var Reportes = document.getElementById("btnReportes");
        Reportes.disabled = true;
    }
    if (tipoUsuario == '2'){
        var BaseDatos = document.getElementById("btnBaseDatos");
        BaseDatos.disabled = true;
    }
}*/
</script>
</head>
<body >
    <!-- Header -->
    <div class="w3-top"><!-- Inicia menu -->
        <div class="w3-bar" id="nav-bar">
            <img class="w3-left" src="Recursos/Imagenes/Logos/hnm.png" id="logo-hnm">
            <button class="btns-menu w3-bar-item w3-btn" style="color: white;" id="btnInicio">Inicio</button>
            <?php if($tipoUsuario != 3) : ?><button hidden class="btns-menu w3-bar-item w3-btn" style="color: white;" id="btnSolicitudes">Solicitudes</button><?php endif; ?>
            <?php if($tipoUsuario == 2) : ?><button class="btns-menu w3-bar-item w3-btn" style="color: white;" id="btnEmpleados">Empleados</button><?php endif; ?>
            <?php if($tipoUsuario == 2) : ?><button class="btns-menu w3-bar-item w3-btn" style="color: white;" id="btnContratos">Contratos</button><?php endif; ?>
            <?php if($tipoUsuario != 4) : ?><button class="btns-menu w3-bar-item w3-btn" style="color: white;" id="btnTramites">Trámites</button><?php endif; ?>
            <?php if($tipoUsuario == 2) : ?>
            <button class="btns-menu w3-bar-item w3-btn" style="color: white;" id="btnHorarios">Horarios</button>
            <button class="btns-menu w3-bar-item w3-btn" style="color: white;" id="btnReportes">Reportes</button>
            <button class="btns-menu w3-bar-item w3-btn" style="color: white;" id="btnBaseDatos">Base de Datos</button>
            <?php endif; ?>
            <div class="w3-right">
                <label class="w3-bar-item" id="nombreUsuario"><?php echo $nombreEmpleado; ?></label>
                <div id="divConfiguracion">
                    <button title="Configuraciones" class="w3-bar-item w3-btn" id="btnConfiguraciones"><i class="fa fa-gear"></i></button>
                </div>
                <div id="divNotificaciones">
                    <button title="Notificaciones" class="w3-bar-item w3-btn" id="btnNotificaciones"><i class="fa fa-bell"></i></button>
                    <span class="badge">3</span>
                </div>
                <button title="Cerrar Sesión" class="w3-bar-item w3-btn" id="btnLogout"><i class="fa fa-sign-in"></i></button>
            </div>
        </div>
    </div>
    <br><br><br><br><br>
    <input id="inputNomina" type="text" value="<?php echo $nomina ?>" hidden>
    <input id="inputBoton" type="text" value="<?php echo $boton?>" hidden>
    <div class="w3-margin-top w3-padding-24 w3-container w3-card" id="contenido" style="min-height:460px;height:auto;">

    </div>
    <br>
    <!-- Cambio de Contraseña -->
    <div class="w3-modal" id="modalCambioContrasena">
        <div class="w3-modal-content w3-card-4 w3-padding-16 w3-animate-zoom w3-light-gray" style="width:40%;border-radius:20px;">
            <div class="w3-bar" style="display: flex; justify-content: flex-start; ">
                <h2 style="padding-left:3%;">Cambio de contraseña</h2>
                <div class="3-bar-item" style="display: flex; justify-content: space-between;">
                    <span id="btnCerrarModalConf" class="cerrarModalTop w3-btn w3-display-topright" style="border-top-right-radius: 20px;">&times;</span>
                </div>
            </div>
            <div class=" w3-panel w3-padding-16">
                <label class="w3-text-purple">Contraseña</label>
                <input class="w3-input w3-border w3-round-large" type="text" id="contrasenaCambio" placeholder="Ingrese su contraseña" maxlength="20"><br>
                <label class="w3-text-purple">Nueva Contraseña</label>
                <input class="w3-input w3-border w3-round-large" type="password" id="nuevaContraseña" placeholder="Ingrese una nueva contraseña" maxlength="20"><br>
                <label class="w3-text-purple">Confirmar contraseña</label>
                <input class="w3-input w3-border w3-round-large" type="password" id="nuevaContraseñaC" placeholder="Ingrese nuevamente la contraseña" maxlength="20">
                <div class="w3-container w3-padding-16" style="text-align: right;">
                    <input class="w3-btn w3-wide w3-round w3-large w3-mobile" type="button" id="btnCambio" value="Guardar">
                    <input class="cerrarModal w3-btn w3-wide w3-round w3-large w3-mobile" type="button" id="btnCancelarConf" value="Cancelar" style="background-color: #e61919; color: white;">
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w3-container w3-theme-dark w3-padding-24 w3-margin-top">
        <div class="w3-tooltip w3-right">
            <p>Hospital de Niño Morelense</p>
        </div>
    </footer>

    <div id="modal"></div>

    <div class="w3-modal" id="modalMensaje">
        <div class="w3-modal-content w3-card-4 w3-padding-16 w3-animate-zoom w3-light-gray" style="width:40%;border-radius:20px;">
            <div class="w3-bar" style="display: flex; justify-content: flex-start; ">
                <div class="3-bar-item" style="display: flex; justify-content: space-between;">
                    <span id="btnCerrarMensajeTop" class="w3-btn w3-display-topright" style="border-top-right-radius: 20px;">&times;</span>
                </div>
            </div>
            <div class=" w3-panel w3-padding-16" style="text-align: center;">
                <h3 class="w3-text-red" id="mensaje" style="padding-left:3%;"></h3>
                <div class="w3-container w3-padding-16">
                    <input class="w3-btn w3-wide w3-round w3-large w3-mobile" type="button" id="btnCerrarMensaje" value="Cerrar" >
                </div>
            </div>
        </div>
    </div>
    <div class="w3-modal" id="modalConfirmar" style="display:none;">
        <div class="w3-modal-content w3-card-4 w3-padding-16 w3-animate-zoom w3-light-gray" style="width:40%;border-radius:20px;">
            <div class="w3-bar" style="display: flex; justify-content: flex-start; ">
                <div class="3-bar-item" style="display: flex; justify-content: space-between;">
                    <span id="btnCerrarConfirmar" class="w3-btn w3-display-topright" style="border-top-right-radius: 20px;">&times;</span>
                </div>
            </div>


            <div class="w3-col s12">
                <div class="w3-container" style="width: 100%; height:150px; " id="">
                    <label for="confirmarNomina">Numero de Nomina:</label><input type="text" name="confirmarNomina" id="confirmarNomina" class="w3-input w3-border-1" placeholder="Ingrese su numero de nomina" require><br>
                    <label for="confirmarPassword">Contraseña:</label><input type="password" name="confirmarPassword" id="confirmarPassword" class="w3-input w3-border-1" Placeholder="Ingrese su contraseña" require><br>
                </div>
            </div>
            <div class="w3-container w3-padding-16" style="text-align: center;">
                <button class="w3-button w3-blue" type="submit" id="btnAceptarFirmar">Aceptar</button>

            </div>

        </div>
    </div>
    <div class="w3-modal" id="modalCambiarFecha" style="display:none;">
        <div class="w3-modal-content w3-card-4 w3-padding-16 w3-animate-zoom w3-light-gray" style="width:40%;border-radius:20px;">
            <div class="w3-bar" style="display: flex; justify-content: flex-start; ">
                <div class="3-bar-item" style="display: flex; justify-content: space-between;">
                    <span id="btnCerrarCambiarFecha" class="w3-btn w3-display-topright" style="border-top-right-radius: 20px;">&times;</span>
                </div>
            </div>
            <div class="w3-col s12">
                <div class="w3-container" style="width: 100%; height:150px; " id="">
                    <label for="turno">Fecha:</label><input type="date" name="nuevaFecha" id="nuevaFecha" class="w3-input w3-border-1" require><br>
                </div>
            </div>
            <div class="w3-container w3-padding-16" style="text-align: center;">
                <button class="w3-button w3-blue" type="submit" id="btnAceptarCambiarFecha">Aceptar</button>
            </div>
        </div>
    </div>
</body>
<script>
    console.log("LA variable es: ");
    var tipoUsuario = <?php echo $tipoUsuario;?>;
    console.log(tipoUsuario);
</script>
<script src="JS/jquery.min.js"></script>
<script src="JS/jquery.dataTables.min.js"></script>
<script src="js/bezier.js"></script>
<script src="js/jquery.signaturepad.js"></script>
<script src="js/json2.min.js"></script>
<script src="JS/html2canvas.js"></script>
<script src="AJAX/funcionesLogin.js"></script>
<script src="AJAX/botonesMenu.js"></script>
<script src="AJAX/scriptConsultasFormatos.js"></script>
<script src="AJAX/solicitudes/scriptEntradaSalida.js"></script>
<script src="AJAX/solicitudes/scriptDobleTurno.js"></script>
<script src="AJAX/solicitudes/scriptLicencia.js"></script>
<script src="AJAX/solicitudes/scriptIntercambio.js"></script>
<script src="AJAX/solicitudes/scriptTramite.js"></script>
<script src="AJAX/solicitudes/scriptOficio.js"></script>
<script src="AJAX/solicitudes/scriptVacaciones.js"></script>
<script src="AJAX/solicitudes/scriptSuplencia.js"></script>
<script src="AJAX/solicitudes/scriptFuncionesGenerales.js"></script>
<script src="http://momentjs.com/downloads/moment.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
<script src="SweetAlert2/sweetalert2.all.min.js"></script>
<script src="SweetAlert2/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@latest"></script>

</html>