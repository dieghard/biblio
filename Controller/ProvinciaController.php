<?php
namespace Controller;
require_once '../Model/ProvinciaModel.php';
use Model\ProvinciasModel;

class ProvinciaController
{
    private $controlador;
    public function __construct()
    {
        $this->controlador = new ProvinciasModel();
    }

    public function eliminarProvincia($data)
    {
        return  $this->controlador->eliminarProvincia($data);

    }

    public function ingresarActualizarProvincia($data)
    {
       return  $this->controlador->ingresarActualizarProvincia($data);

    }

    public function llenarGrilla()
    {
        return  $this->controlador->llenarGrilla();

    }
}



$ajaxProvincia = new ProvinciaController();

if (isset($_POST['ACTION'])) {
    if ($_POST['ACTION'] == 'llenarGrilla') {
          $respuesta = $ajaxProvincia->llenarGrilla();
        $ajaxProvincia = null;
    }
    if ($_POST['ACTION'] == 'eliminarProvincia') {
        $misDatosJSON = json_decode($_POST['datosjson']);
        $respuesta= $ajaxProvincia->eliminarProvincia($misDatosJSON);
        $ajaxProvincia = null;
    }
    if ($_POST['ACTION'] == 'ingresarActualizarProvincia') {
        $misDatosJSON = json_decode($_POST['datosjson']);
        $respuesta = $ajaxProvincia->ingresarActualizarProvincia($misDatosJSON);
        $ajaxProvincia = null;
    }
    echo $respuesta;
} else {
    var_dump($_POST);
}
