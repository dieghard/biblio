<?php
  //  header("Content-type: application/json; charset=utf-8");
namespace Model;
require_once 'conexion.php';
require_once 'tablaMovimientos.php';
use Model\conexion;
use Model\tablaMovimientos;
use Exception;
use PDO;
use PDOException;

class EmisionDeRecibosModel
{

  private function armarSqlSelect($data){
    $sql = "SELECT
              mov.id
            ,  S.apellidoyNombre
            ,  mov.ReciboCobro
            ,  IFNULL(mov.NumeroReciboPagado, 0)
            ,  mov.fecha
            ,  mov.periodoMes
            ,  mov.periodoAnio
            ,  mov.socioId
            , IFNULL(mov.debe, 0) AS debe
            , IFNULL(mov.haber, 0) AS haber
            , IFNULL((SELECT SUM(haber)
                      FROM movimientos
                      WHERE socioId = mov.socioId
                      AND NumeroReciboPagado = mov.Id
                      AND IFNULL(eliminado,'NO') ='NO' ),0) as  Pago
            , IFNULL(mov.debe,0) - IFNULL((SELECT SUM(haber)
                                          FROM movimientos
                                          WHERE socioId = mov.socioId
                                          AND NumeroReciboPagado = mov.Id
                                          AND IFNULL(eliminado,'NO') ='NO'  ),0) as  Total
            ,mov.Observaciones
            ,IFNULL(mov.IdPago, 0) AS IdPago
            ,  mov.Eliminado AS reciboEliminado
            FROM movimientos mov
            INNER JOIN socios S ON S.id = mov.socioId
            WHERE 1 = 1

      AND IFNULL(mov.Eliminado,'NO') != 'SI'";
      if  ($data['socioID'] >0){ $sql .= "  AND mov.SocioId=".$data['socioID'];}
      if  ($data['mesDesde']>0){$sql .= "  AND mov.periodoMes>=".$data['mesDesde'];}
      if  ($data['anioDesde']>0){$sql .= "  AND mov.periodoAnio>=".$data['anioDesde'];}
      if  ($data['mesHasta']>0){$sql .= "  AND mov.periodoMes<=".$data['mesHasta'];}
      if  ($data['anioHasta']>0){$sql .= "  AND mov.periodoAnio<=".$data['anioHasta'];}

      if ( $data['recibos_pagos']=='todos'):

        elseif( $data['recibos_pagos']=='recibos'):
        $sql .= "  AND mov.ReciboCobro='recibo'   ";
      elseif( $data['recibos_pagos']=='pagos'):
        $sql .= "  AND mov.ReciboCobro='PAGO'";
      endif;

      $sql .= '    AND  mov.bibliotecaId=:bibliotecaID';

      if($data['saldoFiltro'] == 'todos'):
        $sql .= " ";

      elseif($data['saldoFiltro'] == 'sin'):
        $sql .= "		HAVING Total < 0 ";

        elseif($data['saldoFiltro'] == 'con'):
        $sql .= "		HAVING Total > 0 ";

      endif;

      $sql .= "   ORDER by S.apellidoyNombre ,mov.id DESC  , mov.NumeroReciboPagado
                      LIMIT 2000";
      return $sql;
  }

  function isColorLight($hexColor) {
    $hexColor = str_replace("#", "", $hexColor);
    $r = hexdec(substr($hexColor, 0, 2));
    $g = hexdec(substr($hexColor, 2, 2));
    $b = hexdec(substr($hexColor, 4, 2));
    $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;
    return $brightness > 128;
  }


