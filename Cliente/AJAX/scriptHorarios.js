var dias = "",
    horaEntrada = "",
    horasTrabajo = "",
    horarios = "",
    numBoton = 0;

function limpiarCamposHorario() {
    document.getElementById("horaEntrada").value = "";
    document.getElementById("horasTrabajo").value = "";
    var x = document.getElementsByClassName("diasLab");
    for (i = 0; i < x.length; i++) {
        x[i].parentElement.style.background = "#ddd";
        x[i].checked = false;
    }
}

function cerrarFormHorario() {
    form = document.getElementById("formularioHorario");
    modal = document.getElementById("modal");
    modal.removeChild(form);
}

function cerrarFormFestio() {
    form = document.getElementById("formularioFestio");
    modalF = document.getElementById("modal");
    modalF.removeChild(form);
}

function obtenerHoras() {
    horaEntrada = document.getElementById("horaEntrada").value;
    horasTrabajo = document.getElementById("horasTrabajo").value;
}

function obtenerDiasSel() {
    dia = document.getElementById("lunes");
    valor = dia.checked;
    if (valor != false)
        dias += "Lu";
    dia = document.getElementById("martes");
    valor = dia.checked;
    if (valor != false)
        dias += "Ma";
    dia = document.getElementById("miercoles");
    valor = dia.checked;
    if (valor != false)
        dias += "Mi";
    dia = document.getElementById("jueves");
    valor = dia.checked;
    if (valor != false)
        dias += "Ju";
    dia = document.getElementById("viernes");
    valor = dia.checked;
    if (valor != false)
        dias += "Vi";
    dia = document.getElementById("sabado");
    valor = dia.checked;
    if (valor != false)
        dias += "Sa";
    dia = document.getElementById("domingo");
    valor = dia.checked;
    if (valor != false)
        dias += "Do";
    dia = document.getElementById("diasFest");
    valor = dia.checked;
    if (valor != false)
        dias += "Df";
}

function eliminarDefHorario(evt) {
    boton = evt.currentTarget.myParam;
    padre = boton.parentElement.parentElement;
    document.getElementById("horarios").removeChild(padre);
}

function crearInputs() {
    div = document.getElementById("horarios");
    divHora = document.createElement("div");
    divHora.setAttribute("class", "w3-row");
    divCol = document.createElement("div");
    divCol.setAttribute("class", "w3-col");
    divCol.setAttribute("style", "width: 80%;");
    input = document.createElement("input");
    input.setAttribute("readonly", "true");
    input.setAttribute("class", "w3-input w3-border");
    input.setAttribute("value", horarios);
    divCol.appendChild(input);
    divHora.appendChild(divCol);
    divCol = document.createElement("div");
    divCol.setAttribute("class", "w3-col");
    divCol.setAttribute("style", "width: 10%;");
    boton = document.createElement("input");
    boton.setAttribute("type", "button");
    boton.setAttribute("value", "Eliminar");
    boton.setAttribute("class", "w3-btn w3-red");
    boton.setAttribute("id", "btnEliminar" + numBoton);
    divCol.appendChild(boton);
    divHora.appendChild(divCol);
    div.appendChild(divHora);
    btn = document.getElementById("btnEliminar" + numBoton);
    boton.addEventListener("click", eliminarDefHorario, false);
    boton.myParam = btn;
}

function eventoHorario() {
    obtenerDiasSel();
    obtenerHoras();
    if (dias == "") {
        alert("Debes seleccionar al menos un día");
        dias = "";
    } else {
        if (horaEntrada == "" || horasTrabajo == "") {
            alert("Debes llenar todos los campos de horas");
            dias = "";
        } else {
            numBoton += 1;
            horas = horasTrabajo.split(":");
            horasMins = horas[0] * 60;
            totalMinutos = horasMins + parseInt(horas[1]);
            horaSalida = moment(horaEntrada, 'HH:mm').add(totalMinutos, 'minutes').format('HH:mm');
            horarios = dias + " " + horaEntrada + " " + horaSalida;
            crearInputs();
            limpiarCamposHorario();
            document.getElementById("divBotonesHorario").style.display = "none";
            document.getElementById("btnNuevaDefinicion").style.display = "block";
            document.getElementById("definirHorario").style.display = "none";
            dias = "", horaEntrada = "", horasTrabajo = "";
        }
    }
}

