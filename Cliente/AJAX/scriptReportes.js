
function mostrarPDF(){
    var urlSrc = "../../Servidor/PHP/reportes.php";
    var datos = "numFuncion=" + 1;
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: datos,
        xhrFields: {
          responseType: 'blob' // Establecer el tipo de respuesta como "blob"
        }
      }).done(function(response) {
        var blob = new Blob([response], { type: 'application/pdf' });
        var url = URL.createObjectURL(blob);
        // Abrir el PDF en una nueva ventana o pestaña
        window.open(url);
      }).fail(function(res) {
        console.log(res);
        //alert(res);
      });
}
function mostrarPDF2(){
  fechaInicio = document.getElementById("fechaInicioP").value;
  fechaFin = document.getElementById("fechaFinalP").value;
    var urlSrc = "../../Servidor/PHP/reportes.php";
    var datos = "fechaInicio=" + fechaInicio + "&fechaFin=" + fechaFin + "&numFuncion=" + 2;
    $.ajax({
        url: urlSrc,
        type: "POST",
        data: datos,
        xhrFields: {
          responseType: 'blob' // Establecer el tipo de respuesta como "blob"
        }
    }).done(function(response) {
      var blob = new Blob([response], { type: 'application/pdf' });
      var url = URL.createObjectURL(blob);
      // Abrir el PDF en una nueva ventana o pestaña
      window.open(url);
    }).fail(function(res) {
      console.log(res);
      //alert(res);
    });
}
var chart = null; // Variable para almacenar la referencia de la gráfica
/*
//function crearGraficaPastel(solicitudesAprobadas, solicitudesRechazadas, solicitudesPendientes) {
  function crearGraficaPastel() {
    var urlSrc = "../../Servidor/PHP/reportes.php";
    var datos = "numFuncion=" + 3;
    $.ajax({
      url: urlSrc,
      dataType: 'json',
      data: datos,
      success: function(data) {
        // Los datos están disponibles en el objeto 'data'
        // Los datos están disponibles en el objeto 'data'
      console.log(data);

      // Separar las solicitudes según su estado
      var aprobadas = data['aprobada'];
      var rechazadas = data['rechazada'];
      var pendientes = data['pendiente'];
        var ctx = document.getElementById('grafica-pastel').getContext('2d');
        
        // Destruir la gráfica existente si existe
        if (chart) {
          chart.destroy();
        }
        var data = {
          labels: ['Aprobadas', 'Rechazadas', 'Pendientes'],
          datasets: [{
            data: [aprobadas, rechazadas, pendientes],
            backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56'],
            hoverBackgroundColor: ['#36A2EB', '#FF6384', '#FFCE56']
          }]
        };
        var options = {
          responsive: true
        };
        chart = new Chart(ctx, {
          type: 'pie',
          data: data,
          options: options
        });
        // Aquí puedes realizar la separación de las solicitudes según el estado en JavaScript
      }
    });
}
*/
function crearGraficaPastel() {
  fechaInicio = document.getElementById("fechaInicioR").value;
  fechaFin = document.getElementById("fechaFinalR").value;
  var urlSrc = "../../Servidor/PHP/reportes.php";
  var datos = "fechaInicio=" + fechaInicio + "&fechaFin=" + fechaFin + "&numFuncion=" + 3;

  $.ajax({
      url: urlSrc,
      type: "POST",
      data: datos
  }).done(function(res) {
      // Los datos están disponibles en el objeto 'res'
      console.log(res);
      
      var datos = res.split("#");
      var aprobadas = parseInt(datos[0].split("*")[1]);
      var rechazadas = parseInt(datos[1].split("*")[1]);
      var pendientes = parseInt(datos[2].split("*")[1]);

      var ctx = document.getElementById('grafica-pastel').getContext('2d');

      // Destruir la gráfica existente si existe
      if (chart) {
          chart.destroy();
      }

      var data = {
          labels: ['Aprobadas', 'Rechazadas', 'Pendientes'],
          datasets: [{
              data: [aprobadas, rechazadas, pendientes],
              backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56'],
              hoverBackgroundColor: ['#36A2EB', '#FF6384', '#FFCE56']
          }]
      };

      var options = {
          responsive: true
      };

      chart = new Chart(ctx, {
          type: 'pie',
          data: data,
          options: options
      });
  }).fail(function(res) {
      console.log(res);
  });
}
/*function crearGraficaPastel() {
  fechaInicio = document.getElementById("fechaInicioR").value;
  fechaFin = document.getElementById("fechaFinalR").value;
  var urlSrc = "../../Servidor/PHP/reportes.php";
  var datos = "fechaInicio=" + fechaInicio + "&fechaFin=" + fechaFin + "$numFuncion=" + 3;
  $.ajax({
    url: urlSrc,
    type: "POST",
    data: datos
  }).done(function(res) {
      // Los datos están disponibles en el objeto 'data'
      console.log(res);
      datos = res.split("#");
      aceptadas = datos[0].split("*");
      rechazadas = datos[1].split("*");
      pendientes = datos[2].split("*");
      // Acceder a las propiedades del objeto 'data' para obtener los valores
      var aprobadas = aceptadas[1];
      var rechazadas = rechazadas[1];
      var pendientes = pendientes[1];
      var ctx = document.getElementById('grafica-pastel').getContext('2d');
      // Resto del código para crear la gráfica...
      // Destruir la gráfica existente si existe
    if (chart) {
      chart.destroy();
    }
    var data = {
      labels: ['Aprobadas', 'Rechazadas', 'Pendientes'],
      datasets: [{
        data: [aprobadas, rechazadas, pendientes],
        backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56'],
        hoverBackgroundColor: ['#36A2EB', '#FF6384', '#FFCE56']
      }]
    };
    var options = {
      responsive: true
    };
    chart = new Chart(ctx, {
      type: 'pie',
      data: data,
      options: options
    });
  }).fail(function(res) {
      console.log(res);
  });
}*/



