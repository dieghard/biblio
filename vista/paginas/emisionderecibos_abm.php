<div class="row">
  <div class="col-12">
    <?php include 'components/emisionreciobos/boxHeader.php';?>
  </div>
</div>
<!---  ACA VIENE LA TABLA--->
<div class="row">
  <div class="col-12">
    <div class="box box-solid box-primary">
      <?php include 'components/emisionreciobos/filtros.php';?>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <div id="tabla"> </div>
  </div>
</div>

<!-- Modal -->
<?php include 'components/emisionreciobos/modalEmisionRecibos.php';?>
<?php include 'components/emisionreciobos/modalEmisionRecibosMonto.php';?>

<!-- Modal Impresion -->
<?php include 'components/emisionreciobos/modalImpresionRecibos.php';?>
<?php require_once('./footer_script.php') ?>

<script src="paginas/js/emisionRecibos.js"></script>
