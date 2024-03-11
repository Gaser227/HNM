function cargarContenidoInicio() {
    document.getElementById("btnInicio").style.background = "rgba(50,190,250,0.6)";
    $.ajax({
        url: "./Plantillas/inicio.php",
        success: function (data) {
            $('#contenido').html(data);
            $.getScript("./AJAX/scriptConsultasFormatos.js");
        }
    });
}

function cargarContenidoSolicitudes() {
    document.getElementById("btnSolicitudes").style.background = "rgba(50,190,250,0.6)";
    $.ajax({
        url: "./Plantillas/botones.php",
        success: function (data) {
            $('#contenido').html(data);
            $.getScript("./AJAX/solicitudes/scriptEntradaSalida.js");
            $.getScript("./AJAX/solicitudes/scriptDobleTurno.js");
            $.getScript("AJAX/solicitudes/scriptLicencia.js");
            $.getScript("AJAX/solicitudes/scriptIntercambio.js");
            $.getScript("AJAX/solicitudes/scriptTramite.js");
            $.getScript("AJAX/solicitudes/scriptOficio.js");
            $.getScript("AJAX/solicitudes/scriptVacaciones.js");
            $.getScript("AJAX/solicitudes/scriptSuplencia.js");
        }
    });
}

function cargarContenidoEmpleados() {
    document.getElementById("btnEmpleados").style.background = "rgba(50,190,250,0.6)";
    $.ajax({
        url: "./Plantillas/empleados.php",
        success: function (data) {
            $('#contenido').html(data);
            $.getScript("./AJAX/scriptEmpleados.js");
        }
    });
}

function cargarContenidoContratos() {
    document.getElementById("btnContratos").style.background = "rgba(50,190,250,0.6)";
    $.ajax({
        url: "./Plantillas/contratos.php",
        success: function (data) {
            $('#contenido').html(data);
            $.getScript("./AJAX/scripContratos.js");
        }
    });
}

function cargarContenidoTramites() {
    document.getElementById("btnTramites").style.background = "rgba(50,190,250,0.6)";
    $.ajax({
        url: "./Plantillas/tramites.php",
        success: function (data) {
            $('#contenido').html(data);
            $.getScript("./AJAX/scriptTramites.js");
        }
    });
}

function cargarContenidoHorarios() {
    document.getElementById("btnHorarios").style.background = "rgba(50,190,250,0.6)";
    $.ajax({
        url: "./Plantillas/horarios.php",
        success: function (data) {
            $('#contenido').html(data);
            $.getScript("./AJAX/scriptHorarios.js");
        }
    });
}

function cargarContenidoReportes() {
    document.getElementById("btnReportes").style.background = "rgba(50,190,250,0.6)";
    $.ajax({
        url: "./Plantillas/reportes.php",
        success: function (data) {
            $('#contenido').html(data);
            $.getScript("./AJAX/scriptReportes.js");
        }
    });
}

function cargarContenidoBD() {
    document.getElementById("btnBaseDatos").style.background = "rgba(50,190,250,0.6)";
    $.ajax({
        url: "./Plantillas/baseDatos.php",
        success: function (data) {
            $('#contenido').html(data);
            $.getScript("./AJAX/scriptBaseDatos.js");
        }
    });
}

function repintarBotones() {
    document.getElementById("btnInicio").style.background = "";
    if(tipoUsuario != 3)
        document.getElementById("btnSolicitudes").style.background = "";
    if(tipoUsuario == 2){
        document.getElementById("btnEmpleados").style.background = "";
        document.getElementById("btnContratos").style.background = "";
    }
    if(tipoUsuario != 4)
        document.getElementById("btnTramites").style.background = "";
    if(tipoUsuario == 2){
        document.getElementById("btnHorarios").style.background = "";
        document.getElementById("btnReportes").style.background = "";
        document.getElementById("btnBaseDatos").style.background = "";
    }
}

function notificaciones() {
    counter = $('.badge');
    val = parseInt(counter.text());
    val++;
    counter.text(val);
}

$(document).ready(function () {
    boton = parseInt(document.getElementById("inputBoton").value);
    console.log(boton);
    setInterval(notificaciones, 30000);
    switch (boton) {
        case 1:
            cargarContenidoSolicitudes();
            break;
        case 2:
            cargarContenidoEmpleados();
            break;
        case 3:
            cargarContenidoContratos();
            break;
        case 4:
            cargarContenidoTramites();
            break
        case 5:
            cargarContenidoHorarios();
            break;
        case 6:
            cargarContenidoReportes();
            break;
        case 7:
            cargarContenidoBD();
            break;
        default:
            cargarContenidoInicio();
    }

    $("#btnInicio").on('click', function () {
        repintarBotones();
        cargarContenidoInicio();
    });
    $("#btnSolicitudes").on('click', function () {
        repintarBotones();
        cargarContenidoSolicitudes();
    });
    $("#btnEmpleados").on('click', function () {
        repintarBotones();
        cargarContenidoEmpleados();
    });
    $("#btnContratos").on('click', function () {
        repintarBotones();
        cargarContenidoContratos();
    });
    $("#btnTramites").on('click', function () {
        repintarBotones();
        cargarContenidoTramites();
    });
    $("#btnHorarios").on('click', function () {
        repintarBotones();
        cargarContenidoHorarios();
    });
    $("#btnReportes").on('click', function () {
        repintarBotones();
        cargarContenidoReportes();
    });
    $("#btnBaseDatos").on('click', function () {
        repintarBotones();
        cargarContenidoBD();
    });
});