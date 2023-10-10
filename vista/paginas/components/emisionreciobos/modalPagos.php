<!-- Modal -->
<div class="modal" id="modalEmisionPagosAbm" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <!-- Modal HEADER-->
      <div class="modal-header">
        <h4 class="modal-title">INGRESO PAGO</h4>
        <button type="button" id="btnCerrar" class="btn btn-cancel close" data-dismiss="modal">&times;</button>
        <input type="hidden" id="id">
      </div>
      <!-- Modal BODY-->
      <div class="modal-body">
        <div class="form-group">
          <div class="input-group">
            <div class="col-xs-12 col-md-5">
              <label for="fecha">Fecha:</label>
              <input type="date" class="form-control" id="fecha" placeholder="Ingrese la fecha y presione enter" onkeypress="return AddKeyPress(event);" maxlength="20" tabindex="1" required>
            </div>
          </div>
        </div>
        <div class="form-group ">
          <label for="socios">Socio:</label>
          <div id="comboSociosPagos">
          </div> <!-- Se llena mediante ajax -->
        </div>


        <div class="form-group">
          <label for="nrecibo">NºRecibo:</label>
          <div id="divcomboRecibos"></div> <!-- Se llena mediante ajax -->
        </div>

        <div class="form-group ">
          <label for="periodoMes">Monto$:</label>
          <input type="number" class="form-control" id="montoPago" placeholder="Ingrese el monto" maxlength="100" tabindex="2" required>
        </div>
        <div class="form-group">
          <label for="observaciones">observaciones</label>
          <input type="text" class="form-control" id="observaciones" placeholder="observaciones" maxlength="100" tabindex="6" required>
        </div>
      </div>
      <!-- Modal FOOTER-->
      <div class="modal-footer">
        <div id="error"></div>
        <button type="button" id="btnGuardarElPago" class="btn btn-success" tabindex="7">Guardar</button>
        <button type="button" id="btnCerrarAbajo" class="btn btn-cancel close btn btn-warning" data-dismiss="modal" tabindex="8">Cerrar</button>
      </div>

    </div>
  </div>
</div>