  private function encabezadoRow($row,  $coloresPorSocio){
    $encabezadoRow = '<tr id="movimientoid-'.$row['id'].'"';
    $encabezadoRow .= ' data-id="'.$row['id'].'"';
    $encabezadoRow .= ' data-socioId="'.$row['socioId'].'"';
    $encabezadoRow .= ' data-socio="'.$row['apellidoyNombre'].'"';
    $encabezadoRow .= ' data-fecha="'.$row['fecha'].'"';
    $encabezadoRow .= ' data-periodoMes="'.$row['periodoMes'].'"';
    $encabezadoRow .= ' data-periodoanio="'.$row['periodoAnio'].'"';

    $encabezadoRow .= ' data-IdPago="'.$row['IdPago'].'"';
    $encabezadoRow .= ' data-debe="'.$row['debe'].'"';
    $encabezadoRow .= ' data-haber="'.$row['haber'].'"';


      if ($row['IdPago']) {
        $encabezadoRow .= ' data-pago-existente="true"'; // Indicar que ya existe un pago
    } else {
      $encabezadoRow .= ' data-pago-existente="false"'; // Indicar que no existe un pago
    }

    $colorSocio = $coloresPorSocio[$row['apellidoyNombre']]['fondo']; // Obtén el color de fondo para este socio
    $colorTexto = $coloresPorSocio[$row['apellidoyNombre']]['texto']; // Obtén el color de texto para este socio
    $encabezadoRow .= ' style="background-color:' . $colorSocio . '; color:' . $colorTexto . ';"';

    $encabezadoRow .= '">';
    return $encabezadoRow;
  }


  private function row($row){
    $icono = '<span class="material-icons">request_quote</span>';
    if ($row['ReciboCobro'] == 'recibo') {
      $icono = '<span class="material-icons">receipt</span>';
    }
    $tableRow = '<td  id="idTdSocio"  style="font-size: 12px;">'.$row['apellidoyNombre'].'</td>';
    $tableRow .= '<td id="idTdPeriodo">'. $row['periodoMes'] .'/' . $row['periodoAnio'] . '</td>';#Numero de comprobante#
    $tableRow .= '<td id="idTdNumeroComprobante">' . $row['id'] . '</td>';#Numero de comprobante#
    $tableRow .= '<td id="idTdReciboCobro">' . $icono . $row['ReciboCobro'] . '</td>';
    $tableRow .= '<td id="idTdFecha">'.$row['fecha'].'</td>';
    $tableRow .= '<td id="idTdNumeroReciboPagado">'.$row['IdPago'].'</td>';
    $tableRow .= '<td id="idTdDebe">$'.$row['debe'].'</td>';
    $tableRow .= '<td id="idTdHaber">$'.$row['haber'].'</td>';
    $tableRow .= '<td id="idTdPago">$'.$row['Pago'].'</td>';
    $tableRow .= '<td id="idTdTotal">$'.$row['Total'].'</td>';
    $tableRow .= '<td id="idTdSaldo">$'.$this->traerSaldo($row['socioId'], $superArray).'</td>';
    $tableRow .= '<td id="idTdObs">'.$row['Observaciones'].'</td>';

    if ($row['Total'] > 0  && $row['ReciboCobro'] == "recibo" ) {// Agregar el botón de "Pagar" solo si no existe un pago
        $tableRow .= '<td id="idTbtnPagar"><button type="button" class="btn btn-success" onclick="realizarPago(this);">Pagar</button></td>';
    }else{
        $tableRow .= '<td></td>';
    }

    $tableRow .= '<td id="idTbtnEliminar"><button type="button" class="btn btn-danger" onclick="eliminarMovimiento(this);">Eliminar</button></td>';
    $tableRow .= '</tr>'; //nueva fila

    return  $tableRow;
  }

  private function traerSaldo(int $socioID,  &$superArray){
    $Coneccion = new Conexion();
    $dbConectado = $Coneccion->DBConect();

    $superArray['success'] = true;
    $superArray['mensaje'] = '';
    $strSql = "SELECT SUM(IFNULL(debe,0) - IFNULL(haber,0)) saldo FROM movimientos WHERE socioId =:socioId AND IFNULL(eliminado,'NO')!='SI'" ;
    $saldo = 0 ;
    try {
          $stmt = $dbConectado->prepare($strSql);
          $stmt->bindParam(':socioId',  $socioID, PDO::PARAM_INT);
          $stmt->execute();
          $registro = $stmt->fetch();
          $saldo = $registro ? $registro['saldo'] : 0;

      } catch (Exception $e) {
          $superArray['success'] = false;
          $trace = $e->getTrace();
          $superArray['mensaje'] = $e->getMessage().' en '.$e->getFile().' en la linea '.$e->getLine().' llamado desde '.$trace[0]['file'].' on line '.$trace[0]['line'];
      }
      return $saldo;
  }

