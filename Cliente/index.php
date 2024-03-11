<?php
session_start();
if (isset($_SESSION["empleadoHnmFormatos"])) {
    header('Location:home.php');
}
?>

<!DOCTYPE html>
<html lang="es_ES">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <!-- Estilos css -->
    <link rel="stylesheet" href="CSS/w3.css">
    <link rel="stylesheet" href="CSS/estilo.css">
    <link rel="stylesheet" href="CSS/estiloLogin.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kumbh+Sans&display=swap">
    <!-- JavaScripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@latest"></script>
    <script src="JS/jquery.min.js"></script>
    <script src="AJAX/funcionesLogin.js"></script>
</head>

<body>
    <div class="w3-display-middle" style="width:50%;">
        <div class="w3-container w3-padding-16" style="margin: auto; width: 85%;">
            <div class="w3-container w3-padding-16 w3-card-4 w3-animate-zoom w3-light-gray" style="border-radius: 20px;">
                <div style="text-align: center; color:white;">
                    <img class="w3-image" src="Recursos/Imagenes/Logos/hnm.png" style="width: 150px;">
                </div>
                <br>
                <label class="w3-text-purple">Número de nómina</label>
                <input class="w3-input w3-border w3-round-large" type="text" id="usuarioLogin" placeholder="Ingrese su número de nómina" maxlength="6"><br>
                <label class="w3-text-purple">Contraseña</label>
                <input class="w3-input w3-border w3-round-large" type="password" id="contrasenaLogin" placeholder="Ingrese su contraseña" maxlength="20">
                <div class="w3-container w3-padding-16" style="text-align: right;">
                    <input class="w3-btn w3-wide w3-round w3-large w3-mobile" type="button" id="botonLogin" value="Ingresar">
                </div>
                <div class="w3-panel" style="text-align: right;">
                    <a class="w3-text-blue" id="registroContrasena">¿Primera vez aquí? Registra tu contraseña</a><br>
                    <a class="w3-text-blue" id="recuperarContrasena">He olvidado mi contraseña</a>
                </div>
            </div>
        </div>
    </div>
    <div class="w3-modal" id="modalRegistroContrasena">
        <div class="w3-modal-content w3-card-4 w3-padding-16 w3-animate-zoom w3-light-gray" style="width:40%;border-radius:20px;">
            <div class="w3-bar" style="display: flex; justify-content: flex-start; ">
                <h2 style="padding-left:3%;">Registro de contraseña</h2>
                <div class="3-bar-item" style="display: flex; justify-content: space-between;">
                    <span id="btnCerrarModalC" class="cerrarModalTop w3-btn w3-display-topright" style="border-top-right-radius: 20px;">&times;</span>
                </div>
            </div>
            <div class=" w3-panel w3-padding-16">
                <label class="w3-text-purple">Número de nómina</label>
                <input class="w3-input w3-border w3-round-large" type="text" id="usuarioRegistro" placeholder="Ingrese su número de nómina" maxlength="6"><br>
                <label class="w3-text-purple">Contraseña</label>
                <input class="w3-input w3-border w3-round-large" type="password" id="contrasenaRegistro" placeholder="Ingrese una contraseña" maxlength="20"><br>
                <label class="w3-text-purple">Confirmar contraseña</label>
                <input class="w3-input w3-border w3-round-large" type="password" id="contrasenaCRegistro" placeholder="Ingrese nuevamente la contraseña" maxlength="20">
                <div class="w3-container w3-padding-16" style="text-align: right;">
                    <input class="w3-btn w3-wide w3-round w3-large w3-mobile" type="button" id="btnRegistro" value="Guardar">
                    <input class="cerrarModal w3-btn w3-wide w3-round w3-large w3-mobile" type="button" id="btnCancelarC" value="Cancelar">
                </div>
            </div>
        </div>
    </div>
    <div class="w3-modal" id="modalRecuperarContrasena">
        <div class="w3-modal-content w3-card-4 w3-padding-16 w3-animate-zoom w3-light-gray" style="width:40%;border-radius:20px;">
            <div class="w3-bar" style="display: flex; justify-content: flex-start; ">
                <h2 style="padding-left:3%;">Recuperar contraseña</h2>
                <div class="3-bar-item" style="display: flex; justify-content: space-between;">
                    <span id="btnCerrarModalR" class="cerrarModalTop w3-btn w3-display-topright" style="border-top-right-radius: 20px;">&times;</span>
                </div>
            </div>
            <div class=" w3-panel w3-padding-16">
                <label class="w3-text-purple">Número de nómina</label>
                <input class="w3-input w3-border w3-round-large" type="text" id="usuarioRecuperar" placeholder="Ingrese su número de nómina" maxlength="6"><br>
            <!--    <label class="w3-text-purple">Correo electrónico</label>
                <input class="w3-input w3-border w3-round-large" type="email" id="correoRecuperar" placeholder="Ingrese su correo electrónico asociado a su cuenta" maxlength="20"><br>-->
                <div class="w3-container w3-padding-16" style="text-align: right;">
                    <input class="w3-btn w3-wide w3-round w3-large w3-mobile" type="button" id="btnRecuperar" value="Continuar">
                    <input class="cerrarModal w3-btn w3-wide w3-round w3-large w3-mobile" type="button" id="btnCancelarR" value="Cancelar">
                </div>
            </div>
        </div>
    </div>
    <div class="w3-modal" id="modalMensaje">
        <div class="w3-modal-content w3-card-4 w3-padding-16 w3-animate-zoom w3-light-gray" style="width:40%;border-radius:20px;">
            <div class="w3-bar" style="display: flex; justify-content: flex-start; ">
                <div class="3-bar-item" style="display: flex; justify-content: space-between;">
                    <span id="btnCerrarMensajeTop" class="cerrarModalTop w3-btn w3-display-topright" style="border-top-right-radius: 20px;">&times;</span>
                </div>
            </div>
            <div class=" w3-panel w3-padding-16" style="text-align: center;">
                <h3 class="w3-text-red" id="mensaje" style="padding-left:3%;"></h3>
                <div class="w3-container w3-padding-16">
                    <input class="cerrarModal w3-btn w3-wide w3-round w3-large w3-mobile" type="button" id="btnCerrarMensaje" value="Cerrar" style="background-color: #e61919;">
                </div>
            </div>
        </div>
    </div>
</body>
</html>