//var urlSrc = "http://10.10.15.15/practicas/upemor/HNM/Servidor/PHP/empleados.php";
var horarios = "",
    img_data, cambiaFirma = 0,
    nominaDisponible;

function cerrarFormEmpleado() {
    form = document.getElementById("formularioEmpleado");
    modal = document.getElementById("modal");
    modal.removeChild(form);
}
function cerrarFormEmpleadoV() {
    form = document.getElementById("formularioEmpleadoVisualizacion");
    modal = document.getElementById("modal");
    modal.removeChild(form);
}

function imagenFirma() {
    var ctx = document.getElementById("canvasFirma");
    img_data = ctx.toDataURL();
}

function eventoGuardar() {
    var urlSrc = "../../Servidor/PHP/empleados.php";
    var formulario = document.getElementById('formEmpleado');
    var datos = new FormData(formulario);
    datos.append("fechaRegistro", document.getElementById("fechaRegistro").innerHTML);
    datos.append("registro", document.getElementById("registro").innerHTML);
    //datos.append("horario", document.getElementById("horario").value);
    datos.append("firmaImg", img_data);
    datos.append("cambiaFirma", cambiaFirma)
    datos.append("numFuncion", 3);
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: datos,
        processData: false,
        contentType: false
    }).done(function(res) {
        alert(res);
        if (res == "Registro guardado correctamente") {
            cerrarFormEmpleado();
            limpiarTabla();
            obtenerDatos(0);
        }
    }).fail(function(res) {
        alert(res);
    });
}

function guardarEmpleado(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    if (nominaDisponible == 1 || document.getElementById("idEmpleado").value != "") {
        if (document.getElementById("error")) {
            if (cambiaFirma == 0) {
                eventoGuardar();
            } else {
                document.getElementById("canvasFirma").focus();
            }
        } else {
            if (cambiaFirma == 1 || document.getElementById("idEmpleado").value == "") {
                imagenFirma();
            }
            eventoGuardar();
        }
    } else {
        document.getElementById("nomina").focus();
    }
}

