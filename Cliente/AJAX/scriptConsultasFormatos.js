
var empleado;
var tabla;
function crearTabla() 
{
    $('#tabla').DataTable({
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

function llenarTabla(valores) {
    tabla = $("#tabla").DataTable();
    tabla.clear().draw();

    for (let i = 0; i < valores.length-1; i++) {
        var datos = valores[i].split('*')
        /*tabla.row.add([
            datos[1],
            datos[2],
            datos[3],
            datos[4],
            "<input title='Vizualizar' class='w3-btn w3-blue' type='button' value='&#9920' onclick=vizualizarTramite(" + datos[1] + "," + "'" + datos[2] + "'" + ")> <input title='Modificar' class='w3-btn w3-blue' type='button' value='&#9998' onclick=mostrarFormato(" + datos[1] + "," + "'" + datos[2] + "'" + ")> <input title='Eliminar' class='w3-btn w3-red' type='button' value='&#10006' onclick=eliminar(" + datos[0] + "," + "'" + datos[2] + "'" + ")>"
        ]).draw(false);*/
        tabla.row.add([
            datos[1],
            datos[2],
            datos[3],
            datos[4],
            "<input title='Vizualizar' class='w3-btn w3-blue' type='button' value='&#9920' onclick=vizualizarTramite(" + datos[1] + "," + "'" + datos[2] + "'" + ")> <input title='Modificar' class='w3-btn w3-blue' type='button' value='&#9998' onclick=mostrarFormato(" + datos[1] + "," + "'" + datos[2] + "'" + "," + "'" + datos[3] + "'" + ")> <input title='Eliminar' class='w3-btn w3-red' type='button' value='&#10006' onclick=eliminar(" + datos[0] + "," + "'" + datos[2] + "'" + "," + "'" + datos[3] + "'" + ")>",
            "<span style='display: none;'>" + datos[4] + "</span>" // Estado oculto
        ]).draw(false);
    }  
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


function obtenerDatos(idEmpleado) {
   /*  var urlSrc = "http://10.10.15.15/practicas/upemor/HNM/Servidor/PHP/consultarSolicitudes.php"; */
    var urlSrc = "../../Servidor/PHP/consultarSolicitudes.php";
    datos = "idEmpleado=" + idEmpleado + "&numFuncion=1";
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: datos
    }).done(function (res) {
        if(res != "Error"){
            valores = res.split("/");
            console.log(valores)
            llenarTabla(valores);
        }
    }).fail(function (res) {
        console.log(res);
    });
}
 
function mostrarFormato(folio,tipoSolicitud,estado)
{   
    console.log("folio: " + folio  + "tipo: " + tipoSolicitud)
    if (tipoSolicitud == "Entrada-Salida") {
        if(estado != "Pendiente"){
            //alert("No se puede eliminar");
            Swal.fire("No se puede editar");
        } else{
            cargarModalEntradaSalida(1,folio);
        }
    } else if (tipoSolicitud == "Licencia"){
        if(estado != "Pendiente"){
            //alert("No se puede eliminar");
            Swal.fire("No se puede editar");
        } else{
            cargarModalLicencia(1,folio);
        }
    }else if (tipoSolicitud == "Vacaciones"){
        if(estado != "Pendiente"){
            //alert("No se puede eliminar");
            Swal.fire("No se puede editar");
        } else{
            cargarModalVacaciones(1,folio);
        }
    }else if (tipoSolicitud == "Intercambio Jornada"){
        if(estado != "Pendiente"){
            //alert("No se puede eliminar");
            Swal.fire("No se puede editar");
        } else{
            cargarModalIntercambio(1,folio);
        }
    }else if (tipoSolicitud == "Suplencia"){
        if(estado != "Pendiente"){
            //alert("No se puede eliminar");
            Swal.fire("No se puede editar");
        } else{
            cargarModalSuplencia(1,folio);
        }
    }
}

function eliminar(id, tipoSolicitud, estado){
    if (tipoSolicitud == "Entrada-Salida") {
        /* $.getScript("./AJAX/solicitudes/scriptEntradaSalida.js"); */
        Swal.fire({
        title: '¿Estas seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
            if (result.isConfirmed) { 
                if(estado != "Pendiente"){
                    //alert("No se puede eliminar");
                    Swal.fire("No se puede eliminar");
                } else{
                    eliminarEntradaSalida(id);
                    limpiarTabla()
                    obtenerDatos($('#idEmpleado').val());
                }
            }
        }) 
    } else if(tipoSolicitud == "Licencia"){
        Swal.fire({
            title: '¿Estas seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, eliminar!'
            }).then((result) => {
                if (result.isConfirmed) { 
                    if(estado != "Pendiente"){
                        alert("No se puede eliminar");
                    } else{
                        eliminarLicencia(id);
                        limpiarTabla()
                        obtenerDatos($('#idEmpleado').val());
                    }
                }
            }) 
    }
    else if(tipoSolicitud == "Suplencia"){
        Swal.fire({
            title: '¿Estas seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, eliminar!'
            }).then((result) => {
                if (result.isConfirmed) { 
                    if(estado != "Pendiente"){
                        alert("No se puede eliminar");
                    } else{
                        eliminarSuplencia(id);
                        limpiarTabla()
                        obtenerDatos($('#idEmpleado').val());
                    }
                }
            }) 
    }
    else if(tipoSolicitud == "Vacaciones"){
        Swal.fire({
            title: '¿Estas seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, eliminar!'
            }).then((result) => {
                if (result.isConfirmed) { 
                    if(estado != "Pendiente"){
                        alert("No se puede eliminar");
                    } else{
                        eliminarVacaciones(id);
                        limpiarTabla()
                        obtenerDatos($('#idEmpleado').val());
                    }
                }
            }) 
    }
    else if(tipoSolicitud == "Intercambio Jornada"){
        Swal.fire({
            title: '¿Estas seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, eliminar!'
            }).then((result) => {
                if (result.isConfirmed) { 
                    if(estado != "Pendiente"){
                        alert("No se puede eliminar");
                    } else{
                        eliminarJornada(id);
                        limpiarTabla()
                        obtenerDatos($('#idEmpleado').val());
                    }
                }
            }) 
    }
}

function limpiarTabla() {
    tabla = $("#tabla").DataTable();
    tabla.clear().draw();
}

$(document).ready(function(){
    
    idEmpleado =  $('#idEmpleado').val();
    console.log("Id's");
    console.log(idEmpleado);
    if (idEmpleado != null) {
        crearTabla();
       obtenerDatos($('#idEmpleado').val());
    }
  
})