function obtenerValoresInputs() {
    hijos = $("#horarios").children();
    horarios = "";
    hijos.each(function() {
        horarios += this.firstChild.firstChild.value + "/";
    });
}

function guardarHorario(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    var urlSrc = "../../Servidor/PHP/horarios.php";
    resultado = document.getElementById("horarios").hasChildNodes();
    console.log("Resultado");
    console.log(resultado);
    if (!resultado) {
        alert("Define dias laborales y horas");
        document.getElementById("btnNuevaDefinicion").focus();
    } else {
        obtenerValoresInputs();
        var formulario = document.getElementById('formHorario');
        var datos = new FormData(formulario);
        datos.append("horarios", horarios);
        datos.append("numFuncion", 2);
        $.ajax({
            url: urlSrc,
            type: "POST",
            data: datos,
            processData: false,
            contentType: false
        }).done(function(res) {
            console.log("Mensaje"); 
            console.log(res);
            Swal.fire(res);
            if (res == "Registro guardado correctamente") {
                cerrarFormHorario();
                limpiarTabla();
                obtenerDatos();
            }
            horarios = "";
        }).fail(function(res) {
            alert(res);
        });
    }
}


function obtenerValoresInputsFest() {
    hijos = $("#festividades").children();
    horarios = "";
    hijos.each(function() {
        horarios += this.firstChild.firstChild.value + "/";
    });
}

function guardarFestividad(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    var urlSrc = "../../Servidor/PHP/festividades.php";
    resultado = document.getElementById("formFest").hasChildNodes();
    console.log(resultado);
    if (!resultado) {
        alert("Define las festividades");
        document.getElementById("btnMostrarFestividades").focus();
    } else {
        /**/
        //obtenerValoresInputsFest();
        var formulario = document.getElementById('formFest');
        var datos = new FormData(formulario);
        //var datos = "nombreFestividad=" + Festividad + "&fecha=" + fecha + "&numFuncion=2"; 
        datos.append("fest", festividad);//Posible error
        datos.append("fecha",fecha)
        datos.append("numFuncion", 2);
        $.ajax({
            url: urlSrc,
            type: "POST",
            data: datos,
            processData: false,
            contentType: false
        }).done(function(res) {
            Swal.fire(res);
            if (res == "Festividad guardada correctamente") {
                cerrarFormFestio();
                limpiarTablaFest();
                obtenerDatosFest();
            }
            //festividades = "";
        }).fail(function(res) {
            alert(res);
        });
    }
}



function pintarBotonesEditar(cadena) {
    switch (cadena) {
        case "Lu":
            document.getElementById("lunes").setAttribute("checked", true);
            boton = document.getElementById("lunes").parentElement;
            boton.style.background = "#9f9";
            break;
        case "Ma":
            document.getElementById("martes").setAttribute("checked", true);
            boton = document.getElementById("martes").parentElement;
            boton.style.background = "#9f9";
            break;
        case "Mi":
            document.getElementById("miercoles").setAttribute("checked", true);
            boton = document.getElementById("miercoles").parentElement;
            boton.style.background = "#9f9";
            break;
        case "Ju":
            document.getElementById("jueves").setAttribute("checked", true);
            boton = document.getElementById("jueves").parentElement;
            boton.style.background = "#9f9";
            break;
        case "Vi":
            document.getElementById("viernes").setAttribute("checked", true);
            boton = document.getElementById("viernes").parentElement;
            boton.style.background = "#9f9";
            break;
        case "Sa":
            document.getElementById("sabado").setAttribute("checked", true);
            boton = document.getElementById("sabado").parentElement;
            boton.style.background = "#9f9";
            break;
        case "Do":
            document.getElementById("domingo").setAttribute("checked", true);
            boton = document.getElementById("domingo").parentElement;
            boton.style.background = "#9f9";
            break;
        case "Df":
            document.getElementById("diasFest").setAttribute("checked", true);
            boton = document.getElementById("diasFest").parentElement;
            boton.style.background = "#9f9";
            break;
    }
}