function crearTabla() {
    $('#tablaEmpleados').DataTable({
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

function radiosSelect(tipoContrato) { //ver
    switch (tipoContrato) {
        case "BS":
            radio = document.getElementById("base");
            radio.setAttribute("checked", "true");
            break;
        case "C":
            radio = document.getElementById("confianza");
            radio.setAttribute("checked", "true");
            break;
        case "G":
            radio = document.getElementById("gobierno");
            radio.setAttribute("checked", "true");
            break;
        case "RL":
            radio = document.getElementById("regimen");
            radio.setAttribute("checked", "true");
            break;
        case "E":
            radio = document.getElementById("eventual");
            radio.setAttribute("checked", "true");
            break;
    }
}

function radiosTurno(turno) {
    document.getElementById("divHorario").style.display = "block";
    //alert("Datos cargados", dato);
    switch (turno) {
        case "Matutino":
            document.getElementById("matutino").setAttribute("checked", "true");
            //radio = document.getElementById("matutino");
            //radio.setAttribute("checked", "true");
            //$("#horario").val(dato);
            break;
        case "Vespertino":
            radio = document.getElementById("vespertino");
            radio.setAttribute("checked", "true");
            //$("#horario").val(dato);
            break;
        case "Nocturno":
            radio = document.getElementById("nocturno");
            radio.setAttribute("checked", "true");
            //$("#horario").val(dato);
            break;
        case "Jornada Acumulada":
            radio = document.getElementById("jornadaAcumulada");
            radio.setAttribute("checked", "true");
            //$("#horario").val(dato);
            break;
        case "Otro":
            radio = document.getElementById("otro");
            radio.setAttribute("checked", "true");
            //$("#horario").val(dato);
            break;
    }
}

function llenarFormEmpleado(datos, tipoContrato) {
    $("#idEmpleado").val(datos[0]);
    $("#nomina").val(datos[1]);
    document.getElementById("nomina").setAttribute("readonly", true);
    $("#nombre").val(datos[2]);
    $("#telefono").val(datos[3]);
    $("#correo").val(datos[4]);
    sexo = datos[5];
    if (sexo == 1) { 
        document.getElementById("femenino").setAttribute("checked", "true");
    } else {
        document.getElementById("masculino").setAttribute("checked", "true");
    }
    $("#tipoEmpleado").val(datos[6]);
    $("#fechaInicio").val(datos[7]);
    fecha = datos[8].split("-")
    document.getElementById("fechaRegistro").innerHTML = fecha[2] + "/" + fecha[1] + "/" + fecha[0];
    document.getElementById("registro").innerHTML = datos[9];
    $("#adscripcion").val(datos[12]);
    //alert(datos[12]);
    $("#categoria").val(datos[13]);
    //alert(datos[13]);
    $("#tipoCont").val(tipoContrato[0]);
    //alert(tipoContrato[0]);
    obtenerTurno(datos[11]);
    $("#horario").val(datos[11]);
    //alert(datos[11]);
    img_data = datos[10];
    divImg = document.getElementById("imgFirma");
    imagen = document.createElement("img");
    imagen.setAttribute("src", "../../Servidor/Firmas/" + datos[10]);
    imagen.setAttribute("class", "w3-image");
    /* imagen.setAttribute("title", "firma" + datos[2]); */
    divImg.appendChild(imagen);
}

function llenarFormEmpleadoV(datos, tipoContrato) {
    $("#idEmpleado").val(datos[0]);
    $("#nomina").val(datos[1]);
    document.getElementById("nomina").setAttribute("readonly", true);
    $("#nombre").val(datos[2]);
    document.getElementById("nombre").setAttribute("readonly", true);
    $("#telefono").val(datos[3]);
    document.getElementById("telefono").setAttribute("readonly", true);
    $("#correo").val(datos[4]);
    document.getElementById("correo").setAttribute("readonly", true);
    sexo = datos[5];
    if (sexo == 1) { 
        document.getElementById("femenino").setAttribute("checked", "true");
    } else {
        document.getElementById("masculino").setAttribute("checked", "true");
    }
    if(datos[6] == 2){
        $("#tipoEmpleado").val("Control operativo");
    } else if(datos[6] == 3){
        $("#tipoEmpleado").val("Autorizador / Jefe");
    } else if(datos[6] == 4){
        $("#tipoEmpleado").val("Usuario estandar");
    }
    document.getElementById("tipoEmpleado").setAttribute("readonly", true);
    $("#fechaInicio").val(datos[7]);
    document.getElementById("fechaInicio").setAttribute("readonly", true);
    fecha = datos[8].split("-")
    document.getElementById("fechaRegistro").innerHTML = fecha[2] + "/" + fecha[1] + "/" + fecha[0];
    document.getElementById("fechaRegistro").setAttribute("readonly", true);
    document.getElementById("registro").innerHTML = datos[9];
    document.getElementById("registro").setAttribute("readonly", true);
    //alert(datos[12]);
    //$("#adscripcion").val(datos[12]); Aqui
    cargarAdscripcion(datos[12]);
    document.getElementById("adscripcion").setAttribute("readonly", true);
    cargarCategoria(datos[13]);
    //$("#categoria").val(datos[13]);
    document.getElementById("categoria").setAttribute("readonly", true);
    $("#tipoCont").val(tipoContrato[1]);
    document.getElementById("tipoCont").setAttribute("readonly", true);
    obtenerTurno(datos[11]);
    cargarHorario(datos[11]);
    //$("#horario").val(datos[11]);
    document.getElementById("horario").setAttribute("readonly", true);
    //alert(datos[11]);
    img_data = datos[10];
    divImg = document.getElementById("imgFirma");
    imagen = document.createElement("img");
    imagen.setAttribute("src", "../../Servidor/Firmas/" + datos[10]);
    imagen.setAttribute("class", "w3-image");
    /* imagen.setAttribute("title", "firma" + datos[2]); */
    divImg.appendChild(imagen);
}
function obtenerTurno(idHorario){
    idHorario = idHorario;
    var urlSrc = "../../Servidor/PHP/empleados.php";
    $.ajax({
        url: urlSrc, 
        type: "POST",
        data: "idHorario=" + idHorario + "&numFuncion=16"
    }).done(function(res) {
        datosH = res.split("*");
        turno = datosH[0];
        horario = datosH[1].split("/");
        radiosTurno(turno);
    }).fail(function(res) {
        console.log(res);
    });
}
function cargarAdscripcion(valor){
    var urlSrc = "../../Servidor/PHP/empleados.php";
    $.ajax({
        url: urlSrc, 
        type: "POST",
        data: "clave=" + valor + "&numFuncion=18"
    }).done(function(res) {
        $("#adscripcion").val(res);
    }).fail(function(res) {
        console.log(res);
    });
}
function cargarCategoria(valor){
    var urlSrc = "../../Servidor/PHP/empleados.php";
    $.ajax({
        url: urlSrc, 
        type: "POST",
        data: "idCategoria=" + valor + "&numFuncion=19"
    }).done(function(res) {
        $("#categoria").val(res);
    }).fail(function(res) {
        console.log(res);
    });
}
function cargarHorario(valor){
    var urlSrc = "../../Servidor/PHP/horarios.php";
    $.ajax({
        url: urlSrc, 
        type: "POST",
        data: "idHorario=" + valor + "&numFuncion=6"
    }).done(function(res) { 
        $("#horario").val(res);
    }).fail(function(res) {
        console.log(res);
    });
}
function crearOption(valor) {
    valores = valor.split("*");
    option = document.createElement("option");
    option.setAttribute("value", valores[0]);
    option.innerHTML = valores[1];
    return option;
}

function selectCrear(valores, idSelect) {
    //alert(valores);
    select = document.getElementById(idSelect);
    cantidad = valores.length - 1;
    for (i = 0; i < cantidad; i++) {
        option = crearOption(valores[i]);
        select.appendChild(option);
    }
}
 
function cargarDatosEmpleados(idEmpleado) {
    alert("Cargando Empleado");
    var urlSrc = "../../Servidor/PHP/empleados.php";
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: "id=" + idEmpleado + "&numFuncion=8"
    }).done(function(res) {
        //alert(res);
        document.getElementById("imagen").style.display = "block";
        document.getElementById("canvas").style.display = "none";
        datos = res.split("%");
        //alert(datos);
        //alert(datos[3]);
        datosAdscripcion = datos[1].split("#");
        selectCrear(datosAdscripcion, "adscripcion");
        //alert(datosAdscripcion);
        datosCategoria = datos[2].split("#");
        selectCrear(datosCategoria, "categoria");
        //alert(datosCategoria);
        datosEmpleado = datos[0].split("*");
        tipoContrato = datos[3].split("*");
        obtenerDatosContrato();
        llenarFormEmpleado(datosEmpleado, tipoContrato);    
    }).fail(function(res) {
        console.log(res);
    });
}

function cargarDatosEmpleadosV(idEmpleado) {
    alert("Cargando Empleado");
    var urlSrc = "../../Servidor/PHP/empleados.php";
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: "id=" + idEmpleado + "&numFuncion=8"
    }).done(function(res) {
        //alert(res);
        document.getElementById("imagen").style.display = "block";
        document.getElementById("canvas").style.display = "none";
        datos = res.split("%");
        //alert(datos);
        //alert(datos[3]);
        datosAdscripcion = datos[1].split("#");
        selectCrear(datosAdscripcion, "adscripcion");
        //alert(datosAdscripcion);
        datosCategoria = datos[2].split("#");
        selectCrear(datosCategoria, "categoria");
        //alert(datosCategoria);
        datosEmpleado = datos[0].split("*");
        tipoContrato = datos[3].split("*");
        //alert(tipoContrato);
        obtenerDatosContrato();
        llenarFormEmpleadoV(datosEmpleado, tipoContrato);    
    }).fail(function(res) {
        console.log(res);
    });
}

