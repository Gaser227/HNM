function cargarModalIntercambio(valor,folio,val) {
    $.ajax({
        url: "./Plantillas/intercambio.php",
        success: function (data) {
            $('#modal').html(data);
            $.getScript("./AJAX/solicitudes/scriptIntercambio.js");
            nomina = document.getElementById("idEmpleado").value;
            document.getElementById("modalIJ").style.display = "block";
            if(valor == 0){
                cargarDatosEmpleado();
                fechaActual();
                cargarSelectJefe(); 
                cargarJefe(null);
            }else{
                cargarSelectJefe(); 
                obtenerDatosSolicitudI(folio,val);
            }
        }
    });
}
function obtenerDatosSolicitudI(folio, val){
    var datos = "folio=" + folio + "&numFuncion=3";
    $.ajax({
        url: "../../Servidor/PHP/intercambio.php",
        type: "POST",
        data: datos,
    }).done(function(res){
        var datos = res.split('*');
        console.log("Carga");
        console.log(datos);
        console.log("Cargo");
        llenarFormatoI(datos, val);
        //cargarJefe(datos[7]);
    }).fail(function(res){
        console.log(res);
    });
}
function llenarFormatoI(datos, val){
    $('#folioES').text(datos[1]);
    $('#folio').val(datos[1]);
    /*for(var i; i<datos[22].length-1;i++){
        palabra=datos[22].substr("10,2");
    }*/
    $("#horaEntradaCubrir").val(hora +":"+ minutos); 
    var [hora,minutos] = dividirHora(datos[9])
    $("#fechaInicioL").val(hora +":"+ minutos); 
    $("#fechaFinalL").val(datos[10])
    $("#nominaSuplenteL").val(hora + ":" + minutos); 
    $("#nombreSuplenteL").val(datos[15]);
    $("#tipoSalida").val(hora + ":" + minutos); 
    fechaActual(true, datos[4]);
    cargarSelectAdscripcion(datos[20]);
    cargarJefe(datos[7]);
    obtenerHorario(datos[26],datos[22])
    $('#horario').val(datos[22]);
    $("#nomina").val(datos[24]);
    $("#nombre").val(datos[25]);
    $("#nombreHorarioEmp").val(datos[26]);
    $("#turno").val(datos[27]);
    $("#categoria").val(datos[29]);
    $("#adscripcion").val(datos[28]);
    $("#estatus").val(obtenerTipoContrato(datos[30]));
    $("#firmaEmpleado").text(datos[25]);
    if(val == 1){
        bloquearCamposI();
    }
}
function bloquearCamposI(){
    document.getElementById("tipoSolicitud").disabled  = true;
    document.getElementById("tipoEntrada").disabled = true;
    document.getElementById("tipoSalida").disabled = true;
    document.getElementById("horaEntradaSalida").readOnly = true;
    document.getElementById("asunto").r
}

