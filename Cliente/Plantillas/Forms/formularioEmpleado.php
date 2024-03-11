<style>
    .w3-text-purple {
        font-size: 18px;
    }
    .w3-text {
        font-size: 18px;
    }
</style>
<div id="formularioEmpleado" class="w3-modal">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <div class="w3-bar">
            <div class="w3-bar-item">
                <h7> </h7>
            </div>
        </div>
        <header class="w3-container w3-deep-white">
            <div class="w3-bar" style="display: flex; justify-content: flex-start;">
                <img class="w3-image" src="Recursos/Imagenes/Logos/hnm.png" style="max-width:100px;width:auto;margin-top:10px">
                <div class="3-bar-item" style="display: flex; justify-content: space-between;">
                    <h2 style="margin-left:180px">Hospital del Niño Morelense</h2>
                    <span id="btnCerrarModal" class="w3-btn w3-display-topright">&times;</span>
                </div>
            </div>
            <div class="w3-bar-item" style="display: flex; justify-content: center;">
                <h4 style="margin:0px;">Datos del empleado</h4>
            </div>
        </header>
        <div class="w3-container w3-deep-white">
            <form id="formEmpleado" enctype="multipart/form-data">
                <section>
                    <input type="text" id="idEmpleado" name="idEmpleado" hidden>
                    <label class="w3-text-purple">Número de nómina <span style="color:orangered;">*</span></label>
                    <input required class="w3-input w3-border" name="nomina" id="nomina" type="text" placeholder="Ingrese número de nómina" maxlength="4">
                    <label class="w3-text" id="mensajeNomina"></label><br>
                    <label class="w3-text-purple">Nombre <span style="color:orangered;">*</span></label>
                    <input required class="w3-input w3-border" name="nombre" id="nombre" type="text" placeholder="Ingrese nombre(s) apellido paterno apellido materno">
                    <label class="w3-text-purple">Número telefónico </label>
                    <input class="w3-input w3-border" name="telefono" id="telefono" type="text" placeholder="Ingrese número telefónico" maxlength="11">
                    <label class="w3-text-purple">Correo electrónico </label>
                    <input class="w3-input w3-border" name="correo" id="correo" type="email" placeholder="Ingrese el correo electronico del empleado">
                    <label class="w3-text-purple">Sexo <span style="color:orangered;">*</span></label>
                    <div class="w3-row-padding">
                        <div class="w3-half">
                            <input type="radio" name="sexo" class="sexo" id="femenino" value="1" checked>
                            <label class="w3-text" for="femenino">Femenino</label>
                        </div>
                        <div class="w3-half">
                            <input type="radio" name="sexo" class="sexo" id="masculino" value="2">
                            <label class="w3-text" for="masculino">Masculino</label>
                        </div>
                    </div>
                    <label class="w3-text-purple">Perfil del empleado <span style="color:orangered;">*</span></label>
                    <select class="w3-input w3-border" name="tipoEmpleado" id="tipoEmpleado" required>
                        <option value="">Selecciona una opción</option>
                        <option value="2">Control operativo</option>
                        <option value="3">Autorizador / Jefe</option>
                        <option value="4" selected>Usuario estandar</option>
                    </select>
                    <label class="w3-text-purple">Adscripción <span style="color:orangered;">*</span></label>
                    <select class="w3-input w3-border" name="adscripcion" id="adscripcion" required>
                        <option value="">Selecciona una opción</option>
                    </select>
                    <label class="w3-text-purple">Tipo de contrato <span style="color:orangered;">*</span></label>
                    <select class="w3-input w3-border" name="tipoCont" id="tipoCont" require>
                        <option value="">Selecciona un Contrato</option>
                    </select>
                    <label class="w3-text-purple">Categoría <span style="color:orangered;">*</span></label>
                    <select class="w3-input w3-border" name="categoria" id="categoria" required>
                        <option value="">Selecciona una opción</option>
                    </select>
                    <label class="w3-text-purple">Turno <span style="color:orangered;">*</span></label>
                    <div class="w3-row-padding">
                        <div class="w3-col" style="width: 20%;" id="matuDiv">
                            <input type="radio" name="turnoCont" class="turnoCont" id="matutino" value="Matutino">
                            <label class="w3-text" for="matutino">Matutino</label>
                        </div>
                        <div class="w3-col" style="width: 20%;" id="vesperDiv">
                            <input type="radio" name="turnoCont" class="turnoCont" id="vespertino" value="Vespertino">
                            <label class="w3-text" for="vespertino">Vespertino</label>
                        </div>
                        <div class="w3-col" style="width: 20%;" id="nocturDiv">
                            <input type="radio" name="turnoCont" class="turnoCont" id="nocturno" value="Nocturno">
                            <label class="w3-text" for="nocturno">Nocturno</label>
                        </div>
                        <div class="w3-col" style="width: 20%;" id="corridoDiv">
                            <input type="radio" name="turnoCont" class="turnoCont" id="jornadaAcumulada" value="Jornada Acumulada">
                            <label class="w3-text" for="horarioCorrido">Jornada Acumulada</label>
                        </div>
                        <div class="w3-col" style="width: 20%;" id="otroDiv">
                            <input type="radio" name="turnoCont" class="turnoCont" id="otro" value="Otro">
                            <label class="w3-text" for="otro">Otro</label>
                        </div>
                    </div>
                    <div id="divHorario" name="divHorario" style="display: none;"> <!--  -->
                    <label class="w3-text-purple">Horario <span style="color:orangered;">*</span></label>
                    <select class="w3-input w3-border" name="horario" id="horario" required>
                        <option value="">Selecciona un horario</option>
                    </select>
                    </div>
                    <!-- <label class="w3-text-purple">¿Puede autorizar? <span style="color:orangered;">*</span></label>
                    <select class="w3-input w3-border" name="autoriza" id="autoriza" required>
                        <option value="">Selecciona una opción</option>
                        <option value="0">No</option>
                        <option value="1">Si</option>
                    </select> -->
                    <label class="w3-text-purple">Fecha de inicio <span style="color:orangered;">*</span></label>
                    <input required class="w3-input w3-border" name="fechaInicio" id="fechaInicio" type="date">
                    <br>
                    <div class="w3-row-padding">
                        <div class="w3-quarter">
                            <label class="w3-text-purple">Fecha de registro</label>
                            <label class="w3-text" name="fechaRegistro" id="fechaRegistro"></label>
                            <!-- <input class="w3-text" name="fechaRegistro" id="fechaRegistro" type="text" readonly style="border:0px;"> -->
                        </div>
                        <div class="w3-rest">
                            <label class="w3-text-purple">Registró</label>
                            <br>
                            <label class="w3-text" name="registro" id="registro"></label>
                            <!-- <input class="w3-text" name="registro" id="registro" type="text" readonly style="border:0px;"> -->
                        </div>
                    </div>
                    <br>
                    <label class="w3-text-purple">Firma del empleado </label>
                    <div class="w3-container" style="text-align: center;" id="canvas">
                        <div class="sigPad" id="areaFirma" style="width:100%;">
                            <div class="sigNav">
                                <input type="button" class="clearButton w3-btn w3-blue" value="Limpiar">
                                <input type="button" class="clearButton w3-btn w3-red" value="Cancelar" id="cancelarCambio">
                            </div>
                            <div class="sig sigWrapper" style="height:auto;">
                                <div class="typed"></div>
                                <canvas id="canvasFirma" class="pad" width="400" height="250" style="border:2px solid gray;"></canvas>
                                <input type="hidden" name="output" class="output">
                            </div>
                        </div>
                    </div>
                    <div class="w3-container" style="text-align: center;" id="imagen">
                        <div>
                            <input class="w3-btn w3-blue" type="button" value="Cambiar" id="cambiarFirma">
                        </div>
                        <div id="imgFirma">
                        </div>
                    </div>
                    <br><br>
                    <div class="w3-container" style="text-align:center;">
                        <input type="submit" id="btnGuardarEmp" value="Guardar" class="w3-button w3-green">
                        <input type="button" id="btnCancelarEmp" value="Cancelar" class="w3-button w3-red">
                    </div>
                </section>
            </form>
        </div>
        <div class="w3-bar w3-white" style="height: 50px;">
        </div>
    </div>
</div>
<!--                                                                                            -->