function cargarEmpleado(idEmpleado) {
    //alert("editarEmpleado" + idEmpleado);
    mostrarFormEmpleado();
    cargarDatosEmpleados(idEmpleado);
}
function cargarEmpleadoV(idEmpleado) { //Aqui
    //alert("editarEmpleado" + idEmpleado);
    mostrarFormEmpleadoV();
    cargarDatosEmpleadosV(idEmpleado);
    
}

function eliminarEmpleado(idEmpleado) {
    var urlSrc = "../../Servidor/PHP/empleados.php";
    //alert("eliminarEmpleado" + idEmpleado);
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: "idEmpleado=" + idEmpleado + "&numFuncion=5"
    }).done(function(res) {
        console.log(res);
        alert(res);
        if (res == "Se inhabilito el empleado") {
            limpiarTabla();
            obtenerDatos(0);
        }
    }).fail(function(res) {
        console.log(res);
    });
}

function habilitarEmpleado(idEmpleado) {
    var urlSrc = "../../Servidor/PHP/empleados.php";
    //alert("eliminarEmpleado" + idEmpleado);
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: "idEmpleado=" + idEmpleado + "&numFuncion=4"
    }).done(function(res) {
        alert(res);
        if (res == "Se habilito el empleado") {
            limpiarTabla();
            obtenerDatos(1);
        }
    }).fail(function(res) {
        console.log(res);
    });
}

