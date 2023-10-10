<div class="box-header">
  <div class="col-md-12 col-sm-12">
    <button data-toggle="collapse" class="btn btn-primary" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Filtros RECIBOS EMITIDOS </button>
  </div>

  <div class="collapse" id="collapseExample">
    <div class="card card-body">

      <div class="col-md-12 col-sm-12 mb-2">
        <div id="comboSocios"></div> <!-- Se llena mediante ajax -->
      </div>

      <!--!!FILTROS de año mes -->
      <div class="col-md-3 col-sm-12">
        <span class="badge badge-light pr-5 m-1">Periodo Desde:
          <select id="mesDesdeFiltro" name="mes" style="forecolor:black">
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
        </span>
        <span class="badge badge-light pr-3 m-1">Año Desde:<input type="number" id="anioDesdeFiltro" min="2019"></span>
        <span class="badge badge-light pr-5">Periodo Hasta:
          <select id="mesHastaFiltro" name="mes">
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
        </span>
        <span class="badge badge-light pr-5">Año Hasta: <input type="number" id="anioHastaFiltro" min="2019"></span>
      </div>
      <!-- Filtro para el estado del saldo -->
      <div class="col-md-3 col-sm-12">
        <span class="badge badge-light pr-5 m-1">Estado del Saldo:
          <select id="saldoFiltro" name="saldo">
            <option value="con" selected>Con Saldo</option>
            <option value="sin">Sin Saldo</option>
            <option value="todos">Todos</option>
          </select>
        </span>
      </div>
      <button type="button" class="btn btn-secondary m-1" id="btnbuscar" title="haga un click aqui para buscar recibos ">BUSQUEDA DE RECIBOS</button>
    </div><!-- /.fin CARD-->
  </div><!-- /.fin colapse -->
</div>
<!-- /.fin colapse -->
