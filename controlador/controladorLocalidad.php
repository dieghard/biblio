<?php

class ControladorLocalidad
{
    public function __construct()
    {
        require_once '../../modelo/modeloLocalidad.php';
    }

    public function eliminarLocalidad($data)
    {
        $controlador = new ModeloLocalidad();
        $respuesta = $controlador->eliminarLocalidad($data);

        return $respuesta;
        $controlador = null;
    }

    public function ingresarActualizarLocalidad($data)
    {
        $controlador = new ModeloLocalidad();
        $respuesta = $controlador->ingresarActualizarLocalidad($data);

        return $respuesta;
        $controlador = null;
    }

    public function llenarGrilla()
    {
        $controlador = new ModeloLocalidad();
        $respuesta = $controlador->llenarGrilla();

        return $respuesta;
        $controlador = null;
    }
}
