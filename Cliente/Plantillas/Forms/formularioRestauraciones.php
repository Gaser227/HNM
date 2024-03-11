<style>
    .w3-text-purple {
        font-size: 18px;
    }
</style>
<div id="formularioRestauraciones" class="w3-modal">
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
                <h4 style="margin:0px;">Restaurar base de datos</h4>
            </div>
        </header>
        <div class="w3-container w3-deep-white">
            <form id="formRestauracion" enctype="multipart/form-data">
                <label class="w3-text-purple">Base de datos <span style="color:orangered;">*</span></label>
                <select class="w3-input w3-border" name="bases" id="bases" required>
                    <option value="">Selecciona una opción</option>
                </select>
                <br>
                <div class="w3-container" style="text-align:center;">
                    <input type="submit" id="btnRestaurar" value="Restaurar" class="w3-btn w3-green">
                    <input type="button" id="btnCancelar" value="Cancelar" class="w3-btn w3-red">
                </div>
            </form>
        </div>
        <div class="w3-bar w3-white" style="height: 50px;">
        </div>
    </div>
</div>