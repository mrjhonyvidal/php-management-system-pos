<?php

require_once "../controllers/usuarios.controller.php";
require_once "../models/usuarios.model.php";
require_once "../helpers/usuarios.helper.php";

class AjaxUsuarios {


  public $idUsuario;
  
  public $idCliente;

  public $activarUsuario;
  
  public $activarId;

  public $validarUsuario;

  public $validarCorreo;



  /** =============================================
    EDITAR USUARIO
  ================================================*/
  public function ajaxEditarUsuario(){

    //$user = array();
    //$user['cuitCliente'] = 99999999999;
    //$user['idcliente'] = 1;
      
    $respuesta = UsuariosController::ctrMostrarUsuario($this->idUsuario, $this->idCliente);    

    echo json_encode($respuesta);


  }
 

  /** =============================================
    ACTIVAR USUARIOS
  ================================================*/
  public function ajaxActivarUsuario(){
     

     $respuesta = UsuariosModel::mdlActivarUsuario($this->activarUsuario, $this->activarId);     
    
     echo json_encode($this->activarUsuario);

  }



   /** =============================================
    VALIDAR REPETICIÓN DE USUARIO Y CORREO
  ================================================*/
  public function ajaxValidarUsuarioIsUnique(){

    if($this->validarUsuario != ''){
      
      $item = "usuario";
      $valor = $this->validarUsuario;

    }else if($this->validarCorreo != ''){
      $item = "correo";
      $valor = $this->validarCorreo;
    }

    $respuesta = UsuariosModel::mdlVerificarSiUsuarioExiste($item, $valor);            

    echo json_encode($respuesta);

  }




   /** =============================================
    VALIDAR CORREO AL REGISTRAR
  ================================================*/
  public function ajaxValidarCorreo(){

    $respuesta = UsuariosModel::mdlGetUserInfoFromCorreo($this->validarCorreo);            
    echo json_encode($respuesta);

  }



}


/** =============================================
    PARAMETROS RECIBIDOS PARA EDITAR USUARIOS
  ================================================*/

if(isset($_POST['idUsuario'])){

  $editar = new AjaxUsuarios();
  $editar->idUsuario = $_POST["idUsuario"];
  $editar->idCliente = $_POST["idCliente"];  
  $editar->ajaxEditarUsuario();

}


/** =============================================
    PARAMETROS RECIBIDOS PARA ACTIVAR USUARIOS
  ================================================*/

if(isset($_POST['activarUsuario'])){

  $activarUsuario = new AjaxUsuarios();
  $activarUsuario->activarUsuario = $_POST["activarUsuario"];
  $activarUsuario->activarId = $_POST["activarId"];
  $activarUsuario->ajaxActivarUsuario();

}  


/** =============================================
    PARAMETROS PARA REVISAR USUARIO Y CORREO
  ================================================*/
if(isset($_POST["validarUsuario"]) || isset($_POST["validarCorreo"])){

  $validarUsuario = new AjaxUsuarios();
  $validarUsuario->validarCorreo = $_POST["validarCorreo"];
  $validarUsuario->validarUsuario = $_POST["validarUsuario"];
  $validarUsuario->ajaxValidarUsuarioIsUnique();
}


/** =================================================
VALIDAR CORREO
=====================================================**/
if(isset($_POST['validarEmail'])){

  $editar = new AjaxUsuarios();
  $editar->validarCorreo = $_POST["validarEmail"]; 
  $editar->ajaxValidarCorreo();

}