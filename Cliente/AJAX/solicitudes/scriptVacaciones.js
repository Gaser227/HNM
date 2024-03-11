var diasLaborales = new Set();
function cargarModalVacaciones(valor, folio,val) {
    $.ajax({
        async: false,
        url: "./Plantillas/vacaciones.php",
        success: function(data) {
            $('#modal').html(data);
            $.getScript("./AJAX/solicitudes/scriptVacaciones.js");
            nomina = document.getElementById("idEmpleado").value;
            document.getElementById("modalV").style.display = "block";
            if (valor == 0) {
                cargarDatosEmpleado();
                fechaActual();
                cargarSelectJefe(); 
                cargarJefe(null);
            } else {
                cargarSelectJefe();
                obtenerDatosSolicitudV(folio,val);
            }
        }
    });
}
function obtenerDatosSolicitudV(folio, val){
    var datos = "folio=" + folio + "&numFuncion=3";
    $.ajax({
        url: "../../Servidor/PHP/vacaciones.php",
        type: "POST",
        data: datos,
    }).done(function(res){
        var datos = res.split('*');
        console.log("Carga");
        console.log(datos);
        console.log("Cargo");
        llenarFormatoV(datos, val);
        //cargarJefe(datos[7]);
    }).fail(function(res){
        console.log(res);
    });
}
function cargarSuplente(val){ //Funcion para cargar el jefe del empleado
    var datos = "idSuplente=" + val + "&numFuncion=24"
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
        $('#firmaSuplente').text(jef[1]);
        $('#cargoSuplente').text(jef[2]); 
        //alert(jef[0]);
        $('#idSuplente').text(jef[0]);
    }).fail(function (res) {
        console.log(res);
    })
}
function llenarFormatoV(datos, val){
    $('#folioS').text(datos[1]);
    $('#folio').val(datos[1]);
    /*for(var i; i<datos[22].length-1;i++){
        palabra=datos[22].substr("10,2");
    }*/
    $("#diasDisfrutar").val(datos[8]);
    $("#nominaSuplente").val(datos[13]); 
    $("#nombreSuplente").val(datos[12]);
    cargarSuplente(datos[13]);
    $("#fechaInicio").val(datos[9]); 
    $("#reinicioLabores").val(datos[10]);
    $("#fechaFin").val(datos[15]);
    $("#diasPendientes").val(datos[11]);
    $("#observaciones").val(datos[14]); 
    //alert(datos[12]);
    cargarJefe(datos[7]);
    obtenerHorario(datos[18],datos[22]);
    $('#fechaCreacion').val(datos[4]);
    $('#horario').val(datos[22]);
    $("#nomina").val(datos[16]);
    $("#nombre").val(datos[17]);
    $("#nombreHorarioEmp").val(datos[18]);
    $("#turno").val(datos[19]);
    $("#categoria").val(datos[21]);
    $("#adscripcion").val(datos[20]);
    $("#estatus").val(obtenerTipoContrato(datos[22]));
    $("#firmaEmpleado").text(datos[17]);
    fechaActual(true, datos[4]);
    if(val == 1){
        bloquearCamposV();
    }
}
function bloquearCamposV(){
    document.getElementById("diasDisfrutar").readonly  = true;
    document.getElementById("nominaSuplente").disabled = true;
    document.getElementById("fechaInicio").disabled = true;
    document.getElementById("reinicioLabores").disabled = true;
    document.getElementById("fechaFin").disabled = true;
    document.getElementById("diasPendientes").disabled = true;
    document.getElementById("observaciones").disabled = true;
    document.getElementById('btnGuardarSolicitudVA').style.display = "none";
    
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
            //aqui  
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
function ocultarModalVacaciones(e) {
    document.getElementById("modalV").style.display = "none";
    e.preventDefault();
}

function cargarFirma(datosConfirmacion) //funcion que carga la firma del empleado
{
    var datos = "nomina=" + datosConfirmacion[0] + "&password=" + datosConfirmacion[1] + "&numFuncion=7";

    $.ajax({
        url: "../../Servidor/PHP/" + "empleados.php",
        type: "POST",
        data: datos
    }).done(function(res) {

        if (res != "Error") {
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
            input.value = res;
            input.style = "display:none";
            $('#divFirma').append(input);
            guardarSolicitudVacaciones();
        } else {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Credenciales incorrectas',
                showConfirmButton: false,
                timer: 2000
            })
        }
    }).fail(function(res) {
        console.log(res);
    });

}

function guardarSolicitudVacaciones() // funcion que guarda el formulario
{
    var formulario = document.getElementById('formularioVA');
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
          url: "../../Servidor/PHP/" + "vacaciones.php",
          type: "POST",
          data: datos,
          processData: false, 
          contentType: false   
      }).done(function(res){
        alert(res);
            tipoSolicitud = "Vacaciones";
            idJefe = document.getElementById("idJefe").value;
            idEmpleado = document.getElementById("nomina").value;
            notificarJefe(tipoSolicitud,idJefe,idEmpleado);
      }).fail(function(res){
          console.log(res);
      }); 
}