function limpiarTabla() {
    tabla = $("#tablaEmpleados").DataTable();
    tabla.clear().draw();
}

function llenarTabla(valores, valor) {
    tabla = $("#tablaEmpleados").DataTable();
    tabla.clear().draw();
    for (var i = 0; i < (valores.length - 1); i++) {
        var dat = valores[i].split("*");
        if (valor == 0)
            botones = "<input title='Modificar' class='w3-btn w3-blue' type='button' value='&#9998' onclick='cargarEmpleado(" + dat[0] + ")'> <input title='Vizualizar' class='w3-btn w3-blue' type='button' value='&#9920' onclick='cargarEmpleadoV(" + dat[0] + ")'> <input title='Inhabilitar' class='w3-btn w3-red' type='button' value='&#10006' onclick='eliminarEmpleado(" + dat[0] + ")'>";
        else
            botones = "<input title='Habilitar' class='w3-btn w3-green' type='button' value='Habilitar &#10004' onclick='habilitarEmpleado(" + dat[0] + ")'>";
        tabla.row.add([
            dat[1],
            dat[2],
            dat[3],
            dat[4],
            botones
        ]).draw(false);
    }
}

function obtenerDatos(valor) {
    var urlSrc = "../../Servidor/PHP/empleados.php";
    nomina = document.getElementById("inputNomina").value;
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: "nomina=" + nomina + "&estado=" + valor + "&numFuncion=1"
    }).done(function(res) {
        valores = res.split("-");
        llenarTabla(valores, valor);
    }).fail(function(res) {
        console.log(res);
    });
}

function obtenerHorarios() {
    $.ajax({
        url: "../../Servidor/PHP/horarios.php",
        type: "POST",
        data: "numFuncion=1"
    }).done(function(res) {
        horarios = res.split("--");
    }).fail(function(res) {
        console.log(res);
    });
}

function obtenerFecha() {
    var date = new Date();
    var dd = String(date.getDate()).padStart(2, '0');
    var mm = String(date.getMonth() + 1).padStart(2, '0'); //January is 0!
    var aaaa = date.getFullYear();
    date = dd + '/' + mm + '/' + aaaa;
    return date;
}

function obtenerDatosAdscripcion() {
    $.ajax({
        url: "../../Servidor/PHP/empleados.php",
        type: "POST",
        data: "numFuncion=12"
    }).done(function(res) {
        alert(res);
        selectCrear(res.split("#"), "adscripcion");
        console.log(res.split("#"));
    }).fail(function(res) {
        console.log(res);
    });
}

