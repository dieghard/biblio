<?php
namespace Model;
require_once 'conexion.php';
use Model\Conexion;
use PDO;
use Exception;
class PanelModel
{
    public function __construct()
    {
        require_once 'conexion.php';
    }

    public function cantidadSocios_y_Montos($bibliotecaID)
    {
        $Coneccion = new Conexion();
        $dbConectado = $Coneccion->DBConect();

        $superArray['success'] = true;
        $superArray['mensaje'] = '';
        $superArray['cantidadUsuariosActivos'] = 0;
        $superArray['cantidadUsuariosInactivos'] = 0;
        $superArray['saldo'] = 0;
        $bibliotecalID = $bibliotecaID;

        // CANTIDAD ACTIVOS
        $strSql = 'SELECT count(*) as cantidad FROM socios Where Activo = "SI"';
        $strSql .= '    AND  bilbiotecaId=:bibliotecaID';

        try {
            $stmt = $dbConectado->prepare($strSql);
            $stmt->bindParam(':bibliotecaID', $bibliotecalID, PDO::PARAM_INT);
            $stmt->execute();
            $registro = $stmt->fetchAll();

            if ($registro) {
                foreach ($registro  as $row) {
                    $superArray['cantidadUsuariosActivos'] = $row['cantidad'];
                }
            }
        } catch (Exception $e) {
            $superArray['success'] = false;
            $trace = $e->getTrace();
            $superArray['mensaje'] = $e->getMessage().' en '.$e->getFile().' en la linea '.$e->getLine().' llamado desde '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }
        // CANTIDAD INACTIVOS
        $strSql = 'SELECT count(*) as cantidad FROM socios Where Activo = "NO"';
        $strSql .= '    AND  bilbiotecaId=:bibliotecaID';

        try {
            $stmt = $dbConectado->prepare($strSql);
            $stmt->bindParam(':bibliotecaID', $bibliotecalID, PDO::PARAM_INT);
            $stmt->execute();
            $registro = $stmt->fetchAll();

            if ($registro) {
                foreach ($registro  as $row) {
                    $superArray['cantidadUsuariosInactivos'] = $row['cantidad'];
                }
            }
        } catch (Exception $e) {
            $superArray['success'] = false;
            $trace = $e->getTrace();
            $superArray['mensaje'] = $e->getMessage().' en '.$e->getFile().' en la linea '.$e->getLine().' llamado desde '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }
        // SALDO ACTIVOS

        $strSql = "SELECT IFNULL(SUM(IFNULL(mov.debe,0) -
                   IFNULL((SELECT haber FROM movimientos WHERE  NumeroReciboPagado = mov.id  AND Eliminado !='SI'),0)),0)  AS saldo
                  FROM movimientos mov
                  inner join socios s on s.id = mov.socioId
                  Where 1= 1
                  AND ifnull(mov.Eliminado,'NO') <>'SI'
                  AND  ifnull(s.activo,'NO')='SI'
                        AND  bilbiotecaId=:bibliotecaID";
        $superArray['sql'] = $strSql;
        try {
            $stmt = $dbConectado->prepare($strSql);
            $stmt->bindParam(':bibliotecaID', $bibliotecalID, PDO::PARAM_INT);
            $stmt->execute();
            $registro = $stmt->fetch(PDO::FETCH_ASSOC); // Usamos fetch() en lugar de fetchAll()
            if ($registro):
              $superArray['saldo'] = $registro['saldo']; // Accedemos al valor 'saldo'
            endif;
        } catch (Exception $e) {
            $superArray['success'] = false;
            $trace = $e->getTrace();
            $superArray['mensaje'] = $e->getMessage().' en '.$e->getFile().' en la linea '.$e->getLine().' llamado desde '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }
        $Coneccion = null;

        return json_encode($superArray);
    }
}
