<?php
/**
 * Description of ajaxComboBibliotecas.
 *
 * @author Diego
 */
class AjaxCostoCuota
{
    public function __construct()
    {
        require_once '../../controlador/controladorCostoCuota.php';
    }

    public function llenarGrilla($bibliotecaID)
    {
        $ajaxCostoCuota = new ControladorCostoCuota();
        $respuesta = $ajaxCostoCuota->llenarGrilla($bibliotecaID);
        echo $respuesta;
    }

    public function eliminarCostoCuota($bibliotecaID, $misDatosJSON)
    {
        $ajaxCostoCuota = new ControladorCostoCuota();
        $respuesta = $ajaxCostoCuota->eliminarCostoCuota($bibliotecaID, $misDatosJSON);
        echo $respuesta;
    }

    public function ingresarActualizarCostoCuota($bibliotecaID, $misDatosJSON)
    {
        $ajaxCostoCuota = new ControladorCostoCuota();
        $respuesta = $ajaxCostoCuota->ingresarActualizarCostoCuota($bibliotecaID, $misDatosJSON);
        echo $respuesta;
    }
}

$ajaxCostoCuota = new AjaxCostoCuota();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$biblioteca = $_SESSION['biblioteca'];
$bibliotecaID = $biblioteca['id'];

if (isset($_POST['ACTION'])) {
    if ($_POST['ACTION'] == 'llenarGrilla') {
        $ajaxCostoCuota->llenarGrilla($bibliotecaID);
        $ajaxCostoCuota = null;
    }
    if ($_POST['ACTION'] == 'eliminarCostoCuota') {
        $misDatosJSON = json_decode($_POST['datosjson']);
        $ajaxCostoCuota->eliminarCostoCuota($bibliotecaID, $misDatosJSON);
        $ajaxCostoCuota = null;
    }
    if ($_POST['ACTION'] == 'ingresarActualizarCostoCuota') {
        $misDatosJSON = json_decode($_POST['datosjson']);
        $ajaxCostoCuota->ingresarActualizarCostoCuota($bibliotecaID, $misDatosJSON);
        $ajaxCostoCuota = null;
    }
} else {
    //  var_dump($_POST);
}