function obtenerDatosContrato(){
    //tipoCont
    $.ajax({
        url: "../../Servidor/PHP/contratos.php",
        type: "POST",
        data: "numFuncion=2"
    }).done(function(res) {
        selectCrear(res.split("#"), "tipoCont");
        //console.log(res.split("#")); 
    }).fail(function(res) {
        console.log(res);
    });
}

function obtenerDatosCategoria(valor) {
    $.ajax({
        url: "../../Servidor/PHP/empleados.php",
        type: "POST",
        data: "tipoContrato=" + valor + "&numFuncion=13"
    }).done(function(res) {
        selectCrear(res.split("#"), "categoria");
    }).fail(function(res) {
        console.log(res);
    });
}

function obtenerDatosHorario(valor) {
    $.ajax({
        url: "../../Servidor/PHP/horarios.php",
        type: "POST",
        data: "turno=" + valor + "&numFuncion=5"
    }).done(function(res) {
        /*alert(res);
        alert(res.split("#"))*/
        selectCrear(res.split("#"), "horario");
    }).fail(function(res) {
        console.log(res);
    });
}
function mostrarFormEmpleado() {
    //alert("Modificar")
    $.ajax({
        url: "./Plantillas/Forms/formularioEmpleado.php",
        success: function(data) {
            $('#modal').html(data);
            document.getElementById("formularioEmpleado").style.display = "block";
            $.getScript("./AJAX/scriptEmpleados.js");
            date = obtenerFecha();
            document.getElementById("fechaRegistro").innerHTML = date;
            document.getElementById("registro").innerHTML = document.getElementById("nombreUsuario").innerHTML;
            selectCrear(horarios, "horario");
            document.getElementById("imagen").style.display = "none";
        }
    });
}

function mostrarFormEmpleadoV() {
    $.ajax({
        url: "./Plantillas/Forms/formularioEmpleadoVisualizacion.php",
        success: function(data) {
            $('#modal').html(data);
            document.getElementById("formularioEmpleadoVisualizacion").style.display = "block", disabled = true;
            $.getScript("./AJAX/scriptEmpleados.js");
            date = obtenerFecha();
            document.getElementById("fechaRegistro").innerHTML = date, disabled = true;
            document.getElementById("registro").innerHTML = document.getElementById("nombreUsuario").innerHTML, disabled = true;
            selectCrear(horarios, "horario");
            document.getElementById("imagen").style.display = "none", disabled = true;
        }
    });
}

function verificarNomina(nomina) {
    var urlSrc = "../../Servidor/PHP/empleados.php";
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: "nomina=" + nomina + "&numFuncion=14"
    }).done(function(res) {
        label = document.getElementById("mensajeNomina");
        label.innerHTML = "";
        if (res == 0) {
            label.innerHTML = "Número de nómina disponible";
            label.style.color = "green";
            nominaDisponible = 1;
        } else {
            label.innerHTML = "Número de nómina no disponible";
            label.style.color = "red";
            nominaDisponible = 0;
        }
    }).fail(function(res) {
        console.log(res);
    });
}

function clasificarNomina(valor) {
    if (valor == "") {
        document.getElementById("baseDiv").style.display = "block";
        document.getElementById("confianzaDiv").style.display = "block";
        document.getElementById("gobiernoDiv").style.display = "block";
        document.getElementById("regimenDiv").style.display = "block";
        document.getElementById("suplenteDiv").style.display = "block"; //Cambio
    } else if (valor <= 999) {
        document.getElementById("baseDiv").style.display = "block";
        document.getElementById("confianzaDiv").style.display = "block";
        document.getElementById("gobiernoDiv").style.display = "block";
        document.getElementById("regimenDiv").style.display = "none";
        document.getElementById("suplenteDiv").style.display = "none"; //Cambio
    } else if (valor >= 1000 && valor <= 7999) {
        document.getElementById("baseDiv").style.display = "none";
        document.getElementById("confianzaDiv").style.display = "none";
        document.getElementById("gobiernoDiv").style.display = "none";
        document.getElementById("regimenDiv").style.display = "block";
        document.getElementById("suplenteDiv").style.display = "none"; //Cambio
    } else {
        document.getElementById("baseDiv").style.display = "none";
        document.getElementById("confianzaDiv").style.display = "none";
        document.getElementById("gobiernoDiv").style.display = "none";
        document.getElementById("regimenDiv").style.display = "none";
        document.getElementById("suplenteDiv").style.display = "block"; //Cambio
    }
}

