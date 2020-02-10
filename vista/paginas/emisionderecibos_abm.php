<div class="row">
    <div class="col-md-12">
            <div class ="row">
                <div class="box box-solid box-success">
                    <div class="box-header">
                        <button type="button" class="btn btn-primary" id="btnNuevo" title="haga un click aqui para ingresar recibos ">INGRESO DE RECIBOS</button></h4>
                        <button type="button" class="btn btn-secondary" id="btnImprimir" title="haga un click aqui para imprimir recibos ">IMPRESION RECIBOS</button>     
                    </div>
                </div>
            </div>
            <!-- comenzamos con los filtros-->
        <!---  ACA VIENE LA TABLA--->
            <div class="row">
               <!---   <div class="col-12"> -->
                    <div class="box box-solid box-primary">
                        <div class="box-header">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <h4 class="box-title">FILTROS RECIBOS EMITIDOS</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div id="comboSocios"></div> <!-- Se llena mediante ajax -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <label for="mesDesdeFiltro">Periodo Desde:</label>  
                                    <select id="mesDesdeFiltro" name ="mes">
                                    <option value="0">Seleccione</option>
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <label for="anioDesdeFiltro">Año Desde:</label>
                                    <input type="number" id="anioDesdeFiltro" min="2017" >
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <label for="mesHastaFiltro">Periodo Hasta:</label>  
                                    <select id="mesHastaFiltro" name ="mes">
                                    <option value="0">Seleccione</option>
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <label for="anioHastaFiltro">Año Hasta:</label>
                                    <input type="number" id="anioHastaFiltro" min="2017" >
                                </div>
                            </div>
                        </div><!-- /.box-header -->
                        <button type="button" class="btn btn-secondary" id="btnbuscar" title="haga un click aqui para buscar recibos ">BUSQUEDA DE RECIBOS</button>

                        <div class="box-body">
                            <div id="tabla"><!---se llena por j --></div>
                        </div><!-- /.box-body -->
                    </div>
               <!-- </div>-->
            </div>
        <!---  FIN TABLA--->
    </div>
</div>
<!-- Modal -->
<div class="modal" id="modalEmisionRecibosAbm" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <!-- Modal HEADER-->
            <div class="modal-header">
                <h4 class="modal-title">INGRESO DE RECIBOS</h4>
                <button type="button" id="btnCerrar" class="btn btn-cancel close" data-dismiss="modal">&times;</button>
                <input type="hidden" id="id">
            </div>
            <!-- Modal BODY-->
            <div class="modal-body">
                <div class="form-group">
                    <label for="fecha">Fecha:</label>
                    <input type="date" class="form-control" id="fecha" placeholder="Ingrese la fecha y presione enter"  onkeypress="return AddKeyPress(event);" maxlength="20" tabindex="1" required > 
                </div>
                <div class="form-group ">
                    <label for="periodoMes">Periodo Mes:</label>
                    <input type="number" class="form-control" id="periodoMes" placeholder="Ingrese el numero del mes" maxlength="100" tabindex="2" min="1" max="12" required>  
                </div>
                <div class="form-group ">
                    <label for="periodoAnio">año:</label>
                    <input type="number" class="form-control" id="periodoAnio" placeholder="Ingrese el numero del mes" maxlength="100" tabindex="3" min="2018" max="2050" required>  
                </div>
                <div class="form-group ">
                    <label for="socios">Socios:</label>
                        <div id="comboSociosabm"></div> <!-- Se llena mediante ajax --> 
                </div>
                <div class="form-group">
                    <label for="observaciones">observaciones</label>
                    <input type="text" class="form-control" id="observaciones" placeholder="observaciones" maxlength="100" tabindex="6" required >
                </div>
            </div>
            <!-- Modal FOOTER-->
            <div class="modal-footer">
                <button type="button" id="btnGuardar" class="btn btn-success" tabindex="7" >Guardar</button>
                <button type="button" id="btnCerrarAbajo" class="btn btn-cancel close btn btn-warning" data-dismiss="modal" tabindex="8">Cerrar</button>
            </div>
            <div id="error"></div>
        </div>
    </div>
</div>
    <!-- /////////////////////////////////////////////////////////////////////-->
    <!-- Modal Impresion -->
<div class="modal" id="modalImpresionRecibos" >
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
                    <button type="button" id="btnImprimirRecibo" class="btn btn-success" tabindex="7" >Imprimir</button>
                    <button type="button" id="btnCerrarAbajo" class="btn btn-cancel close btn btn-warning" data-dismiss="modal" tabindex="8">Cerrar</button>
                </div>
                <div id="error"></div>
            </div>
        </div>
</div>
<script src="paginas/js/emisionRecibos.js"></script>
