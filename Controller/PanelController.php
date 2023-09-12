<?php
namespace Controllers;

require_once '../Model/PanelModel.php';
use Model\PanelModel;

class PanelController
{
  private $model ;
  public function __construct(){
    $this->model = new PanelModel();
  }

  public function verificarUsuarios($bibliotecaID){
      return  $this->model->cantidadSocios_y_Montos($bibliotecaID);
  }

}

if (isset($_POST['ACTION'])) :
    $accion = $_POST['ACTION'];
else :
    return;
endif;

if ($accion == 'cantidadSocios') :
    $panel = new PanelController();
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $biblioteca = $_SESSION['biblioteca'];
    $bibliotecaID = $biblioteca['id'];


    $respuesta = $panel->verificarUsuarios($bibliotecaID);
    echo $respuesta;
endif;
