<?php
namespace Controller;
require_once '../Model/EmisionDeRecibosModel.php';
use Model\EmisionDeRecibosModel;

class EmisionDeRecibosController
{
    private $MP;
    public function __construct()
    {
      $this->MP = new EmisionDeRecibosModel();
    }

    public function LLenarGrilla($bibliotecaID,$data)
    {
        return  $this->MP->LlenarGrilla($bibliotecaID,$data);

    }

    public function IngresoEmisionRecibos($bibliotecaID, $misDatosJSON)
    {
       return $this->MP->IngresoEmisionRecibos($bibliotecaID, $misDatosJSON);
    }

    /* ******************************************************************************
    PAGOS!!!!!
    ***** */
    public function ingresoEmisionPagos($bibliotecaID, $misDatosJSON)
    {
       return  $this->MP->IngresoEmisionPagos($bibliotecaID, $misDatosJSON);

    }
}

$respuesta = '';

if (isset($_POST['ACTION'])) {
    $accion = $_POST['ACTION'];
} else {
    echo $respuesta;
  return;
}

if ($accion == 'llenarGrilla') {
    $respuesta = LlenarGrilla();
}
if ($accion == 'ingresoEmision') {
    $respuesta = IngresoEmisionRecibos();
}
if ($accion == 'ingresoPago') {
    $respuesta = ingresoEmisionPagos();
}

echo $respuesta;

function LlenarGrilla()
{
    $respuesta = new EmisionDeRecibosController();
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

    return $respuesta->llenarGrilla($bibliotecaID,$data);
}
function IngresoEmisionRecibos()
{
    $respuesta = new EmisionDeRecibosController();

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $biblioteca = $_SESSION['biblioteca'];
    $bibliotecaID = $biblioteca['id'];

    $misDatosJSON = json_decode($_POST['datosjson']);

    //$superArray['$misDatosJSON'] = $misDatosJSON;
    //$superArray['$bibliotecaID'] = $bibliotecaID ;

    //echo json_encode($superArray);
    return $respuesta->ingresoEmisionRecibos($bibliotecaID, $misDatosJSON);
}
  function ingresoEmisionPagos()
  {
      $respuesta = new EmisionDeRecibosController();

      if (session_status() == PHP_SESSION_NONE) {
          session_start();
      }
      $biblioteca = $_SESSION['biblioteca'];
      $bibliotecaID = $biblioteca['id'];

      $misDatosJSON = json_decode($_POST['datosjson']);

      //$superArray['$misDatosJSON'] = $misDatosJSON;
      //$superArray['$bibliotecaID'] = $bibliotecaID ;

      //echo json_encode($superArray);
      return $respuesta->ingresoEmisionPagos($bibliotecaID, $misDatosJSON);
  }
