<style>
/* Estilos para filas pagadas */
tr.pagado {
  background-color: greenyellow;
  /* Cambia el color de fondo */
  font-weight: bold;
  /* Hace que el texto sea más grueso o negrita */
}

.icono-con-texto {
  display: flex;
  align-items: center;
  /* Centra verticalmente */
}

/* Estilos para el icono */
.icono-con-texto .material-icons {
  font-size: 24px;
  /* Tamaño del icono */
  margin-right: 8px;
  /* Espacio entre el icono y el texto (ajusta según sea necesario) */
}

/* Estilos para el texto */
.icono-con-texto {
  font-size: 12px;
  /* Tamaño del texto */
}

/* Estilo para filas con fondo aleatorio */
.color-random {
  background-color: var(--color-random);
  color: white;
  /* Color de texto para que sea legible en fondos oscuros */
}

/* Define una variable CSS para el color aleatorio */
:root {
  --color-random: #90EE90;
  /* Color de fondo de respaldo si no se generó un color aleatorio */
}

</style>

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
<?php include 'components/emisionreciobos/modalPagos.php';?>

<!-- Modal Impresion -->
<?php include 'components/emisionreciobos/modalImpresionRecibos.php';?>
<?php require_once('./footer_script.php') ?>

<script src="paginas/js/emisionRecibos.js"></script>
