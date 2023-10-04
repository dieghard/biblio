<?php
  //  header("Content-type: application/json; charset=utf-8");
namespace Model;
require_once 'conexion.php';
use Model\conexion;
use Exception;
use PDO;
use PDOException;

class EmisionDeRecibosModel
{
  private function armarSqlSelect($data){
      $sql = "SELECT mov.id,
          S.apellidoyNombre as socio,
          mov.ReciboCobro as reciboCobro,
          IFNULL(mov.NumeroReciboPagado,'') as reciboPagado,
              mov.fecha,
              mov.periodoMes,
              mov.periodoAnio,
              mov.socioId,
              mov.debe,
              mov.haber,
              mov.saldo,
              mov.Observaciones
          FROM movimientos mov
          INNER join socios S on S.id = mov.socioId
          WHERE IFNULL(mov.Eliminado,'NO')='NO'   ";
      if  ($data['socioID'] >0){ $sql .= "  AND mov.SocioId=".$data['socioID'];}
      if  ($data['mesDesde']>0){$sql .= "  AND mov.periodoMes>=".$data['mesDesde'];}
      if  ($data['anioDesde']>0){$sql .= "  AND mov.periodoAnio>=".$data['anioDesde'];}
      if  ($data['mesHasta']>0){$sql .= "  AND mov.periodoMes<=".$data['mesHasta'];}
      if  ($data['anioHasta']>0){$sql .= "  AND mov.periodoAnio<=".$data['anioHasta'];}

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

  public function LlenarGrilla($bibliotecaID,&$data){
      $Coneccion = new Conexion();
      $dbConectado = $Coneccion->DBConect();

      $superArray['success'] = true;
      $superArray['mensaje'] = '';
      $superArray['tabla'] = '';
      $bibliotecalID = $bibliotecaID;

      if ($data['socioID'] == 'undefined') :
        $data['socioID'] = 0 ;
      endif;

      $strSql = $this->armarSqlSelect($data);
      $strSql .= '    AND  mov.bibliotecaId=:bibliotecaID
                      ORDER by S.apellidoyNombre ,mov.id DESC  , mov.NumeroReciboPagado
                      LIMIT 2000';
      $tabla = '';
      $superArray['sql'] = $strSql;
      $superArray['SocioID'] = $data['socioID'];

      try {
          $stmt = $dbConectado->prepare($strSql);
          $stmt->bindParam(':bibliotecaID', $bibliotecalID, PDO::PARAM_INT);
          $stmt->execute();
          $registro = $stmt->fetchAll();
          $tabla = '<div class="table-responsive">
                    <table class="table table-condensed  table-striped table-bordered" id="idTablaUser">
                  <thead class="thead-dark">
                      <tr>
                          <th scope="col">Nº COMPROBANTE</th>
                          <th scope="col">SOCIO</th>
                          <th scope="col">Rec./Cob.</th>
                          <th scope="col">FECHA</th>
                          <th scope="col">PERIODO</th>
                          <th scope="col">Nº RECIBO PAGADO</th>
                          <th scope="col">DEBE</th>
                          <th scope="col">HABER</th>
                          <th scope="col">SALDO</th>
                          <th scope="col">OBS.</th>
                          <th scope="col"></th>
                      </tr>
                  </thead>
              <tbody>';
          $coloresPorSocio = array();
          if ($registro) {
              $socioAnterior = ''; // Variable para realizar el cambio de color por socio
              foreach ($registro  as $row) {
                if (!array_key_exists($row['socio'], $coloresPorSocio)) {
                      // Genera un color hexadecimal aleatorio para cada socio
                      $colorRandom = '#' . dechex(rand(0x000000, 0xFFFFFF));

                      // Verifica si el color es claro u oscuro
                      if ($this->isColorLight($colorRandom)) {
                          $colorTexto = 'black'; // Si el fondo es claro, el texto es negro
                      } else {
                          $colorTexto = 'white'; // Si el fondo es oscuro, el texto es blanco
                      }

                      $coloresPorSocio[$row['socio']] = [
                          'fondo' => $colorRandom,
                          'texto' => $colorTexto,
                      ];
                  }
                  $existePago = $this->verificarPago($row['id']);
                  $encabezadoRow = '<tr id="movimientoid-'.$row['id'].'"';
                  $encabezadoRow .= 'data-id="'.$row['id'].'"';
                  $encabezadoRow .= 'data-socioId="'.$row['socioId'].'"';
                  $encabezadoRow .= 'data-socio="'.$row['socio'].'"';
                  $encabezadoRow .= 'data-fecha="'.$row['fecha'].'"';
                  $encabezadoRow .= 'data-periodoMes="'.$row['periodoMes'].'"';
                  $encabezadoRow .= 'data-periodoanio="'.$row['periodoAnio'].'"';
                  $encabezadoRow .= 'data-debe="'.$row['debe'].'"';
                  $encabezadoRow .= 'data-haber="'.$row['haber'].'"';
                  $encabezadoRow .= 'data-saldo="'.$row['saldo'].'"';
                   if ($existePago) {
                     $encabezadoRow .= 'data-pago-existente="true"'; // Indicar que ya existe un pago
                  } else {
                    $encabezadoRow .= 'data-pago-existente="false"'; // Indicar que no existe un pago
                  }

                  if ($row['reciboCobro'] == 'recibo') {
                        $icono = '<span class="material-icons">receipt</span>';
                  } else {
                        $icono = '<span class="material-icons">request_quote</span>';
                  }
                 $colorSocio = $coloresPorSocio[$row['socio']]['fondo']; // Obtén el color de fondo para este socio
                 $colorTexto = $coloresPorSocio[$row['socio']]['texto']; // Obtén el color de texto para este socio
                 $encabezadoRow .= ' style="background-color:' . $colorSocio . '; color:' . $colorTexto . ';"';

                  $encabezadoRow .= '">';

                  $tabla .= $encabezadoRow.'<td>'.$row['id'].'</td>';
                  $tabla .= '<td>'.$row['socio'].'</td>';
                  $tabla .= '<td>' . $icono . $row['reciboCobro'] . '</td>';
                  $tabla .= '<td>'.$row['fecha'].'</td>';
                  $tabla .= '<td>'.$row['periodoMes'].'- '.$row['periodoAnio'].'</td>';
                  $tabla .= '<td>'.$row['reciboPagado'].'</td>';
                  $tabla .= '<td>$'.$row['debe'].'</td>';
                  $tabla .= '<td>$'.$row['haber'].'</td>';
                  $tabla .= '<td>$'.$row['saldo'].'</td>';
                  $tabla .= '<td>'.$row['Observaciones'].'</td>';
                  if (!$existePago) {
                      if ($row['reciboPagado'] == "") {
                        // Agregar el botón de "Pagar" solo si no existe un pago
                        $tabla .= '<td><button type="button" class="btn btn-success" onclick="realizarPago(this);">Pagar</button></td>';
                      }
                      else{
                      $tabla .= '<td></td>';
                      }
                  }else{
                      $tabla .= '<td></td>';
                  }

                  $tabla .= '</tr>'; //nueva fila
                   // Si existe un pago, agregar una nueva fila para mostrar el pago
                  if ($existePago) {
                      $tabla .= '<tr class="pagado" style="background-color:green; color:white">';
                      /*$tabla .= "<td colspan='12'>El COMPROBANTE <span class='material-icons'>receipt</span> {$row['id']}  FUE PAGADO POR EL COMPROBATE  <span class='material-icons'>request_quote</span> {$existePago[0]['PagadoConReciboID']} CON EL MONTO : $" . $existePago[0]['haber'] . "</td>";
                      */
                      $tabla .= "<td colspan='12'>El COMPROBANTE <span class='icono-con-texto'><span class='material-icons'>receipt</span> {$row['id']}  FUE PAGADO POR EL COMPROBANTE <span class='material-icons'>request_quote</span> {$existePago[0]['PagadoConReciboID']}</span> CON EL MONTO : $" . $existePago[0]['haber'] . "</td>";



                      $tabla .= '</tr>';
                  }
              }
          }
          $tabla .= '</tbody>
                      </table>
                      </div>';
      } catch (Exception $e) {
          $superArray['success'] = false;

          $trace = $e->getTrace();
          $superArray['mensaje'] = $e->getMessage().' en '.$e->getFile().' en la linea '.$e->getLine().' llamado desde '.$trace[0]['file'].' on line '.$trace[0]['line'];
      }


      $superArray['tabla'] = $tabla;

      $Coneccion = null;

      return json_encode($superArray);
  }

  private function verificarPago(int $reciboID){
    $conexion = new Conexion();
    $pdo = $conexion->DBConect();

    $strSql = '';
      $strSql =' SELECT
                Recibos.id,Recibos.ReciboCobro,Recibos.debe
              , Pagos.id as PagadoConReciboID
              , Pagos.haber
              ,Pagos.NumeroReciboPagado
              , Pagos.saldo
              FROM
              movimientos  Recibos
              INNER JOIN movimientos Pagos on Recibos.id = Pagos.NumeroReciboPagado
              where Recibos.id =:reciboID';

      $stmt =  $pdo->prepare($strSql);
      $stmt->bindParam(':reciboID', $reciboID);

    try {
        $stmt->execute();
        $registro = $stmt->fetchAll();
      } catch (Exception $e) {
        $superArray['success'] = false;
        $superArray['mensaje'] = 'Error: '.$e->getMessage();
        $registro = null;
      }

    return $registro ;
  }

  private function insertRecibos(int $bibliotecaID, $data, int $socioID,float  $valorCuota){
    $conexion = new Conexion();
    $pdo = $conexion->DBConect();

    try {

      $strSql = ' INSERT INTO  MOVIMIENTOS (bibliotecaId,ReciboCobro,Fecha,periodoMes,periodoAnio,socioId,observaciones,debe,saldo)';
      $strSql .= ' VALUES ';
      $strSql .= "(:bibliotecaId,:ReciboCobro,:Fecha,:periodoMes,:periodoAnio,:socioId,:observaciones,:debe,:saldo)";

    # preparar la consulta #
    $stmt = $pdo->prepare($strSql);
    $reciboCobro = 'recibo';
    #region Vincula los parámetros con sus valores
    $stmt->bindParam(':bibliotecaId', $bibliotecaID, PDO::PARAM_INT);
    $stmt->bindParam(':ReciboCobro', $reciboCobro, PDO::PARAM_STR);
    $stmt->bindParam(':Fecha', $data->fecha, PDO::PARAM_STR);
    $stmt->bindParam(':periodoMes', $data->periodoMes, PDO::PARAM_INT);
    $stmt->bindParam(':periodoAnio', $data->periodoAnio, PDO::PARAM_INT);
    $stmt->bindParam(':socioId', $socioID, PDO::PARAM_INT);
    $stmt->bindParam(':observaciones', $data->observaciones, PDO::PARAM_STR);
    #endregion
    // Manejo del monto
    $monto = $data->monto > 0 ? $data->monto : $valorCuota;
    $stmt->bindParam(':debe', $monto, PDO::PARAM_INT);
  // Calcula el saldo
    $saldo = $pdo->query("SELECT IFNULL((SELECT saldo FROM movimientos WHERE socioId = s.id ORDER BY id DESC LIMIT 1), 0) + $monto AS saldo FROM socios S")->fetchColumn();
    $stmt->bindParam(':saldo', $saldo, PDO::PARAM_INT);

 // Ejecuta la consulta
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
        $checkSql = 'SELECT COUNT(*) FROM MOVIMIENTOS WHERE socioId = :socioId AND periodoMes = :periodoMes AND periodoAnio = :periodoAnio AND debe = :monto';
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
    $strSql = 'INSERT INTO  MOVIMIENTOS (bibliotecaId,ReciboCobro,Fecha,periodoMes,periodoAnio,socioId,haber,saldo,observaciones,NumeroReciboPagado)
               VALUES                   (:bibliotecaId,:ReciboCobro,:Fecha,:periodoMes,:periodoAnio,:socioId,:haber,:saldo,:observaciones,:NumeroReciboPagado)';
    return $strSql;
  }

  private function obtenerElUltimoSaldo($bibliotecaID, $data){
    $coneccion = new Conexion();
    $dbConectado = $coneccion->DBConect();
    $strSql = 'SELECT IFNULL(saldo,0) as saldo FROM movimientos WHERE SOCIOId=:socioId';
    $strSql .= '    AND  bibliotecaId=:bibliotecaID
                ORDER BY  id DESC
                LIMIT 1';
    $saldo = 0;
        try {
            $stmt = $dbConectado->prepare($strSql);
            $stmt->bindParam(':bibliotecaID', $bibliotecaID, PDO::PARAM_INT);
            $stmt->bindParam(':socioId', $data->socioId, PDO::PARAM_INT);
            $stmt->execute();
            $registro = $stmt->fetchAll();

            if ($registro) {
                /* obtener los valores */
                foreach ($registro  as $row) {
                    $saldo = $row['saldo'];
                }
            }
        } catch (Exception $e) {
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
    $saldo = $this->obtenerElUltimoSaldo($bibliotecaID, $data);
    $superArray['$saldo ANTES DEL CALCULO']=$saldo;
    if ($saldo<0){
        $saldo = $data->haber + $saldo  ;
    }
    else{
        $saldo = $saldo - $data->haber;
    }
    $superArray['$saldo DESPUES DEL CALCULO'] =$saldo;
    $superArray['sql'] = $strSql;

    $stmt = $dbConectado->prepare($strSql);
    $dbConectado->beginTransaction();
    $reciboCobro = 'cobro';
    try {
        $stmt = $dbConectado->prepare($strSql);
        $stmt->bindParam(':bibliotecaId', $bibliotecaID, PDO::PARAM_INT);
        $stmt->bindParam(':ReciboCobro', $reciboCobro, PDO::PARAM_STR);
        $stmt->bindParam(':Fecha', $data->fecha, PDO::PARAM_STR);
        $stmt->bindParam(':periodoMes', $data->periodoMes, PDO::PARAM_STR);
        $stmt->bindParam(':periodoAnio', $data->periodoAnio, PDO::PARAM_INT);
        $stmt->bindParam(':socioId', $data->socioId, PDO::PARAM_INT);
        $stmt->bindParam(':haber', $data->haber);
        $stmt->bindParam(':saldo', $saldo);
        $stmt->bindParam(':observaciones', $data->observaciones);
        $stmt->bindParam(':NumeroReciboPagado', $data->numeroReciboPagado);
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
}
