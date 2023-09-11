<?php
namespace Controllers;

require_once '../../Model/PanelModel.php';
use Model\PanelModel;

class PanelController
{
  private $model  ;
  public function __construct()
  {
    $model = new PanelModel();
  }

    public function verificarUsuarios($bibliotecaID)
    {
        return  $this->model->verificarUsuarios($bibliotecaID);

    }

  }



if (isset($_POST['ACTION'])) {
    $accion = $_POST['ACTION'];
} else {
    return;
}

if ($accion == 'cantidadSocios') {
    $panel = new PanelController();
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $biblioteca = $_SESSION['biblioteca'];
    $bibliotecaID = $biblioteca['id'];


    $respuesta = $panel->verificarUsuarios($bibliotecaID);
    echo $respuesta;
}
