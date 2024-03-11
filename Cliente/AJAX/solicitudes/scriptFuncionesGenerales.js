
var datosHorario = [];

function fechaActual(bandera , valor)// funcion que carga la fecha y permite ser modifica en caso de ser necesario
{
    
    var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    var dias = ["Domingo","Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"];
    if(bandera){
       
        var date = new Date(valor.replace(/-+/g, '/'));
        var fechaNum = date.getDate();
        var mes_name = date.getMonth();
        var fecha = date.getFullYear() + "/" + (date.getMonth()+1) + "/" + fechaNum;
        var f = (dias[date.getDay()] + " " + fechaNum + " de " + meses[mes_name] + " de " + date.getFullYear());
        $('#fechaCreacion').text(f);
        $('#fechaJustificada').val(fecha);
        
    }else{
        /* diasSemana = new Array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado"); */
        date = new Date();
        fecha = date.getFullYear() + "/" + (date.getMonth() + 1) + "/" + (date.getDate()) ;
        f = (dias[date.getDay()] + " " + (date.getDate()) + " de " + meses[date.getMonth()] + " de " + date.getFullYear());
        $('#fechaCreacion').text(f);
        $('#fechaJustificada').val(fecha);
 
    }
}

function cargarDatosEmpleado()// Esta funcion carga los datos personales del empleado en el formulario
{ 
    id = document.getElementById("idEmpleado").value;
    var datos = "id=" + id + "&numFuncion=8";
     $.ajax({
        async:false,
         url: urlSrc + "empleados.php",
        type: "POST",
        data: datos
    }).done(function(res){
        var datos = res.split('%');
        console.log("FuncionGeneral");
        console.log(datos)
        obtenerFolio();
        var datosEmpleado = datos[0].split('*');
        console.log(datosEmpleado);
        console.log("");
        console.log(datos);
        var [adscripcion, categoria] = obtenerCategoriaAdscripcion(datos[1],datos[2], datosEmpleado[12], datosEmpleado[13]);
       
        $('#fechaJustificada').val(fecha); 
        $('#nomina').val(datosEmpleado[1]);
        $('#nombre').val(datosEmpleado[2]);
        $('#idHorario').val(datosEmpleado[11]);
        $('#adscripcion').val(adscripcion);
        $('#categoria').val(categoria);
        $('#tipoContrato').val(datos[4]); 
        $('#firmaEmpleado').text(datosEmpleado[2]); 
         //$('#horario').val("--:-- a --:--");
        $("#estatus").val(obtenerTipoContrato(datos[4]));
        /*alert(datos[3]);
        alert(obtenerTipoContrato(datos[3]));*/
        //tipoContrato = datos[3];
        obtenerHorario();
        //mostrarHoraES();
        /* cargarSelectTipoSalida();
        mostrarCheckBox();
        cargarSelectJefe() 
        cargarSelectAdscripcion(); */
    }).fail(function(res){
        console.log(res);
      
    }); 
}

function obtenerTipoContrato(valor){
    valor = valor.toLowerCase();
    if(valor == "bs" ){
        return "Base sindicalizado";    
    } else if (valor == "c") {
        return "Confianza"
    } else if (valor == "g") {
        return "Cuerpo de gobierno";
    } else if (valor == "rl") {
        return "Regimen de ley"
    }else if(valor == "s"){
        return "Eventual";
    }
}

function obtenerCategoriaAdscripcion(adscripcion, categoria, idAdscripcion, idCategoria)// funcion que obtiene la categoria y la adscrpcion del empleado
{
    adscripcion = adscripcion.split('#');
    categoria = categoria.split('#');
    var nombreAdscripcion;
    var nombreCategoria;
   for(var i = 0; i<adscripcion.length;i++){
        aux = adscripcion[i].split('*');
        if(aux[0] == idAdscripcion){
             nombreAdscripcion = aux[1];
             break;
        }
    } 
   for(var i = 0; i<categoria.length;i++){
        aux = categoria[i].split('*');
        if(aux[0] == idCategoria){
             nombreCategoria = aux[1];
             break;
        }
    } 
    
    var datos = [nombreAdscripcion,nombreCategoria];
    return datos;

}
function obtenerHorario(idHorario,valor)// funcion para cargar el nombre de los horarios del empleado
{
    datosHorario=[]
    var id;
    
    if(idHorario != null){
        id = idHorario;
    }else{
        id = $("#idHorario").val();
    }
  
    var datos = "id=" + id + "&numFuncion=4";
   console.log(datos);
    $.ajax({
        url: urlSrc + "horarios.php",
        type: "POST",
        data: datos
    }).done(function (res) {
        
        var datos = res.split('*');
        
        var horarios = datos[2].split('/');
        
        $('#nombreHorarioEmp').val(datos[0]);
        $('#turno').val(datos[1]);
       
        for(var i = 0; i < horarios.length; i++){
             datosHorario.push(horarios[i].split(' '));
        } 
        
        if((datosHorario.length)>1){
            var selectDias = document.getElementById('selectDias');
            document.getElementById('inputDias').disabled = "yes";
            document.getElementById('inputDias').style.display = "none";
            selectDias.style = "display:block";
            
             for (let i = 0; i < datosHorario.length; i++) {
                    var opcion = document.createElement('option');
                    opcion.value = datosHorario[i][0];
                    opcion.text = datosHorario[i][0];
                    if(datosHorario[i][0] == valor && valor != null){
                        opcion.selected = "yes";
                    }
                    selectDias.appendChild(opcion);  
            } 
        }else{
            document.getElementById('selectDias').style.display = "none";
            document.getElementById('selectDias').disabled = "yes";
            var horario = document.getElementById('horario');
            var inputDias = document.getElementById('inputDias');
            inputDias.style = "display:block";
            inputDias.value = datosHorario[0][0];
            horario.value = datosHorario[0][1] + " a " + datosHorario[0][2];

        }    
    }).fail(function (res) {
        console.log(res);
    })
}

function obtenerFolio()// esta funcion obtiene el ultimo folio guardado para crear uno nuevo
{
    var datos = "numFuncion=2" 
    $.ajax({
        url: "../../Servidor/PHP/" + "consultarSolicitudes.php",
        type: "POST",
        data: datos
    }).done(function(res){
        var folio = parseInt(res)+1;
        $('#folio').val(folio); 
        $('#folioS').text(folio);
    }).fail(function(res){
        console.log(res);
    });
}