<style>
    .w3-text-purple {
        font-size: 18px;
    }
</style>
<div id="formularioHorario" class="w3-modal">
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
                <h4 style="margin:0px;">Registrar nuevo horario</h4>
            </div>
        </header>
        <div class="w3-container w3-deep-white">
            <form id="formHorario" enctype="multipart/form-data">
                <input type="text" name="idHorario" id="idHorario" hidden>
                <label class="w3-text-purple">Turno <span style="color:orangered;">*</span></label>
            <!--   <input required class="w3-input w3-border" type="text" placeholder="Ingrese el turno" name="turno" id="turno">  -->
                <select class="w3-input w3-border" name="selecTurno" id="selecTurno" required> 
                    <option value="Matutino" selected>Matutino</option>
                    <option value="Vespertino">Vespertino</option>
                    <option value="Nocturno">Nocturno</option>
                    <option value="Jornada Acumulada">Jornada Acumulada</option>
                    <option value="Otro">Otro</option> 
                </select> 
                <br>
                <div id="horarios"></div>
                <label class="w3-text-purple">Definir días laborales y horas</label>
                <div class="w3-container" id="definirHorario" style="display: none;">
                    <label class="w3-text-purple">Días laborales <span style="color:orangered;">*</span></label>
                    <div class="w3-row" style="text-align:center;">
                        <div class="w3-col" style="width:12.5%">
                            <label class="w3-btn" for="lunes" style="background: #ddd;"><input class="diasLab" type="checkbox" id="lunes" hidden>L</label>
                        </div>
                        <div class="w3-col" style="width:12.5%">
                            <label class="w3-btn" for="martes" style="background: #ddd;"><input class="diasLab" type="checkbox" id="martes" hidden>M</label>
                        </div>
                        <div class="w3-col" style="width:12.5%">
                            <label class="w3-btn" for="miercoles" style="background: #ddd;"><input class="diasLab" type="checkbox" id="miercoles" hidden>M</label>
                        </div>
                        <div class="w3-col" style="width:12.5%">
                            <label class="w3-btn" for="jueves" style="background: #ddd;"><input class="diasLab" type="checkbox" id="jueves" hidden>J</label>
                        </div>
                        <div class="w3-col" style="width:12.5%">
                            <label class="w3-btn" for="viernes" style="background: #ddd;"><input class="diasLab" type="checkbox" id="viernes" hidden>V</label>
                        </div>
                        <div class="w3-col" style="width:12.5%">
                            <label class="w3-btn" for="sabado" style="background: #ddd;"><input class="diasLab" type="checkbox" id="sabado" hidden>S</label>
                        </div>
                        <div class="w3-col" style="width:12.5%">
                            <label class="w3-btn" for="domingo" style="background: #ddd;"><input class="diasLab" type="checkbox" id="domingo" hidden>D</label>
                        </div>
                        <div class="w3-col" style="width:12.5%">
                            <label class="w3-btn" for="diasFest" style="background: #ddd;"><input class="diasLab" type="checkbox" id="diasFest" hidden>D/F</label>
                        </div>
                    </div>
                    <label class="w3-text-purple">Horario <span style="color:orangered;">*</span></label>
                    <div class="w3-row-padding" style="text-align:center;">
                        <div class="w3-half">
                            <label>Hora de entrada</label><br>
                            <input class="w3-input w3-border" type="time" name="horaEntrada" id="horaEntrada">
                        </div>
                        <div class="w3-half">
                            <label>Horas a trabajar</label><br>
                            <input class="w3-input w3-border" type="time" name="horasTrabajo" id="horasTrabajo">
                        </div>
                    </div>
                </div>
                <div class="w3-container">
                    <br>
                    <input type="button" id="btnNuevaDefinicion" value="Nueva definición" class="w3-btn w3-blue">
                    <div class="w3-container" style="text-align:center;display: none;" id="divBotonesHorario">
                        <input type="button" id="btnListo" value="Registrar horario" class="w3-btn w3-blue">
                        <input type="button" id="btnCancela" value="Cancelar" class="w3-btn w3-red">
                    </div>
                </div>
                <br>
                <div class="w3-container" style="text-align:center;">
                    <input type="submit" id="btnGuardarHorario" value="Guardar" class="w3-btn w3-green">
                    <input type="button" id="btnCancelarHorario" value="Cancelar" class="w3-btn w3-red">
                </div>
            </form>
        </div>
        <div class="w3-bar w3-white" style="height: 50px;">
        </div>
    </div>
</div>