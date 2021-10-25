<?php

require_once "../controllers/descargas.controller.php";
require_once "../models/descargas.model.php";
require_once "../helpers/usuarios.helper.php";

/**
* 
*/
class ajaxDescargas {


	public $idUsuario;

	public $idCliente;

	public $cuitCliente;

	public $cartaNumber;

	public $descargaID;	




	public function ajaxEditarDescarga(){

		$respuesta = DescargasController::ctrMostrarDescarga($this->cartaNumber, $this->idCliente, $this->cuitCliente);

		echo json_encode($respuesta);
	}


}

/*** HABILITAR OBJETOS A PARTIR DE LA LLAMADA AJAX **/

if (isset($_POST['idDescarga'])){
	
	$activarTabla = new ajaxDescargas();	
	$activarTabla->idCliente = $_POST['idCliente'];
	$activarTabla->cuitCliente = $_POST['cuitCliente'];
	$activarTabla->descargaID = $_POST['idDescarga'];
	$activarTabla->cartaNumber = $_POST['numeroCarta'];
	$activarTabla->ajaxEditarDescarga();
}