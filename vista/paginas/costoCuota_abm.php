<style type="text/css">

#idTablaUser_filter {
        float: left;
        text-align: left;
}

</style>
<div class="row">
 <div class ="col-12">
       <div class="row">
        <div class="box box-solid box-success">
                <div class="box-header">  
                    <h4>Maestro Costos Cuotas <button type="button" class="btn btn-primary" id="btnNuevo" title="haga un click aqui para ingresar un nuevo Costo de Cuota">NUEVA COSTO</button> </h4>
                </div>
                <div class="box-body">            
                     <div id="tabla">
                         <!---se llena por j -->
                     </div>
                </div>
            <!--<hr class="b-w-5 b-wisteria">---DIBUJA UNA LINEA -->
            </div>
    </div>
     <!-- Modal -->
    <div class="modal" id="modalCostoCuota" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <!-- Modal HEADER-->
                <div class="modal-header">
                    <h4 class="modal-title">COSTO CUOTA</h4>
                    <button type="button" id="btnCerrar" class="btn btn-cancel close" data-dismiss="modal">&times;</button>
                    <input type="hidden" id="id"  > 
                </div>
                <!-- Modal BODY-->
                <div class="modal-body">
                    <div class="form-group ">
                        <label for="descripcion">Descripcion:</label>
                        <input type="text" class="form-control" id="descripcion" placeholder="Ingrese descripcion" maxlength="100" tabindex="0" required>  
                    </div>
                    <div class="form-group ">
                        <label for="valorCuota">Valor Cuota:</label>
                        <input type="number" class="form-control" id="valorCuota" placeholder="Ingrese el valor de la cuota" maxlength="100" tabindex="1" required>  
                    </div>        
                </div>
                 <!-- Modal FOOTER-->
                <div class="modal-footer">
                    <button type="button" id="btnGuardar" class="btn btn-success" tabindex="2" >Guardar</button>
                    <button type="button" id="btnCerrarAbajo" class="btn btn-cancel close btn btn-warning" data-dismiss="modal" tabindex="3" >Cerrar</button>
                </div>
                <div id="error"></div>    
            </div>
        </div>
    </div>    
</div>    
</div>        
<!-- /////////////////////////////////////////////////////////////////////-->
<script src="paginas/js/costoCuota.js"></script>
    