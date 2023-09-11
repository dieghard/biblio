<?php
namespace Controller;

require_once '../Model/UserModel.php';
use Model\UserModel;

class UserController{
    private $mp;
    public function __construct(){
      $this->mp = new UserModel();
    }
    public function TraerPass($Mail){
    return $this->mp->TraerPass($Mail);
    }
    public function UserEdit($nombre,$pass,$id){
        return $this->mp->UserEdit($nombre,$pass,$id);
    }
    public function LLenarGrilla($bibliotecaID){
        return $this->mp->LlenarGrilla($bibliotecaID);

    }

    public function BuscarxDNI($data){
        return $this->mp->BuscarxDNI($data);

    }
    public function Modificar($data){
      return $this->mp->Modificar($data);

    }
    public function IngresoSocio($bibliotecaID,$data){
        return $this->mp->IngresoSocio($bibliotecaID,$data);
  }
    public function EliminarSocio($bibliotecaID,$data){
      return $this->mp->EliminarSocio($bibliotecaID,$data);

    }

  public function LlenarComboBibliotecas(){
      return $this->mp->LlenarComboBiliotecas();

  }
  public function ValidarPasswordController($usuario,$password,$bibliotecaId){
            return $this->mp->validarPasswordModelo($usuario,$password,$bibliotecaId);
  }
}


$usuarioController = new UserController();
$respuesta ='';

if(isset($_POST["ACTION"])):
    $accion = htmlspecialchars( $_POST["ACTION"]);
else:
    echo $respuesta;
    return;

endif;


switch ($accion) :
  case 'llenarGrilla':
      $respuesta = LlenarGrilla();
      break;
  case 'ingresoSocio':
    $respuesta =  IngresoSocio();
    break;
    case 'eliminarSocio':
      $respuesta = EliminarSocio();
      break;
  case 'buscarxDni':
      $respuesta = BuscarxDNI();
      break;
  case 'llenarComboBilbioteca':
      $respuesta = $usuarioController->LlenarComboBibliotecas();
      break;
  case 'ingreso':
     if(isset($_POST["usuario"])){
        $usuario = isset($_POST["usuario"]) ? htmlspecialchars($_POST["usuario"]) : "";
        $password = isset($_POST["password"]) ? htmlspecialchars($_POST["password"]) : "";
        $bibliotecaID = isset($_POST["bibliotecaID"]) ? intval($_POST["bibliotecaID"]) : 0;
        $respuesta = $usuarioController->ValidarPasswordController( $usuario,$password,$bibliotecaID);
      }
      break;
  endswitch;


echo $respuesta ;



function BuscarxDNI(){

  $respuesta = new UserController();
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $biblioteca = $_SESSION["biblioteca"];
    $bibliotecaID = $biblioteca['id'];
    $data['documento']= $_POST["documento"];
    $data['bibliotecaID']=$bibliotecaID;

    return $respuesta->BuscarxDNI($data);

}

function  LlenarGrilla(){
        $respuesta = new UserController();
        if (session_status() == PHP_SESSION_NONE) {
                session_start();
        }
        $biblioteca = $_SESSION["biblioteca"];
        $bibliotecaID = $biblioteca['id'];

        return $respuesta->llenarGrilla($bibliotecaID );

}

function  IngresoSocio(){
        $respuesta = new UserController();
        if (session_status() == PHP_SESSION_NONE) {
                session_start();
        }
        $misDatosJSON = json_decode($_POST["datosjson"]);
        $biblioteca = $_SESSION["biblioteca"];
        $bibliotecaID = $biblioteca['id'];
        return  $respuesta->IngresoSocio($bibliotecaID,$misDatosJSON  );
    }


    function EliminarSocio(){
  $respuesta = new UserController();
    if (session_status() == PHP_SESSION_NONE) {
            session_start();
    }
    $misDatosJSON = json_decode($_POST["datosjson"]);
    $biblioteca = $_SESSION["biblioteca"];
    $bibliotecaID = $biblioteca['id'];
    return  $respuesta->EliminarSocio($bibliotecaID,$misDatosJSON  );
}

function llenarComboBiblios(){

    $ajaxUser = new UserController();
    $respuesta=  $ajaxUser ->LlenarComboBibliotecas();
    echo $respuesta;

}
