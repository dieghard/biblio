<?php
namespace Model;

class tablaMovimientos{
  public static function head()
  {
    return '<div class="table-responsive">
                    <table class="table table-condensed  table-striped table-bordered" id="idTablaUser">
                     <thead class="thead-dark">
                      <tr>
                          <th scope="col" id="idColumnaSocio">SOCIO</th>
                          <th scope="col" id="idColumnaPeriodo">PERIODO</th>
                          <th scope="col" id="idColumnaNumeroComprobante">Nº COMPROBANTE</th>
                          <th scope="col" id="idColumnaReciboCobro">Rec./Cob.</th>
                          <th scope="col" id="idColumnaFecha">FECHA</th>
                          <th scope="col" id="idColumnaNumeroReciboPagado">Nº RECIBO PAGADO</th>
                          <th scope="col" id="idColumnaDebe">DEBE</th>
                          <th scope="col" id="idColumnaHaber">HABER</th>
                          <th scope="col" id="idColumnaPago">PAGO</th>
                          <th scope="col" id="idColumnaTotal">TOTAL</th>
                          <th scope="col" id="idColumnaSaldo">SALDO</th>
                          <th scope="col" id="idColumnaObs">OBS.</th>
                          <th scope="col" id="idColumnaBotonPago"></th>
                          <th scope="col" id="idColumnaBotonEliminar"></th>
                      </tr>
                  </thead>
              <tbody>';

  }
}
