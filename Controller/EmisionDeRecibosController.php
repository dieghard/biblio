<?php
namespace Controller;
require_once '../../model/EmisionDeRecibosModel.php';
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


        $grilla = $this->MP->LlenarGrilla($bibliotecaID,$data);

        return $grilla;
        $MP = null;
    }



    public function IngresoEmisionRecibos($bibliotecaID, $misDatosJSON)
    {

        $ingreso = $this->MP->IngresoEmisionRecibos($bibliotecaID, $misDatosJSON);
        return $ingreso;
        $this->MP = null;
    }

    /* ******************************************************************************
    PAGOS!!!!!
    ***** */
    public function ingresoEmisionPagos($bibliotecaID, $misDatosJSON)
    {
        $ingreso =  $this->MP->IngresoEmisionPagos($bibliotecaID, $misDatosJSON);

        return $ingreso;
        $this->MP = null;
    }
}


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

    $respuesta->llenarGrilla($bibliotecaID,$data);
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
    $respuesta->ingresoEmisionRecibos($bibliotecaID, $misDatosJSON);
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
      $respuesta->ingresoEmisionPagos($bibliotecaID, $misDatosJSON);
  }
