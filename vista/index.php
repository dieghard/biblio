<?php /// SI NO ESTA LOGUEADO ARAFUE
 require_once '../Controller/Controlador.php';
 require_once '../Config/App.php';
 require_once '../Config/Config.php';
if (!isset($_SESSION['usuario'])) {
    session_start();
    if (isset($_SESSION['usuario'])) {
        $usuario = $_SESSION['usuario'];
        $biblioteca = $_SESSION['biblioteca'];
        $_session_NOMBRE = $usuario['apellidoyNombre'];
    } else {
        $newURL = '../index.php';
        header('Location: '.$newURL);
    }
} else {
    $newURL = '../index.php';
    header('Location: '.$newURL);
}
  if (isset($_GET['controlador'])) {
      $pagina = $_GET['controlador'];
  } else {
      $newURL = '../index.php';

  }

?>
<!doctype html>

<html lang="es">
<?php   include "head_script.php" ?>;



<body class="dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-closed sidebar-collapse">
  <!-- begin .app -->
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
                if ($pagina == 'panel') {
                    include 'paginas/panel.php';
                } elseif ($pagina == 'emisionderecibos') {
                    include 'paginas/emisionderecibos_abm.php';
                } elseif ($pagina == 'socios') {
                    include 'paginas/users_abm.php';
                } elseif ($pagina == 'provincias') {
                    include 'paginas/provincias_abm.php';
                } elseif ($pagina == 'localidad') {
                    include 'paginas/localidad_abm.php';
                } elseif ($pagina == 'costoCuota') {
                    include 'paginas/costoCuota_abm.php';
                } elseif ($pagina == 'sectores') {
                    include 'paginas/sector_abm.php';
                } else {
                    $newURL = 'logout.php';
                    echo '<meta http-equiv="refresh" content="0;URL=logout.php">';
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