  public function LlenarGrilla($bibliotecaID,&$data){
      $Coneccion = new Conexion();
      $dbConectado = $Coneccion->DBConect();

      $superArray['success'] = true;
      $superArray['mensaje'] = '';
      $superArray['tabla'] = '';
      $bibliotecalID = $bibliotecaID;

     $data['socioID'] = $data['socioID'] == "undefined" ? 0 : $data['socioID'] ;


      $strSql = $this->armarSqlSelect($data);

      $tabla = '';
      $superArray['sql'] = $strSql;
      $superArray['SocioID'] = $data['socioID'];

      try {
          $stmt = $dbConectado->prepare($strSql);
          $stmt->bindParam(':bibliotecaID', $bibliotecalID, PDO::PARAM_INT);
          $stmt->execute();
          $registro = $stmt->fetchAll();
          $tabla = tablaMovimientos::head();
          $coloresPorSocio = array();
          $debeAgrupado = 0;
          $haberAgrupado = 0;

          if ($registro) :
            foreach ($registro  as $row) :
                $debeAgrupado +=  $row['debe'];
                $haberAgrupado +=  $row['haber'];

                  if (!array_key_exists($row['apellidoyNombre'], $coloresPorSocio)) :
                      // Genera un color hexadecimal aleatorio para cada socio
                      $colorRandom = '#' . dechex(rand(0x000000, 0xFFFFFF));
                      // Verifica si el color es claro u oscuro
                      if ($this->isColorLight($colorRandom)) :
                          $colorTexto = 'black'; // Si el fondo es claro, el texto es negro
                      else :
                          $colorTexto = 'white'; // Si el fondo es oscuro, el texto es blanco
                      endif;

                      $coloresPorSocio[$row['apellidoyNombre']] = [
                          'fondo' => $colorRandom,
                          'texto' => $colorTexto,
                      ];
                  endif;

                  $tabla .= $this->encabezadoRow($row, $coloresPorSocio);
                  $tabla .= $this->row($row,);

                endforeach;

            endif;
          $tabla .= '</tbody></table></div>';
      } catch (Exception $e) {
          $superArray['success'] = false;

          $trace = $e->getTrace();
          $superArray['mensaje'] = $e->getMessage().' en '.$e->getFile().' en la linea '.$e->getLine().' llamado desde '.$trace[0]['file'].' on line '.$trace[0]['line'];
      }
      $superArray['tabla'] = $tabla;
      $Coneccion = null;
      return json_encode($superArray);

  }


