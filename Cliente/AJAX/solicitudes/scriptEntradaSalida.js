/* var name = JSON.parse(localStorage.getItem("username")); */
/* var tipoContrato; */
/* var folio; */
/* var bandera = false; */
var fecha;
var nomina;
/* var urlSrc = "http://10.10.15.15/practicas/upemor/HNM/Servidor/PHP/"; */
//var urlSrc = "http://10.10.15.15/practicas/upemor/HNM/Servidor/PHP/";

var datosAdscripcion = [];
// recibe un valor entre 0 y 1. 0 = para saber si se va a crear la solicitud
//                              1 = para saber si se vaa modificar la funcion 
function cargarModalEntradaSalida(valor,folio,val)// función para mostrar formulario 
{ 
    $.ajax({
        async:false,
        url:"./Plantillas/entradaSalida.php",
        success:function(data){
            
            $.getScript("./AJAX/solicitudes/scriptEntradaSalida.js");
            $('#modal').html(data);
           
            nomina = document.getElementById("idEmpleado").value;
            document.getElementById("modalES").style.display="block";
            if(valor == 0){

                // cargar los datos del empleado y tambien parte de los datos mostrados en ka seccion solicitud
                    cargarDatosEmpleado();
                    fechaActual();
                    cargarSelectAdscripcion();
                    cargarSelectJefe(); 
                    mostrarCheckBox(null);
                    cargarSelectTipoSalida();
                    cargarJefe(null);

                
            }else{
                //Vizualizar
                cargarSelectJefe();
                obtenerDatosSolicitudES(folio,val);
            }
        }
    }); 
}

