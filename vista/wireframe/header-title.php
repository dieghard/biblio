<?php
$pagina = $_GET['controlador'];
$titulo = '';
$botones = '';
switch ($pagina) {
  case 'panel':
    $titulo = 'Panel';
    break;
  case 'emisionderecibos':
    $titulo = 'Emision de recibos';
    $botones = '<div class="box-header">
      <button type="button" class="btn btn-primary" id="btnNuevo" title="haga un click aqui para ingresar recibos ">INGRESO DE RECIBOS</button>
      <button type="button" class="btn btn-secondary" id="btnNuevoMonto" title="haga un click aqui para ingresar recibos con montos ">INGRESO DE RECIBOS CON MONTOS</button>

      <button type="button" class="btn btn-danger" id="btnPago" title="haga un click aqui para ingresar un pago ">INGRESO DE PAGOS</button>

      <button type="button" class="btn btn-success" id="btnImprimir" title="haga un click aqui para imprimir recibos ">IMPRESION RECIBOS</button>
    </div>';
    break;
  case 'socios':
    $titulo = 'Socios';
    break;
  case 'provincias':
    $titulo = 'Provincias';
    break;
  case 'localidad':
    $titulo = 'Localidad';
    break;
  case 'costoCuota':
    $titulo = 'Costos';
    break;
  case 'sectores':
    $titulo = 'Sectores';
    break;
  default:
    echo '<meta http-equiv="refresh" content="0;URL=logout.php">';
    break;
}
?>
<header class="main-heading shadow-2dp">
  <div class="dashhead bg-white">
    <div class="dashhead-titles">
      <h6 class="dashhead-subtitle">Biblios<p>Software para biblioteca</p>
      </h6>

      <h3 class="dashhead-title"><?php echo  $titulo; ?></h3>
    </div>
    <?php echo $botones; ?>

    <div class="dashhead-toolbar">
      <div class="dashhead-toolbar-item">
        <a href="index.php">Panel</a>
      </div>
    </div>
  </div>
</header>