  private function traerValorCuota(int $socioId){
    $conexion = new Conexion();
    $pdo = $conexion->DBConect();
       $strSql = "SELECT COALESCE(tiposocio.valorCuota, 0) AS valorCuota
          FROM socios
          LEFT JOIN tiposocio ON tiposocio.id = socios.tiposocioid
          WHERE socios.id = :socioId";
    $stmt = $pdo->prepare($strSql);
    $stmt->bindParam(':socioId', $socioId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
  }

  private function insertRecibos(int $bibliotecaID, $data, int $socioID,float  $valorCuota){
    $conexion = new Conexion();
    $pdo = $conexion->DBConect();

    try {

      $strSql = ' INSERT INTO  MOVIMIENTOS (bibliotecaId,ReciboCobro,Fecha,periodoMes,periodoAnio,socioId,observaciones,debe,esPorRecibo,Eliminado)';
      $strSql .= ' VALUES ';
      $strSql .= "(:bibliotecaId,:ReciboCobro,:Fecha,:periodoMes,:periodoAnio,:socioId,:observaciones,:debe,:esPorRecibo, :Eliminado)";
      $debe = $this->traerValorCuota($socioID);
        # preparar la consulta #
      $stmt = $pdo->prepare($strSql);
      $reciboCobro = 'recibo';
      $eliminado = 'NO';
      #region Vincula los parámetros con sus valores
      $stmt->bindParam(':bibliotecaId', $bibliotecaID, PDO::PARAM_INT);
      $stmt->bindParam(':ReciboCobro', $reciboCobro, PDO::PARAM_STR);
      $stmt->bindParam(':Fecha', $data->fecha, PDO::PARAM_STR);
      $stmt->bindParam(':periodoMes', $data->periodoMes, PDO::PARAM_INT);
      $stmt->bindParam(':periodoAnio', $data->periodoAnio, PDO::PARAM_INT);
      $stmt->bindParam(':socioId', $socioID, PDO::PARAM_INT);
      $stmt->bindParam(':observaciones', $data->observaciones, PDO::PARAM_STR);
      $stmt->bindParam(':debe', $debe, PDO::PARAM_STR);
      $stmt->bindParam(':esPorRecibo', $data->esPorRecibo, PDO::PARAM_STR);
      $stmt->bindParam(':Eliminado', $eliminado, PDO::PARAM_STR);

    $stmt->execute();

 } catch (PDOException $e) {
        // Manejo de excepciones
        echo "Error de base de datos: " . $e->getMessage();
    }

    $stmt = null;
    $pdo = null;
  }

  private function obtenerSocios(array &$superArray,int $bibliotecaID, int $socioID ){
    $conexion = new Conexion();
    $dbConectado = $conexion->DBConect();
    $strSql = " SELECT socios.id, tiposocio.valorCuota ";
    $strSql .= "  FROM socios ";
    $strSql .= "  INNER JOIN tiposocio ON tiposocio.id =  socios.tipoSocioId";
    $strSql .= "  WHERE activo='SI' AND pagaCuota='SI' AND bibliotecaID = :bibliotecaID";

    if ($socioID > 0):
      $strSql .= '  AND socios.id = :socioID';
    endif;
    $stmt = $dbConectado->prepare($strSql);
    $stmt->bindParam(':bibliotecaID', $bibliotecaID, PDO::PARAM_INT);
    if ($socioID > 0) {
      $stmt->bindParam(':socioID', $socioID, PDO::PARAM_INT);
    }

    try {
        $stmt->execute();
        $registro = $stmt->fetchAll();
      } catch (Exception $e) {
        $superArray['success'] = false;
        $superArray['mensaje'] = 'Error: '.$e->getMessage();
        $registro = null;
      }

      return $registro;
  }

  private function validarSiExisteCuota(int $socioID, $data, float $monto){
    try {
        $conexion = new Conexion();
        $pdo = $conexion->DBConect();
        // Verificar si ya existe un registro con los mismos valores
        $checkSql = "SELECT COUNT(*)
                    FROM MOVIMIENTOS
                    WHERE socioId = :socioId
                    AND periodoMes = :periodoMes
                    AND periodoAnio = :periodoAnio
                    AND debe = :monto
                    AND Eliminado !='SI'";
        $stmtCheck = $pdo->prepare($checkSql);
        $stmtCheck->bindParam(':socioId', $socioID, PDO::PARAM_INT);
        $stmtCheck->bindParam(':periodoMes', $data->periodoMes, PDO::PARAM_INT);
        $stmtCheck->bindParam(':periodoAnio', $data->periodoAnio, PDO::PARAM_INT);
        $stmtCheck->bindParam(':monto', $monto, PDO::PARAM_STR);
        $stmtCheck->execute();

        $count = $stmtCheck->fetchColumn();

        if ($count == 0) {
          return false;
        } else {
          return true;
        }

        // Resto del código...
    } catch (PDOException $e) {
        // Manejo de excepciones
        echo "Error de base de datos: " . $e->getMessage();
    }
  }

  public function IngresoEmisionRecibos($bibliotecaID, $data){
    $conexion = new Conexion();
    $dbConectado = $conexion->DBConect();
    $Ejecucion = '0';
    header('Content-Type: text/html;charset=utf-8');
    $superArray['success'] = true;
    $superArray['mensaje'] = '';

    $registro = $this->obtenerSocios($superArray,$bibliotecaID, $data->socioId ) ;
    if (!$registro) { //Si no hay socios no sigo
      $superArray['success'] = false;
      $superArray['mensaje'] = 'No se encontraron socios';
      return json_encode($superArray);
    }
    $registrosNuevos = 0;
    foreach ($registro as $row) {
      $validar = $this->validarSiExisteCuota($row['id'],$data,$row['valorCuota']);
      if(!$validar):
        $this->insertRecibos($bibliotecaID, $data, $row['id'],$row['valorCuota']);
        $registrosNuevos ++;
      endif;

    }


    // Agregar la cantidad de registros nuevos al array de respuesta
    $superArray['registrosNuevos'] = $registrosNuevos;
    $stmt = null;
    $dbConectado = null;
    return json_encode($superArray);
  }

  private function armarSqlInsert_Pagos($bibliotecaID, $data){

    $strSql = 'INSERT INTO  MOVIMIENTOS
              (bibliotecaId,ReciboCobro,Fecha,periodoMes,periodoAnio,socioId,haber,observaciones,NumeroReciboPagado,Eliminado)VALUES
              (:bibliotecaId,:ReciboCobro,:Fecha,:periodoMes,:periodoAnio,:socioId,:haber,:observaciones,:NumeroReciboPagado,:Eliminado)';
    return $strSql;
  }

  private function traerTotalAPagar($bibliotecaID, $data){
    $coneccion = new Conexion();
    $dbConectado = $coneccion->DBConect();
    $strSql = "SELECT IFNULL(IFNULL(mov.debe,0) - IFNULL((SELECT SUM(haber)
									FROM movimientos
									WHERE socioID = mov.socioId
									AND NumeroReciboPagado = mov.id
									AND eliminado !='SI' ),0),0) AS total
              FROM movimientos mov
              WHERE mov.ReciboCobro = 'recibo'
              AND mov.socioId = :socioId
              AND  mov.bibliotecaId = :bibliotecaID
              AND mov.id  = :id
              LIMIT 1";
    $saldo = 0;
        try {
            $stmt = $dbConectado->prepare($strSql);
            $stmt->bindParam(':bibliotecaID', $bibliotecaID, PDO::PARAM_INT);
            $stmt->bindParam(':socioId', $data->socioId, PDO::PARAM_INT);
            $stmt->bindParam(':id', $data->id, PDO::PARAM_INT);
            $stmt->execute();
            $registro = $stmt->fetchAll();

            if ($registro) {
              $primerRegistro = $registro[0];
              $saldo = $primerRegistro["total"];

            }
        } catch (Exception $e) {
          $saldo = 0;
            $superArray['success'] = false;
            $trace = $e->getTrace();
            $superArray['mensaje'] = $e->getMessage().' en '.$e->getFile().' en la linea '.$e->getLine().' llamado desde '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }
        $coneccion = null;
        $dbConectado = null;

        return $saldo;
  }

  public function ingresoEmisionPagos($bibliotecaID, $data){

    $conexion = new Conexion();
    $dbConectado = $conexion->DBConect();
    $superArray['success'] = true;
    $superArray['mensaje'] = '';
    $strSql = $this->armarSqlInsert_Pagos($bibliotecaID, $data);
    $superArray['sql'] = $strSql;
    $stmt = $dbConectado->prepare($strSql);
    $dbConectado->beginTransaction();
    $reciboCobro = 'PAGO';
    $eliminado = 'NO';
    $traerTotal = 0;
    if (isset($data->botonPagoTotal)):
      $traerTotal = $this->traerTotalAPagar($bibliotecaID, $data);
    else:
      $traerTotal = $data->haber;
    endif;
    try {
        $stmt = $dbConectado->prepare($strSql);
        $stmt->bindParam(':bibliotecaId', $bibliotecaID, PDO::PARAM_INT);
        $stmt->bindParam(':ReciboCobro', $reciboCobro, PDO::PARAM_STR);
        $stmt->bindParam(':Fecha', $data->fecha, PDO::PARAM_STR);
        $stmt->bindParam(':periodoMes', $data->periodoMes, PDO::PARAM_STR);
        $stmt->bindParam(':periodoAnio', $data->periodoAnio, PDO::PARAM_INT);
        $stmt->bindParam(':socioId', $data->socioId, PDO::PARAM_INT);
        $stmt->bindParam(':haber', $traerTotal);
        $stmt->bindParam(':observaciones', $data->observaciones);
        $stmt->bindParam(':NumeroReciboPagado', $data->numeroReciboPagado);
        $stmt->bindParam(':Eliminado', $eliminado);
        $stmt->execute();
        $superArray['success'] = true;
        $dbConectado->commit();
    } catch (Exception $e) {
        $superArray['success'] = false;
        $superArray['mensaje'] = 'Error: '.$e->getMessage();
        $dbConectado->rollBack();
    }
    $stmt = null;
    $dbConectado = null;

    return json_encode($superArray);
  }

  public function elminarMovimientos($bibliotecaID, $data){

    $conexion = new Conexion();
    $dbConectado = $conexion->DBConect();
    $superArray['success'] = true;
    $superArray['mensaje'] = '';
    $strSql = "UPDATE movimientos set Eliminado='SI' Where id = :id" ;
    $superArray['sql'] = $strSql;

    $stmt = $dbConectado->prepare($strSql);
    $dbConectado->beginTransaction();
    #Eliminamos el moviminento (lo ponemos en SI)#
    try {
        $id = $data->id;
        $stmt = $dbConectado->prepare($strSql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $superArray['success'] = true;
        $dbConectado->commit();
    } catch (Exception $e) {
        $superArray['success'] = false;
        $superArray['mensaje'] = 'Error: '.$e->getMessage();
        $dbConectado->rollBack();
    }

    #Si pago algo lo ponemos en 0#
    $strSql = "UPDATE movimientos set NumeroReciboPagado = 0 Where NumeroReciboPagado = :id" ;
    $superArray['sql'] = $strSql;

    $stmt = $dbConectado->prepare($strSql);
    $dbConectado->beginTransaction();

    try {
        $id = $data->id;
        $stmt = $dbConectado->prepare($strSql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $superArray['success'] = true;
        $dbConectado->commit();
    } catch (Exception $e) {
        $superArray['success'] = false;
        $superArray['mensaje'] = 'Error: '.$e->getMessage();
        $dbConectado->rollBack();
    }



    #Si es por Recibo  lo ponemos en 0#
    $strSql = "UPDATE movimientos set IdPago = 0 Where IdPago = :id" ;
    $superArray['sql'] = $strSql;

    $stmt = $dbConectado->prepare($strSql);
    $dbConectado->beginTransaction();

    try {
        $id = $data->id;
        $stmt = $dbConectado->prepare($strSql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $superArray['success'] = true;
        $dbConectado->commit();
    } catch (Exception $e) {
        $superArray['success'] = false;
        $superArray['mensaje'] = 'Error: '.$e->getMessage();
        $dbConectado->rollBack();
    }

    # --- COMENTE TODO PQ MEPA QUE LO VOY A CALCULAR A MANOPLA ACA LO MAS CRITICO, RECALCULAR EL SALDO DE TODO #

    // #Si es por Recibo  lo ponemos en 0#
    // $strSql = "UPDATE movimientos m
    //   JOIN (
    //       SELECT     m1.id,m1.socioId,m1.fecha,m1.debe,m1.haber,
    //           (
    //               SELECT COALESCE(SUM(m2.debe - m2.haber), 0)
    //               FROM movimientos m2
    //               WHERE m2.socioId = m1.socioId AND m2.fecha <= m1.fecha AND m2.Eliminado != 'SI'
    //           ) AS saldo
    //       FROM movimientos m1
    //       WHERE m1.socioId = :socioId  -- Reemplaza :socioId con el valor del socioId deseado
    //       AND m1.Eliminado != 'SI'
    //   ) AS saldo_calc
    //   ON m.id = saldo_calc.id
    //   SET m.saldo = saldo_calc.saldo;" ;
    // $superArray['sql'] = $strSql;
    // $stmt = $dbConectado->prepare($strSql);
    // $dbConectado->beginTransaction();

    // try {
    //     $socioId = $data->socioId;
    //     $stmt = $dbConectado->prepare($strSql);
    //     $stmt->bindParam(':socioId', $socioId, PDO::PARAM_INT);
    //     $stmt->execute();
    //     $superArray['success'] = true;
    //     $dbConectado->commit();
    // } catch (Exception $e) {
    //     $superArray['success'] = false;
    //     $superArray['mensaje'] = 'Error: '.$e->getMessage();
    //     $dbConectado->rollBack();
    // }

    $stmt = null;
    $dbConectado = null;



    return json_encode($superArray);

  }
}
