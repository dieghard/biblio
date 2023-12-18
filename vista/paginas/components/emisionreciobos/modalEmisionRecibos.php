<style>
.modal-content {
  background-color: #f9f9f9;
  font-family: Arial, sans-serif;
}

.modal-header {
  border-bottom: 1px solid #ddd;
}

.modal-title {
  color: #333;
}

.modal-body {
  padding: 20px;
}

.input-group-text {
  color: #555;
}

.btn {
  margin-right: 10px;
}

.btn:hover {
  opacity: 0.8;
}

#btnGuardar {
  background-color: #5cb85c;
  border-color: #4cae4c;
}

#btnCerrarAbajo {
  background-color: #f0ad4e;
  border-color: #eea236;
}

.modal {
  transition: all 0.3s ease-out;
  transform: translateY(-100%);
  opacity: 0;
  display: none;
  /* Oculta el modal por defecto */
}

.modal.show {
  transform: translateY(0);
  opacity: 1;
  display: block;
  /* Muestra el modal cuando se añade la clase .show */
}

</style>
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
