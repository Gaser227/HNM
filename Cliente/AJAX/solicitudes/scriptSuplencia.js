function cargarModalSuplencia(valor,folio,val) {
    $.ajax({
        url: "./Plantillas/suplencia.php",
        success: function (data) {
            $('#modal').html(data);
            $.getScript("./AJAX/solicitudes/scriptSuplencia.js");
            nomina = document.getElementById("idEmpleado").value;
            document.getElementById("modalS").style.display = "block";
            if(valor == 0){
                cargarDatosEmpleado();
                fechaActual();
                cargarSelectJefe(); 
                cargarJefe(null);
            }else{
                cargarSelectJefe(); 
                obtenerDatosSolicitudS(folio,val);
            }
        }
    });
}
function obtenerDatosSolicitudS(folio, val){
    var datos = "folio=" + folio + "&numFuncion=3";
    $.ajax({
        url: "../../Servidor/PHP/suplencia.php",
        type: "POST",
        data: datos,
    }).done(function(res){
        var datos = res.split('*');
        llenarFormatoS(datos, val);
        //cargarJefe(datos[7]);
    }).fail(function(res){
        console.log(res);
    });
}
function llenarFormatoS(datos, val){
    console.log(datos);
    $('#folioS').text(datos[1]);
    $('#folio').val(datos[1]);
    /*for(var i; i<datos[22].length-1;i++){
        palabra=datos[22].substr("10,2");
    }*/
    $("#fechainicio").val(datos[8]); 
    $("#fechaFin").val(datos[9])
    $("#nominaSuplente").val(datos[11]); 
    $("#nombreSuplente").val(datos[10]);
    cargarSuplente(datos[11]);
    $("#motivo").val(datos[12]); 
    //alert(datos[12]);
    fechaActual(true, datos[4]);
    cargarSelectAdscripcion(datos[20]);
    cargarJefe(datos[7]);
    obtenerHorario(datos[15],datos[22]);
    $('#fechaCreacion').val(datos[4]);
    $('#horario').val(datos[22]);
    $("#nomina").val(datos[13]);
    $("#nombre").val(datos[14]);
    $("#nombreHorarioEmp").val(datos[15]);
    $("#turno").val(datos[16]);
    $("#categoria").val(datos[18]);
    $("#adscripcion").val(datos[17]);
    $("#estatus").val(obtenerTipoContrato(datos[19]));
    $("#firmaEmpleado").text(datos[14]);
    if(val == 1){
        bloquearCamposS();
    }
}
function bloquearCamposS(){
    document.getElementById('btnGuardarSolicitudSU').style.display = "none";
    document.getElementById("fechainicio").disabled  = true;
    document.getElementById("fechaFin").disabled = true;
    document.getElementById("motivo").disabled = true;
    document.getElementById("nominaSuplente").disabled = true;
    //document.getElementById("tipoSalida").readOnly = true;
}

function ocultarModalSuplencia(e) {
    document.getElementById("modalS").style.display = "none";

    e.preventDefault();
}

function obtenerNombreSuplenteS(){
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

function obtenerFechas(){
    fechaInicio = $("#fechainicio").val();
    fechaFin = $("#fechaFin").val();
    alert(fechaInicio);
    //alert(fechaFin);
    var urlSrc = "../../Servidor/PHP/festividades.php";
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: "fechaInicio=" + fechaInicio + "&fechaFin=" + fechaFin + "&numFuncion=5"
    }).done(function(res) {
        //console.log(res);
        if(res == "Existen festividades durante tus vacaciones."){
            alert(res);
            $("#fechainicio").val("");
            $("#fechaFin").val("")
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
            guardarSolicitudSU();
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
function guardarSolicitudSU() // funcion que guarda el formulario
{
    var formulario = document.getElementById('formularioSU');
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
          url: "../../Servidor/PHP/" + "suplencia.php",
          type: "POST",
          data: datos,
          processData: false, 
          contentType: false   
      }).done(function(res){
        swal.fire(res);
            console.log("Mensaje: " + res);
            tipoSolicitud = "Suplencia";
            idJefe = document.getElementById("idJefe").value;
            idEmpleado = document.getElementById("nomina").value;
            alert("id jefe: " + idJefe);
            notificarJefe(tipoSolicitud,idJefe,idEmpleado);
      }).fail(function(res){
          console.log(res);
      }); 
}
function cargarJefe(valor){ //Funcion para cargar el jefe del empleado
    if(valor == null){
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
function eliminarSuplencia(id){
    datos = "id=" + id + "&numFuncion=4";
        $.ajax({
            url: "../../Servidor/PHP/suplencia.php",
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

    $('#btnGuardarSolicitudSU').click(function (e) {
        //alert("Guardado");
        form = document.getElementById("formularioSU");
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
                ocultarModalSuplencia(e);  
            })
        }); 
    });

    $('#btnAbrirModalS').one('click', function () {
        cargarModalSuplencia(0);
        obtenerFolio();
    });
    $('#btnCerrarModal').click(function (e) {
        ocultarModalSuplencia(e);
    });
    $("#nominaSuplente").change(function(){
        obtenerNombreSuplenteS();
    });
    $("#fechaFin").change(function(){
        obtenerFechas();
    });
    $("cambioGuardiaSuplente").change(function(){
        compararFechas();
    });
    /*$("#fechainicio").change(function(){
        fechaInicio = $("#fechainicio").val();
       alert(fechaInicio);
    });*/
});