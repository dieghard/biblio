<?php
namespace Controller;
require_once '../Model/SectorModel.php';
use Model\SectorModel;

class SectorController
{
    private $model;
    public function __construct()
    {
      $this->model = new SectorModel();
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

  if ($_POST['ACTION'] == 'llenarGrilla') {
    $respuesta = $ajaxSector->llenarGrilla($bibliotecaID);
  }elseif ($_POST['ACTION'] == 'eliminarSector') {
        $misDatosJSON = json_decode($_POST['datosjson']);
        $respuesta = $ajaxSector->eliminarSector($bibliotecaID, $misDatosJSON);
    }elseif ($_POST['ACTION'] == 'ingresarActualizarSector') {
      $misDatosJSON = json_decode($_POST['datosjson']);
      $respuesta = $ajaxSector->ingresarActualizarSector($bibliotecaID, $misDatosJSON);
    }
  } else {
    //  var_dump($_POST);
  }

  echo $respuesta;
