<?php
namespace Controller;
require_once '../../Model/CombosModel.php';
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


if(isset($_POST["combo"])){
        $combo = $_POST["combo"];
}
    else{
        return;
}
if(isset($_POST["tabIndex"])){
        $tabIndex = $_POST["tabIndex"];
}
if(isset($_POST["idCombo"])){
    $idCombo = $_POST["idCombo"];
}



if ($combo=='localidades'){comboLocalidades($tabIndex);}
if ($combo=='sector'){comboSectores($tabIndex);}
if ($combo=='provincias'){comboProvincias($tabIndex);}
if ($combo=='tipoSocio'){combotipoSocio($tabIndex);}
if ($combo=='Socios'){comboSocios($tabIndex);}
if ($combo=='socios_abm'){comboSociosAbm($tabIndex,$idCombo);}
if ($combo=='socios_impresion'){socios_impresion($tabIndex,$idCombo);}

function  comboLocalidades($tabIndex ){
    $respuesta = new CombosController();
    $respuesta->ComboLocalidad($tabIndex );
}
function comboProvincias($tabIndex ){
    $respuesta = new CombosController();
    $respuesta->comboProvincia($tabIndex );
}
function comboSectores($tabIndex){
    $respuesta = new CombosController();
    $respuesta->comboSectores($tabIndex);
}
function combotipoSocio($tabIndex ){
    $respuesta = new CombosController();
    $respuesta->comboTipoSocio($tabIndex );
}
function comboSocios($tabIndex ){
    $respuesta = new CombosController();
    $respuesta->comboSocios($tabIndex );
}
function comboSociosAbm($tabIndex,$idCombo ){
    $respuesta = new CombosController();
    $respuesta->comboSociosAbm($tabIndex,$idCombo );
}
function socios_impresion($tabIndex,$idCombo ){
    $respuesta = new CombosController();
    $respuesta->socios_impresion($tabIndex,$idCombo );
}
