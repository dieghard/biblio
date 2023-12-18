<?php
require_once '../Controller/Controlador.php';
require_once '../Config/App.php';
require_once '../Config/Config.php';

session_start();

if (!isset($_SESSION['usuario'])) {
  redirect('../index.php');
}

$usuario = $_SESSION['usuario'];
$biblioteca = $_SESSION['biblioteca'];
$_session_NOMBRE = $usuario['apellidoyNombre'];

if (!isset($_GET['controlador'])) {
  redirect('../index.php');
}

$pagina = $_GET['controlador'];

function redirect($url)
{
  header('Location: ' . $url);
  exit;
}
?>
<!doctype html>
<html lang="es">

<?php include "head_script.php"; ?>
<script>
$(document).ready(function() {
  $("a").on('click', function(event) {
    if (this.hash !== "") {
      event.preventDefault();
      var hash = this.hash;
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function() {
        window.location.hash = hash;
      });
    }
  });
});
</script>

<body class="dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-closed sidebar-collapse app-side-opened app-side-mini" cz-shortcut-listen="true">

  <div class="app">
    <div class="app-wrap">
      <?php include "header.php" ?>
      <div class="app-container">
        <aside class="app-side">
          <div class="side-content">
            <?php include 'wireframe/user-left-panel.php'; ?>
            <?php include 'wireframe/menu.php'; ?>
          </div>
        </aside>
        <div class="side-visible-line hidden-xs" data-side="collapse">
          <i class="fa fa-caret-left"></i>
        </div>
        <div class="app-main">
          <?php include 'wireframe/header-title.php'; ?>
          <div class="main-content bg-clouds">
            <div class="container-fluid p-t-15">
              <?php
              switch ($pagina) {
                case 'panel':
                  include 'paginas/panel.php';
                  break;
                case 'emisionderecibos':
                  include 'paginas/emisionderecibos_abm.php';
                  break;
                case 'socios':
                  include 'paginas/users_abm.php';
                  break;
                case 'provincias':
                  include 'paginas/provincias_abm.php';
                  break;
                case 'localidad':
                  include 'paginas/localidad_abm.php';
                  break;
                case 'costoCuota':
                  include 'paginas/costoCuota_abm.php';
                  break;
                case 'sectores':
                  include 'paginas/sector_abm.php';
                  break;
                default:
                  echo '<meta http-equiv="refresh" content="0;URL=logout.php">';
                  break;
              }
              ?>
            </div>
          </div>
        </div>
      </div>
      <?php
      include 'wireframe/footer.php';
      include 'footer_script.php'; ?>
</body>

</html>
