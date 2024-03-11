var mensaje = "",
    elemento = "",
    sesion = 0;
var username = "",
    password = "";

function mostrarMensaje() {
    document.getElementById("modalMensaje").style.display = "block";
    document.getElementById("mensaje").innerHTML = mensaje;
}

///

/*---------------------------------------------------------- Funciones Login ---------------------------------------*/

///
function limpiarCamposLogin() {
    document.getElementById("usuarioLogin").value = "";
    document.getElementById("contrasenaLogin").value = "";
}

function validarCamposLogin() {
    elemento = document.getElementById("usuarioLogin");
    username = document.getElementById("usuarioLogin").value;
    if (username === "") {
        mensaje = "Número de nómina necesario";
        mostrarMensaje();
        return false;
    }
    elemento = document.getElementById("contrasenaLogin");
    password = document.getElementById("contrasenaLogin").value;
    if (password === "") {
        mensaje = "Contraseña necesaria";
        mostrarMensaje();
        return false;
    }
    return true;
}

function eventoBotonLogin() {
    var urlSrc = "../../Servidor/PHP/login.php";
    if (validarCamposLogin()) {
        var datos = "nomina=" + username + "&contrasena=" + password + "&numFuncion=1";
        $.ajax({
            url: urlSrc,
            type: 'POST',
            data: datos,
         
        }).done(function(res) {
            if (res === "Sesión Iniciada") {
                window.location.replace("./home.php");
            } else {
                mensaje = res;
                mostrarMensaje();
            }
        }).fail(function(res) {
            console.log(res);
        });
    }
}

function eventoBotonLogout() {
    var urlSrc = "../../Servidor/PHP/login.php";
    $.ajax({
        url: urlSrc,
        type: 'POST',
        data: "numFuncion=2"
    }).done(function(res) {
        mensaje = res;
        sesion = 1;
        mostrarMensaje();
    }).fail(function(res) {
        console.log(res);
    });
}

///

/*---------------------------------------------------------- Funciones registro contraseña ---------------------------------------*/

///
function limpiarCamposRegistro() {
    document.getElementById("usuarioRegistro").value = "";
    document.getElementById("contrasenaRegistro").value = "";
    document.getElementById("contrasenaCRegistro").value = "";
}

function validarCamposRegistroContrasena() {
    elemento = document.getElementById("usuarioRegistro");
    username = document.getElementById("usuarioRegistro").value;
    if (username === "") {
        mensaje = "Número de nómina necesario";
        mostrarMensaje();
        return false;
    }
    elemento = document.getElementById("contrasenaRegistro");
    password = document.getElementById("contrasenaRegistro").value;
    if (password === "") {
        mensaje = "Contraseña necesaria";
        mostrarMensaje();
        return false;
    } else {
        if (password.length < 8) {
            mensaje = ("La contraseña debe tener al menos 8 caracteres");
            mostrarMensaje();
            return false;
        }
    }
    elemento = document.getElementById("contrasenaCRegistro");
    passwordConf = document.getElementById("contrasenaCRegistro").value;
    if (passwordConf === "") {
        mensaje = "Es necesario confirmar la contraseña";
        mostrarMensaje();
        return false;
    } else {
        if (password.length < 8) {
            mensaje = ("La contraseña debe tener al menos 8 caracteres");
            mostrarMensaje();
            return false;
        }
    }
    if (password !== passwordConf) {
        mensaje = "Las contraseñas no coinciden";
        mostrarMensaje();
        return false;
    }
    return true;
}

function eventoBotonRegistro() {
    var urlSrc = "../../Servidor/PHP/login.php";
    if (validarCamposRegistroContrasena()) {
        var datos = "nomina=" + username + "&contrasena=" + password + "&numFuncion=3";
        $.ajax({
            url: urlSrc,
            type: 'POST',
            data: datos
        }).done(function(res) {
            if (res !== "Ocurrio un error") {
                cerrarModalC();
            }
            mensaje = res;
            mostrarMensaje();
        }).fail(function(res) {
            console.log(res);
        });
    }
}

