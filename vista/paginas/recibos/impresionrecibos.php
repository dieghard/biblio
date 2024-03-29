<?php

require 'fpdf/fpdf.php';
require_once '../../../model/conexion.php';

use Model\Conexion;

class ConexionDB
{
  public function getConexion()
  {
    $coneccion = new Conexion();
    return $coneccion->DBConect();
  }

  public function ejecutarConsulta($strSql)
  {
    $dbConectado = $this->getConexion();
    $stmt = $dbConectado->prepare($strSql);
    $stmt->execute();
    return $stmt->fetchAll();
  }
}

class PDFGenerator
{
  public function inicializarPDF()
  {
    $pdf = new FPDF();
    $pdf->SetFont('Arial', '', 10);
    $pdf->AddPage();
    return $pdf;
  }
}
class Recibo
{
  public function inicializarData()
  {
    return [
      'socio' => '',
      'nsocio' => '0',
      'tipoSocio' => '',
      'domicilio' => '',
      'sector' => '',
      'saldoAnterior' => '0',
      'periodo' => '',
      'saldoActual' => '0',
      'fecha' => '',
      'numeroRecibo' => '0'
    ];
  }
}

$action = $_GET['ACTION'];

$superArray['mensaje'] = '';
$superArray['success'] = false;

$conexionDB = new ConexionDB();
$PDFGenerator = new PDFGenerator();
$Recibo = new Recibo();


if ($action == 'impresionRecibos') {
  $socioID = $_GET['socioID'];
  $mesImpresion = $_GET['mesImpresion'];
  $anioImpresion = $_GET['anioImpresion'];
  $numeroRecibo = $_GET['numeroReciboImpresion'];
  $sectorImpresion  = $_GET['sectorImpresion'];
}

$strSql = "SELECT mov.id, IFNULL(S.apellidoyNombre,'') as socio
            , IFNULL(S.numeroSocio,'') as numeroSocio
            ,IFNULL(tS.descripcion,'') as tipoSocio
            ,IFNULL(mov.ReciboCobro,'') as reciboCobro
            ,IFNULL(S.domicilio,'') as domicilio
            ,IFNULL(se.descripcion,'') as sector
            ,IFNULL(mov.NumeroReciboPagado,'') as reciboPagado
            ,mov.fecha,mov.periodoMes
            ,mov.periodoAnio
            ,mov.socioId
            ,IFNULL(mov.debe,0) as debe
            ,IFNULL(mov.haber,0) as haber
           ,IFNULL(mov.debe,0)- IFNULL((SELECT SUM(haber)
											FROM movimientos
											WHERE  NumeroReciboPagado = mov.id
											AND reciboCobro = 'PAGO'
											AND socioId = mov.SocioID
											AND Eliminado !='SI'),0) AS saldoDebeHaber

            FROM movimientos mov
            INNER join socios S on S.id = mov.socioId
            LEFT join tiposocio tS on tS.id = S.tipoSocioId
            LEFT join sector se on se.id = S.sectorid
            WHERE IFNULL(mov.Eliminado,'NO')='NO'
            AND ReciboCobro = 'recibo'";
if ($socioID > 0) :
  $strSql .= " AND mov.socioId =" . $socioID;
endif;
if ($mesImpresion > 0) :
  $strSql .= " AND mov.periodoMes=" . $mesImpresion;
endif;
if ($anioImpresion > 0) :
  $strSql .= " AND mov.periodoAnio={$anioImpresion}";
endif;
if (strlen($numeroRecibo) > 0) :
  $strSql .= " AND mov.id IN({$numeroRecibo}) ";
endif;
if ($sectorImpresion == "undefined") :
  $sectorImpresion = 0;
endif;
if ($sectorImpresion > 0) :
  $strSql .= " AND S.sectorid=" . $sectorImpresion;
endif;
// Agrega la condición para filtrar los registros con saldo mayor que 0
$strSql .= " HAVING saldoDebeHaber > 0 ";
//echo    ($strSql);
$coneccion = new Conexion();
$dbConectado = $coneccion->DBConect();

$conexionDB = new ConexionDB();
$PDFGenerator = new PDFGenerator();
$Recibo = new Recibo();

