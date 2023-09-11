<?php
namespace Controller;
require_once '../Model/LocalidadModel.php';
use Model\LocalidadModel;

class LocalidadController
{
    private $controlador;
    public function __construct()
    {
        $this->controlador = new LocalidadModel();
    }

    public function eliminarLocalidad($data)
    {
       return $this->controlador->eliminarLocalidad($data);

    }

    public function ingresarActualizarLocalidad($data)
    {
        return  $this->controlador->ingresarActualizarLocalidad($data);

    }

    public function llenarGrilla()
    {

        return  $this->controlador->llenarGrilla();

    }
}

$ajaxLocalidad = new LocalidadController();

if (isset($_POST['ACTION'])) {
    if ($_POST['ACTION'] == 'llenarGrilla') {
        $respuesta = $ajaxLocalidad->llenarGrilla();
        $ajaxLocalidad = null;
    }
    if ($_POST['ACTION'] == 'eliminarLocalidad') {
        $misDatosJSON = json_decode($_POST['datosjson']);
        $respuesta = $ajaxLocalidad->eliminarLocalidad($misDatosJSON);
        $ajaxLocalidad = null;
    }
    if ($_POST['ACTION'] == 'ingresarActualizarLocalidad') {
        $misDatosJSON = json_decode($_POST['datosjson']);
        $respuesta = $ajaxLocalidad->ingresarActualizarLocalidad($misDatosJSON);
        $ajaxLocalidad = null;
    }
    echo $respuesta;
} else {
    //  var_dump($_POST);
}