function llenarFormHorario(datos) {
    $("#idHorario").val(datos[0]);
    $("#selecTurno").val(datos[1]);
    if (datos[2] != "") {
        horariosAux = datos[2].split("/");
        for (i = 0; i < horariosAux.length; i++) {
            horarios = horariosAux[i];
            numBoton = i + 1;
            crearInputs();
        }
    }
}

function cargarDatosHorario(id) {
    var urlSrc = "../../Servidor/PHP/horarios.php";
    var datos = "id=" + id + "&numFuncion=4";
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: datos
    }).done(function(res) {
        datosHor = res.split("*");
        llenarFormHorario(datosHor);
    }).fail(function(res) {
        console.log(res);
    });
}

function cargarHorario(id) {
    //alert(id);
    mostrarFormHorario();
    cargarDatosHorario(id);
}

function eliminarHorario(id) {
    alert(id);
    var urlSrc = "../../Servidor/PHP/horarios.php";
    var datos = "id=" + id + "&numFuncion=3";
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: datos
    }).done(function(res) {
        Swal.fire(res);
        if (res == "Registro eliminado correctamente") {
            limpiarTabla();
            obtenerDatos();
        }
    }).fail(function(res) {
        console.log(res);
    });
}

function crearTabla() {
    $('#tablaHorarios').DataTable({
        "bDestroy": true,
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
    tabla = $("#tablaHorarios").DataTable();
    tabla.clear().draw();
}

function llenarTabla(valores) {
    tabla = $("#tablaHorarios").DataTable();
    tabla.clear().draw();
    for (var i = 0; i < (valores.length - 1); i++) {
        var dat = valores[i].split("*");
        tabla.row.add([
            dat[1],
            dat[2],
            "<input title='Modificar' class='w3-btn w3-blue' type='button' value='&#9998' onclick='cargarHorario(" + dat[0] + ")'>  <input title='Eliminar' class='w3-btn w3-red' type='button' value='&#10006' onclick='eliminarHorario(" + dat[0] + ")'>"
        ]).draw(false);
    }
}

function obtenerDatos() {
    var urlSrc = "../../Servidor/PHP/horarios.php";
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: "numFuncion=1"
    }).done(function(res) {
        valores = res.split("--");
        llenarTabla(valores);
    }).fail(function(res) {
        console.log(res);
    });
}


/* Festividades */

function llenarFormFestio(datos) {
    
    console.log(datos[0]);
    console.log(datos[1]);
    console.log(datos[2]);
    //$("#selecTurno").val(datos[1]);
    $("#idFestio").val(datos[0]);
    $("#Festividad").val(datos[1]); 
    $("#FechFest").val(datos[2]); 
}

function mostrarFormHorario() {
    $.ajax({
        url: "./Plantillas/Forms/formularioHorario.php",
        success: function(data) {
            $('#modal').html(data);
            document.getElementById("formularioHorario").style.display = "block";
            $.getScript("./AJAX/scriptHorarios.js");
        }
    });
}

function cargarFestio(id) {
    //alert(id);
    mostrarFormFestivo();
    cargarDatosFestio(id);
}

function cargarDatosFestio(id) {
    var urlSrc = "../../Servidor/PHP/festividades.php";
    var datos = "id=" + id + "&numFuncion=4";
    alert("Festividad"+id);
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: datos
    }).done(function(res) {
        datos = res.split("*");
        console.log(fecha);
        console.log(datos[2]);
        llenarFormFestio(datos);
    }).fail(function(res) {
        console.log(res);
    });
}
 
