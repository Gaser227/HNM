function cargarModalOficio(valor,folio) {
    $.ajax({
        url: "./Plantillas/oficio.php",
        success: function (data) {
            $('#modal').html(data);
            $.getScript("./AJAX/solicitudes/scriptOficio.js");
            nomina = document.getElementById("idEmpleado").value;
            document.getElementById("modalO").style.display = "block";
            if(valor == 0){
                cargarDatosEmpleado();
                fechaActual();
            }else{
                obtenerDatosSolicitud(folio);
            }
        }
    });
}
function ocultarModalOficio(e) {
    document.getElementById("modalO").style.display = "none";
    e.preventDefault();
}

$(document).ready(function () {
    $('#btnAbrirModalO').one('click', function () {
        cargarModalOficio(0);
        obtenerFolio();
    });
    $('#btnCerrarModal').click(function (e) {
        ocultarModalOficio(e);
    });
});