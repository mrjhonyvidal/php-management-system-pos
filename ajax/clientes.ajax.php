<?php

require_once "../helpers/usuarios.helper.php";
require_once "../controllers/clientes.controller.php";
require_once "../models/usuarios.model.php";
require_once "../models/clientes.model.php";

class AjaxClientes {


	public $cuitCliente;

	public $idUsuario;
  
  public $idCliente;

  public $validarCUIT;


	/**
	 * BUSCAR INFO CLIENTE A PARTIR DEL CUIT 
	 */
	public function ajaxGetClienteInfoFromCUIT(){
		$respuesta = ClientesController::ctrMostrarClienteByCUIT($this->cuitCliente);

		echo json_encode($respuesta);
	}

 /** =============================================
    EDITAR CLIENTE
  ================================================*/
  public function ajaxEditarCliente(){
      
    $respuesta = ClientesController::ctrMostrarClienteByID($this->idCliente);    

    echo json_encode($respuesta);


  }


  /** =============================================
    VALIDAR CUIT
  ================================================*/
  public function ajaxValidarCUIT(){
      
    $respuesta = ClientesController::ctrMostrarClienteByCUIT($this->validarCUIT);    

    echo json_encode($respuesta);


  }


}


/*** HABILITAR OBJETOS A PARTIR DE LA LLAMADA AJAX **/
if(isset($_POST['cuitTyped'])){

	$infoCliente = new AjaxClientes();
	$infoCliente->cuitCliente = $_POST["cuitTyped"];
	$infoCliente->ajaxGetClienteInfoFromCUIT();
}



/** =============================================
    PARAMETROS RECIBIDOS PARA EDITAR CLIENTES
  ================================================*/

if(isset($_POST['idCliente'])){

  $editar = new AjaxClientes();  
  $editar->idCliente = $_POST["idCliente"];  
  $editar->ajaxEditarCliente();

}


/** =================================================
VALIDAR CUIT
=====================================================**/
if(isset($_POST['validarCUIT'])){

  $editar = new AjaxClientes();
  $editar->validarCUIT = $_POST["validarCUIT"]; 
  $editar->ajaxValidarCUIT();

}