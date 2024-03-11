<style>
    .w3-text-purple {
        font-size: 18px;
    }
</style>
<div id="formularioCategoria" class="w3-modal">
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
                    <span id="btnCerrarModalCat" class="w3-btn w3-display-topright">&times;</span>
                </div>
            </div>
            <div class="w3-bar-item" style="display: flex; justify-content: center;">
                <h4 style="margin:0px;">Registro de Categoria Nueva</h4>
            </div>
        </header>
        <div class="w3-container w3-deep-white" id="categoria">
            <form id="formCat" enctype="multipart/form-data">
                <div class="w3-container" id="cat">
                <input type="text" name="idCat" id="idCat" hidden>
                <label class="w3-text-purple">Nombre <span style="color:orangered;">*</span></label>
                <input required class="w3-input w3-border" type="text" placeholder="Seleccione el contrato" name="nombreCategoria" id="nombreCategoria">
                <label class="w3-text-purple">Contrato <span style="color:orangered;">*</span></label>
                <select class="w3-input w3-border" name="tipoContrato" id="tipoContrato">
                    <option value="">Selecciona una categoria</option>
                </select>
                </div>
                <br>
                <div id="categoria"></div>
                <br>
                <div class="w3-container" style="text-align:center;">
                    <input type="submit" id="btnGuardarCategoria" value="Guardar" class="w3-btn w3-green">
                    <input type="button" id="btnCancelarCategoria" value="Cancelar" class="w3-btn w3-red">
                </div>
            </form>
        </div>
        <div class="w3-bar w3-white" style="height: 50px;">
        </div>
    </div>
</div>

<div class="w3-modal" id="modalMensajeCat">
    <div class="w3-modal-content w3-card-4 w3-padding-16 w3-animate-zoom w3-light-gray" style="width:40%;border-radius:20px;">
        <div class="w3-bar" style="display: flex; justify-content: flex-start; ">
            <div class="3-bar-item" style="display: flex; justify-content: space-between;">
                <span id="btnCerrarMensajeTopCat" class="w3-btn w3-display-topright" style="border-top-right-radius: 20px;">&times;</span>
            </div>
        </div>
        <div class=" w3-panel w3-padding-16" style="text-align: center;">
            <h3 class="w3-text-red" id="mensaje" style="padding-left:3%;"></h3>
            <div class="w3-container w3-padding-16">
                <input class="w3-btn w3-wide w3-round w3-large w3-mobile" type="button" id="btnCerrarMensajeCat" value="Cerrar" >
            </div>
        </div>
    </div>
</div>