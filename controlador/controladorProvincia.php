<?php

class ControladorProvincia
{
    public function __construct()
    {
        require_once '../../modelo/modeloProvincia.php';
    }

    public function eliminarProvincia($data)
    {
        $controlador = new ModeloProvincias();
        $respuesta = $controlador->eliminarProvincia($data);

        return $respuesta;
        $controlador = null;
    }

    public function ingresarActualizarProvincia($data)
    {
        $controlador = new ModeloProvincias();
        $respuesta = $controlador->ingresarActualizarProvincia($data);

        return $respuesta;
        $controlador = null;
    }

    public function llenarGrilla()
    {
        $controlador = new ModeloProvincias();
        $respuesta = $controlador->llenarGrilla();

        return $respuesta;
        $controlador = null;
    }
}