$(document).ready(function() {
    obtenerHorarios();
    if (!document.getElementById("formularioEmpleado")) {
        crearTabla();
        obtenerDatos(0);
    }
    if (document.getElementById("canvasFirma")) {
        $('#areaFirma').signaturePad({
            drawOnly: true,
            drawBezierCurves: true,
            lineColour: "#fff"
        });
        form = document.getElementById("formEmpleado");
        form.addEventListener("submit", function(evt) {
            evt.preventDefault();
            guardarEmpleado(evt);
        });
    }
    $("#btnAgregarEmpleado").one("click", function(evt) {
        evt.preventDefault();
        evt.stopImmediatePropagation();
        mostrarFormEmpleado();
        obtenerDatosAdscripcion();
        obtenerDatosContrato();
        
    });
    $("#tipoCont").on("change", function() {
        //  alert("Entro");
        select = document.getElementById("categoria");
        console.log(document.getElementById("tipoCont").value);
        long = select.length;
        for (i = long; i >= 1; i--) {
            select.remove(i);
        }
        valor = this.value;
        //alert(valor);
        obtenerDatosCategoria(valor);
    });

    $(".turnoCont").on("change", function() {
        document.getElementById("divHorario").style.display = "block";
        select = document.getElementById("horario");
        long = select.length;
        for (i = long; i >= 1; i--) {
            select.remove(i);
        }
        valor = this.value;
        obtenerDatosHorario(valor);
    });   

    $("#btnCerrarModal").one("click", function() {
        cerrarFormEmpleado();
    });
    $("#btnCancelarEmp").click(function() {
        cerrarFormEmpleado();
    });
    $("#btnCerrarModalV").one("click", function() {
        cerrarFormEmpleadoV();
    });
    $("#cambiarFirma").click(function() {
        document.getElementById("canvas").style.display = "block";
        document.getElementById("imagen").style.display = "none";
        cambiaFirma = 1;
    });
    $("#cancelarCambio").click(function() {
        if (document.getElementById("idEmpleado").value != "") {
            document.getElementById("canvas").style.display = "none";
            document.getElementById("imagen").style.display = "block";
            cambiaFirma = 0;
        }
    });
    $("#nomina").on("keyup", function() {
        read = document.getElementById("nomina").getAttribute("readonly");
        if (read == null) {
            if (this.value == "") {
                document.getElementById("mensajeNomina").innerHTML = "";
            } else {
                verificarNomina(this.value);
            }
        }
        clasificarNomina(this.value);
    });
    $("#btnInhabiles").click(function() {
        this.parentNode.style.display = "none";
        document.getElementById("divBtnHabiles").style.display = "block";
        limpiarTabla();
        obtenerDatos(1);
    });
    $("#btnHabiles").click(function() {
        this.parentNode.style.display = "none";
        document.getElementById("divBtnInhabiles").style.display = "block";
        limpiarTabla();
        obtenerDatos(0);
    });
});

$(function() {
    $(document).on('keydown', '#nomina', function(event) {
        return event.keyCode === 8 || event.keyCode === 46 ? true : !isNaN(Number(event.key));
    });
});
$(function() {
    $(document).on('keydown', '#telefono', function(event) {
        return event.keyCode === 8 || event.keyCode === 46 ? true : !isNaN(Number(event.key));
    });
});