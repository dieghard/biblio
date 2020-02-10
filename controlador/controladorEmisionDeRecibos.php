<?php

class controladorEmisionDeRecibos
{
    /*=============================================
    LLAMAMOS LA PLANTILLA
    =============================================*/
    public function __construct()
    {
        require_once '../../modelo/modeloEmisionDeRecibos.php';
    }

    public function LLenarGrilla($bibliotecaID,$data)
    {
        $MP = new ModeloEmisionDeRecibos();

        $grilla = $MP->LlenarGrilla($bibliotecaID,$data);

        return $grilla;
        $MP = null;
    }

    public function impresionRecibos($bibliotecaID, $data)
    {
        $MP = new ModeloEmisionDeRecibos();

        $grilla = $MP->impresionRecibos($bibliotecaID, $data);

        return $grilla;
        $MP = null;
    }

    public function IngresoEmisionRecibos($bibliotecaID, $misDatosJSON)
    {
        $moduleEmi = new ModeloEmisionDeRecibos();

        $ingreso = $moduleEmi->IngresoEmisionRecibos($bibliotecaID, $misDatosJSON);

        return $ingreso;
        $moduleEmi = null;
    }

    /* ******************************************************************************
    PAGOS!!!!!
    ***** */
    public function ingresoEmisionPagos($bibliotecaID, $misDatosJSON)
    {
        $emisionPagoModelo = new ModeloEmisionDeRecibos();

        $ingreso = $emisionPagoModelo->IngresoEmisionPagos($bibliotecaID, $misDatosJSON);

        return $ingreso;
        $emisionPagoModelo = null;
    }
}
