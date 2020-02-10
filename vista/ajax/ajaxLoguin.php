<?php
require_once "../../controlador/userController.php";
/*
=================================================================================================
 * VALIDAR USUARIO!
================================================================================================= 
*/

class Ajax_Validar_User {
        public function Ingreso($usuario,$pass,$bibliotecaID){
            $CP = new UserController();
            $respuesta = $CP->ValidarPasswordController ($usuario,$pass,$bibliotecaID); 
            
            return $respuesta;
            $CP = null;
        }
}
/*
=================================================================================================
 * LECTURA DE AJAX DEPENDIENDO EL TIPO DE CHEK LLAMO A UNA CLASE O A OTRA!
================================================================================================= 
*/

if(isset($_POST["tipoVerificacion"])){
        $Verificacion = $_POST["tipoVerificacion"];
    }
    else{
        return;
    }


if ($Verificacion=='ingreso'){  
    if(isset($_POST["usuario"])){
        $usuario = new Ajax_Validar_User();
        
        $usuariote= $_POST["usuario"];
        $password= $_POST["password"];
        $bibliotecaID= $_POST["bibliotecaID"];
        //$respuesta ='PASE POR AQUI PAPA';
        $respuesta = $usuario->Ingreso( $usuariote,$password,$bibliotecaID);
        echo $respuesta ;
    }
}          
   