///
/*---------------------------------------------------------- Funciones cambiar contraseña ---------------------------------------*/
function eventoBotonCambio() {
    var urlSrc = "../../Servidor/PHP/login.php";
    if (validarCamposCambioContrasena()) {
        var datos = "&nuevaContraseña=" + password + "&numFuncion=5";
        $.ajax({
            url: urlSrc,
            type: 'POST',
            data: datos
        }).done(function(res){
            if (res !== "Ocurrio un error") {
                cerrarModalCambio();
            }
            console.log(res);
            mensaje = "Se realizo el cambio de contraseña correctamente";
            res = mensaje;
            console.log(res);
            mostrarMensaje();
        }).fail(function(res){
            console.log(res);
        });
    }
}

function validarCamposCambioContrasena() {
    elemento = document.getElementById("contrasenaCambio");
    pass = document.getElementById("contrasenaCambio").value;
    if (pass === "") {
        mensaje = "Contraseña necesaria";
        mostrarMensaje();
        return false;
    } /*else {
        if (pass.length < 8) {
            mensaje = ("La contraseña debe tener al menos 8 caracteres");
            mostrarMensaje();
            return false;
        }
    }*/
    elemento = document.getElementById("nuevaContraseña");
    password = document.getElementById("nuevaContraseña").value;
    if (password === "") {
        mensaje = "Es necesario ingresar la nueva contraseña";
        mostrarMensaje();
        return false;
    } else {
        if (password.length < 8) {
            mensaje = ("La contraseña debe tener al menos 8 caracteres");
            mostrarMensaje();
            return false;
        }
    }
    elemento = document.getElementById("nuevaContraseñaC");
    passwordConf = document.getElementById("nuevaContraseñaC").value;
    if (passwordConf === "") {
        mensaje = "Es necesario confirmar la nueva contraseña";
        mostrarMensaje();
        return false;
    } else {
        if (passwordConf.length < 8) {
            mensaje = ("La contraseña debe tener al menos 8 caracteres");
            mostrarMensaje();
            return false;
        }
    }
    if (password !== passwordConf) {
        mensaje = "Las contraseñas no coinciden";
        mostrarMensaje();
        return false;
    }
    if (pass == password || pass == passwordConf) {
        mensaje = "La contraseña no puede ser la misma";
        mostrarMensaje();
        return false;
    }
    return true;
}

function limpiarCamposConf() {
    document.getElementById("contrasenaCambio").value = "";
    document.getElementById("nuevaContraseña").value = "";
    document.getElementById("nuevaContraseñaC").value = "";
}

/*---------------------------------------------------------- Funciones recuperar contraseña ---------------------------------------*/

///
function limpiarCamposRecuperar() {
    document.getElementById("usuarioRecuperar").value = "";
    //document.getElementById("correoRecuperar").value = "";
}

function validarCamposRecuperarContrasena() {
    //elemento = document.getElementById("usuarioRecuperar");
    username = document.getElementById("usuarioRecuperar").value;
    if (username == "") {
        mensaje = "Número de nómina necesario";
        mostrarMensaje();
        return false;
    }
    return true;
}

function eventoBotonRecuperar() {
    var urlSrc = "../../Servidor/PHP/login.php";
    if (validarCamposRecuperarContrasena()) {
        var datos = "nomina=" + username + "&numFuncion=4";
        $.ajax({
            url: urlSrc,
            type: 'POST',
            data: datos
        }).done(function(res) {
            if (res !== "Ocurrio un error") {
                cerrarModalR();
            }
            mensaje = res;
            mostrarMensaje();
        }).fail(function(res) {
            console.log(res);
        });
    }
}

/*  */

function abrirModalC() {
    document.getElementById("modalRegistroContrasena").style.display = "block";
    document.getElementById("usuarioRegistro").focus();
}

function cerrarModalC() {
    document.getElementById("modalRegistroContrasena").style.display = "none";
    limpiarCamposRegistro();
}

function abrirModalR() {
    document.getElementById("modalRecuperarContrasena").style.display = "block";
    document.getElementById("usuarioRecuperar").focus();
}

function cerrarModalR() {
    document.getElementById("modalRecuperarContrasena").style.display = "none";
    limpiarCamposRecuperar();
}

/*function abrirModalCam() {
    document.getElementById("modalCambioContrasena").style.display = "block";
    document.getElementById("usuarioRecuperar").focus();
}

function cerrarModalCam() {
    document.getElementById("modalCambioContrasena").style.display = "none";
    limpiarCamposRecuperar();
}*/

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

