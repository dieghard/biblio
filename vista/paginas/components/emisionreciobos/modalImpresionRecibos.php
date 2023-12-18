<div class="modal" id="modalImpresionRecibos">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <!-- Modal HEADER-->
      <div class="modal-header">
        <h4 class="modal-title">IMPRESION DE RECIBOS</h4>
        <button type="button" id="btnCerrar" class="btn btn-cancel close" data-dismiss="modal">&times;</button>
        <input type="hidden" id="id">
      </div>
      <!-- Modal BODY-->
      <div class="modal-body">
        <div class="form-group">
          <label for="periodoMesImpresion">Periodo Mes:</label>
          <input type="number" class="form-control" id="periodoMesImpresion" placeholder="Ingrese el numero del mes" maxlength="100" tabindex="2" min="1" max="12" required>
        </div>
        <div class="form-group">
          <label for="periodoAnioImpresion">año:</label>
          <input type="number" class="form-control" id="periodoAnioImpresion" placeholder="Ingrese el numero del mes" maxlength="100" tabindex="3" min="2018" max="2050" required>
        </div>
        <div class="form-group">
          <label for="numeroReciboImpresion">NºRECIBO:</label>
          <input type="text" class="form-control" id="numeroReciboImpresion" placeholder="Ingrese el numero de recibo (opcional)" maxlength="100" tabindex="3" min="2018" max="2050" required>
        </div>
        <div class="form-group">
          <label for="socios">Socio:</label>
          <div id="comboSociosImpresion"></div> <!-- Se llena mediante ajax -->
        </div>
        <div class="form-group">
          <div id="elSector" class="form-group">
            <!-- lo llenamos por js-->
          </div>
        </div>
      </div>
      <!-- Modal FOOTER-->
      <div class="modal-footer">
        <button type="button" id="btnImprimirRecibo" class="btn btn-success" tabindex="7">Imprimir</button>
        <button type="button" id="btnCerrarAbajo" class="btn btn-cancel close btn btn-warning" data-dismiss="modal" tabindex="8">Cerrar</button>
      </div>
      <div id="error"></div>
    </div>
  </div>
</div>