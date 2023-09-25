<?php
class VistasModelo {
  protected static function obtener_vistas_modelo($vista){
    $listaBlanca = [];
    if(in_array($vista,$listaBlanca)){
      if(is_file("./vistas/contenidos/".$vista."-view.php")){
        $contenido ="./vistas/contenidos/".$vista."-view.php";
      }
      else{
        $contenido = "404";
      }
    }elseif( $vista == "login"||$vista == 'index'){
      $contenido = "login";
    }else{
      $contenido = "404";
    }
    return $contenido;
  }
}
