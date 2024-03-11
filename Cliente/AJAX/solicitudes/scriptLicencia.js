/* var urlSrc = "http://10.10.15.15/practicas/upemor/HNM/Servidor/PHP/"; */
var urlSrc = "../../Servidor/PHP/";

function cargarModalLicencia(valor,folio,val) {
    $.ajax({
        async:false,
        url:"./Plantillas/licencia.php",
        success:function(data){
            $('#modal').html(data);
            $.getScript("./AJAX/solicitudes/scriptLicencia.js");
            nomina = document.getElementById("idEmpleado").value;
            document.getElementById("modalSL").style.display="block";
            if(valor == 0){
                cargarDatosEmpleado();
                fechaActual();
                cargarSelectJefe(); 
                cargarJefe(null);
            }else{
                cargarSelectJefe(); 
                obtenerDatosSolicitudL(folio,val);
            }
        }
    });
}
function obtenerDatosSolicitudL(folio, val){
    var datos = "folio=" + folio + "&numFuncion=3";
    $.ajax({
        url: "../../Servidor/PHP/licencia.php",
        type: "POST",
        data: datos,
    }).done(function(res){
        var datos = res.split('*');
        console.log("Carga");
        console.log(datos);
        console.log("Cargo");
        llenarFormatoL(datos, val);
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
function llenarFormatoL(datos, val){
    $('#folioS').text(datos[1]);
    $('#folio').val(datos[1]);
    /*for(var i; i<datos[22].length-1;i++){
        palabra=datos[22].substr("10,2");
    }*/
    if(datos[8] == 1){ 
        $("#ConGoceSueldo").prop("checked", true); 
    } else if (datos[8] == 2){
        $("#SinGoceSueldo").prop("checked", true); 
    }
    $("#fechaInicioL").val(datos[13]); 
    $("#fechaFinalL").val(datos[14]);
    $("#totalDiasL").val(datos[15])
    $("#nominaSuplenteL").val(datos[10]); 
    $("#nombreSuplenteL").val(datos[9]);
    cargarSuplente(datos[10]);
    $("#tipoSalida").val(datos[12]); 
    //alert(datos[12]);
    fechaActual(true, datos[4]);
    cargarSelectAdscripcion(datos[20]);
    cargarJefe(datos[7]);
    obtenerHorario(datos[18],datos[22]);
    $('#fechaCreacion').val(datos[4]);
    $('#horario').val(datos[22]);
    $("#nomina").val(datos[17]);
    $("#nombre").val(datos[16]);
    $("#nombreHorarioEmp").val(datos[15]);
    $("#turno").val(datos[19]);
    $("#categoria").val(datos[21]);
    $("#adscripcion").val(datos[20]);
    $("#estatus").val(obtenerTipoContrato(datos[22]));
    $("#firmaEmpleado").text(datos[17]);
    if(val == 1){
        bloquearCamposL();
    }
}
function bloquearCamposL(){
    document.getElementById('btnGuardarSolicitudL').style.display = "none";
    document.getElementById("fechaInicioL").disabled  = true;
    document.getElementById("fechaFinalL").disabled = true;
    document.getElementById("tipoSalida").disabled = true;
    document.getElementById("nominaSuplenteL").disabled = true;
    document.getElementById("tipoSalida").readOnly = true;
    document.getElementById("ConGoceSueldo").disabled = true;
    document.getElementById("SinGoceSueldo").disabled = true;
}

function eliminarLicencia(id){
    datos = "id=" + id + "&numFuncion=4";
        $.ajax({
            url: "../../Servidor/PHP/licencia.php",
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

function ocultarModalLicencia(e) {
    document.getElementById("modalSL").style.display = "none";

    e.preventDefault();
}
function obtenerFechas(){
    fechaInicio = $("#fechaInicioL").val();
    fechaFin = $("#fechaFinalL").val();
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
        } else{
            // Convertir las fechas a objetos Date
            var date1 = new Date(fechaInicio);
            var date2 = new Date(fechaFin);
            // Restar las fechas en milisegundos y convertir a días
            var diferenciaEnMilisegundos = date2 - date1; 
            var diferenciaEnDias = Math.floor(diferenciaEnMilisegundos / (1000 * 60 * 60 * 24));
            $("#totalDiasL").val(diferenciaEnDias)
        }
    }).fail(function(res) {
        console.log(res);
    });
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
function obtenerNombreSuplente(){
    nomina = $("#nominaSuplenteL").val();
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
            $("#nombreSuplenteL").val("");
            $("#nominaSuplenteL").val("")
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
            $("#nombreSuplenteL").val(jef[1]);
        }
    }).fail(function(res) {
        console.log(res);
    });
}
/*function cargarSuplente(val){ //Funcion para cargar el jefe del empleado
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
            $('#firmaSuplente').text(jef[1]);
            $('#cargoSuplente').text(jef[2]); 
            //alert(jef[0]);
            $('#idSuplente').text(jef[0]);
        }).fail(function (res) {
            console.log(res);
        })
}*/
function guardarSolicitudL() // funcion que guarda el formulario
{
    var formulario = document.getElementById('formularioL');
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
          url: "../../Servidor/PHP/" + "licencia.php",
          type: "POST",
          data: datos,
          processData: false, 
          contentType: false   
      }).done(function(res){
        alert(res);
            console.log("Mensaje: " + res);
            tipoSolicitud = "Licencia";
            idJefe = document.getElementById("idJefe").value;
            idEmpleado = document.getElementById("nomina").value;
            notificarJefe(tipoSolicitud,idJefe,idEmpleado);
      }).fail(function(res){
          console.log(res);
      }); 
}

function cargarFirma(datosConfirmacion)//funcion que carga la firma del empleado
{
    //alert("Entro"); 
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
            guardarSolicitudL();
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
function comprobarSolicitudes(){
    id = $("#idEmpleado").val();
    var datos = "idEmpleado=" + id + "&numFuncion=6"
    $.ajax({
        url: "../../Servidor/PHP/" + "licencia.php",
        type: "POST",
        data: datos  
    }).done(function(res){
        console.log(res);
        if(res == "El empleado ha realizado 3 o más solicitudes"){
            alert(res);
            document.getElementById('btnGuardarSolicitudL').style.display = "none";
            /*var boton = document.getElementById('btnGuardarSolicitud');
            boton.disabled = true;*/
        }else{
            alert(res);
        }
    }).fail(function(res){
        console.log(res);
    });  
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
$(document).ready(function () {

    $('#btnGuardarSolicitudL').click(function (e) {
            form = document.getElementById("formularioL");
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
    $('#btnAbrirModalSL').one('click', function () {
        //if()
        cargarModalLicencia(0);
        obtenerFolio();
        comprobarSolicitudes();
    });
    $('#btnCerrarModal').click(function (e) {
        ocultarModalLicencia(e);
    });
    $('#fechaFinalL').change(function() {
        obtenerFechas();
    });
    $("#nominaSuplenteL").change(function(){
        obtenerNombreSuplente();
    });

    const checkboxes = document.querySelectorAll('input[name="sueldo"]');
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
