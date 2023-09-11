<?php
//namespace Controlador;
class ControladorLogin{


	public function Login(){
		include "vista/login.php";
	}
	public function enlacesPaginasController(){
		$MP = new ModeloPlantilla();

		if (isset ($_GET["action"])) {
			$enlaces = $_GET["action"];
		} else{
                        $enlaces ='panel';

		}
		$respuesta = $MP->enlacesPaginasModelo($enlaces);

		include  $respuesta;
		$respuesta =null;
	}
}

