<?php
session_start();
if (isset($_SESSION['empleadoHnmFormatos'])) {
    $id = $_SESSION['empleadoHnmFormatos'][0];

} else {
    header('Location:index.php');
}
?>
<div id="modalSL" class="w3-modal">
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
                    <h3 style="margin:0px;text-align:center;"><b>Licencia</b></h3>
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
       
        <form id="formularioL" action="" method="post" enctype="multipart/form-data">
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
                    <h7>Solicitud</h7>
                </div>
            </div>
            <section>
                <div class="w3-col s12">
                    <div class="w3-container" style="width: 100%; height:px;" id="">
                        <p>Solicito concederme licencia con goce o sin goce de sueldo para sustentarme de mis labores</p>
                    </div>
                    <div class="w3-col s4">
                        <div class="w3-container" style="width: 100%; height: 50px;">
                            <label for="ConGoceSueldo">Con goce de sueldo</label>
                            <input type="checkbox" name="sueldo" id="ConGoceSueldo" class="w3-check w3-border-1" value="1">
                        </div>
                        </div>
                        <div class="w3-col s4">
                        <div class="w3-container" style="width: 100%; height: 50px;">
                            <label for="SinGoceSueldo">Sin goce de sueldo</label>
                            <input type="checkbox" name="sueldo" id="SinGoceSueldo" class="w3-check w3-border-1" value="2">
                        </div>
                        </div>
                    <div class="w3-col s4">
                        <div class="w3-container" style="width: 100%; height:50px;" id="">
                        </div>
                    </div>
                    <br>
                    <div class="w3-col s4">
                        <div class="w3-container" style="width: 100%; height:80px;" id="">
                            <label for="">Fecha de Inicio:</label> <input type="date" name="fechaInicioL" id="fechaInicioL" class="w3-input w3-border-1">
                        </div>
                    </div>
                    <div class="w3-col s4">
                        <div class="w3-container" style="width: 100%; height:80px;" id="">
                            <label for="">Fecha de Final:</label> <input type="date" name="fechaFinalL" id="fechaFinalL" class="w3-input w3-border-1">
                        </div>
                    </div>
                    <div class="w3-col s4">
                        <div class="w3-container" style="width: 100%; height:80px;" id="">
                            <label>Dia(s):</label><input type="text" name="totalDiasL" id="totalDiasL" class="w3-input w3-border-1" readonly="readonly" required>
                        </div>
                    </div>
                </div>
                <div class="w3-col s4" style="display:">
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                        <label for="nominaSuplenteL">Nomina del Suplente Propuesto: </label><input type="text" name="nominaSuplenteL" id="nominaSuplenteL" class="w3-input w3-border-1" >
                    </div>
                </div>
                <div class="w3-col s4" style="display:">
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                        <label for="nombreSuplenteL">Nombre del Suplente Propuesto: </label><input type="text" name="nombreSuplenteL" id="nombreSuplenteL" class="w3-input w3-border-1" readonly>
                    </div>
                </div>
                <div class="w3-col s4">
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                        <label>Motivo:</Label>
                        <select class="w3-select" name="tipoSalida" id="tipoSalida" required>
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="Defuncion Familiar">Defunción Familiar</option>
                            <option value="Matrimonio">Matrimonio</option>
                            <option value="Paternidad">Paternidad</option>
                            <option value="Economico por Antguedad">Economico por Antiguedad</option>
                            <option value="Dia Economico">Dia Economico</option>
                            <option value="Cumpleaños">Cumpleaños</option>
                            <option value="Por Laborar 4 dias Consecutivos">Por Laborar 4 Dias Consecutivos</option>
                        </select>
                    </div>
                </div>
               
            </section>
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
                    <label>Seleccione la Persona Quien Autoriza:</Label>
                        <select class="w3-select" name="selectJefe[]" id="selectJefe">
                            <option value="" onclick="cargarJefe()">Jefe Inmediato</option> 
                        </select>
                    </div>
                </div>

               <div class="w3-col s4"> <!-- tercer Firma select-->
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                       
                    </div>
                </div>
                <div class="w3-col s4"> <!-- firma empleado -->
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
                <div class="w3-col s4"> <!-- segunda firma -->
                    <div class="w3-container firma" style="width: 100%; height:200px;" id="">
                        <div class="w3-container firma" style="width: 100%; height: 110px; background: #fff;border-bottom:1px solid;">
                           
                        </div>
                        <div style="display: flex; justify-content:center;">
                            <label id="firmaJefe">NOMBRE</label><br>
                        </div>
                        <div style="display: flex; justify-content:center;">
                            <label id="cargoJefe">Director de Divisón</label>
                        </div>
                        <input type="text" name="idJefe" id="idJefe" style="display: none;"><br>
                    </div>
                </div>
              

                <div class="w3-col s4"> <!-- tercer firma  -->
                    <div class="w3-container firma" style="width: 100%; height:200px;" id="">
                        <div class="w3-container firma" style="width: 100%; height: 110px; background: #fff;border-bottom:1px solid;">
                           
                        </div>
                        <div style="display: flex; justify-content:center;">
                            <label id="firmaSuplente">NOMBRE</label><br>
                        </div>
                        <div style="display: flex; justify-content:center;">
                            <label id="cargoSuplente">PUESTO</label><br>
                        </div>
                        <input type="text" name="idSuplente" id="idSuplente" style="display: none;"><br>
                    </div>
                </div>
                <!--<div class="w3-col s4"> 
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                        <label>Persona Quien Autoriza:</Label>
                        <select class="w3-select" name="selectDivision" id="selectDivision" required>
                            <option value="" disabled selected>Selecciona una opción</option>
                            
                        </select>
                    </div>
                </div>-->
                    <div class="w3-col s4"> <!-- quinta firma seelct -->
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                    </div>
                </div>
             
               <div class="w3-col s4"> <!-- sexta firma select -->
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                    
                    </div>
                </div> 
                <!--<div class="w3-col s4"> 
                    <div class="w3-container firma" style="width: 100%; height:200px;" id="">
                        <div class="w3-container firma" style="width: 100%; height: 110px; background: #fff;border-bottom:1px solid;">
                          
                        </div>
                        <div style="display: flex; justify-content:center;">
                            <label id="firmaGeneral">NOMBRE</label><br>
                        </div>
                        <div style="display: flex; justify-content:center;">
                            <label id="cargoGeneral">Director General</label><br>
                        </div>
                    </div>
                </div>-->
                <div class="w3-col s4">  <!-- firma empleado -->
                    <div class="w3-container firma" style="width: 100%; height:200px;" id="">
                      
                    </div>
                </div>
                <div class="w3-col s4"> <!-- firma empleado -->
                    <div class="w3-container firma" style="width: 100%; height:200px;" id="">
                        
                    </div>
                </div>
                    <div class="w3-container" class="w3-bar-item" style="display: flex; justify-content: center;" id="">
                        <input type="submit" id="btnGuardarSolicitudL" value="Enviar y Guardar Solicitud" class="w3-button w3-green" style="margin-bottom:10px">
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