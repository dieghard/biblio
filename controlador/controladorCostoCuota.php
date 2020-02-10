<?php

class ControladorCostoCuota
{
    public function __construct()
    {
        require_once '../../modelo/modeloCostoCuota.php';
    }

    public function eliminarCostoCuota($bibliotecaID, $data)
    {
        $controlador = new ModeloCostoCuota();
        $respuesta = $controlador->eliminarValorCuota($bibliotecaID, $data);

        return $respuesta;
        $controlador = null;
    }

    public function ingresarActualizarCostoCuota($bibliotecaID, $data)
    {
        $controlador = new ModeloCostoCuota();
        $respuesta = $controlador->ingresarActualizarValorCuota($bibliotecaID, $data);

        return $respuesta;
        $controlador = null;
    }

    public function llenarGrilla($bibliotecaID)
    {
        $controlador = new ModeloCostoCuota();
        $respuesta = $controlador->llenarGrilla($bibliotecaID);

        return $respuesta;
        $controlador = null;
    }
}
