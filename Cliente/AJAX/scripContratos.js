function mostrarFormContrato() {
    $.ajax({
        url: "./Plantillas/Forms/formularioContrato.php",
        success: function(data) {
            $('#modal').html(data);
            document.getElementById("formularioContrato").style.display = "block";
            $.getScript("./AJAX/scripContratos.js");
        }
    });
}

function mostrarFormCategoria() {
    $.ajax({
        url: "./Plantillas/Forms/formularioCategoria.php",
        success: function(data) {
            $('#modal').html(data);
            document.getElementById("formularioCategoria").style.display = "block";
            $.getScript("./AJAX/scripContratos.js");
        }
    });
    obtenerDatosContrato();
}

function mostrarMensaje() {
    document.getElementById("modalMensaje").style.display = "block";
    document.getElementById("mensaje").innerHTML = mensaje;
}
function selectCrear(valores, idSelect) {
    select = document.getElementById(idSelect);
    cantidad = valores.length - 1;
    //alert(valores);
    //alert(idSelect);
    //alert(cantidad);
    for (i = 0; i < cantidad; i++) {
        option = crearOption(valores[i]);
        select.appendChild(option);
    }
}
function crearOption(valor) {
    valores = valor.split("*");
    option = document.createElement("option");
    option.setAttribute("value", valores[0]);
    option.innerHTML = valores[1];
    return option;
}

function guardarContrato(e){
    if(validarCamposContrato()){
        e.preventDefault();
        e.stopImmediatePropagation();
        var urlSrc = "../../Servidor/PHP/contratos.php";
        resultado = document.getElementById("cont").hasChildNodes();
        console.log(resultado);
        if (!resultado) {
            alert("Define el contrato");
        } else {
            var formulario = document.getElementById('formCont');
            var datos = new FormData(formulario);
            datos.append("contrato", contrato);
            datos.append("numFuncion", 1);
            $.ajax({
                url: urlSrc,
                type: "POST",
                data: datos,
                processData: false,
                contentType: false
            }).done(function(res) {
                if (res == "Contrato guardado correctamente") {
                    cerrarFormCont();
                    limpiarTablaCont();
                    obtenerDatosContra();
                    Swal.fire(res);
                }else{
                    console.log(res);
                    Swal.fire(res);
                }
            }).fail(function(res) {
                alert(res);
            });
        }
    }
}

function guardarCategoria(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    var urlSrc = "../../Servidor/PHP/contratos.php";
    resultado = document.getElementById("cat").hasChildNodes(); //YA da
    console.log(resultado);
    if (!resultado) {
        alert("Define la categoria");
    } else {
        var formulario = document.getElementById('formCat');
        var datos = new FormData(formulario);
        datos.append("categoria", categoria);//Posible error
        datos.append("numFuncion", 5);
        //alert("Datos"+document.getElementById('formCat'));
        $.ajax({
            url: urlSrc,
            type: "POST",
            data: datos,
            processData: false,
            contentType: false
        }).done(function(res) {
            //alert(res);
            //console.log(res);
            if (res == "Categoria guardada correctamente") {
                cerrarFormCat();
                limpiarTablaCat();
                obtenerDatosCat();
                Swal.fire(res);
            }else{
                Swal.fire(res);
            }
        }).fail(function(res) {
            alert(res);
        });
    }
}

function validarCamposContrato(){
    elemento = document.getElementById("nombreContrato");
    contrato = document.getElementById("nombreContrato").value;
    if (contrato === "") {
        mensaje = "Nombre necesario";
        mostrarMensaje();
        return false;
    }
    clave = document.getElementById("claveContrato");
    clave = document.getElementById("claveContrato").value;
    if (clave === "") {
        mensaje = "Es necesario ingresar la calve";
        mostrarMensaje();
        return false;
    } else {
        if (clave.length > 4) {
            mensaje = ("La clave debe ser menos");
            mostrarMensaje();
            return false;
        }else{
            return true;
        }
    }
}

function obtenerDatosContrato(){
    //tipoCont
    alert("WEnas");
    $.ajax({
        url: "../../Servidor/PHP/contratos.php",
        type: "POST",
        data: "numFuncion=2"
    }).done(function(res) {
        selectCrear(res.split("#"), "tipoContrato");
        //console.log(res.split("#")); 
        //alert("result: "+ res.split("#"));
    }).fail(function(res) {
        console.log(res);
    });
}

function cargarContrato(claveContrato) {
    alert(claveContrato);
    mostrarFormContrato();
    cargarDatosCont(claveContrato);
}

function cargarCat(id) {
    //alert(id);
    mostrarFormCategoria();
    cargarDatosCat(id);
}

