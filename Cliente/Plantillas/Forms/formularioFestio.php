<style>
    .w3-text-purple {
        font-size: 18px;
    }
</style>
<div id="formularioFestio" class="w3-modal">
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
                    <span id="btnCerrarModalFest" class="w3-btn w3-display-topright">&times;</span>
                </div>
            </div>
            <div class="w3-bar-item" style="display: flex; justify-content: center;">
                <h4 style="margin:0px;">Registrar nueva festividad</h4>
            </div>
        </header>
        <div class="w3-container w3-deep-white" id="festividad">
            <form id="formFest" enctype="multipart/form-data"> 
                <div class="w3-container" id="fest">
                <input type="text" name="idFestio" id="idFestio" hidden>
                <label class="w3-text-purple">Festividad <span style="color:orangered;">*</span></label>
                <input required class="w3-input w3-border" type="text" placeholder="Ingrese la festividad" name="Festividad" id="Festividad">
                <label class="w3-text-purple">Fecha <span style="color:orangered;">*</span></label>
                <input required class="w3-input w3-border" type="date" name="FechFest" id="FechFest">
                </div>
                <br>
                <div id="festividades"></div>
                <!--<div class="w3-container">
                    <br>
                    <input type="button" id="btnMostrarFestividades" value="Mostrar festividades" class="w3-btn w3-blue">  id="btnNuevaDefinicion" 
                    <div class="w3-container" style="text-align:center;display: none;" id="divBotonFest">
                        <input type="button" id="btnCancelaFest" value="Cancelar" class="w3-btn w3-red">
                    </div>
                    <div class="w3-container" style="text-align:center;display: none;" id="divMuestraFestividades">
                        Mostrar festividades 
                        <div class="w3-container">
                        <table id="tablaFestividades" class="w3-table-all w3-centered w3-small w3-hoverable">
                            <thead>
                                <tr class="w3-blue">  
                                    <th>Festividad</th>
                                    <th>Fecha</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div> -->
                <br>
                <div class="w3-container" style="text-align:center;">
                    <input type="submit" id="btnGuardarFestio" value="Guardar" class="w3-btn w3-green">
                    <input type="button" id="btnCancelarFestio" value="Cancelar" class="w3-btn w3-red">
                </div>
            </form>
        </div>
        <div class="w3-bar w3-white" style="height: 50px;">
        </div>
    </div>
</div> 