<?php
namespace Controller;
require_once '../Model/CombosModel.php';
use Model\CombosModel;

class CombosController{
    private $mp;
    public function __construct(){
      $this->mp = new CombosModel();
    }
    public function comboLocalidad($tabIndex){
      return $this->mp->ComboLocalidad($tabIndex);

    }
    public function comboProvincia($tabIndex){

        return $this->mp->comboProvincia($tabIndex);

    }
    public function comboSectores($tabIndex){

      return  $this->mp->comboSectores($tabIndex);

    }
    public function comboTipoSocio($tabIndex ){

      $respuesta = $this->mp->comboTipoSocio($tabIndex );
      return $respuesta;

    }

    public function comboSocios($tabIndex ){
      return $this->mp->ComboSocios($tabIndex );

    }
    public function ComboSociosAbm($tabIndex,$idCombo ){
      return $this->mp->comboSociosAbm($tabIndex,$idCombo );
      $this->mp = null;
    }
    public function socios_impresion($tabIndex,$idCombo ){
        return $this->mp->socios_impresion($tabIndex,$idCombo );

    }
}


if(isset($_POST["combo"])):
    $combo = $_POST["combo"];
else:
  return;
endif;

$tabIndex = 0;
if(isset($_POST["tabIndex"])):
    $tabIndex = $_POST["tabIndex"];
endif;

if(isset($_POST["idCombo"])):
    $idCombo = $_POST["idCombo"];
else:
    return;
endif;


$respuesta = '';
if ($combo=='localidades'){$respuesta = comboLocalidades($tabIndex);}
if ($combo=='sector'){$respuesta = comboSectores($tabIndex);}
if ($combo=='provincias'){$respuesta = comboProvincias($tabIndex);}
if ($combo=='tipoSocio'){$respuesta = combotipoSocio($tabIndex);}
if ($combo=='Socios'){$respuesta = comboSocios($tabIndex);}
if ($combo=='socios_abm'){$respuesta = comboSociosAbm($tabIndex,$idCombo);}
if ($combo=='socios_impresion'){$respuesta = socios_impresion($tabIndex,$idCombo);}

echo$respuesta ;

function  comboLocalidades($tabIndex ){
    $respuesta = new CombosController();
    return $respuesta->ComboLocalidad($tabIndex );
}
function comboProvincias($tabIndex ){
    $respuesta = new CombosController();
    return  $respuesta->comboProvincia($tabIndex );
}
function comboSectores($tabIndex){
    $respuesta = new CombosController();
    return $respuesta->comboSectores($tabIndex);
}
function combotipoSocio($tabIndex ){
    $respuesta = new CombosController();
    return $respuesta->comboTipoSocio($tabIndex );
}
function comboSocios($tabIndex ){
    $respuesta = new CombosController();
    return $respuesta->comboSocios($tabIndex );
}
function comboSociosAbm($tabIndex,$idCombo ){
    $respuesta = new CombosController();
    return $respuesta->comboSociosAbm($tabIndex,$idCombo );
}
function socios_impresion($tabIndex,$idCombo ){
    $respuesta = new CombosController();
    return $respuesta->socios_impresion($tabIndex,$idCombo );
}