$pdf = $PDFGenerator->inicializarPDF();
$data = $Recibo->inicializarData();

$registro = $conexionDB->ejecutarConsulta($strSql);

$pdf->SetFont('Arial', '', 10);
$data['socio'] = '';
$data['nsocio'] = '0';
$data['tipoSocio'] = '';
$data['domicilio'] = '';
$data['sector'] = '';
$data['saldoAnterior'] = '0';
$data['periodo'] = '';
$data['saldoActual'] = '0';
$data['fecha'] = '';
$data['numeroRecibo'] = '0';
$lineaY_izquierda = 2;
$lineaY_derecha = 2;
$correarALaDerecha = 120;
$renglonesHaciaAbajo = 8;
//$pdf->AddPage();
$lineaX = 10;
$superArray = [];
try {

  $contador = 1;
  if ($registro) {
    foreach ($registro  as $row) {
      $data['socio'] = $row['socio'];
      $data['nsocio'] = $row['numeroSocio'];
      $data['tipoSocio'] = $row['tipoSocio'];
      $data['domicilio'] = $row['domicilio'];
      $data['sector'] = $row['sector'];
      $data['saldoAnterior'] = "$" . $row['saldoDebeHaber'];
      $data['periodo'] = $row['periodoMes'] . '/' . $row['periodoAnio'];
      $data['saldoActual'] = traerSaldo($row['socioId'], $superArray);
      $data['fecha'] = $row['fecha'];
      $data['numeroRecibo'] = $row['id'];

      //impresion
      $lineaY_izquierda = $lineaY_izquierda + $renglonesHaciaAbajo;
      $lineaY_derecha = $lineaY_derecha + $renglonesHaciaAbajo;
      $lineaY_izquierda = Crear_Recibo($pdf, $lineaX, $lineaY_izquierda, $data);
      $lineaY_derecha = Crear_Recibo($pdf, $lineaX + $correarALaDerecha, $lineaY_derecha, $data);
      $contador++;
      if ($contador == 6) {
        $contador = 1;
        $lineaY_izquierda = 2;
        $lineaY_derecha = 2;
        $correarALaDerecha = 120;
        $renglonesHaciaAbajo = 7;
        $pdf->AddPage();
        $lineaX = 10;
      }
    }
  }
} catch (Exception $e) {
  $superArray['success'] = false;
  $trace = $e->getTrace();
  echo $e->getMessage() . ' en ' . $e->getFile() . ' en la linea ' . $e->getLine() . ' llamado desde ' . $trace[0]['file'] . ' on line ' . $trace[0]['line'];
}

$pdf->Output();
$coneccion = null;



