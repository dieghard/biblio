<?php
/**
 * Description of ajaxComboBibliotecas.
 *
 * @author Diego
 */
class AjaxLocalidad
{
    public function __construct()
    {
        require_once '../../controlador/controladorLocalidad.php';
    }

    public function llenarGrilla()
    {
        $ajaxLocalidad = new ControladorLocalidad();
        $respuesta = $ajaxLocalidad->llenarGrilla();
        echo $respuesta;
    }

    public function eliminarLocalidad($misDatosJSON)
    {
        $ajaxLocalidad = new ControladorLocalidad();
        $respuesta = $ajaxLocalidad->eliminarLocalidad($misDatosJSON);
        echo $respuesta;
    }

    public function ingresarActualizarLocalidad($misDatosJSON)
    {
        $ajaxLocalidad = new ControladorLocalidad();
        $respuesta = $ajaxLocalidad->ingresarActualizarLocalidad($misDatosJSON);
        echo $respuesta;
    }
}

$ajaxLocalidad = new AjaxLocalidad();

if (isset($_POST['ACTION'])) {
    if ($_POST['ACTION'] == 'llenarGrilla') {
        $ajaxLocalidad->llenarGrilla();
        $ajaxLocalidad = null;
    }
    if ($_POST['ACTION'] == 'eliminarLocalidad') {
        $misDatosJSON = json_decode($_POST['datosjson']);
        $ajaxLocalidad->eliminarLocalidad($misDatosJSON);
        $ajaxLocalidad = null;
    }
    if ($_POST['ACTION'] == 'ingresarActualizarLocalidad') {
        $misDatosJSON = json_decode($_POST['datosjson']);
        $ajaxLocalidad->ingresarActualizarLocalidad($misDatosJSON);
        $ajaxLocalidad = null;
    }
} else {
    //  var_dump($_POST);
}