function notificarJefe(tipoSolicitudd, idJefe, idEmpleado){
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

function obtenerDiasLaborales(diasLaborales) {
    var max = datosHorario.length;
    console.log(datosHorario)
    var cadenaDias = "";
    for (i = 0; i < max; i++) {
        for (j = 0; j < 3; j++) {
            cadenaDias += datosHorario[i][0];
        }
    }
    max = cadenaDias.length / 2;
    j = 0;
    i = 2;
    n = 0;
    while (n < max) {
        diasLaborales.add(cadenaDias.substring(j, i))
        n += 1;
        j += 2;
        i += 2;
    }
    asignarNombreDias(diasLaborales);
    return diasLaborales;

}
function asignarNombreDias(diasLaborales) {
    iterator = diasLaborales.values();
    while (valor = iterator.next().value) {
        switch (valor) {
            case "Lu":
                diasLaborales.delete(valor);
                diasLaborales.add("Lunes");
                break;
            case "Ma":
                diasLaborales.delete(valor);
                diasLaborales.add("Martes");
                break;
            case "Mi":
                diasLaborales.delete(valor);
                diasLaborales.add("Miércoles");
                break;
            case "Ju":
                diasLaborales.delete(valor);
                diasLaborales.add("Jueves");
                break;
            case "Vi":
                diasLaborales.delete(valor);
                diasLaborales.add("Viernes");
                break;
            case "Sa":
                diasLaborales.delete(valor);
                diasLaborales.add("Sábado");
                break;
            case "Do":
                diasLaborales.delete(valor);
                diasLaborales.add("Domingo");
                break;
            default:
                break;
        }
    }
}
function obtenerDiasFestivos(festivos) {

    datos = "numFuncion=6";
    $.ajax({
        url: "../../Servidor/PHP/" + "vacaciones.php",
        type: "POST",
        data: datos
    }).done(function(res) {
        fechas = res.split('*');
        for (let i = 0; i < fechas.length - 1; i++) {
            fecha = new Date(moment(fechas[i]).format('YYYY/MM/DD'));
            let mes = fecha.getMonth();
            let dia = fecha.getDate();
            festivos[mes].push(dia);
        }
        return festivos;
    }).fail(function(res) {

    });
}

function calcularReinicioLabores(diasLaborales) {
    /*var festivos = [
        [],
        [],
        [],
        [],
        [],
        [],
        [],
        [],
        [],
        [],
        [],
        []
    ];
    obtenerDiasFestivos(festivos);
    var fechaFinal = new Date(fechaInicio);
    //var diasDisfrutar = $("#diasDisfrutar").val();
    i = 0;
    while (i <= diasDisfrutar) {
        let festivo = false;
        fechaFinal.setTime(fechaFinal.getTime() + 24 * 60 * 60 * 1000);
        diaSemana = nombreDelDiaSegunFecha(fechaFinal)
        console.log(diaSemana)
        if (diasLaborales.has(diaSemana)) {
            let mes = fechaFinal.getMonth();
            let dia = fechaFinal.getDate();
            console.log("mes: "+ mes);
            console.log("dia: "+ dia);
            for (let df in festivos[mes]) {
                console.log("-------------");
                console.log("dia: "+ dia + "dia Festivo:" + festivos[mes][df]);
                if (dia == festivos[mes][df]) {
                    festivo = true;
                    break;
                }
            }
            if (!festivo) {
                i++;
            }
        }
        i++;
    }*/
    var fechaInicio = $("#fechaInicio").val();
    var fechaFin = $("#fechaFin").val();
    var date1 = new Date(fechaInicio);
    var date2 = new Date(fechaFin);
    fechaFinal = $("#fechaFin").val();
    var diferenciaEnMilisegundos = date2.getTime() - date1.getTime();
    // Convertir la diferencia en días
    var diferenciaEnDias = Math.floor(diferenciaEnMilisegundos / (1000 * 60 * 60 * 24));
    document.getElementById("diasDisfrutar").value = diferenciaEnDias;
    date2.setDate(date2.getDate() + 1);
    var nuevaFecha = date2.toISOString().split('T')[0];
    //alert(nuevaFecha);
    /*date2.setTime(date2.getTime() + (24 * 60 * 60 * 1000)); // Agregar un día adicional
    //document.getElementById("fechaFin").value = moment(fechaFinal).format('YYYY-MM-DD');
    date2.setTime(date2.getTime() + (24 * 60 * 60 * 1000)); // Agregar un día adicional*/
    document.getElementById("reinicioLabores").value = nuevaFecha;
}

function calcularFestividades(){
    fechaInicio = $("#fechaInicio").val();
    fechaFin = $("#fechaFin").val();
    reinicioLabores = $("#reinicioLabores").val();
    //alert("Fecha fin : " + fechaFin);
    //alert(fechaInicio);
    console.log(fechaInicio);
    //alert(fechaFin);
    console.log(fechaFin);
    //alert(reinicioLabores);
    var urlSrc = "../../Servidor/PHP/festividades.php";
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: "fechaInicio=" + fechaInicio + "&fechaFin=" + fechaFin + "&reinicioLabores=" + reinicioLabores +"&numFuncion=6"
    }).done(function(res) {
        //alert(res);
        console.log(res);
        /*if(res == "Usuario no encontrado o no disponible"){
            $("#nombreSuplente").val("");
            $("#nominaSuplente").val("")
        }else{
            $("#nombreSuplente").val(res);
        }*/
    }).fail(function(res) {
        console.log(res);
    });
}

