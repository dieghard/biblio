<?php
namespace Controller;
require_once '../../Modelo/SectorModel.php';
use Model\SectorModel;

class SectorController
{
    private $model;
    public function __construct()
    {
      $model = new SectorModel();
    }

    public function eliminarSector($bibliotecaID, $data)
    {

        return $this->model->eliminarSector($bibliotecaID, $data);

    }

    public function ingresarActualizarSector($bibliotecaID, $data)
    {
      return $this->model->ingresarActualizarSector($bibliotecaID, $data);

    }

    public function llenarGrilla($bibliotecaID)
    {
      return $this->model->llenarGrilla($bibliotecaID);

    }
}


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$biblioteca = $_SESSION['biblioteca'];
$bibliotecaID = $biblioteca['id'];
$ajaxSector = new  SectorController();
$respuesta ='';
if (isset($_POST['ACTION'])) {
    $misDatosJSON = json_decode($_POST['datosjson']);
    if ($_POST['ACTION'] == 'llenarGrilla') {
        $respuesta = $ajaxSector->llenarGrilla($bibliotecaID);
      }
      if ($_POST['ACTION'] == 'eliminarSector') {
        $respuesta = $ajaxSector->eliminarSector($bibliotecaID, $misDatosJSON);
      }
      if ($_POST['ACTION'] == 'ingresarActualizarSector') {
        $respuesta = $ajaxSector->ingresarActualizarSector($bibliotecaID, $misDatosJSON);
      }
      echo $respuesta;
} else {
    //  var_dump($_POST);
}
