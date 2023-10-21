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

    /*  PAGOS!!!!! */

    public function ingresoEmisionPagos($bibliotecaID, $misDatosJSON)
    {
       return  $this->MP->IngresoEmisionPagos($bibliotecaID, $misDatosJSON);

    }

    public function eliminarRecibo($bibliotecaID, $misDatosJSON){
        return  $this->MP->elminarMovimientos($bibliotecaID, $misDatosJSON);

    }
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
    $data['saldoFiltro'] = $_POST['saldoFiltro'];
    $data['recibos_pagos'] = $_POST['recibos_pagos'];
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

    return $respuesta->IngresoEmisionRecibos($bibliotecaID, $misDatosJSON);
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

      return $respuesta->ingresoEmisionPagos($bibliotecaID, $misDatosJSON);
}

  $respuesta = '';

  if (isset($_POST['ACTION'])) {
      $accion = $_POST['ACTION'];
  } else {
      echo $respuesta;
    return;
  }

  if ($accion == 'llenarGrilla') :
      $respuesta = LlenarGrilla();
  endif;
  if ($accion == 'ingresoEmision') :
      $respuesta = IngresoEmisionRecibos();
  endif;
  if ($accion == 'ingresoPago') :
      $respuesta = ingresoEmisionPagos();
  endif;
  if ($accion == 'eliminarMovimiento') :
    $respuesta = new EmisionDeRecibosController();
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $biblioteca = $_SESSION['biblioteca'];
    $bibliotecaID = $biblioteca['id'];
    $misDatosJSON = json_decode($_POST['datosjson']);
    $respuesta =  $respuesta->eliminarRecibo($bibliotecaID, $misDatosJSON);

  endif;



  echo $respuesta;
