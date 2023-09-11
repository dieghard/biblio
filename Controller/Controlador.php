<?php

namespace Controlador;

require_once '../Model/Modelo.php';
use Model\Modelo;
class Controlador
{
 /*=============================================
   Interaccion del Usuario
 =============================================*/
    public function ControladorLinks()
    {
        $MP = new Modelo();

        if (isset($_GET['action'])) {
            $enlaces = $_GET['action'];
        }
        else {
            $enlaces = 'panel';
        }
        $respuesta = $MP->ControladorLinksModelo($enlaces);
        include $respuesta;
        $respuesta = null;
    }
}