/**/

function abrirModalConf() {
    document.getElementById("modalCambioContrasena").style.display = "block";
    document.getElementById("nuevaContraseña").focus();
}

function cerrarModalCambio() {
    document.getElementById("modalCambioContrasena").style.display = "none";
    limpiarCamposConf();
}


/*---------------------------------------------------------- Llamadas ---------------------------------------*/

$(document).ready(function() {
    if (document.getElementById("usuarioLogin")) {
        limpiarCamposLogin();
        document.getElementById("usuarioLogin").focus();
    }
    $("#botonLogin").click(function() {
        eventoBotonLogin();
    });

    $("#btnLogout").click(function() {
        eventoBotonLogout();
    });

    $("#btnRegistro").click(function() {
        eventoBotonRegistro();
    });

    $("#btnCambio").click(function() {
        eventoBotonCambio();
    });

    $("#btnRecuperar").click(function() {
        eventoBotonRecuperar();
    });

    $("#registroContrasena").click(function() {
        abrirModalC();
    });

    $("#btnConfiguraciones").click(function() {
        abrirModalConf();
    });

    $("#btnCancelarConf").click(function() {
        cerrarModalCambio();
    });

    $("#btnCerrarModalConf").click(function() {
        cerrarModalCambio();
    });

    $("#recuperarContrasena").click(function() {
        abrirModalR();
    });
    $("#btnCerrarModalC").click(function() {
        cerrarModalC();
    });
    $("#btnCerrarModalR").click(function() {
        cerrarModalR();
    });
    $("#btnCancelarC").click(function() {
        cerrarModalC();
    });
    $("#btnCancelarR").click(function() {
        cerrarModalR();
    });
    $("#btnCerrarMensajeTop").click(function() {
        cerrarModalMensaje();
    });
    $("#btnCerrarMensaje").click(function() {
        cerrarModalMensaje();
    });
    $("#registroContrasena").click(function() {
        abrirModalC();
    });
});
$(function() {
    $(document).on("keyup", "#usuarioLogin", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("contrasenaLogin").focus();
        }
        if (event.keyCode === 9) {
            event.preventDefault();
            document.getElementById("contrasenaLogin").focus();
        }
    });
});
$(function() {
    $(document).on("keyup", "#contrasenaLogin", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("botonLogin").click();
        }
    });
});
$(function() {
    $(document).on('keydown', '#usuarioLogin', function(event) {
        return event.keyCode === 8 || event.keyCode === 46 ? true : !isNaN(Number(event.key));
    });
});

$(function() {
    $(document).on("keyup", "#usuarioRegistro", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("contrasenaRegistro").focus();
        }
        if (event.keyCode === 9) {
            event.preventDefault();
            document.getElementById("contrasenaRegistro").focus();
        }
    });
});
$(function() {
    $(document).on("keyup", "#contrasenaRegistro", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("contrasenaCRegistro").focus();
        }
    });
});
$(function() {
    $(document).on("keyup", "#contrasenaCRegistro", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("btnRegistro").click();
        }
    });
});

$(function() {
    $(document).on('keydown', '#usuarioRegistro', function(event) {
        return event.keyCode === 8 || event.keyCode === 46 ? true : !isNaN(Number(event.key));
    });
});

$(function() {
    $(document).on("keyup", "#usuarioRecuperar", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("correoRecuperar").focus();
        }
        if (event.keyCode === 9) {
            event.preventDefault();
            document.getElementById("correoRecuperar").focus();
        }
    });
});


$(function() {
    $(document).on("keyup", "#contrasenaCambio", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("contrasenaCambio").focus();
        }
        if (event.keyCode === 9) {
            event.preventDefault();
            document.getElementById("contrasenaCambio").focus();
        }
    });
});
/*$(function() {
    $(document).on("keyup", "#correoRecuperar", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("btnRecuperar").click();
        }
    });
});*/
$(function() {
    $(document).on('keydown', '#usuarioRecuperar', function(event) {
        return event.keyCode === 8 || event.keyCode === 46 ? true : !isNaN(Number(event.key));
    });
});
