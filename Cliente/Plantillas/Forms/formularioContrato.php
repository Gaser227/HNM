<style>
    .w3-text-purple {
        font-size: 18px;
    }
</style>

<div id="formularioContrato" class="w3-modal">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <div class="w3-bar">
            <div class="w3-bar-item">
                <h7>  </h7>
            </div>
        </div>
        <header class="w3-container w3-deep-white">
            <div class="w3-bar" style="display: flex; justify-content: flex-start;">
                <img class="w3-image" src="Recursos/Imagenes/Logos/hnm.png" style="max-width:100px;width:auto;margin-top:10px">
                <div class="3-bar-item" style="display: flex; justify-content: space-between;">
                    <h2 style="margin-left:180px">Hospital del Niño Morelense</h2>
                    <span id="btnCerrarModalCont" class="w3-btn w3-display-topright">&times;</span>
                </div>
            </div>
            <div class="w3-bar-item" style="display: flex; justify-content: center;">
                <h4 style="margin:0px;">Registro de Contrato Nuevo</h4>
            </div>
        </header>
        <div class="w3-container w3-deep-white" id="contrato">
            <form id="formCont" enctype="multipart/form-data">
                <div class="w3-container" id="cont">
                <input class="w3-input w3-border" type="text" name="tipoOperacion" id="tipoOperacion" style="display: none;">
                <label class="w3-text-purple">Nombre <span style="color:orangered;">*</span></label>
                <input required class="w3-input w3-border" type="text" placeholder="Ingrese el contrato" name="nombreContrato" id="nombreContrato">
                <label class="w3-text-purple">Clave <span style="color:orangered;">*</span></label>
                <input class="w3-input w3-border" type="text" placeholder="Ingrese la clave" name="claveContrato" id="claveContrato" style=" text-transform: uppercase;">
                </div>
                <br>
                <div id="contrato"></div>
                <br>
                <div class="w3-container" style="text-align:center;">
                    <input type="submit" id="btnGuardarContrato" value="Guardar" class="w3-btn w3-green">
                    <input type="button" id="btnCancelarContrato" value="Cancelar" class="w3-btn w3-red">
                </div>
            </form>
        </div>
        <div class="w3-bar w3-white" style="height: 50px;">
        </div>
    </div>
</div>

<div class="w3-modal" id="modalMensaje">
        <div class="w3-modal-content w3-card-4 w3-padding-16 w3-animate-zoom w3-light-gray" style="width:40%;border-radius:20px;">
            <div class="w3-bar" style="display: flex; justify-content: flex-start; ">
                <div class="3-bar-item" style="display: flex; justify-content: space-between;">
                    <span id="btnCerrarMensajeTop" class="w3-btn w3-display-topright" style="border-top-right-radius: 20px;">&times;</span>
                </div>
            </div>
            <div class=" w3-panel w3-padding-16" style="text-align: center;">
                <h3 class="w3-text-red" id="mensaje" style="padding-left:3%;"></h3>
                <div class="w3-container w3-padding-16">
                    <input class="w3-btn w3-wide w3-round w3-large w3-mobile" type="button" id="btnCerrarMensaje" value="Cerrar" >
                </div>
            </div>
        </div>
    </div>