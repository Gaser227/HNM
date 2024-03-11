<div id="modalTabla" class="w3-modal">
        <div class="w3-modal-content w3-animate-top w3-card-4">
            <header class="w3-container w3-deep-purple"> 
                <div class="w3-bar" style = "display: flex; justify-content: flex-start; ">
                    <img src="../clienteFormatos/Recursos/Imagenes/hospital_logo.png" width ="100px" height="75px" style="margin-top:10px">
                    <div class="3-bar-item"  style = "display: flex; justify-content: space-between;">
                        <h2  style="margin-left:150px">Solicitudes Enviadas </h2>                    
                        <span id="btnCerrarModalTabla"class="w3-button w3-display-topright">&times;</span>
                    </div>
                </div>
            </header>
            <div class="w3-bar w3-blue">
                <div class="w3-bar-item">
                    <h>Solicitudes</h7>
                </div>
            </div>
            <section>
                <table id ="tablaSolicitudes" class="w3-table w3-bordered"> 
                    <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Tipo de Solicitud</th>
                        <th>Firmas Requeridas</th>
                        <th>Firmas Obtenidas</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody id="filas">
                    </tbody>
                </table>
            </section>
        
            <div class="w3-bar w3-blue">
                <div class="w3-bar-item">
                    <h7> </h7>
                </div>
            </div>
            
            <footer class="w3-container w3-deep-purple">
                <p>Hospital del Niño Morelense</p>
            </footer>
        </div>
    </div>