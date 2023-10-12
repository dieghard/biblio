<style type="text/css">
#idTablaUser_filter {
  float: left;
  text-align: left;
}

</style>
<div class="row">
  <div class="col-12">
    <div class="row">
      <div class="box box-solid box-success">
        <div class="box-header">
          <h4>Maestro Provincias <button type="button" class="btn btn-primary" id="btnNuevo" title="haga un click aqui para ingresar una nueva provincia">NUEVA PROVINCIA</button> </h4>
        </div>
        <div class="box-body">
          <div id="tabla">
            <!---se llena por j -->
          </div>
        </div>
        <!--<hr class="b-w-5 b-wisteria">---DIBUJA UNA LINEA -->
      </div>

    </div>


    <?php require_once('provincias_abm_modal.php') ?>
    <script src="paginas/js/provinciasabm.js"></script>
