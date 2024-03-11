<?php
session_start();
if (isset($_SESSION['empleadoHnmFormatos'])) {
    $id = $_SESSION['empleadoHnmFormatos'][0];

} else {
    header('Location:index.php');
}
?>
<div id="modalIJ" class="w3-modal">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <div class="w3-bar">
            <div class="w3-bar-item">
                <h7> </h7>
            </div>
        </div>
        <header class="w3-container w3-deep-white">
            <div class="w3-bar" style="">
                <div class="w3-col s2 w3-bar-item" style ="background:;margin:0px;">
                   <img src="Recursos/Imagenes/Logos/hnm.png" width="70px" style="margin-top:px">
                </div>
                <div class="w3-col s7 w3-bar-item" style="background:;text-align:center;" >
                    <h3 style="margin:0px;text-align:center;"><b>Hospital del Niño Morelense</b></h3>  
                    <h5 style="margin:0px;text-align:center">Dirección de División Administrativa, Coordinación de Area de Administración de personal.</h5>  
                    <h3 style="margin:0px;text-align:center;"><b>Intercambio de Jornada Laboral</b></h3>
                    <label style="margin-left:35px;font-size:12pt ;" id="fechaCreacion" name ="fechaCreacion"> </label> <button class="w3-btn"style="background-color:white;margin-top:-5px;font-size:12pt;border:0px;" id="btnEditarFecha"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

                </div>
                <div class="w3-col s3 w3-bar-item"  style ="background:;margin-top:0px;text-align:center;">
                    <h5 style=" margin-top:0px"> Folio # </h5><label id="folioS" name="folioS" style="margin-top:0px;font-size:20pt"></label>
                    <span id="btnCerrarModal" class="w3-btn w3-display-topright">&times;</span>
                </div>
            </div>
           
        </header>
        <div class="w3-bar w3-blue">
            <div class="w3-bar-item">
                <h7>Datos del Empleado</h7>
            </div>
        </div>
        
        <form id="formularioIT" action="" method="post" enctype="multipart/form-data">
            
            <input type="text" id = "idEmpleado" name ="idEmpleado" style="display:none;"value ="<?php echo $id; ?>">
            <input type="text" id = "folio" name ="folio" style ="display:none;">
            <input type="text" id = "idHorario" name ="idHorario" style ="display:none;">
            <input type="text" id = "fechaJustificada" name ="fechaJustificada" style ="display:none;">
            <input type="text" name="tipoContrato" id="tipoContrato" style="display:none;">
            <section>
                <br>
                <div class="w3-col s4">
                    <div class="w3-container" style="width: 100%; height:150px; " id="">
                        <label for="nomina">Nomina #</label><input type="text" name="nomina" id="nomina" class="w3-input w3-border-1" readonly="readonly" required><br>
                        <label for="estatus">Estatus:</label><input type="text" name="estatus" id="estatus" class="w3-input w3-border-1" readonly="readonly" required><br>
                    </div>
                </div>
                <div class="w3-col s4">
                    <div class="w3-container" style="width: 100%; height:150px; " id="">
                        <Label for="nombre">Nombre:</Label><input type="text" name="nombre" id="nombre" class="w3-input w3-border-1" readonly="readonly" required><br>
                        <label for="adscripcion">Adscripción:</label><input type="text" name="adscripcion" id="adscripcion" class="w3-input w3-border-1" readonly="readonly" required><br>
                    </div>
                </div>
                <div class="w3-col s4">
                    <div class="w3-container" style="width: 100%; height:160px; " id="">
                        <label for="categoria">Categoria:</label><input type="text" name="categoria" id="categoria" class="w3-input w3-border-1" readonly="readonly" required ><br>
                        <label for="nombreHorarioEmp" style="display:none">Horario:</label><input type="text" name="nombreHorarioEmp" id="nombreHorarioEmp" class="w3-input w3-border-1" readonly="readonly" required style="display:none"><br>
                    </div>
                </div>
                <div class="w3-col s4">
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                        <label for="turno">Turno:</label><input type="text" name="turno" id="turno" class="w3-input w3-border-1" readonly="readonly" required><br>
                    </div> 
                </div>
                <div class="w3-col s4">
                    <div class="w3-container" id ="divDias" style="width: 100%; height:80px; " id="">
                        <label for="diasLaborales">Dias Laborales:</label><input type="text" name="inputDias" id="inputDias" class="w3-input w3-border-1" readonly="readonly" required><br>
                         <select class="w3-select w3-input w3-border-1" name="selectDias" id="selectDias" style ="display:none;" required>
                            <option value="" disabled selected>Selecciona una opción</option>
                           
                            
                        </select>
                    </div>
                </div>
                <div class="w3-col s4">
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                       <label  for="horario">Entrada - Salida:</label><input type="text" name="horario" id="horario" class="w3-input w3-border-1" readonly="readonly" required  style=" margin-top:px"><br>
                       
                    </div>
                </div>
            </section>
            <br>
            <div class="w3-bar w3-blue">
                <div class="w3-bar-item">
                    <h7>Datos del Suplente</h7>
                </div>
            </div>
          <section>
                <br>
                <div class="w3-col s4">
                    <div class="w3-container" style="width: 100%; height:150px; " id="">
                        <label for="nominaSuplente">Nomina #</label><input type="text" name="nominaSuplente" id="nominaSuplente" class="w3-input w3-border-1"  required><br>
                        <label for="estatusSuplente">Estatus:</label><input type="text" name="estatusSuplente" id="estatusSuplente" class="w3-input w3-border-1" readonly="readonly" required><br>
                        <input style="display: none;" type="text" name="estatusVal" id="estatusVal">
                    </div>
                </div>
                <div class="w3-col s4">
                    <div class="w3-container" style="width: 100%; height:150px; " id="">
                        <Label for="nombreSuplente">Nombre:</Label><input type="text" name="nombreSuplente" id="nombreSuplente" class="w3-input w3-border-1" readonly="readonly" required><br>
                        <label for="adscripcionSuplente">Adscripción:</label><input type="text" name="adscripcionSuplente" id="adscripcionSuplente" class="w3-input w3-border-1" readonly="readonly" required><br>
                        <input style="display: none;" type="text" name="adscripcionVal" id="adscripcionVal">
                    </div>
                </div>
                <div class="w3-col s4">
                    <div class="w3-container" style="width: 100%; height:160px; " id="">
                        <label for="categoriaSuplente">Categoria:</label><input type="text" name="categoriaSuplente" id="categoriaSuplente" class="w3-input w3-border-1" readonly="readonly" required ><br>
                        <input style="display: none;" type="text" name="categoriaVal" id="categoriaVal">
                        <label for="tipoPlazaSuplente">Tipo Plaza:</label><input type="text" name="tipoPlazaSuplente" id="tipoPlazaSuplente" class="w3-input w3-border-1" readonly="readonly" required ><br>
                        <input style="display: none;" type="text" name="plazaVal" id="plazaVal">
                    </div>
                </div>
                <!-- <div class="w3-col s4">
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                        <label for="turnoSuplente">Turno:</label><input type="text" name="turnoSuplente" id="turnoSuplente" class="w3-input w3-border-1" required><br>
                    </div>
                </div> -->
                <div class="w3-col s4">
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                    <!--<label>Turno</label>-->
                    <label for="turnoSuplente">Turno:</label><input type="text" name="turnoSuplente" id="turnoSuplente" class="w3-input w3-border-1" readonly="readonly" required><br>
            <!--   <input required class="w3-input w3-border" type="text" placeholder="Ingrese el turno" name="turno" id="turno">  -->
                    <!--<select class="w3-input w3-border" name="turnoSuplente" id="turnoSuplente">
                        <option disabled selected>Selecciona una opción</option>
                        <option value="Matutino">Matutino</option>
                        <option value="Vespertino">Vespertino</option>
                        <option value="Nocturno">Nocturno</option>
                        <option value="Jornada Acumulada">Jornada Acumulada</option>
                        <option value="Otro">Otro</option> 
                    </select>--> 
                    </div>
                </div>
                <div class="w3-col s4">
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                        <label for="cambioGuardiaSuplente">Cambio de Guardia:</label><input type="date" name="cambioGuardiaSuplente" id="cambioGuardiaSuplente" class="w3-input w3-border-1"  required><br>
                    </div>
                </div>
                <div class="w3-col s4">
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                       
                    </div>
                </div>
                <div class="w3-col s12">
                        <div class="w3-container" style="width: 100%; height:50px;" id="">
                            <label for="SinGoceSueldo">Tipo de Pago: </label>
                        </div>
                </div>
                <div class="w3-col s4">
                        <div class="w3-container" style="width: 100%; height:50px;" id="">
                            <label for="efectivo">En Efectivo</label><input type="checkbox" name="tipoPago" id="efectivo" class="w3-check w3-border-1" value="en efectivo" >
                        </div>
                </div>
                <div class="w3-col s4">
                        <div class="w3-container" style="width: 100%; height:50px;" id="">
                            
                            <label for="tiempo">En tiempo</label><input type="checkbox" name="tipoPago" id="tiempo" class="w3-check w3-border-1" value="por tiempo" >
                        </div>
                </div>
            </section>
            <br>
            <br>
            <div class="w3-bar w3-blue">
                <div class="w3-bar-item">
                    <h7>Firmas</h7>
                </div>
            </div>
            <section>
               <div class="w3-col s4">
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                    </div>
                </div>
               <div class="w3-col s4">
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                        
                    </div>
                </div>
                <div class="w3-col s4"> 
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                    <label>Seleccione la Persona Quien Autoriza:</Label>
                        <select class="w3-select" name="selectJefe[]" id="selectJefe">
                            <option value="" onclick="cargarJefe()">Jefe Inmediato</option> 
                        </select>
                    </div>
                </div>
                <div class="w3-col s4">
                    <div class="w3-container " style="width: 100%; height:200px; " id="">
                        <div class="w3-container firma" style="width: 100%; height: 110px; background: #fff;border-bottom:1px solid;" id="divFirma">
                        </div>
                        <div style="display: flex; justify-content:center;">
                            <label id="firmaEmpleado">NOMBRE</label><br>
                        </div>
                        <div style="display: flex; justify-content:center;">
                            <label id="cargoEmpleado">Firma Solicitante</label><br>
                        </div>
                    </div>
                </div>

                <div class="w3-col s4">
                    <div class="w3-container firma" style="width: 100%; height:200px;" id="">
                        <div class="w3-container firma" style="width: 100%; height: 110px; background: #fff;border-bottom:1px solid;">
                            <!--<canvas id="canvas">Su navegador no soporta canvas :( </canvas>-->
                        </div>
                        <div style="display: flex; justify-content:center;">
                            <label id="firmaSuplente">NOMBRE</label><br>
                        </div>
                        <div style="display: flex; justify-content:center;">
                            <label id="cargoSuplente">Firma del Suplente</label><br>
                        </div>
                        <input type="text" name="idSuplente" id="idSuplente" style="display: none;"><br>
                    </div>
                </div>
                <div class="w3-col s4">
                    <div class="w3-container firma" style="width: 100%; height:200px;" id="">
                        <div class="w3-container firma" style="width: 100%; height: 110px; background: #fff;border-bottom:1px solid;">
                            <!--<canvas id="canvas">Su navegador no soporta canvas :( </canvas>-->
                        </div>
                        <div style="display: flex; justify-content:center;">
                            <label id="firmaJefe">NOMBRE</label><br>
                        </div>
                        <div style="display: flex; justify-content:center;">
                            <label id="cargoJefe">Vo. Bo. Jefe Inmediato</label><br>
                        </div>
                    </div>
                </div>
                    <div class="w3-col s4"> <!-- quinta firma seelct -->
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                    </div>
                </div>
             
               <div class="w3-col s4"> <!-- sexta firma select -->
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                    
                    </div>
                </div> 
                <div class="w3-col s4"> <!-- firma empleado -->
                    <div class="w3-container firma" style="width: 100%; height:200px;" id="">
                        
                    </div>
                </div>
                    <div class="w3-container" class="w3-bar-item" style="display: flex; justify-content: center;" id="">
                        <input type="submit" id="btnGuardarSolicitudIT" value="Enviar y Guardar Solicitud" class="w3-button w3-green" style="margin-bottom:10px">
                    </div>
                </div> 
            </section>
        </form>
        <div class="w3-bar w3-white">
            <div class="w3-bar-item">
                <h7> </h7>
            </div>
        </div>
    </div>
</div>