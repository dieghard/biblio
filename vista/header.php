<header class="app-heading">
  <!-- begin .navbar -->
  <nav class="navbar navbar-default navbar-static-top shadow-2dp">
    <!-- begin .navbar-header -->
    <div class="navbar-header">
      <!-- begin .navbar-header-left with image -->
      <div class="navbar-header-left b-r">
        <!--begin logo-->
        <a class="logo" href="../index.html">
          <span class="logo-xs visible-xs">
            <img src="assets/img/logo_xs.svg" alt="logo-xs">
          </span>
          <span class="logo-lg hidden-xs">
            <img src="assets/img/logo_lg.svg" alt="logo-lg">
          </span>
        </a>
        <!--end logo-->
      </div>
      <!-- END: .navbar-header-left with image -->
      <nav class="nav navbar-header-nav">

        <a class="visible-xs b-r" href="#" data-side=collapse>
          <i class="fa fa-fw fa-bars"></i>
        </a>

        <a class="hidden-xs b-r" id="botonOcultar" href="#" data-side=mini>
          <i class="fa fa-fw fa-bars"></i>
        </a>

      </nav>

      <ul class="nav navbar-header-nav m-l-a">
        <li class="visible-xs b-l">
          <a href="#top-search" data-toggle="canvas">
            <i class="fa fa-fw fa-search"></i>
          </a>
        </li>
        <!-- BEGIN MAILS en NAV ARRIBA -->
        <?php //include ('wireframe\mails.php')?>
        <!-- END MAILS en NAV ARRIBA -->

        <!-- BEGIN Usuario en NAV ARRIBA -->
        <?php include 'wireframe/datosUser.php'; ?>
        <!-- END Usuario en NAV ARRIBA -->
      </ul>
    </div>
    <!-- END: .navbar-header -->
  </nav>
  <!-- END: .navbar -->
</header>