function nombreDelDiaSegunFecha(fecha) {
    return [
        'Domingo',
        'Lunes',
        'Martes',
        'Miércoles',
        'Jueves',
        'Viernes',
        'Sábado',
        'Domingo',
    ][new Date(fecha).getDay()];
}
//funcion que calcula el numero de dias disponibles a disfrutar segun los dias laborales del empleado
function calcularDiasVacaciones(diasLaborales){
    var maxDias = diasLaborales.size;
    if(maxDias >= 5){
        return totalDias = 10;
    }else if(maxDias == 2){
        return totalDias = 5;
    }else{
        return totalDias = 6;
    }
}

function calcularDiasPendientes(diasLaborales){
    totalDias = calcularDiasVacaciones(diasLaborales);
    diasDisfrutar = $("#diasDisfrutar").val();
    if(diasDisfrutar  <= totalDias){
        $("#diasPendientes").val(totalDias - diasDisfrutar);
    }else{
        Swal.fire('Tu total de dias permitidos son: ' + totalDias);
        $("#diasDisfrutar").val(null);
        $("#diasPendientes").val(null);    
    }
}
/*
function obtenerNombreSuplente(){
    nomina = $("#nominaSuplente").val();
    datos = "nomina=" + nomina+ "&numFuncion=8";
    $.ajax({
        url: "../../Servidor/PHP/" + "empleados.php",
        type: "POST",
        data: datos
    }).done(function(res){ 
        //console.log(res);
        datos = res.split("*")
        //alert(datos[3]);
        $("#nombreSuplente").val(datos[2]);
    }).fail(function(res){
        console.log(res)

    });
}
*/
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
            $("#nombreSuplente").val("");
            $("#nominaSuplente").val("")
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
            $("#nombreSuplente").val(jef[1]);
        }
    }).fail(function(res) {
        console.log(res);
    });
}

function eliminarVacaciones(id){
    datos = "id=" + id + "&numFuncion=4";
        $.ajax({
            url: "../../Servidor/PHP/vacaciones.php",
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

$(document).ready(function() {
    $('#btnAbrirModalSV').one('click', function() {
        cargarModalVacaciones(0);
        obtenerFolio();
        

    });
    $('#btnCerrarModal').click(function(e) {
        ocultarModalVacaciones(e);
    });

$('#btnGuardarSolicitudVA').click(function(e) {
        form = document.getElementById("formularioVA");
        form.addEventListener("submit", function(evt) {
            evt.preventDefault();
            swal.fire({
                title: 'Confirmar identidad',
                html: '<input id="swal-input1" class="swal2-input" autofocus placeholder="Nómina">' +
                    '<input type ="password" id="swal-input2" class="swal2-input" placeholder="Contraseña">',
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        if (true) {
                            resolve([
                                document.getElementById('swal-input1').value,
                                document.getElementById('swal-input2').value
                            ]);
                        }
                    });
                }
            }).then(function(result) {
                var datos = [];
                for (let i = 0; i < result.value.length; i++) {
                    datos.push(result.value[i]);
                }
                cargarFirma(datos);
                ocultarModalVacaciones(e);
            })
        });
    });
    $('#selectDias').change(function() {
        var selectDias = document.getElementById('selectDias');
        var horario = document.getElementById('horario');
        for (let i = 0; i < datosHorario.length; i++) {
            if (datosHorario[i][0] == selectDias.value) {
                horario.value = datosHorario[i][1] + " a " + datosHorario[i][2];
            }
        }
    });
    $('#btnEditarFecha').click(function() {
        document.getElementById('modalCambiarFecha').style.display = "block";
    });
    $('#btnCerrarCambiarFecha').click(function() {
        document.getElementById("modalCambiarFecha").style = "display:none";
        fechaActual(true, document.getElementById('nuevaFecha').value);
    });
    /*$('#fechaInicio').change(function() {
        calcularReinicioLabores(diasLaborales);
        calcularFestividades();
    });*/
    $('#fechaFin').change(function() {
        calcularReinicioLabores(diasLaborales);
        calcularFestividades();
    });
    $('#diasDisfrutar').change(function(){ 
        obtenerDiasLaborales(diasLaborales);
        iterator = diasLaborales.values();
        while (valor = iterator.next().value) {
            console.log(valor)  
        }
        calcularDiasPendientes(diasLaborales);
    });
    $("#nominaSuplente").change(function(){
        obtenerNombreSuplente();
    });
        

});