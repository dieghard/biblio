<?php

// required headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Allow: GET, POST, OPTIONS, PUT, DELETE');
/*
=================================================================================================
 * VALIDAR USUARIO!
=================================================================================================
*/
class Ajax_EmisionRecibos
{
    public function __construct()
    {
        require_once '../../controlador/controladorEmisionDeRecibos.php';
    }

    public function llenarGrilla($bibliotecaID,$data)
    {
        $controller = new controladorEmisionDeRecibos();

        $respuesta = $controller->llenarGrilla($bibliotecaID,$data);
        echo $respuesta;
        $controller = null;
    }

    public function impresionRecibos($bibliotecaID, $data)
    {
        $controller = new controladorEmisionDeRecibos();

        $respuesta = $controller->impresionRecibos($bibliotecaID, $data);
        echo $respuesta;
        $controller = null;
    }

    public function ingresoEmisionRecibos($bibliotecaID, $misDatosJSON)
    {
        $controller = new controladorEmisionDeRecibos();

        $respuesta = $controller->IngresoEmisionRecibos($bibliotecaID, $misDatosJSON);
        echo $respuesta;
        $controller = null;
    }

    public function ingresoEmisionPagos($bibliotecaID, $misDatosJSON)
    {
        $controller = new controladorEmisionDeRecibos();

        $respuesta = $controller->ingresoEmisionPagos($bibliotecaID, $misDatosJSON);
        echo $respuesta;
        $controller = null;
    }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['ACTION'])) {
    $accion = $_POST['ACTION'];
} else {
    return;
}

if ($accion == 'llenarGrilla') {
    LlenarGrilla();
}
if ($accion == 'ingresoEmision') {
    IngresoEmisionRecibos();
}
if ($accion == 'ingresoPago') {
    ingresoEmisionPagos();
}
if ($accion == 'impresionRecibos') {
    impresionRecibos();
}

function impresionRecibos()
{
    $respuesta = new Ajax_EmisionRecibos();
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $biblioteca = $_SESSION['biblioteca'];
    $bibliotecaID = $biblioteca['id'];
    $data['socioID'] = $_POST['socioID'];
    $data['mesImpresion'] = $_POST['mesImpresion'];
    $data['anioImpresion'] = $_POST['anioImpresion'];
    $data['numeroReciboImpresion'] = $_POST['numeroReciboImpresion'];
    $data['sectorImpresion'] = $_POST['sectorImpresion'];

    $respuesta->impresionRecibos($bibliotecaID, $data);
}
function LlenarGrilla()
{
    $respuesta = new Ajax_EmisionRecibos();
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $biblioteca = $_SESSION['biblioteca'];
    $bibliotecaID = $biblioteca['id'];
    $data['socioID'] = $_POST['socioID'];
    $data['mesDesde'] = $_POST['mesDesde'];
    $data['anioDesde'] = $_POST['anioDesde'];
    $data['mesHasta'] = $_POST['mesHasta'];
    $data['anioHasta'] = $_POST['anioHasta'];

    $respuesta->llenarGrilla($bibliotecaID,$data);
}
function IngresoEmisionRecibos()
{
    $respuesta = new Ajax_EmisionRecibos();

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $biblioteca = $_SESSION['biblioteca'];
    $bibliotecaID = $biblioteca['id'];

    $misDatosJSON = json_decode($_POST['datosjson']);

    //$superArray['$misDatosJSON'] = $misDatosJSON;
    //$superArray['$bibliotecaID'] = $bibliotecaID ;

    //echo json_encode($superArray);
    $respuesta->ingresoEmisionRecibos($bibliotecaID, $misDatosJSON);
}
    function ingresoEmisionPagos()
    {
        $respuesta = new Ajax_EmisionRecibos();

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $biblioteca = $_SESSION['biblioteca'];
        $bibliotecaID = $biblioteca['id'];

        $misDatosJSON = json_decode($_POST['datosjson']);

        //$superArray['$misDatosJSON'] = $misDatosJSON;
        //$superArray['$bibliotecaID'] = $bibliotecaID ;

        //echo json_encode($superArray);
        $respuesta->ingresoEmisionPagos($bibliotecaID, $misDatosJSON);
    }
