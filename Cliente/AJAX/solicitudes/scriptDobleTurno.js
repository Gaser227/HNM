function cargarModalDobleTurno(valor,folio)
{
    $.ajax({
        url: "./Plantillas/dobleTurno.php",
        success: function (data) {
            $('#modal').html(data);
            $.getScript("./AJAX/solicitudes/scriptDobleTurno.js");
            nomina = document.getElementById("idEmpleado").value;
            document.getElementById("modalDT").style.display = "block";
            if(valor == 0){
                cargarDatosEmpleado();
                fechaActual();
            }else{
                obtenerDatosSolicitud(folio);
            }

        }
    });
}
function ocultarModalDobleTurno(e)
{
    document.getElementById("modalDT").style.display = "none";

    e.preventDefault();
}

$(document).ready(function(){
    $('#btnAbrirModalDT').one('click', function () {
        cargarModalDobleTurno(0);

        obtenerFolio();
    });
    $('#btnCerrarModal').click(function (e) {
        ocultarModalDobleTurno(e);
    });
});