function eliminarFestio(id) {
    //alert(id);
    var urlSrc = "../../Servidor/PHP/festividades.php";
    var datos = "id=" + id + "&numFuncion=3";  
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: datos
    }).done(function(res) {
        Swal.fire(res);
        if (res == "Festividad eliminada correctamente") {
            limpiarTablaFest();
            obtenerDatosFest();
        }
    }).fail(function(res) {
        console.log(res);
    });
}

function crearTablaFest() {
    $('#tablaFestividades').DataTable({
        "bDestroy": true,
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

function limpiarTablaFest() {
    tablaFest = $("#tablaFestividades").DataTable();
    tablaFest.clear().draw();
}

function llenarTablaFest(valores) {
    tablaFest = $("#tablaFestividades").DataTable();
    tablaFest.clear().draw();
    for (var i = 0; i < (valores.length - 1); i++) {
        var dat = valores[i].split("*");
        tablaFest.row.add([
            dat[1],
            dat[2],
            "<input title='Modificar' class='w3-btn w3-blue' type='button' value='&#9998' onclick='cargarFestio(" + dat[0] + ")'>  <input title='Eliminar' class='w3-btn w3-red' type='button' value='&#10006' onclick='eliminarFestio(" + dat[0] + ")'>"
        ]).draw(false);
    }
}

function obtenerDatosFest() {
    var urlSrc = "../../Servidor/PHP/festividades.php";
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: "numFuncion=1"
    }).done(function(res) {
        valores = res.split("--");
        llenarTablaFest(valores);
    }).fail(function(res) {
        console.log(res);
    });
}

function mostrarFormFestivo() {
    $.ajax({
        url: "./Plantillas/Forms/formularioFestio.php",
        success: function(data) {
            $('#modal').html(data);
            document.getElementById("formularioFestio").style.display = "block";
            $.getScript("./AJAX/scriptHorarios.js");
        }
    });
}

$(document).ready(function() {
    if (!document.getElementById("formularioHorario")) {
        crearTabla();
        obtenerDatos();
    }
    if (!document.getElementById("formularioFestio")) {
        crearTablaFest();
        obtenerDatosFest();
    }
    $(".diasLab").on("change", function() {
        valor = this.checked;
        if (valor == false) {
            this.parentElement.style.background = "#ddd";
        } else {
            this.parentElement.style.background = "#9f9";
        }
    });
    $("#btnCerrarModal").click(function() {
        cerrarFormHorario();
    });
    $("#btnCerrarModalFest").click(function() {
        cerrarFormFestio();
    });
    $("#btnNuevaDefinicion").click(function() {
        this.style.display = "none";
        document.getElementById("divBotonesHorario").style.display = "block";
        document.getElementById("definirHorario").style.display = "block";
    });
    $("#btnMostrarFestividades").click(function() {
        this.style.display = "none";
        document.getElementById("divMuestraFestividades").style.display = "block";
        //obtenerDatosFest();
    });
    $("#btnListo").click(function() {
        eventoHorario();
    });
    $("#btnCancela").click(function() {
        limpiarCamposHorario();
        document.getElementById("divBotonesHorario").style.display = "none";
        document.getElementById("btnNuevaDefinicion").style.display = "block";
        document.getElementById("definirHorario").style.display = "none";
    });
    $("#btnCancelarHorario").click(function() {
        cerrarFormHorario();
    });
    $("#btnCancelarFestio").click(function() {
        cerrarFormFestio();
    });
    if (document.getElementById("formularioHorario")) {
        form = document.getElementById("formHorario");
        form.addEventListener("submit", function(evt) {
            evt.preventDefault();
            guardarHorario(evt);
        });
    }

    if (document.getElementById("formularioFestio")) {
        form = document.getElementById("formFest");
        form.addEventListener("submit", function(evt) {
            evt.preventDefault();
            guardarFestividad(evt);
        });
    }
});