function bloquearCampos(){
    document.getElementById("tipoSolicitud").disabled  = true;
    document.getElementById("tipoEntrada").disabled = true;
    document.getElementById("tipoSalida").disabled = true;
    document.getElementById("horaEntradaSalida").readOnly = true;
    document.getElementById("asunto").readOnly = true;
    document.getElementById('btnGuardarSolicitudES').style.display = "none";
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


function ocultarModalEntradaSalida(e)// funcion  para ocultar el modal entrada salida
{
  
    document.getElementById("modalES").style.display="none";
    
    e.preventDefault();
    
}
function cargarSelectTipoSalida()// funcion para agregar una opcion más al select para seleccionar un tipo de 
{ // esta funcion define si se agrega la opcion salida por acuerdo sindical
   
    tipoContrato = ($("#tipoContrato").val()).toLowerCase();
    //alert(tipoContrato)
    selectTipoSalida = document.getElementById("tipoSalida");
    if (tipoContrato == "E" || tipoContrato == "sb") { 
        opcion = document.createElement('option');
        opcion.value = "acuerdo sindical";
        opcion.text = "Por Acuerdo Sindical";
        selectTipoSalida.add(opcion);
        opcion = document.createElement('option');
        opcion.value = "medica";
        opcion.text = "Medica";
        selectTipoSalida.add(opcion);
        opcion = document.createElement('option');
        opcion.value = "reposicion de tiempo";
        opcion.text = "Por Reposicion de Tiempo";
        selectTipoSalida.add(opcion);
    }
}
function mostrarHoraES()// empleado base o suplente se añaden campos de Hora de Entrada y hora de Salida 
{ 
    tipoContrato = tipoContrato.toLowerCase();
    if (tipoContrato == "b" || tipoContrato == "e") {
        document.getElementById("hora1").style.display="block";
        document.getElementById("hora2").style.display="block";
        document.getElementById("hora1").required;
        document.getElementById("hora2").required;
    }
}
function mostrarCheckBox(valor)// empleado base o suplente se añaden campos de Hora de Entrada y hora de Salida 
{
    if(valor == null){
        tipoContrato = ($("#tipoContrato").val()).toLowerCase();
        estatus = ($("#estatus").val()).toLowerCase();
        if (tipoContrato == "rl") {
            $('#regimenLey').prop("disabled",false);
            $('#cambioPorOficio').prop("disabled",false);
            $('#eventualBase').prop("disabled",true);
            $('#check1').prop("style","display:none"); // eventual/base
        /*   $('#check2').prop("style","display:none"); */ // cambioPorOficio
            $('#departamento').prop('required', false);
        
            $('#eventualBase').prop("style",true);
        }else if(tipoContrato == 'c'){
            $('#regimenLey').prop("disabled", true);
            $('#cambioPorOficio').prop("disabled", false);
            $('#eventualBase').prop("disabled", true);
        
            $('#check1').prop("style", "display:none");
            $('#check3').prop("style", "display:none");
            $('#departamento').prop('disabled', false);
            $('#departamento').prop('required', false);
            $('#divDepartamento').prop('display', "style:none");
        }else if(tipoContrato == 'bs'){
            $('#regimenLey').prop("disabled", true);
            $('#cambioPorOficio').prop("disabled", false);
            $('#eventualBase').prop("disabled", false);
            $('#check3').prop("style", "display:none");

        }else if(tipoContrato == "e"){
            $('#regimenLey').prop("disabled", false);
            $('#cambioPorOficio').prop("disabled", false);
            $('#eventualBase').prop("disabled", false);
            $('#check1').prop("style", "display:none");
            $('#check2').prop("style", "display:none");
            $('#check3').prop("style", "display:none");
            $('#horaEntradaCubrir').prop('disabled', false);
            $('#horaSalidaCubrir').prop('disabled', false);
            $('#departamento').prop('disabled', false);
            $('#divDepartamento').prop('style', "display:block");
            $('#divDatosCubrir').prop('style', "display: block");
        }    
    }else{
        valor = valor.toLowerCase();    
        if (valor == "rl") {
            $('#regimenLey').prop("disabled",false);
            $('#cambioPorOficio').prop("disabled",false);
            $('#eventualBase').prop("disabled",true);
            $('#check1').prop("style","display:none"); // eventual/base
        /*   $('#check2').prop("style","display:none"); */ // cambioPorOficio
            $('#departamento').prop('required', false);
            $('#eventualBase').prop("style",true);
                //return valor;
        }else if(valor == 'c'){
                $('#regimenLey').prop("disabled", true);
                $('#cambioPorOficio').prop("disabled", false);
                $('#eventualBase').prop("disabled", true);
            
                $('#check1').prop("style", "display:none");
                $('#check3').prop("style", "display:none");
                $('#departamento').prop('disabled', false);
                $('#departamento').prop('required', false);
                $('#divDepartamento').prop('display', "style:none");
                //return valor;
        }else if(valor == 'bs'){
                $('#regimenLey').prop("disabled", true);
                $('#cambioPorOficio').prop("disabled", false);
                $('#eventualBase').prop("disabled", false);
                $('#check3').prop("style", "display:none");
                //return valor;
        }else if(valor == "e"){
                $('#regimenLey').prop("disabled", false);
                $('#cambioPorOficio').prop("disabled", false);
                $('#eventualBase').prop("disabled", false);
                $('#check1').prop("style", "display:none");
                $('#check2').prop("style", "display:none");
                $('#check3').prop("style", "display:none");
                $('#horaEntradaCubrir').prop('disabled', false);
                $('#horaSalidaCubrir').prop('disabled', false);
                $('#departamento').prop('disabled', false);
                $('#divDepartamento').prop('style', "display:block");
                $('#divDatosCubrir').prop('style', "display: block");
                //return valor;
        }
    }
}
function diferenciaHora(valor1, valor2) // funcion que hace la operacion "diferencia" ente dos horas
{
    diff = (new Date("1970-1-1 " + valor1) - new Date("1970-1-1 " + valor2));
    diff = moment('2000-01-01 00:00').add(moment.duration(diff)).format('HH:mm');
    return diff;
}
function obtenerHoraEntradaSalida(){
    if ($("#horaEntradaCubrir").val() == "" &&  $("#horaSalidaCubrir").val() == ""){
        horario = document.getElementById("horario").value;
        //alert(horario);
        separarHorario = horario.split(' ');
        horaEntrada = separarHorario[0];
        horaSalida = separarHorario[2];
    }else{
        /*separarHorario = horario.split(' ');
        horaEntrada = separarHorario[0];
        horaSalida = separarHorario[2];
        alert(horaEntrada);
        alert(horaSalida);*/
        horaEntrada = $("#horaEntradaCubrir").val();
        horaSalida = $("#horaSalidaCubrir").val();
    }
    return [horaEntrada,horaSalida];
}
function calcularTiempoTotal()// funcion que calcula el tiempop total dependiendo si es un pase de entrada, salida o intermedio
{   
    tipoContrato = ($("#tipoContrato").val()).toLowerCase();
    var selectSalida = (document.getElementById('tipoSalida').value).toLowerCase();
    selectTipo = (document.getElementById('tipoSolicitud').value).toLowerCase();
    horaRegreso = document.getElementById("horaRegreso").value;
    horaEntradaSalida = document.getElementById('horaEntradaSalida').value;
    var [horaEntrada, horaSalida] = obtenerHoraEntradaSalida()
    if (selectTipo == 'entrada' && horaEntrada != "" && horaEntradaSalida != ""){ 
        if(horaEntradaSalida > horaSalida) {
            //alert(horaEntradaSalida);
            $("#horaEntradaSalida").val(null);
            $("#totalTiempo").val(null);
            $("#horasTrabajadas").val(null);
            Swal.fire('La hora de entrada no debe ser mayor a la salida');
            //alert(horaSalida);
        }else  
            document.getElementById('totalTiempo').value = diferenciaHora(horaEntradaSalida, horaEntrada);
     /*    if (horaEntradaSalida > horaEntrada  ) {
            document.getElementById('totalTiempo').value = diferenciaHora(horaEntradaSalida, horaEntrada);
        } else {
            $("#horaEntradaSalida").val(null);
            Swal.fire('La hora de entrada/salida debe ser mayor a la hora de entrada');
        } */
    } else if (selectTipo == 'salida' && horaSalida != "" && horaEntradaSalida != ""){
        if (horaEntradaSalida < horaSalida) {
            document.getElementById('totalTiempo').value = diferenciaHora(horaSalida, horaEntradaSalida);
            if(document.getElementById('totalTiempo').value >= "03:00" && tipoContrato == "bs"){
            //if(document.getElementById('horasTrabajadas').value < "02:00" && tipoContrato == "bs"){
            //alert(document.getElementById('totalTiempo').value);
            //alert(document.getElementById('totalTiempo').value);
            //alert("Entro");
            $("#horaEntradaSalida").val(null);
            $("#totalTiempo").val(null);
            $("#horasTrabajadas").val(null);
            Swal.fire('La hora de entrada/salida debe ser menor a 3 horas');
            }
        } else {
            $("#horaEntradaSalida").val(null);
            $("#totalTiempo").val(null);
            $("#horasTrabajadas").val(null);
            Swal.fire('La hora de entrada/salida debe ser menor a la hora de salida');
        }
        
    }else if (selectTipo == 'intermedio' && horaRegreso != ""){
        if (horaEntradaSalida < horaRegreso ){

            if(document.getElementById('totalTiempo').value = diferenciaHora(horaRegreso,horaEntradaSalida) > "02:00" && selectSalida == "personal"){
            //if(document.getElementById('horasTrabajadas').value = diferenciaHora(horaRegreso,horaEntradaSalida) < "02:00" && selectSalida == "personal"){
                Swal.fire('La hora de regreso debe ser menor a 2 horas');
                $("#horaEntradaSalida").val(null);
                $("#horaRegreso").val(null);
                $("#totalTiempo").val(null);
                $("#horasTrabajadas").val(null);
            }else
                document.getElementById('totalTiempo').value = diferenciaHora(horaRegreso,horaEntradaSalida);
                //alert("");

        } else {
            $("#horaEntradaSalida").val(null);
            $("#horaRegreso").val(null);

            Swal.fire('La hora de entrada/salida debe ser menor a la hora de regreso');
        }
    }
    /*if(horaSalida > entra)
        Swal.fire('Los horarios no pueden chocar entre si');*/
    /*selectSalida = (document.getElementById('tipoSalida').value).toLowerCase();
    if(selectSalida !=""){
        if (selectSalida == "acuerdo sindical"){
            if(diff > "01:00"){
                Swal.fire('Se cobrara el tiempo despues de la hora : ' + diferenciaHora(diff,"1:00"));
            }
        } else if (selectSalida == "medica" || selectSalida == "acuerdo sindical" || "resposicion de tiempo"){
            if (diff > "02:00") {
                Swal.fire('Se cobrara el tiempo despues de las  2 horas: ' + diferenciaHora(diff, "2:00"));
            }
        }
    }*/
    if(selectTipoSalida != "oficial"){
        if(selectSalida !=""){
            if (selectSalida == "acuerdo sindical"){
                if(diff > "01:00"){
                    //alert("No deberioa aparecer esto 1");
                    Swal.fire('Se cobrara el tiempo despues de la hora : ' + diferenciaHora(diff,"1:00"));
                }
            } else if (selectSalida == "medica" || selectSalida == "acuerdo sindical" || selectSalida == "resposicion de tiempo"){
                if (diff > "02:00") {
                    //alert("No deberioa aparecer esto 2");
                    Swal.fire('Se cobrara el tiempo despues de las  2 horas: ' + diferenciaHora(diff, "2:00"));
                }
            }
        }
    }
   
    
}

function calcularHorasTrabajadas() {
    horaEntradaSalida = document.getElementById('horaEntradaSalida').value;
    var [horaEntrada, horaSalida] = obtenerHoraEntradaSalida();
    diferenciaHora(horaSalida,horaEntradaSalida);
    //selectTipo = (document.getElementById('tipoSolicitud').value).toLowerCase();
    if (horaEntradaSalida == "") { //Aqui
        alert("Debes llenar todos los campos de horas");
        //dias = "";
    } else if(selectTipo == 'entrada') { //
        horas = diff.split(":");
        horasMins = horas[0] * 60;
        totalMinutos = horasMins + parseInt(horas[1]);
        Salida = moment(horaEntradaSalida, 'HH:mm').add(totalMinutos, 'minutes').format('HH:mm');
        horarios = Salida;
        //alert(horarios);
        //$('#horasTrabajadas').val(horarios);
        $('#horasTrabajadas').val(diff);
    } else {
        // Calcula la diferencia de tiempo entre horaEntrada y horaEntradaSalida
        var diff = diferenciaHora(horaEntradaSalida, horaEntrada);
        horas = diff.split(":");
        horasMins = horas[0] * 60;
        totalMinutos = horasMins + parseInt(horas[1]);
        // Resta la diferencia de tiempo a la horaEntrada para obtener la hora de salida
        Salida = moment(horaEntrada, 'HH:mm').subtract(totalMinutos, 'minutes').format('HH:mm');
        horarios = Salida;
        //alert(horarios);
        $('#horasTrabajadas').val(diff);
      }
}
    //Aqui

function cargarFirma(datosConfirmacion)//funcion que carga la firma del empleado
{
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
            guardarSolicitudES();
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
function cargarSelectAdscripcion(valor)// funcion que carga el select "selectAdscripcion" del formato
{
    var datos = "numFuncion=12";
    $.ajax({
        url: "../../Servidor/PHP/" + "empleados.php",
        type: "POST",
        data: datos
    }).done(function (res) {
        var datos = res.split('#');
    var departamentos = document.getElementById('departamento')
    for (let i = 0; i < datos.length; i++) {
        var adscripcion = datos[i].split('*');
        var opcion = document.createElement('option');
        opcion.value = adscripcion[1];
        opcion.text = adscripcion[1];
        if(adscripcion[1] == valor && valor != null){
            opcion.selected ="yes";
        }
        departamentos.add(opcion);
    }
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
function guardarSolicitudES() // funcion que guarda el formulario
{
    var formulario = document.getElementById('formularioSE')
    var datos = new FormData(formulario);
    datos.append("numFuncion",1);
    console.log("Formulario",formulario);
    console.log("Datos",datos);
       $.ajax({
          url: "../../Servidor/PHP/" + "entradaSalida.php",
          type: "POST",
          data: datos,
          processData: false, 
          contentType: false   
      }).done(function(res){
        //alert("Mesaje");
            Swal.fire(res); 
            console.log(res);
            notificarJefe();
      }).fail(function(res){
          console.log(res);
      }); 
}

function notificarJefe(){
    correo = new Array();
    $('input[name^="selectJefe"]').each(function() {
        
            //console.log($(this).val());
            console.log("Correo");
        
        
    });
    tipoSolicitud = $("#nombreSolicitud").val();
    console.log(correo)
   /*  console.log("correo: "+correo + " Tipo Solicitud" + tipoSolicitud);
    datos = "correo=" + correo + "&tipoSolicitud=" + tipoSolicitud;
    $.ajax({
        url: urlSrc + "notificacionCorreo",
        type: "POST",
        data: datos
    }).done(function(res){
        mensajeExito();
    }).fail(function(res){
        console.log(res);
    }); */
}

function mensajeExito() // Funcion que muestra un mensaje en pantalla con sweet alert 2
{
    let timerInterval
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Se ha enviado correctamente',
        showConfirmButton: false,
        timer: 2000
    }).then((result) => {
        document.getElementById("modalES").style.display = "none";
    });
}

function obtenerDatosSolicitudES(folio, val){
    var datos = "folio=" + folio + "&numFuncion=3";
    $.ajax({
        url: "../../Servidor/PHP/entradaSalida.php",
        type: "POST",
        data: datos,
    }).done(function(res){
        var datos = res.split('*');
        console.log(datos);
        mostrarCheckBox(datos[30]);
        llenarFormato(datos, val);
        //cargarJefe(datos[7]);
    }).fail(function(res){
        console.log(res);
    });
}
function dividirHora(hora){
    hora = hora.split('.');
    hora = hora[0].split(':');
    return [hora[0],hora[1]];
}
function llenarFormato(datos, val){
    $('#folioS').text(datos[0]);
    $('#folio').val(datos[1]);
    /*for(var i; i<datos[22].length-1;i++){
        palabra=datos[22].substr("10,2");
    }*/
    var [hora,minutos] = dividirHora(datos[8])
    $("#horaEntradaCubrir").val(hora +":"+ minutos); 
    var [hora,minutos] = dividirHora(datos[9])
    $("#horaSalidaCubrir").val(hora +":"+ minutos); 
    $("#tipoSolicitud").val(datos[10])
    if ($("#tipoSolicitud").val() == "entrada"){
        $("#tipoSalida").prop("disabled", true);
        $("#tipoEntrada").prop("disabled", false);
        $("#tipoEntrada").val(datos[11]);
        $("#asunto").prop("disabled", false);
    }else{
        $("#tipoEntrada").prop("disabled", true);
        $("#tipoSalida").prop("disabled", false);
        $("#horaRegreso").prop("disabled", false);
        $("#tipoSalida").val(datos[11]);
        $("#asunto").prop("disabled", false);
        var [hora, minutos] = dividirHora(datos[13])
        $("#horaRegreso").val(hora + ":" + minutos); 
    }
    if(datos[11] == "oficial"){
        $("#divAsunto").prop("style","display:block");
        $("#asunto").prop("disabled", false);
    }
    var [hora, minutos] = dividirHora(datos[12])
    $("#horaEntradaSalida").val(hora + ":" + minutos); 
    alert($("#horaEntradaSalida").val(hora + ":" + minutos)); //Aqui
    var [hora, minutos] = dividirHora(datos[14])
    $("#asunto").val(datos[15]);
    $("#totalTiempo").val(hora + ":" + minutos); 
    fechaActual(true, datos[19]);
    cargarSelectAdscripcion(datos[20]);
    if(datos[21] == "regimen de ley"){ 
        $("#regimenLey").prop("checked", true); 
    } else if (datos[21] == "eventualBase"){
        $("#eventualBase").prop("checked", true); 
    }else if (datos[21] == "cambioPorOficio"){
        $("#cambioPorOficio").prop("checked", true); 
    }
    if($('#eventualBase').is(':checked') || $('#regimenLey').is(':checked') || $('#cambioPorOficio').is(':checked')){
        mostrarDatosCubrir(false, "display:block");
    }    //
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
        bloquearCampos();
    }
}
function mostrarDatosCubrir(bandera, display){
    $('#horaEntradaCubrir').prop('disabled', bandera);
    $('#horaSalidaCubrir').prop('disabled', bandera);
    $('#departamento').prop('disabled', bandera);
    $('#divDepartamento').prop('display', "style:block");
    $('#divDatosCubrir').prop('style', display);
}
function eliminarEntradaSalida(id){
    datos = "id=" + id + "&numFuncion=4";
        $.ajax({
            url: "../../Servidor/PHP/entradaSalida.php",
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

function Limpieza(){
    //document.getElementById("horaSalidaCubrir").value = "";
    document.getElementById("horaEntradaSalida").value = "";
    document.getElementById("horaSalidaCO").value = "";

    //document.getElementById("horaEntradaCubrir").value = "";
    document.getElementById("horaEntradaSalida").value = "";
    document.getElementById("horaEntradaCO").value = "";

    document.getElementById("totalTiempo").value = "";
    document.getElementById("horasTrabajadas").value = "";
}


$(document).ready(function()
{
    $('#btnGuardarSolicitudES').click(function (e) {
        //alert("Guardado");
        form = document.getElementById("formularioSE");
        //form.addEventListener("submit", function (evt) {
            //evt.preventDefault();
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
                ocultarModalEntradaSalida(e);  
            })
        //}); 
    });
    $('#btnAbrirModalES').one('click', function(){
        cargarModalEntradaSalida(0);
      
        
    });
    $('#btnCerrarModal').click(function(e){
       ocultarModalEntradaSalida(e);        
    });
    $('#tipoSalida').change(function(){ //  si el empleado es sindicalizado o suplente y selecciona salida de tipo medica se habilita el campo asunto.
        var [horaEntrada, horaSalida] = obtenerHoraEntradaSalida();
        tipoContrato = ($("#tipoContrato").val()).toLowerCase();
        var selectTipoSalida = (document.getElementById('tipoSalida').value).toLowerCase();
        var tipoSolicitud = (document.getElementById('tipoSolicitud').value).toLowerCase();
       /*  tipoContrato = tipoContrato.toLowerCase(); */
        Limpieza();
            
        $("#horaEntradaSalida").val(horaSalida);
        if ((selectTipoSalida == "omision" || selectTipoSalida == "omisionhorariocorrido") && tipoSolicitud == "intermedio") {
            //alert(selectTipoSalida);
            //alert('Esta opción no está disponible');
            document.getElementById('asunto').disabled = true;
            document.getElementById('asunto').required = false;
            document.getElementById('divIntermedio').style.display = "none";
            document.getElementById('divAsunto').style.display = "none";
            //tipoSalida.options[0].selected = true;
        }else{
            document.getElementById('divIntermedio').style.display = "block";
        }  
        
        /* if (tipoContrato == "bs" || tipoContrato == "e") { */
        if ((tipoSolicitud == "salida" || tipoSolicitud == "intermedio") && selectTipoSalida == "personal"){
            document.getElementById('asunto').disabled = true;
            document.getElementById('asunto').required = false;
            if(tipoContrato == "bs" || tipoContrato == "e")
                document.getElementById('divHoraSindicalizada').style.display = "block";
            document.getElementById('divAsunto').style.display = "none";
        }else{
            document.getElementById('asunto').disabled = false;
            document.getElementById('asunto').required = true;
            document.getElementById('divAsunto').style.display = "block";
            document.getElementById('divHoraSindicalizada').style.display = "none";
            
        }
       /*  } */

    });           // calcularTiempoTotal();
    $('#tipoEntrada').change(function(){ //  si el empleado es sindicalizado o suplente y selecciona salida de tipo medica se habilita el campo asunto.
        var [horaEntrada, horaSalida] = obtenerHoraEntradaSalida();//omisionHorarioCorrido
        var selectTipoEntrada = (document.getElementById('tipoEntrada').value).toLowerCase();
        var tipoSolicitud = (document.getElementById('tipoSolicitud').value).toLowerCase();
        tipoContrato = ($("#tipoContrato").val()).toLowerCase();
        /* tipoContrato = tipoContrato.toLowerCase(); */
        Limpieza();
        document.getElementById('divIntermedio').style.display = "block";
        $("#horaEntradaSalida").val(horaEntrada);
        //alert(tipoContrato);
        //if(tipoContrato != "bs" || tipoContrato != "e"){
        /* if (tipoContrato == "bs" || tipoContrato == "e") { */
            if (selectTipoEntrada == "omision" && selectTipoEntrada == "omisionHorarioCorrido") {
                document.getElementById('asunto').disabled = true;
                document.getElementById('asunto').required = false;
                document.getElementById('divAsunto').style.display = "none";
                $("#horaEntradaSalida").val(horaEntrada);

            }else{
                document.getElementById('asunto').disabled = false;
                document.getElementById('asunto').required = true;
                document.getElementById('divAsunto').style.display = "block";
            }
       /*  } */
        /*}else{
            Swal.fire('Esta opcion no es de sindicalizadosXD');
            document.getElementById("divDatosCubrir").style.display = "none";
            document.getElementById('divAsunto').style.display = "none";
            //tipoSalida.options[0].selected = true;
        }*/

        

    });
    $('#tipoSolicitud').change(function(){
        tipoContrato = ($("#tipoContrato").val()).toLowerCase();
        horaRegreso = document.getElementById("horaRegreso");
        horaRegreso.value=""; 
        horaEntrada = document.getElementById("horaEntradaSalida").value = "";
        totalTiempo = document.getElementById("totalTiempo").value = ""; 
        horasTrabajadas = document.getElementById("horasTrabajadas").value = ""; 
        var tipoSolicitud = document.getElementById("tipoSolicitud").value;
        var tipoSalida = document.getElementById("tipoSalida");
        var tipoEntrada = document.getElementById("tipoEntrada");
       
        if(tipoSolicitud == "entrada"){
            document.getElementById('divHoraSindicalizada').style.display = "none";
            //alert(tipoContrato);
            Limpieza();
            var [horaEntrada, horaSalida] = obtenerHoraEntradaSalida();
            /*if(tipoContrato == "bs"){
                Swal.fire('Esta opcion no es de sindicalizados');
                document.getElementById('divIntermedio').style.display = "none";
                document.getElementById('divAsunto').style.display = "none";
                document.getElementById("divDatosCubrir").style.display = "none";
                document.getElementById("horaentradaSalida").display = "none";
                document.getElementById("totalTiempo").display = "none";
                //tipoSalida.disabled = true;
                //tipoSalida.required = false;
                //$('#tipoSalida').prop('selectedIndex', 0);
                //tipoSalida.options[0].selected = true;*
            }else{*/
                //document.getElementById('horaEntradaSalida').style.display = "block"; 
                //document.getElementById('totalTiempo').style.display = "block";
                //alert(horaEntrada);
                tipoSalida.disabled = true;
                tipoSalida.required = false;
                $('#tipoSalida').prop('selectedIndex', 0);
                tipoEntrada.disabled = false;
                tipoEntrada.required = true;
                horaRegreso.disabled = true;
                horaRegreso.required = false;
                horaRegreso.value = "";
                
                document.getElementById('asunto').disabled = true;
                document.getElementById('asunto').required = false;

                document.getElementById('divTipoSalida').style.display = "none";
                document.getElementById('divTipoEntrada').style.display = "block";
                document.getElementById('divAsunto').style.display = "none";
                $("#divHoraRegreso").prop("style", "display:none");
                $("#horaentradaSalida").text("Hora de Entrada:");
                $("#horaEntradaSalida").val(horaEntrada);
            //}
        } else if (tipoSolicitud == "salida"){
            document.getElementById('divHoraSindicalizada').style.display = "none";
            Limpieza();
            var [horaEntrada,horaSalida] = obtenerHoraEntradaSalida()
            $("#horaEntradaSalida").val(horaSalida);
            //alert(horaSalida);
            tipoEntrada.disabled = true;
            tipoEntrada.required = false;
            $('#tipoEntrada').prop('selectedIndex', 0);
            tipoSalida.disabled = false;
            tipoSalida.required = true;
            horaRegreso.disabled = true;
            horaRegreso.required = false;
            horaRegreso.value = "";
            document.getElementById('divTipoEntrada').style.display = "none";
            document.getElementById('divTipoSalida').style.display = "block";

            document.getElementById('asunto').disabled = true;
            document.getElementById('asunto').required = false;

            document.getElementById('divAsunto').style.display = "none";
            $("#divHoraRegreso").prop("style", "display:none");
            $("#horaentradaSalida").text("Hora de Salida:");
        } else if (tipoSolicitud == "intermedio"){
            document.getElementById('divHoraSindicalizada').style.display = "none";
            Limpieza();
            tipoEntrada.disabled = true;
            tipoEntrada.required = false;
            tipoSalida.disabled = false;
            tipoSalida.required = true;
            horaRegreso.disabled = false;
            horaRegreso.required = true;
            $("#divHoraRegreso").prop("style", "display:block");
            document.getElementById('divTipoEntrada').style.display = "none";
            document.getElementById('divTipoSalida').style.display = "block";
            $("#horaentradaSalida").text("Hora de Salida:");

        }
    });
    $('#btnEditarFecha').click(function(){
        document.getElementById('modalCambiarFecha').style.display="block";
    });
    $('#btnAceptarCambiarFecha').click(function(){
        document.getElementById('modalCambiarFecha').style.display="none";
        
        fechaActual(true, document.getElementById('nuevaFecha').value);
    });
    $('#horaEntradaSalida').change(function () {
        
        calcularTiempoTotal();
        calcularHorasTrabajadas();
    });
    $('#horaRegreso').change(function () {
       
        calcularTiempoTotal();
    });
    $('#horaEntradaCubrir').change(function () {
        tipoContrato = ($("#tipoContrato").val()).toLowerCase();
        horario = document.getElementById("horario").value;
        horaEntradaCubrir = document.getElementById("horaEntradaCubrir").value;
        separarHorario = horario.split(' ');
        entra = separarHorario[0];
        sale = separarHorario[2];
        //calcularTiempoTotal();
        var isChecked = document.getElementById('cambioPorOficio').checked;
        var Checked = document.getElementById('eventualBase').checked;
        //alert(tipoContrato);
        if(isChecked || (Checked && (tipoContrato == "bs" || tipoContrato == "e" ))){
            calcularTiempoTotal();
        }else if(horaEntradaCubrir < sale){
            Swal.fire('Los horarios no pueden chocar entre si'); //Aqui
            $("#horaEntradaCubrir").val(null);
        }else{
            calcularTiempoTotal();
        }  
    });
    $('#horaSalidaCubrir').change(function () {
        tipoContrato = ($("#tipoContrato").val()).toLowerCase();
        horario = document.getElementById("horario").value;
        salida = document.getElementById("horaSalidaCubrir").value;
        separarHorario = horario.split(' ');
        sale = separarHorario[0];
        entra = separarHorario[2]; 
        //calcularTiempoTotal();
        //alert(salida);
        let cruza = false;
        for(var i=1;i<=2;i++){
            cruza = cruza || ( salida >= entra && salida >= sale);
        }
        if($('#cambioPorOficio').is(':checked')){
            calcularTiempoTotal();
        } else{
            if(cruza == false){
                Swal.fire('Los horarios no pueden chocar entre si'); //Aqui
                $("#horaSalidaCubrir").val(null);
            }else{
                calcularTiempoTotal();
            }
        }
    });
    $('#eventualBase').change(function(){
        if ($('#eventualBase').is(':checked')) {

            $('#cambioPorOficio').prop('checked',false); 
            $('#regimenLey').prop('checked',false);
            mostrarDatosCubrir(false, "display:block");
        }else{
            mostrarDatosCubrir(true, "display:none");
            $("#horaEntradaCubrir").val("");
            $("#horaSalidaCubrir").val("");
            calcularTiempoTotal(); 
        }
    });
    $('#cambioPorOficio').change(function(){
        if ($('#cambioPorOficio').is(':checked')) {
            $('#eventualBase').prop('checked',false); 
            $('#regimenLey').prop('checked',false);
            mostrarDatosCubrir(false, "display:block");
        }else{
            mostrarDatosCubrir(true, "display:none");
            $("#horaEntradaCubrir").val("");
            $("#horaSalidaCubrir").val("");
            calcularTiempoTotal();
        }
    });
    $('#regimenLey').change(function(){
        if ($('#regimenLey').is(':checked')) {
            $('#cambioPorOficio').prop('checked',false); 
            $('#eventualBase').prop('checked',false);
            mostrarDatosCubrir(false, "display:block");

            $("#totalTiempo").val(null);
            $("#horasTrabajadas").val(null);
            $("#horaRegreso").val(null);
            $("#horaEntradaSalida").val(null);
        }else{
            
            mostrarDatosCubrir(true, "display:none");
            $("#horaEntradaCubrir").val("");
            $("#horaSalidaCubrir").val("");
            calcularTiempoTotal();
        }
    });
    $('#selectHorario').change(function(){
        horaRegreso = document.getElementById("horaRegreso").value = "";
        horaEntrada = document.getElementById("horaEntradaSalida").value = "";
        totalTiempo = document.getElementById("totalTiempo").value = "";  
        horasTrabajadas = document.getElementById("horasTrabajadas").value = ""; 
        cargarDatosHorario(); 
    });
    $('#selectJefe').change(function(){
        var nombreJefe;
        var select = document.getElementById("selectJefe"); //El <select>
        nombreJefe = select.options[select.selectedIndex].innerText;
        var sel = document.getElementById("selectJefe").value;
        //var cat = sel.options[sel.selectedIndex].innerText;
        var categoria = document.getElementById('selectJefe').value;
        //var categoria = document.getElementById(jefe[1]).value;
        $('#firmaJefe').text(nombreJefe);
        $('#cargoJefe').text(categoria); 
    });
    $('#selectDias').change(function(){
        var selectDias = document.getElementById('selectDias');
        var horario = document.getElementById('horario');
        for (let i = 0; i < datosHorario.length; i++) {
            if(datosHorario[i][0] == selectDias.value){
                horario.value = datosHorario[i][1] + " a " + datosHorario[i][2];
            }
        } 
    });
    /*$('#horasTrabajadas').change(function(){
        horasTrabajados();
    });*/
    $('#btnCerrarCambiarFecha').click(function(){
        document.getElementById("modalCambiarFecha").style = "display:none";
    })
});