function crear_Recibo($pdf, $lineaX, $lineaY, $data)
{
  $pdf->SetXY($lineaX, $lineaY);
  $pdf->Cell(40, 1, 'Biblioteca Popular Florentino Ameghino', 0, 0, 'L');

  $pdf->SetFont('Arial', 'B', 6);

  $lineaY = $lineaY + 1;
  $pdf->SetXY($lineaX, $lineaY);
  $pdf->Cell(50, 5, 'Rivadavia 10 - Gral. Levalle (Cba)', 0, 0, 'L');

  $lineaY = $lineaY + 4;
  $pdf->SetXY($lineaX, $lineaY);
  $pdf->Cell(50, 5, 'Tel.03385-480737 CUIT 30-66878313-5', 0, 0, 'L');

  $pdf->SetFont('Arial', '', 8);
  $lineaY = $lineaY + 4;
  $pdf->SetXY($lineaX, $lineaY);
  $pdf->Cell(50, 5, iconv("UTF-8", "ISO-8859-1//TRANSLIT", 'Socio:' . $data['socio']), 0, 0, 'L');


  $lineaY = $lineaY + 4;
  $pdf->SetXY($lineaX, $lineaY);
  $pdf->Cell(50, 5, iconv("UTF-8", "ISO-8859-1//TRANSLIT", 'N°:Socio:'  . $data['nsocio']), '0', 0, 'L');

  //$lineaY   = $lineaY   + 4;
  $pdf->SetXY($lineaX + 24, $lineaY);
  $pdf->Cell(50, 5, iconv("UTF-8", "ISO-8859-1//TRANSLIT", 'Tipo:' . $data['tipoSocio']), '0', 0, 'L');

  $lineaY = $lineaY + 4;
  $pdf->SetXY($lineaX, $lineaY);
  $pdf->Cell(10, 5, iconv("UTF-8", "ISO-8859-1//TRANSLIT", 'Dom:' . $data['domicilio']), 0, 0, 'L');

  //$lineaY   = $lineaY   + 4;
  $pdf->SetXY($lineaX + 34, $lineaY);
  $pdf->Cell(50, 5, iconv("UTF-8", "ISO-8859-1//TRANSLIT", 'Sector:' . $data['sector']), '0', 0, 'L');

  $lineaY = $lineaY + 4;
  $pdf->SetXY($lineaX, $lineaY);
  $pdf->Cell(50, 5, iconv("UTF-8", "ISO-8859-1//TRANSLIT", 'Cuota:' . $data['saldoAnterior']), 0, 0, 'L');

  $lineaY = $lineaY + 4;
  $pdf->SetXY($lineaX, $lineaY);
  $pdf->Cell(50, 5, iconv("UTF-8", "ISO-8859-1//TRANSLIT", 'Periodo:' . $data['periodo']), 0, 0, 'L');

  $lineaY = $lineaY + 4;
  $pdf->SetXY($lineaX, $lineaY);
  $pdf->Cell(50, 5, iconv("UTF-8", "ISO-8859-1//TRANSLIT", 'Saldo Actual:$' . $data['saldoActual']), 0, 0, 'L');

  $lineaY = $lineaY + 4;
  $pdf->SetXY($lineaX, $lineaY);
  $pdf->Cell(50, 5, iconv("UTF-8", "ISO-8859-1//TRANSLIT", 'Recibi Pesos:$'), 0, 0, 'L');

  /*    $lineaY = $lineaY + 4;
    $pdf->SetXY($lineaX, $lineaY);
    $pdf->Cell(50, 5, utf8_decode('Son:$'), 0, 0, 'L');
*/
  $lineaY = $lineaY + 4;
  $pdf->SetXY($lineaX, $lineaY);
  $pdf->Cell(50, 5, iconv("UTF-8", "ISO-8859-1//TRANSLIT", 'Fecha:' . $data['fecha']), 0, 0, 'L');

  $lineaY = $lineaY + 4;
  $pdf->SetXY($lineaX, $lineaY);
  $pdf->Cell(50, 5, iconv("UTF-8", "ISO-8859-1//TRANSLIT", 'Recibo N°:' . $data['numeroRecibo']), 0, 0, 'L');

  $lineaY = $lineaY + 4;
  $pdf->SetXY($lineaX, $lineaY);
  $pdf->Cell(50, 5, iconv("UTF-8", "ISO-8859-1//TRANSLIT", '-------------------------------------------------------------------------------------------------------'), 0, 0, 'L');
  return $lineaY;
}

function traerSaldo(int $socioID,  &$superArray)
{
  $Coneccion = new Conexion();
  $dbConectado = $Coneccion->DBConect();

  $superArray['success'] = true;
  $superArray['mensaje'] = '';
  $strSql = "SELECT SUM(IFNULL(debe,0) - IFNULL(haber,0)) saldo FROM movimientos WHERE socioId =:socioId AND IFNULL(eliminado,'NO')!='SI'";
  $saldo = 0;
  try {
    $stmt = $dbConectado->prepare($strSql);
    $stmt->bindParam(':socioId',  $socioID, PDO::PARAM_INT);
    $stmt->execute();
    $registro = $stmt->fetch();
    $saldo = $registro ? $registro['saldo'] : 0;
  } catch (Exception $e) {
    $superArray['success'] = false;
    $trace = $e->getTrace();
    $superArray['mensaje'] = $e->getMessage() . ' en ' . $e->getFile() . ' en la linea ' . $e->getLine() . ' llamado desde ' . $trace[0]['file'] . ' on line ' . $trace[0]['line'];
  }
  return $saldo;
}