function cargarDatosCont(claveContrato) {
    var urlSrc = "../../Servidor/PHP/contratos.php";
    var datos = "claveContrato=" + claveContrato + "&numFuncion=4";
    alert("Contrato"+claveContrato);
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: datos
    }).done(function(res) {
        datosCont = res.split("*");
        llenarFormCont(datosCont);
    }).fail(function(res) {
        console.log(res);
    });
}
function cargarDatosCat(id) {
    var urlSrc = "../../Servidor/PHP/contratos.php";
    var datos = "id=" + id + "&numFuncion=8";
    //alert("Categoria"+id);
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: datos
    }).done(function(res) {
        datos = res.split("*");
        llenarFormCat(datos);
    }).fail(function(res) {
        console.log(res);
    });
}
function eliminarContrato(claveContrato) {
    var urlSrc = "../../Servidor/PHP/contratos.php";
    var datos = "claveContrato=" + claveContrato + "&numFuncion=3";
    $.ajax({  
        url: urlSrc,
        type: "POST",
        data: datos
    }).done(function(res) {
        if (res == "Registro eliminado correctamente") {
            limpiarTablaCont();
            obtenerDatosContra();
            Swal.fire(res);
        }else{
            Swal.fire(res);
        }
    }).fail(function(res) {
        console.log(res);
    });
}
function eliminarCat(id) {
    var urlSrc = "../../Servidor/PHP/contratos.php";
    var datos = "id=" + id + "&numFuncion=7";
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: datos
    }).done(function(res) {
        if (res == "Registro eliminado correctamente") {
            limpiarTablaCat();
            obtenerDatosCat();
            Swal.fire(res);
        }else{
            Swal.fire(res);
        }
    }).fail(function(res) {
        console.log(res);
    });
}
function crearTablaCont() {
    $('#tablaContratos').DataTable({
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
function creartablaCat() {
    $('#tablaCategorias').DataTable({
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
function limpiarTablaCont() {
    tablaCont = $("#tablaContratos").DataTable();
    tablaCont.clear().draw();
}
function limpiarTablaCat() {
    tablaCont = $("#tablaCategoria").DataTable();
    tablaCont.clear().draw();
}
function llenarTablaContrato(valores) {
    tablaCont = $("#tablaContratos").DataTable();
    tablaCont.clear().draw();
    for (var i = 0; i < (valores.length - 1); i++) {
        var dat = valores[i].split("*"); 
        tablaCont.row.add([
            dat[0],
            dat[1],
            "<input title='Modificar' class='w3-btn w3-blue' type='button' value='&#9998' onclick='cargarContrato(\""+ dat[0] + "\")'> <input title='Eliminar' class='w3-btn w3-red' type='button' value='&#10006' onclick='eliminarContrato(\""+ dat[0] + "\")'>" //
        ]).draw(false);
        console.log(dat[0]);
    }
}
function llenarTablaCat(valores) {
    tablaCat = $("#tablaCategorias").DataTable();
    tablaCat.clear().draw();
    for (var i = 0; i < (valores.length - 1); i++) {
        var dat = valores[i].split("*");
        tablaCat.row.add([
            dat[1],
            dat[2],
            "<input title='Modificar' class='w3-btn w3-blue' type='button' value='&#9998' onclick='cargarCat("+ dat[0] + ")'>  <input title='Eliminar' class='w3-btn w3-red' type='button' value='&#10006' onclick='eliminarCat(" + dat[0] + ")'>"
        ]).draw(false);
        //console.log(dat);
    }
}
function obtenerDatosContra() {
    var urlSrc = "../../Servidor/PHP/contratos.php";
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: "numFuncion=2"
    }).done(function(res) {
        valores = res.split("#");
        llenarTablaContrato(valores);
    }).fail(function(res) {
        console.log(res);
    });
}
function llenarFormCont(datos) { 
    $("#claveContrato").val(datos[0]);
    $("#nombreContrato").val(datos[1]);
    $("#tipoOperacion").val(2);
}
function llenarFormCat(datos) { //Aqui
    alert(datos[0]);
    alert(datos[2]);
    $("#idCat").val(datos[0]);
    $("#nombreCategoria").val(datos[1]);
    $("#tipoContrato").val(datos[2]);
}
function obtenerDatosCat() {
    var urlSrc = "../../Servidor/PHP/contratos.php";
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: "numFuncion=6"
    }).done(function(res) {
        valores = res.split("#");
        llenarTablaCat(valores);
    }).fail(function(res) {
        console.log(res);
    });
}
function cerrarModalMensaje() {
    document.getElementById("modalMensaje").style.display = "none";
    if (elemento) {
        elemento.style.borderColor = "red";
        elemento.focus();
        elemento = "";
    }
    if (sesion == 1) {
        window.location.replace("./index.php");
    }
}
function cerrarModalMensajeCat() {
    document.getElementById("modalMensajeCat").style.display = "none";
    if (elemento) {
        elemento.style.borderColor = "red";
        elemento.focus();
        elemento = "";
    }
    if (sesion == 1) {
        window.location.replace("./index.php");
    }
}
function cerrarFormCont(){
    form = document.getElementById("formularioContrato");
    modalF = document.getElementById("modal");
    modalF.removeChild(form);
}
function cerrarFormCat(){
    formm = document.getElementById("formularioCategoria");
    modalC = document.getElementById("modal");
    modalC.removeChild(formm);
}

/*----------------------------------------------------------------*/
$(document).ready(function() {
    if (!document.getElementById("formularioContrato")) {
        crearTablaCont();
        obtenerDatosContra();
    }
    if (!document.getElementById("formularioCategoria")) {
        creartablaCat();
        obtenerDatosCat();
    }

    $("#btnCerrarModalCont").click(function() {
        cerrarFormCont();
    });
    $("#btnCerrarModalCat").click(function() {
        cerrarFormCat();
    });
    $("#btnCancelarContrato").click(function() {
        cerrarFormCont();
    });
    $("#btnCancelarCategoria").click(function() {
        cerrarFormCat();
    });
    $("#btnCerrarMensajeTop").click(function() {
        cerrarModalMensaje();
    });
    $("#btnCerrarMensaje").click(function() {
        cerrarModalMensaje();
    });
    $("#btnCerrarMensajeTopCat").click(function() {
        cerrarModalMensajeCat();
    });
    $("#btnCerrarMensajeCat").click(function() {
        cerrarModalMensajeCat();
    });
    if (document.getElementById("formularioContrato")) {
        form = document.getElementById("formCont");
        form.addEventListener("submit", function(evt) {
            evt.preventDefault();
            guardarContrato(evt);
        });
    }
    if (document.getElementById("formularioCategoria")) {
        form = document.getElementById("formCat");
        form.addEventListener("submit", function(evt) {
            evt.preventDefault();
            guardarCategoria(evt);
        });
    }
});