function cargarJefe(valor){ //Funcion para cargar el jefe del empleado
    if(valor == null){ //Modificar
        var val = document.getElementById('adscripcion').value;
    }else{
        var val = valor;
    }
    if(isNaN(val)){//isNaN devuelve verdadero si el valor es una cadena o falso si el valor es numerico
        var datos = "adscripcion=" + val + "&numFuncion=15";
        $.ajax({
            url: "../../Servidor/PHP/" + "empleados.php",
            type: "POST",
            data: datos
        }).done(function (res) {
            var datos = res.split('/');
            var jef = "";
            for (var i = 0; i < datos.length-1; i++) {
                jef = datos[i].split("*")            
            } 
            $('#idJefe').val(jef[0]);
            $('#firmaJefe').text(jef[1]);
            $('#cargoJefe').text(jef[2]); 
            //alert(jef[0]);  
        }).fail(function (res) {
            console.log(res);
        })
    }else{
        var datos = "idJefe=" + val + "&numFuncion=17"
        $.ajax({
            url: "../../Servidor/PHP/" + "empleados.php",
            type: "POST",
            data: datos
        }).done(function (res) {
            var datos = res.split('/');
            var jef = "";
            for (var i = 0; i < datos.length-1; i++) {
                jef = datos[i].split("*")            
            } 
            $('#firmaJefe').text(jef[1]);
            $('#cargoJefe').text(jef[2]); 
            //alert(jef[0]);
            $('#idJefe').text(jef[0]);
        }).fail(function (res) {
            console.log(res);
        })
    }
}
function cargarSelectJefe()// funcion que carga en un select con todos los nombres de los que puede ir dirigido el tramite
{
    var datos = "numFuncion=11";
    $.ajax({
        url: "../../Servidor/PHP/" + "empleados.php",
        type: "POST",
        data: datos
    }).done(function (res) {
        var selectJefe = document.getElementById("selectJefe");
        var datos = res.split('/');
        //console.log(datos)
        for (var i = 0; i < datos.length-1; i++) {
            var jefe = datos[i].split("*")
            opcion = document.createElement('option');
            opcion.value = jefe[1];
            opcion.text = jefe[0];
            //console.log(i);
            //var valor;
            if(jefe[i] == valor && valor != null){
                opcion.selected = "yes";
            }
            selectJefe.appendChild(opcion);
        }
    }).fail(function (res) {
        console.log(res);
    })
}
function ocultarModalIntercambio(e) {
    document.getElementById("modalIJ").style.display = "none";
    e.preventDefault();
}
function obtenerSuplente(){
    nomina = $("#nominaSuplente").val();
    var urlSrc = "../../Servidor/PHP/empleados.php";
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: "id=" + nomina + "&numFuncion=21"
    }).done(function(res) {
        //alert(res);
        //console.log("DAT: " + res);
        datos = res.split("*");
        estatus = datos[3];
        if(estatus != 1){
            Swal.fire('Empleado no disponible');
        }else{
            obtenerAdscripcion(datos[5]);
            obtenerDatosCategoria(datos[6]);
            obtenerHorarios(datos[4]);
            llenarFormEmpleado(datos);   
        }
    }).fail(function(res) {
        console.log(res);
    });
}
function llenarFormEmpleado(datos) {
    console.log("Datos: " + datos);
    $("#nombreSuplente").val(datos[2]);
    estatus = datos[3];
    if(estatus == 1){
        $("#estatusSuplente").val("Disponible");
        $("#estatusVal").val(estatus);
    }else{
        $("#estatusSuplente").val("No disponible");
    }
}
function obtenerNombreSuplente(){
    nomina = $("#nominaSuplente").val();
    //datos = "id=" + nomina+ "&numFuncion=20";
    var urlSrc = "../../Servidor/PHP/empleados.php";
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: "id=" + nomina + "&numFuncion=20"
    }).done(function(res) {
        //alert(res);
        if(res == "Usuario no encontrado o no disponible"){
            alert(res);
        }else{
            var datos = res.split('/');
            var jef = "";
            for (var i = 0; i < datos.length-1; i++) {
                jef = datos[i].split("*")            
            } 
            $('#firmaSuplente').text(jef[1]);
            $('#cargoSuplente').text(jef[2]); 
            //alert(jef[0]);
            $('#idSuplente').text(jef[0]);
        }
    }).fail(function(res) {
        console.log(res);
    });
}
function obtenerHorarios(id){
    turno = $("#turno").val();
    var urlSrc = "../../Servidor/PHP/horarios.php";
    $.ajax({
        url: urlSrc, 
        type: "POST",
        data: "id=" + id + "&numFuncion=7"
    }).done(function(res) {
        console.log(res);
        if(turno == res){
            Swal.fire('Compartes mismo turno');
            borrarCampos();
        }else{
            $("#turnoSuplente").val(res);
        }
    }).fail(function(res) {
        console.log(res);
    });
}
function borrarCampos(){
    $("#nominaSuplente").val("");
    $("#estatusSuplente").val("");
    $("#nombreSuplente").val("");
    $("#adscripcionSuplente").val("");
    $("#categoriaSuplente").val("");
    $("#tipoPlazaSuplente").val("");
    $("#turnoSuplente").val("");
    $("#cambioGuardiaSuplente").val("");
}
function obtenerAdscripcion(id){
    $("#adscripcionVal").val(id);
    var urlSrc = "../../Servidor/PHP/empleados.php";
    $.ajax({
        url: urlSrc, 
        type: "POST",
        data: "id=" + id + "&numFuncion=22"
    }).done(function(res) {
        datos = res.split('*');
        $("#adscripcionSuplente").val(datos[1]);
    }).fail(function(res) {
        console.log(res);
    });
}
function obtenerDatosCategoria(valor){
    $("#categoriaVal").val(valor);
    var urlSrc = "../../Servidor/PHP/empleados.php";
    $.ajax({
        url: urlSrc, 
        type: "POST",
        data: "id=" + valor + "&numFuncion=23"
    }).done(function(res) {
        datos = res.split("%");
        categoria = datos[0].split("*");
        $("#categoriaSuplente").val(categoria[0]);
        contrato = datos[1].split("*");
        $("#tipoPlazaSuplente").val(contrato[1]);
        $("#plazaVal").val(contrato[0]);
        //$("#adscripcionSuplente").val(res);
    }).fail(function(res) {
        console.log(res);
    });
}
function compararFechas(){
    cambioGuardiaSuplente = $("#cambioGuardiaSuplente").val();
    //alert(fechaFin);
    var urlSrc = "../../Servidor/PHP/festividades.php";
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: "cambioGuardiaSuplente=" + cambioGuardiaSuplente + "&numFuncion=7"
    }).done(function(res) {
        //console.log(res);
        if(res == "Existen festividades durante tu intercambio."){
            alert(res);
            $("#cambioGuardiaSuplente").val("");
        }
    }).fail(function(res) {
        console.log(res);
    });
}
function cargarFirma(datosConfirmacion)//funcion que carga la firma del empleado
{
    alert("Entro"); 
    var datos = "nomina=" + datosConfirmacion[0] + "&password=" + datosConfirmacion[1] +"&numFuncion=7";
    $.ajax({
        url: "../../Servidor/PHP/" + "empleados.php",
        type: "POST",
        data: datos
    }).done(function (res) {
        if(res != "Error"){
            var image = new Image();
            var input = document.createElement("INPUT");
            var src = "../Cliente/Recursos/Imagenes/firma.png"; // cambiar firma.png por res
            image.src = src;
            image.width = 240;
            image.height = 100;
            image.id = "imgFirma";
            $('#divFirma').append(image);
            input.id = "idFirma";
            input.name = "idFirma";
            input.value=res;
            input.style="display:none";
            $('#divFirma').append(input); 
            guardarSolicitudIT();
        }else{
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Credenciales incorrectas',
                showConfirmButton: false,
                timer: 2000
            })
        }
    }).fail(function (res) {
        console.log(res);
    }); 
}
function guardarSolicitudIT() // funcion que guarda el formulario
{
    var formulario = document.getElementById('formularioIT');
    var datos = new FormData(formulario);
    datos.append("numFuncion",1);
    //console.log("Formulario",formulario);
    //console.log("Datos",datos);
    /* for (var pair of datos.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
    } */
    //alert("Los datos"); 
    //alert(datos);
       $.ajax({
          url: "../../Servidor/PHP/" + "intercambio.php",
          type: "POST",
          data: datos,
          processData: false, 
          contentType: false   
      }).done(function(res){
        swal.fire(res);
            console.log("Mensaje: " + res);
            tipoSolicitud = "Intercambio Jornada";
            idJefe = document.getElementById("idJefe").value;
            idEmpleado = document.getElementById("nomina").value;
            notificarJefeI(tipoSolicitud,idJefe,idEmpleado);
      }).fail(function(res){
          console.log(res);
      }); 
}
function notificarJefeI(tipoSolicitudd, idJefe, idEmpleado){
    var urlSrc = "../../Servidor/PHP/correos.php";
    var datos = "solicitud=" + tipoSolicitudd + "&idJefe=" + idJefe + "&idEmpleado=" + idEmpleado + "&numFuncion=1";
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
function eliminarJornada(id){
    datos = "id=" + id + "&numFuncion=4";
        $.ajax({
            url: "../../Servidor/PHP/intercambio.php",
            type: "POST",
            data: datos
        }).done(function (res) {
         
            Swal.fire(
                'Eliminado!',
                'La solicitud ha sido eliminada',
                'success'
            )
        }).fail(function (res) {
            console.log(res)
        }); 
}

$(document).ready(function () {
    $('#btnGuardarSolicitudIT').click(function (e) {
        //alert("Guardado");
        form = document.getElementById("formularioIT");
        form.addEventListener("submit", function (evt) {
            evt.preventDefault();
            swal.fire({
                title: 'Confirmar identidad',
                html:
                    '<input id="swal-input1" class="swal2-input" autofocus placeholder="Nómina">' +
                    '<input type ="password" id="swal-input2" class="swal2-input" placeholder="Contraseña">',
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        if (true) {
                            resolve([
                                document.getElementById('swal-input1').value,
                                document.getElementById('swal-input2').value
                            ]);
                        }
                    });
                }
            }).then(function (result) {
                var datos = [];
                for (let i = 0; i < result.value.length; i++) {
                    datos.push(result.value[i]);  
                }
                //alert(datos);
                cargarFirma(datos);
                ocultarModalIntercambio(e);  
            })
        }); 
    });

    $('#btnAbrirModalIJ').one('click', function () {
        cargarModalIntercambio(0);

        obtenerFolio();
    });
    $('#btnCerrarModal').click(function (e) {
        ocultarModalIntercambio(e);
    });
    $("#nominaSuplente").change(function(){
        obtenerSuplente();
        obtenerNombreSuplente();
    });
    $("#cambioGuardiaSuplente").change(function(){
        compararFechas();
    });
    const checkboxes = document.querySelectorAll('input[name="tipoPago"]');
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', function() {
            checkboxes.forEach((cb) => {
            if (cb !== this) {
                cb.checked = false;
            }
            });
        });
    });
});