function abrirModalOpcion1() {
    document.getElementById("modalOpcion1").style.display = "block";
    //document.getElementById("nuevaContraseña").focus();
}
function cerrarModalOpcion1() {
    document.getElementById("modalOpcion1").style.display = "none";
    //limpiarCamposConf();
}

function abrirModalOpcion2() {
    document.getElementById("modalOpcion2").style.display = "block";
    //document.getElementById("nuevaContraseña").focus();
}
function cerrarModalOpcion2() {
    document.getElementById("modalOpcion2").style.display = "none";
    //limpiarCamposConf();
}

function abrirModalOpcion3() {
    document.getElementById("modalOpcion3").style.display = "block";
    //document.getElementById("nuevaContraseña").focus();
}
function cerrarModalOpcion3() {
    document.getElementById("modalOpcion3").style.display = "none";
    //limpiarCamposConf();
}

$(document).ready(function() {
    $("#btnOpcion1").click(function() {
        //alert("Pruena");
        //abrirModalOpcion1();
        mostrarPDF();
    }); 
    $("#btnOpcion2").click(function() {
        //alert("Pruena");
        abrirModalOpcion2();
        //mostrarPDF2();
    });
    $("#btnCerrarOpcion3").click(function() {
      cerrarModalOpcion3();
  });
  $("#btnCerrarOpcion2").click(function() {
    cerrarModalOpcion2();
});
  $("#btnOpcion3").click(function() {
    abrirModalOpcion3();
    //crearGraficaPastel(aprobadas, rechazadas, pendientes);
    //crearGraficaPastel();
    
  }); 
  $("#generarGrafica").click(function() {
    //alert("Pulsado");
    crearGraficaPastel();
}); 
$("#generarPdf").click(function() {
  //alert("Pulsado");
  mostrarPDF2();
});
});
