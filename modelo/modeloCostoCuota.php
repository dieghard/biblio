<?php
  //  header("Content-type: application/json; charset=utf-8");

class ModeloCostoCuota
{
    public function __construct()
    {
        require_once 'conexion.php';
    }

    private function armarSqlSelect($bibliotecaID)
    {
        $sql = 'SELECT id,UPPER(descripcion) as descripcion, ifnull(valorCuota,0) as valorCuota
                FROM tiposocio
                where bibliotecaid='.$bibliotecaID.
                ' ORDER BY descripcion';

        return $sql;
    }

    public function llenarGrilla($bibliotecaID)
    {
        $coneccion = new Conexion();
        $dbConectado = $coneccion->DBConect();

        $superArray['success'] = true;
        $superArray['mensaje'] = '';
        $superArray['tabla'] = '';

        $strSql = $this->armarSqlSelect($bibliotecaID);
        $tabla = '';
        try {
            $stmt = $dbConectado->prepare($strSql);
            $stmt->execute();
            $registro = $stmt->fetchAll();
            $tabla = '<div class="table-responsive">
                     <table class="table table-condensed  table-striped  table-bordered" id="idTablaUser">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">DESCRIPCION</th>
                            <th scope="col">VALOR CUOTA</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                <tbody>';

            if ($registro) {
                /* obtener los valores */
                foreach ($registro  as $row) {
                    $encabezadoRow = '<tr id="'.$row['id'].'"';
                    $encabezadoRow .= 'data-id="'.$row['id'].'"';
                    $encabezadoRow .= 'data-descripcion="'.$row['descripcion'].'"';
                    $encabezadoRow .= 'data-valorcuota="'.$row['valorCuota'].'"';
                    $encabezadoRow .= '">';
                    $tabla .= $encabezadoRow.'<td>'.$row['descripcion'].'</td>';
                    $tabla .= '<td>'.$row['valorCuota'].'</td>';
                    $tabla .= '<td><button type="button" title="Presione para modificar item" class="btn btn-primary edit" onclick="fnProcesaEditar(this)"  value="'.$row['id'].'"><i class="fa fa-edit "></i></button>     ';
                    $tabla .= '<button type="button" title="Presione para eliminar item" class="btn btn-danger delete" onclick="fnProcesaEliminar(this)" value="'.$row['id'].'"><i class="fa fa-eraser "></i> </button></td>';
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

        $coneccion = null;

        return json_encode($superArray);
    }

    private function armarSqlInsert()
    {
        $strSql = 'INSERT INTO  tiposocio (bibliotecaid, descripcion,  valorCuota)
                    VALUES                (:bibliotecaid,:descripcion,:valorCuota)';

        return $strSql;
    }

    private function armarSqlUpdate()
    {
        $strSql = 'UPDATE tiposocio set descripcion=:descripcion ,valorCuota=:valorCuota WHERE id=:id and bibliotecaid=:bibliotecaid';

        return $strSql;
    }

    /*--------------------------------------------------------------------------------------------- */
    public function ingresarActualizarValorCuota($bibliotecaID, $data)
    {
        /* ACA INSERTAMOS LOS DATOS!!!! */

        $conexion = new Conexion();
        $dbConectado = $conexion->DBConect();
        header('Content-Type: text/html;charset=utf-8');
        $superArray['success'] = true;
        $superArray['mensaje'] = '';

        if ($data->id > 0) {
            $strSql = $this->armarSqlUpdate();
        } else {
            $strSql = $this->ArmarSqlInsert();
        }
        ////////////////ENCABEZADO

        $stmt = $dbConectado->prepare($strSql);

        if ($data->id > 0) {
            $stmt->bindParam(':id', $data->id, PDO::PARAM_INT);
        }
        $stmt->bindParam(':bibliotecaid', $bibliotecaID, PDO::PARAM_INT);
        $stmt->bindParam(':descripcion', $data->descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':valorCuota', $data->valorCuota);
        //Comienzo la transaccion
        $dbConectado->beginTransaction();
        try {
            $stmt->execute();
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

    public function eliminarValorCuota($bibliotecaID, $data)
    {
        $conexion = new Conexion();
        $dbConectado = $conexion->DBConect();
        $superArray['success'] = true;
        $superArray['mensaje'] = '';

        $strSql = 'Select tipoSocioId from socios where tipoSocioId=:id';
        $stmt = $dbConectado->prepare($strSql);
        $stmt->bindParam(':id', $data->id, PDO::PARAM_INT);
        /*Comienzo la transaccion */

        try {
            $stmt->execute();
            $registro = $stmt->fetchAll();
            if ($registro) {
                $superArray['success'] = false;
                $superArray['mensaje'] = 'NO SE PUEDE ELIMINAR EL VALOR DE LA CUOTA YA QUE SOCIOS LA ESTAN UTILIZANDO';

                return json_encode($superArray);
            }
        } catch (Exception $e) {
            $superArray['success'] = false;
            $superArray['mensaje'] = 'Error: '.$e->getMessage();

            return json_encode($superArray);
        }

        $strSql = 'DELETE FROM tiposocio WHERE id=:id ';

        $stmt = $dbConectado->prepare($strSql);
        $stmt->bindParam(':id', $data->id, PDO::PARAM_INT);
        /*Comienzo la transaccion */
        $dbConectado->beginTransaction();
        try {
            $stmt->execute();
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
