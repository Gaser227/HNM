var empleado;
var tablaSolicitudes;

function crearTablaTramites() {
    $('#tablaSolicitudes').DataTable({
        language: {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
        }
    });
}
function limpiarTabla() {
    tabla = $("#tablaSolicitudes").DataTable();
    tabla.clear().draw();
}
function llenarTablaTramites(valores) {
    
    tablaSolicitudes = $("#tablaSolicitudes").DataTable();
    limpiarTablaTramites();
    for (let i = 0; i < valores.length-1; i++) {
        var datos = valores[i].split('*')
        tablaSolicitudes.row.add([
            datos[1],
            datos[2],
            datos[3],
            datos[4],
            datos[5],
            "<input title='Vizualizar' class='w3-btn w3-blue' type='button' value='&#9920' onclick=vizualizarTramite(" + datos[1] + "," + "'" + datos[2] + "'" + ")> <input title='Aceptar' class='w3-btn w3-blue' type='button' value='&#9989' onclick=aceptarTramite(" + datos[1] + "," + "'" + datos[2] + "'" + ")> <input title='Denegar' class='w3-btn w3-blue' type='button' value='&#9932' onclick=denegarTramite(" + datos[1] + "," + "'" + datos[2] + "'" + ")>"//9998 9920
        ]).draw(false);
    }  
}


function obtenerDatosTramites(nomina) {
   /*  var urlSrc = "http://10.10.15.15/practicas/upemor/HNM/Servidor/PHP/consultarSolicitudes.php"; */
    var urlSrc = "../../Servidor/PHP/consultarSolicitudes.php";
    datos = "nomina=" + nomina + "&numFuncion=3";
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: datos
    }).done(function (res) {
        if(res != "Error"){
            valores = res.split("/");
           console.log(valores)
            llenarTablaTramites(valores);
        }
    }).fail(function (res) {
        console.log(res);
    });
}

function vizualizarTramite(folio,tipoSolicitud)
{   
    console.log("folio: " + folio  + "tipo: " + tipoSolicitud)
    alert(tipoSolicitud);
    if (tipoSolicitud == "Entrada-Salida") {
       /*  $.getScript("./AJAX/solicitudes/scriptEntradaSalida.js"); */
        cargarModalEntradaSalida(1,folio,1); 
    } else if (tipoSolicitud == "Licencia"){
        cargarModalLicencia(1,folio,1); 
    }else if (tipoSolicitud == "Vacaciones"){
        cargarModalVacaciones(1,folio,1);
    }else if (tipoSolicitud == "Intercambio Jornada"){
        alert("intercambio");
        cargarModalIntercambio(1,folio,1);
    }else if (tipoSolicitud == "Suplencia"){
        cargarModalSuplencia(1,folio,1);
    }
}

function aceptarTramite(folio){
    nomina = document.getElementById("inputNomina").value;
    var urlSrc = "../../Servidor/PHP/consultarSolicitudes.php";
    datos = "folio=" + folio + "&numFuncion=4";
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: datos
    }).done(function (res) {
        swal.fire(res);
        if(res == "La solicitud ha sido aceptada."){
            limpiarTabla();
            obtenerDatosTramites(nomina);
            nofificarEmpleado(folio, nomina,1);
        }
    }).fail(function (res) {
        console.log(res);
    });
}
function denegarTramite(folio){
    nomina = document.getElementById("inputNomina").value;
    var urlSrc = "../../Servidor/PHP/consultarSolicitudes.php";
    datos = "folio=" + folio + "&numFuncion=5";
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: datos
    }).done(function (res) {
        swal.fire(res);
        if(res == "La solicitud no ha sido aceptada."){
            limpiarTabla();
            obtenerDatosTramites(nomina);
            nofificarEmpleado(folio, nomina,2);
        }
    }).fail(function (res) {
        console.log(res);
    });
}

function nofificarEmpleado(folio, nomina, estado){
    var urlSrc = "../../Servidor/PHP/correos.php";
    var datos = "folio=" + folio + "&nomina=" + nomina + "&estado=" + estado + "&numFuncion=2";
        $.ajax({
            url: urlSrc,
            type: 'POST',
            data: datos
        }).done(function(res) {
            if (res == "Ocurrio un error") {
                alert("Ocurrio un error al notificar al jefe");
            } else{
                alert(res);
            }
        }).fail(function(res) {
            console.log(res);
        });
}

function limpiarTablaTramites() {
    tablaSolicitudes = $("#tablaSolicitudes").DataTable();
    tablaSolicitudes.clear().draw();
}

$(document).ready(function(){
    
    //Modificar para solo mostrar jefes
    /*
    Se llama a una funcion para que recoga las solicitudes donde se pidan la firma del jefe
    Se compara con el id del usuario
    Si son iguales, mostrara todas las solicitudes que tengan la misma id
    */    
    nomina = document.getElementById("inputNomina").value;
    //idEmpleado = 29;
    if (nomina != null) {
        crearTablaTramites();
        obtenerDatosTramites(nomina);
    }
  
})