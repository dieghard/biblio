<div class="box-header">
  <div class="col-md-12 col-sm-12">
    <button data-toggle="collapse" class="btn btn-primary" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Filtros RECIBOS EMITIDOS </button>
  </div>

  <div class="collapse" id="collapseExample">

    <div class="card card-body">
      <div class="row">
        <div class="col-md-12 col-sm-12 mb-2">
          <div id="comboSocios"></div> <!-- Se llena mediante ajax -->
        </div>
      </div>
      <!--!!FILTROS de año mes -->
      <div class="row">
        <div class="col-md-3 col-sm-12">
          <span class="badge badge-light pr-5 m-1">
            Periodo Desde:
            <select id="mesDesdeFiltro" name="mes">
              <?php require_once("optionMeses.php"); ?>
            </select>
            <input type="number" id="anioDesdeFiltro" min="2019">
          </span>

          <span class="badge badge-light pr-5 m-1">
            Periodo Hasta:
            <select id="mesHastaFiltro" name="mes">
              <?php require("optionMeses.php"); ?>
            </select>
            </select>
            <input type="number" id="anioHastaFiltro" min="2019">
          </span>

        </div>
      </div>
      <!-- Filtro para el estado del saldo -->
      <div class="row">
        <div class="col-md-3 col-sm-12">
          <span class="badge badge-light pr-5 m-1">Estado del Saldo:
            <select id="saldoFiltro" name="saldo">
              <option value="con" selected>Con Saldo</option>
              <option value="sin">Sin Saldo</option>
              <option value="todos">Todos</option>
            </select>
          </span>
        </div>
        <div class="col-md-3 col-sm-12">
          <span class="badge badge-light pr-5 m-1">Filtrar por Recibos o Pagos:
            <select id="recibos_pagos" name="recibos_pagos">
              <option value="todos" selected>todos</option>
              <option value="recibos">recibos</option>
              <option value="pagos">pagos</option>
            </select>
          </span>
        </div>
      </div>
      <button type="button" class="btn btn-secondary m-1" id="btnbuscar" title="haga un click aqui para buscar recibos ">BUSQUEDA DE RECIBOS</button>
    </div><!-- /.fin CARD-->
  </div><!-- /.fin colapse -->
</div>
<!-- /.fin colapse -->
