<!DOCTYPE html>
<html>

<head>
  <link rel='shortcut icon' type='image/png' href='favicon.ico' />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Biblio - RA.SOFTWARE</title>
  <link rel="stylesheet" href="vista/assets/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="vista/assets/vendor/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="vista/assets/css/animate.css">
  <link rel="stylesheet" href="vista/assets/css/loguin.css">

</head>

<body>
  <div class="container">

    <div class="row text-center  justify-content-center align-items-center minh-100 m-1 ">
      <div class="col">
        <img src="vista/assets/img/logora.png" class="rounded mx-auto d-block img-fluid" width="10%" height="10%" alt="R.A. Software">
      </div>
    </div>
    <div class="row">
      <div class="wrapper fadeInDown">
        <div id="divFormContent"></div>
      </div>
    </div>

    <script src="vista/assets/js/jquery-3.2.1.min.js"></script>
    <script src="vista/assets/js/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="vista/assets/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> <!-- LOGIN-->
    <script>
    $(function() {
      $("#divFormContent").load("./vista/login-formcontent.html");
    });
    </script>

    <script src="vista/assets/js/login.js"></script>
</body>
</html>
