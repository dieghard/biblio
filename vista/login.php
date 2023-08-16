<!DOCTYPE html>
<html>

<head>
<link rel='shortcut icon' type='image/png' href='favicon.ico'/>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Login Biblio - RA.SOFTWARE</title>
  <!-- Core stylesheet files. REQUIRED -->
  <!-- Bootstrap -->
  <link rel="stylesheet" href="vista/assets/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!-- Font Awesome -->
  <!-- WARNING: Font Awesome doesn't work if you view the page via file:// -->
  <link rel="stylesheet" href="vista/assets/vendor/font-awesome/css/font-awesome.css">
  <!-- animate.css -->
  <link rel="stylesheet" href="vista/assets/css/animate.css">
  <!-- END: core stylesheet files -->
  <!-- Theme main stlesheet files. REQUIRED -->
  <!--<link rel="stylesheet" href="vista/assets/css/chl.css">-->
  <link rel="stylesheet" href="vista/assets/css/loguin.css">
    <!--<link rel="stylesheet" href="vista/assets/css/theme-peter-river.css">-->
  <!-- END: theme main stylesheet files -->
<!--
  <style media="screen">
    .app {
      background-image: url("vista/assets/img/bg.svg");
      background-repeat: no-repeat;
      background-size: cover;
    }</style>client secret:
    9W3bSRO5rs1ikI8EDfRyn-t1

-->
</head>

<!--<body class="bg-clouds">-->
<body>
<div class="container">


  <div class="row text-center  justify-content-center align-items-center minh-100 m-1 ">
      <div class="col">
        <img src="vista/assets/img/logora.png" class="rounded mx-auto d-block img-fluid"   width="10%" height="10%" alt="R.A. Software" >
      </div>
  </div>

  <!---div class="app"> -->
    <div class="row">
      <!---<div class="text-center box shadow-5 animated fadeInLeft b-r-4 p-a-20">-->
      <div class="wrapper fadeInDown">
        <div id="formContent">
           <!-- Icon -->
          <div class="fadeIn first">
            <img src="vista/assets/img/biblioteca.jpg"  class="rounded mx-auto d-block img-fluid m-2" width="10%" height="10%"  id="icon"  alt="User Icon" />
          </div>
          <hr>
          <div class="text-center box shadow-5 animated fadeInLeft b-r-4 p-a-20">SOFTWARE BIBLIO</div>
            <!--<h6>SOFTWARE BIBLIO</h6>-->
              <div class="form-group has-feedback m-1">
                <!-- <i class="fa fa-fw fa-envelope form-control-feedback"></i>-->
                <input  type="email" class="form-control fadeIn second" id="inputEmail" placeholder="Ingrese su Email" >

                </div>
              <div class="form-group has-feedback m-1">
               <!-- <i class="fa fa-fw fa-key form-control-feedback"></i>-->
                <input type="password" class="form-control fadeIn third" id="inputPassword" placeholder="Ingrese su Password" >

              </div>
              <div class="form-group has-feedback m-1">
                <div id="comboBiblioteca"></div>
                    <!-- <span class="form-control-feedback">
                      <i class="fa-book"></i>
                    </span>-->
              </div>
              <div id="divUsuario"></div>
              <button id="btn-login" class="btn btn-primary btn-lg m-3 ">Ingresar</button>
             <div class="row m-3 text-center  justify-content-center align-items-center minh-100" >
                <a href="app-forgot.html">
                  <small>¿Olvido el password?</small>
                </a>
              </div>
            <!--
              <p class="text-muted text-right">
                ¿No tiene una cuenta?
                <a href="app-register.html">Crear una cuenta</a>
              </p>
            <div class="g-signin2" data-onsuccess="onSignIn"></div>
            -->


          </div>
    </div>
</div>
  <!-- Core javascript files. REQUIRED -->
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

 <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="vista/assets/js/jquery-3.2.1.min.js"></script>
  <!-- Bootstrap -->
  <script src="vista/assets/js/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="vista/assets/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>    <!-- LOGIN-->
  <!-- FIN Bootstrap -->

  <script src="vista/assets/js/login.js"></script>
</body>
</html>
