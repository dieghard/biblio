<?php
namespace Controller;

require_once '../Model/CostoCuotaModel.php';
use Model\CostoCuotaModel;

class CostoCuotaController
{
    private $model;
    public function __construct()
    {

      $model= new CostoCuotaModel();
    }

    public function eliminarCostoCuota($bibliotecaID, $data)
    {
       return $this->model->eliminarValorCuota($bibliotecaID, $data);
    }

    public function ingresarActualizarCostoCuota($bibliotecaID, $data)
    {

        return $this->model->ingresarActualizarValorCuota($bibliotecaID, $data);

    }

    public function llenarGrilla($bibliotecaID)
    {
        return $this->model->llenarGrilla($bibliotecaID);

    }
}


$ajaxCostoCuota = new CostoCuotaController();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

  $biblioteca = $_SESSION['biblioteca'];
  $bibliotecaID = $biblioteca['id'];
  $respuesta = '';
if (isset($_POST['ACTION'])) {
    if ($_POST['ACTION'] == 'llenarGrilla') {
        $respuesta = $ajaxCostoCuota->llenarGrilla($bibliotecaID);
        $ajaxCostoCuota = null;
    }
    if ($_POST['ACTION'] == 'eliminarCostoCuota') {
        $misDatosJSON = json_decode($_POST['datosjson']);
        $respuesta =  $ajaxCostoCuota->eliminarCostoCuota($bibliotecaID, $misDatosJSON);
        $ajaxCostoCuota = null;
    }
    if ($_POST['ACTION'] == 'ingresarActualizarCostoCuota') {
        $misDatosJSON = json_decode($_POST['datosjson']);
        $respuesta = $ajaxCostoCuota->ingresarActualizarCostoCuota($bibliotecaID, $misDatosJSON);
        $ajaxCostoCuota = null;
    }
    echo $respuesta;
} else {
    //  var_dump($_POST);
}
