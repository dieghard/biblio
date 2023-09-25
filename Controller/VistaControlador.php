<?php
require_once "./model/vistasModelo.php";

class VistasControlador extends VistasModelo
{

  public function obtener_plantilla_controlador($vista)
  {
    return require_once "./vista/plantilla.php";
  }
  public function obtener_vistas_controlador($vista){
    if(isset($_GET['views'])){
      $ruta = explode("/", $_GET['views']);
      $respuesta = VistasModelo::obtener_vistas_modelo($ruta[0]);
    }else{
      $respuesta = "login";
    }
    return $respuesta;
  }
}
