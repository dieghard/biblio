<?php
  //  header("Content-type: application/json; charset=utf-8");

require_once 'conexion.php';

class ModeloEmisionDeRecibos
{
    private function armarSqlSelect($data)
    {
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
        if  ($data['socioID']>0){ $sql .= "  AND mov.SocioId=".$data['socioID'];}
        if  ($data['mesDesde']>0){$sql .= "  AND mov.periodoMes>=".$data['mesDesde'];}
        if  ($data['anioDesde']>0){$sql .= "  AND mov.periodoAnio>=".$data['anioDesde'];}
        if  ($data['mesHasta']>0){$sql .= "  AND mov.periodoMes<=".$data['mesHasta'];}
        if  ($data['anioHasta']>0){$sql .= "  AND mov.periodoAnio<=".$data['anioHasta'];}

        return $sql;
    }
    public function LlenarGrilla($bibliotecaID,$data)
    {
        $Coneccion = new Conexion();
        $dbConectado = $Coneccion->DBConect();

        $superArray['success'] = true;
        $superArray['mensaje'] = '';
        $superArray['tabla'] = '';
        $bibliotecalID = $bibliotecaID;

        $strSql = $this->armarSqlSelect($data);
        $strSql .= '    AND  mov.bibliotecaId=:bibliotecaID
                        ORDER by mov.id DESC  , mov.NumeroReciboPagado,S.apellidoyNombre
                        LIMIT 2000';
        $tabla = '';
        $superArray['sql']=$strSql;
        try {
            $stmt = $dbConectado->prepare($strSql);
            $stmt->bindParam(':bibliotecaID', $bibliotecalID, PDO::PARAM_INT);
            $stmt->execute();
            $registro = $stmt->fetchAll();
            $tabla = '<div class="table-responsive">
                     <table class="table table-condensed  table-striped table-bordered" id="idTablaUser">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nº RECIBO</th>
                            <th scope="col">SOCIO</th>
                            <th scope="col">Rec./Cob.</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">PERIODO</th>
                            <th scope="col">Nº RECIBO PAGADO</th>
                            <th scope="col">DEBE</th>
                            <th scope="col">HABER</th>
                            <th scope="col">SALDO</th>
                            <th scope="col">OBS.</th>
                        </tr>
                    </thead>
                <tbody>';

            if ($registro) {
                /* obtener los valores */
                foreach ($registro  as $row) {
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
                    $encabezadoRow .= '">';
                    $tabla .= $encabezadoRow.'<td>'.$row['id'].'</td>';
                    $tabla .= '<td>'.$row['socio'].'</td>';
                    $tabla .= '<td>'.$row['reciboCobro'].'</td>';
                    $tabla .= '<td>'.$row['fecha'].'</td>';
                    $tabla .= '<td>'.$row['periodoMes'].'- '.$row['periodoAnio'].'</td>';
                    $tabla .= '<td>'.$row['reciboPagado'].'</td>';
                    $tabla .= '<td>$'.$row['debe'].'</td>';
                    $tabla .= '<td>$'.$row['haber'].'</td>';
                    $tabla .= '<td>$'.$row['saldo'].'</td>';
                    $tabla .= '<td>'.$row['Observaciones'].'</td>';
                    $tabla .= '</tr>'; //nueva fila
                }
            }
            $tabla .= '</tbody>
                        </table>
                        </div>';
        } catch (Throwable $e) {
            $superArray['success'] = false;

            $trace = $e->getTrace();
            $superArray['mensaje'] = $e->getMessage().' en '.$e->getFile().' en la linea '.$e->getLine().' llamado desde '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }
        $superArray['tabla'] = $tabla;

        $Coneccion = null;

        return json_encode($superArray);
    }
    private function ArmarSqlInsert($bibliotecaID, $data)
    {
        $laFecha = "'". ($data->fecha) ."'" ;

        $strSql = ' INSERT INTO  MOVIMIENTOS (bibliotecaId,ReciboCobro,Fecha,periodoMes,periodoAnio,socioId,observaciones,debe,saldo) ';
        $strSql .=' SELECT ';
        $strSql .= $bibliotecaID.", ";
        $strSql .= "'recibo', ";
        $strSql .= $laFecha.',';
        $strSql .= $data->periodoMes.', ';
        $strSql .= $data->periodoAnio.', ';
        $strSql .= ' S.id, ';
        $strSql .= "'". $data->observaciones ."'," ;

        if ($data->monto>0){
            $strSql .= $data->monto .', ';
        }else{
            $strSql .= ' ts.valorCuota, ';
        }

        $strSql .= ' IFNULL((select (saldo)
                            from movimientos
                            where socioId =s.id
                            order by id DESC  limit 1),0)  + ';
        if ($data->monto>0){
            $strSql .= $data->monto ;
        }else{
             $strSql .= ' ts.valorCuota ';
        }
        $strSql .= ' as saldo ';
        $strSql .= ' FROM socios S';

        if ($data->monto==0){
            $strSql .= ' INNER JOIN tiposocio ts on ts.id = s.tipoSocioId ' ;
        }

        $strSql .= ' WHERE s.activo="SI" ';
        $strSql .= ' AND S.pagaCuota="SI" ';
        if ($data->monto=0){
            $strSql .= ' AND S.id NOT IN (select socioid from movimientos ' ;
            $strSql .= '                   where periodoMes='.$data->periodoMes;
            $strSql .='                     AND periodoAnio='.$data->periodoAnio;
            $strSql .="                     AND ReciboCobro='recibo') ";
        }
        if ($data->socioId > 0) { $strSql .= '  AND S.id='.$data->socioId; }

        return $strSql;
    }
    public function IngresoEmisionRecibos($bibliotecaID, $data)
    {
        /* ACA INSERTAMOS LOS DATOS!!!! */

        $conexion = new Conexion();
        $dbConectado = $conexion->DBConect();
        $Ejecucion = '0';
        header('Content-Type: text/html;charset=utf-8');
        $superArray['success'] = true;
        $superArray['mensaje'] = '';

        $strSql = $this->ArmarSqlInsert($bibliotecaID, $data);

        ////////////////ENCABEZADO

        $superArray['sql'] = $strSql;

        $stmt = $dbConectado->prepare($strSql);

        //Comienzo la transaccion
        $dbConectado->beginTransaction();
        try {
            $stmt->execute();
            $Ejecucion = '1';
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
    /*--------------------------------------------------------------------------------------------- */
    private function armarSqlInsert_Pagos($bibliotecaID, $data)
    {
        //*$laFecha = ($data->fecha);*/
        $strSql = 'INSERT INTO  MOVIMIENTOS (bibliotecaId,ReciboCobro,Fecha,periodoMes,periodoAnio,socioId,haber,saldo,observaciones,NumeroReciboPagado)
               VALUES                   (:bibliotecaId,:ReciboCobro,:Fecha,:periodoMes,:periodoAnio,:socioId,:haber,:saldo,:observaciones,:NumeroReciboPagado)';

        return $strSql;
    }
    private function obtenerElUltimoSaldo($bibliotecaID, $data)
    {
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
        } catch (Throwable $e) {
            $superArray['success'] = false;
            $trace = $e->getTrace();
            $superArray['mensaje'] = $e->getMessage().' en '.$e->getFile().' en la linea '.$e->getLine().' llamado desde '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }
        $coneccion = null;
        $dbConectado = null;

        return $saldo;
    }
    public function ingresoEmisionPagos($bibliotecaID, $data)
    {
        /* ACA INSERTAMOS LOS DATOS!!!! */

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
        ////////////////ENCABEZADO
        $superArray['sql'] = $strSql;

        $stmt = $dbConectado->prepare($strSql);
        //Comienzo la transaccion
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
