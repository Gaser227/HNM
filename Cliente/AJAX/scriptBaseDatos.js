var archivos = "";

function cerrarFormRestaurar() {
    form = document.getElementById("formularioRestauraciones");
    modal = document.getElementById("modal");
    modal.removeChild(form);
}

function realizarRespaldo() {
    $.ajax({
        url: "../../Servidor/PHP/respaldos.php",
        type: "POST"
    }).done(function(res) {
        alert(res);
        console.log("Resultado: ");
        console.log(res);
    }).fail(function(res) {
        console.log(res);
        console.error(xhr.responseText);
        console.error(status);
        console.error(error);
    });
}

function listarRespaldos() {
    $.ajax({
        url: "../../Servidor/PHP/restauraciones.php",
        type: "POST",
        data: "numFuncion=1"
    }).done(function(res) {
        if (res != "") {
            archivos = res.split("*");
            archivos.pop();
            console.log(archivos);
        }
    }).fail(function(res) {
        console.log(res);
    });
}

function crearOption(valor) {
    option = document.createElement("option");
    option.setAttribute("value", valor);
    option.innerHTML = valor;
    return option;
}

function selectCrear(valores, idSelect) {
    select = document.getElementById(idSelect);
    for (i = 0; i < valores.length; i++) {
        option = crearOption(valores[i]);
        select.appendChild(option);
    }
}

function mostrarFormRestaurar() {
    $.ajax({
        url: "./Plantillas/Forms/formularioRestauraciones.php",
        success: function(data) {
            $('#modal').html(data);
            document.getElementById("formularioRestauraciones").style.display = "block";
            $.getScript("./AJAX/scriptBaseDatos.js");
            if (archivos != "")
                selectCrear(archivos, "bases");
        }
    });
}

function restaurarBase(){
    var formulario = document.getElementById('formRestauracion');
    var datos = new FormData(formulario);
    datos.append("numFuncion",2);
    $.ajax({
        url: "../../Servidor/PHP/restauraciones.php",
        type: "POST",
        data: datos,
        processData: false, 
        contentType: false 
    }).done(function(res) {
        Swal.fire(res);
        console.log(res);
    }).fail(function(res) {
        console.log(res);
    });
}

$(document).ready(function() {
    $("#btnRespaldoBD").on("click", function(evt) {
        evt.preventDefault();
        evt.stopImmediatePropagation();
        realizarRespaldo();
    });
    $("#btnRestauraciones").on("click", function(evt) {
        evt.preventDefault();
        evt.stopImmediatePropagation();
        listarRespaldos();
        mostrarFormRestaurar();
    });
    $("#btnRestaurar").on("click", function(evt) {
        evt.preventDefault();
        evt.stopImmediatePropagation();
        restaurarBase();
    });
    $("#btnCerrarModal").one("click", function() {
        cerrarFormRestaurar();
    });
    $("#btnCancelar").click(function() {
        cerrarFormRestaurar();
    });
});