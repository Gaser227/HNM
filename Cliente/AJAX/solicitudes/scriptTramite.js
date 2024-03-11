function cargarModalTramite(valor,folio) {
    $.ajax({
        url: "./Plantillas/tramite.php",
        success: function (data) {
            $('#modal').html(data);
            $.getScript("./AJAX/solicitudes/scriptTramite.js");
            nomina = document.getElementById("idEmpleado").value;
            document.getElementById("modalST").style.display = "block";
            if(valor == 0){
                cargarDatosEmpleado();
                fechaActual();
            }else{
                obtenerDatosSolicitud(folio);
            }
        }
    });
}
function ocultarModalTramite(e) {
    document.getElementById("modalST").style.display = "none";

    e.preventDefault();
}

$(document).ready(function () {
    $('#btnAbrirModalST').one('click', function () {
        cargarModalTramite(0);

        obtenerFolio();
    });
    $('#btnCerrarModal').click(function (e) {
        ocultarModalTramite(e);
    });
});