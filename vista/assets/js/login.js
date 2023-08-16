/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$(window).on('load', function() {
    $( document ).ready(function() {

     llenarComboBiblioteca();

    });
});

function  llenarComboBiblioteca(){
    var datos = new FormData();

    datos.append("ACTION","llenarComboBilbioteca");
    $.ajax({
            url:"vista/ajax/ajaxComboblioteca.php",
                method:"POST",
                data:datos,
                cache:false,
                contentType:false,
                processData :false,
                success:function(respuesta){
                    var n = respuesta.length;
                    if(n>0) {
                        $('#comboBiblioteca').html(respuesta);

                    }
                }
        });

}


$(document).ready(function() {
   /* ACA VEMOS SI ENTRAMOS O NO AL PANEL DE CONTROL!!!!!!*/
   $("#btn-login").click(function() {

        var usuario = $("#inputEmail").val();
        var password = $("#inputPassword").val();
        var bibliotecaID = $("#cmbBiblioteca").val();

       var continuar = true;
        if (usuario.length <=0){
            $("#divUsuario").fadeToggle(2000);
            $("#divUsuario").text('Debe ingresar un usuario') ;
            $("#divUsuario").css("color", "red");
            continuar=false;
            return false;
        }
        if (bibliotecaID <=0){
            $("#divUsuario").fadeToggle(2000);
            $("#divUsuario").text('Debe Seleccionar un cuartel, si no existe contactese a info@rasoftware.com') ;
            $("#divUsuario").css("color", "red");
            continuar=false;
            return false;
        }
    if (password.length <=0){
        $("#divUsuario").fadeToggle(2000);
        $("#divUsuario").text('Debe ingresar una contraseña') ;
        $("#divUsuario").css("color", "red");
        continuar=false;
        return false;
    }
   // alert ('continuar:'+continuar);

    if (continuar == true){
        var datos = new FormData();
        datos.append("usuario",usuario);
        datos.append("password",password);
        datos.append("bibliotecaID",bibliotecaID);
        datos.append("tipoVerificacion","ingreso");


       $.ajax({
            url:"vista/ajax/ajaxLoguin.php",
                method:"POST",
                data:datos,
                cache:false,
                contentType:false,
                processData :false,
                success:function(respuesta){

                    if(respuesta.success == true) {
                            window.location.href=   respuesta.path;
                        }
                        else {
                                $("#divUsuario").fadeToggle(2000);
                                $("#divUsuario").text(respuesta.error) ;
                                $("#divUsuario").css("color", "red");
                        }
                }
        });
    }
  });



});

function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();

  }