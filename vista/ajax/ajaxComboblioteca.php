<?php

/**
 * Description of ajaxComboBibliotecas
 *
 * @author Diego
 */
class ajaxComboBibliotecas {
       public function __construct(){
           require_once '../../controlador/userController.php'; 
           }
       
          public function llenarComboBiblios(){
            $ajaxUser = new UserController();
            $respuesta=  $ajaxUser ->LlenarComboBibliotecas();
            echo $respuesta;       
                   
       }    
}
  
$ajaxUser = new ajaxComboBibliotecas();

if ($_POST['ACTION'] == 'llenarComboBilbioteca'){
    $ajaxUser->llenarComboBiblios();
    $ajaxUser=null;
    
}
