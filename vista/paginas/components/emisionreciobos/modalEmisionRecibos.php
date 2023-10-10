<div class="modal" id="modalEmisionRecibosAbm">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <!-- Modal HEADER-->
      <div class="modal-header">
        <h4 class="modal-title">INGRESO DE RECIBOS</h4>
        <button type="button" class="close" id="btnCerrar" class="btn btn-cancel close" data-dismiss="modal">&times;</button>
        <input type="hidden" id="id">
      </div>
      <!-- Modal BODY-->
      <div class="modal-body">
        <div class="form-group">
          <div class="input-group  mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">FECHA:</span>
            </div>
            <input type="date" class="form-control" id="fecha" placeholder="Ingrese la fecha y presione enter" onkeypress="return AddKeyPress(event);" maxlength="20" tabindex="1" required>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">PERIODO MES:</span>
            </div>
            <input type="number" class="form-control" id="periodoMes" placeholder="Ingrese el numero del mes" maxlength="100" tabindex="2" min="1" max="12" required>

            <div class="input-group-prepend">
              <span class="input-group-text">AÑO:</span>
            </div>
            <input type="number" class="form-control" id="periodoAnio" placeholder="Ingrese el numero del mes" maxlength="100" tabindex="3" min="2018" max="2050" required>
          </div>
        </div>

        <div class="form-group">
          <label for="socios">Socio:</label>
          <div id="divcomboSociosabmRecibos"></div> <!-- Se llena mediante ajax -->
        </div>


        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default">OBS.:</span>
            </div>
            <input type="text" class="form-control" id="observaciones" placeholder="observaciones" maxlength="100" tabindex="6" required>
          </div>
        </div>
      </div>
      <!-- Modal FOOTER-->
      <div class="modal-footer">
        <button type="button" id="btnGuardar" class="btn btn-success" tabindex="7">Guardar</button>
        <button type="button" id="btnCerrarAbajo" class="btn btn-cancel close btn btn-warning" data-dismiss="modal" tabindex="8">Cerrar</button>
      </div>
      <div id="error"></div>
    </div>
  </div>
</div>
