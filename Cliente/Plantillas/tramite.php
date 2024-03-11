<?php
session_start();
if (isset($_SESSION['empleadoHnmFormatos'])) {
    $id = $_SESSION['empleadoHnmFormatos'][0];

} else {
    header('Location:index.php');
}
?>
<div id="modalST" class="w3-modal">
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
                    <h3 style="margin:0px;text-align:center;"><b>Tramite</b></h3>
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
        
        <form id="formulario" action="" method="post" enctype="multipart/form-data">
            
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
                 <div class="w3-col s4">
                    <div class="w3-container " style="width: 100%; height:80px;" id="">
                        <label>Tipo de Solicitud:</Label>
                        <select class="w3-select w3-input w3-border-1" name="tipoSolicitud" id="tipoSolicitud" required>
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="Constancia Laboral">Constancia Laboral</option>
                            <option value="Aclaraciones de Nomina">Aclaraciones de Nómina</option>
                            <option value="Solicitud de Gafete de Identificacion">Solicitud de Gafete de Identificación</option>
                            <option value="Reimpresion de Recibo de Nomina">Reimpresion de Recibo de Nómina</option>
                            <option value="Tarjeta Adicionale de Vales de Despensa">Tarjeta Adicionale de Vales de Despensa</option>
                            <option value="Reembolso por Descuento Improcedente">Reembolso por Descuento Improcedente</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                </div>
                <div class="w3-col s4" id="hora1" style="display:">
                    <div class="w3-container" style="width: 100%; height:100px; " id="">
                        <label for="periodo">Periodos: </label><input type="text" name="periodo" id="periodo" class="w3-input w3-border-1" required>
                    </div>
                </div>
                <div class="w3-col s4" id="hora2" style="display:">
                    <div class="w3-container" style="width: 100%; height:100px; " id="">
                        <label for="rfcBeneficiario">R.F.C. del Beneficiario: </label><input type="text" name="rfcBeneficiario" id="rfcBeneficiario" class="w3-input w3-border-1" required>
                    </div>
                </div>
                <div class="w3-col s4">
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                        <label for="especifique">Especifique: </label><input type="text" name="especifique" id="especifique" class="w3-input w3-border-1" required>
                    </div>
                </div>
                <div class="w3-col s12" id="divObservaciones" style="display:">
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                        <label for="observaciones">Observaciones:</label><textarea class="w3-input w3-border-1" id="observaciones" name="observaciones" rows="1" cols="4" maxlength="250" style="resize:none;"></textarea><br>
                    </div>
                </div>
            </section>
            <div class="w3-bar w3-blue">
                <div class="w3-bar-item">
                    <h7>Firmas</h7>
                </div>
            </div>
            <section>
               <div class="w3-col s6">
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                    </div>
                </div>
               <div class="w3-col s6">
                    <div class="w3-container" style="width: 100%; height:80px; " id="">
                        <label>Seleccione la Persona Quien Recibe:</Label>
                        <select class="w3-select" name="selectJefe" id="selectJefe" required>
                            <option value="" disabled selected>Selecciona una opción</option>
                        </select>
                    </div>
                </div>
                <div class="w3-col s6">
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
                <div class="w3-col s6">
                    <div class="w3-container firma" style="width: 100%; height:200px;" id="">
                        <div class="w3-container firma" style="width: 100%; height: 110px; background: #fff;border-bottom:1px solid;">
                            <!--<canvas id="canvas">Su navegador no soporta canvas :( </canvas>-->
                        </div>
                        <div style="display: flex; justify-content:center;">
                            <label id="firmaJefe">NOMBRE</label><br>
                        </div>
                        <div style="display: flex; justify-content:center;">
                            <label id="cargoJefe">PUESTO</label><br>
                        </div>
                    </div>
                </div>
                    <div class="w3-container" class="w3-bar-item" style="display: flex; justify-content: center;" id="">
                        <input type="submit" id="btnGuardarSolicitud" value="Enviar y Guardar Solicitud" class="w3-button w3-green" style="margin-bottom:10px">
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