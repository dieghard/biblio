 <!-- Modal -->
 <div class="modal" id="modalProvincia" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <!-- Modal content-->
     <div class="modal-content">
       <!-- Modal HEADER-->
       <div class="modal-header">
         <h4 class="modal-title">PROVINCIA</h4>
         <button type="button" id="btnCerrar" class="btn btn-cancel close" data-dismiss="modal">&times;</button>
         <input type="hidden" id="id">
       </div>
       <!-- Modal BODY-->
       <div class="modal-body">
         <div class="form-group ">
           <label for="descripcion">Descripcion:</label>
           <input type="text" class="form-control" id="descripcion" placeholder="Ingrese descripcion" maxlength="100" tabindex="0" required>
         </div>
       </div>
       <!-- Modal FOOTER-->
       <div class="modal-footer">
         <button type="button" id="btnGuardar" class="btn btn-success" tabindex="2">Guardar</button>
         <button type="button" id="btnCerrarAbajo" class="btn btn-cancel close btn btn-warning" data-dismiss="modal" tabindex="3">Cerrar</button>
       </div>
       <div id="error"></div>
     </div>
   </div>
 </div>
