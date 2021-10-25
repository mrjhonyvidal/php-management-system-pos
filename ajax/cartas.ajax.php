<?php

require_once "../controllers/cartas.controller.php";
require_once "../models/cartas.model.php";
require_once "../helpers/usuarios.helper.php";

/**
* 
*/
class ajaxCartas {


	public $idUsuario;

	public $idCliente;

	public $cuitCliente;

	public $cartaNumber;

	public $cartaID;	

	public $imagenPath;

	public $imagenID;




	public function ajaxEditarCarta(){

		$respuesta = CartasController::ctrMostrarCarta($this->cartaNumber, $this->idCliente, $this->cuitCliente);

		echo json_encode($respuesta);
	}



	public function ajaxGetCartaScannedImages(){

		$respuesta = CartasController::ctrGetScannedImages($this->cartaID, $this->idCliente, $this->cuitCliente);

		echo json_encode($respuesta);	
	}


	public function ajaxBorrarIndividualImage(){

		$respuesta = CartasController::ctrDeleteIndividualImage($this->imagenID, $this->imagenPath);

		echo json_encode($respuesta);
	}


	public function ajaxGetCartaDetailsToDescarga(){
		$respuesta = CartasController::ctrGetCartaDetailsToDescarga($this->cartaNumber, $this->idCliente, $this->cuitCliente);

		echo json_encode($respuesta);
	}


}

/*** HABILITAR OBJETOS A PARTIR DE LA LLAMADA AJAX **/

if (isset($_POST['idCarta'])){
	
	$activarTabla = new ajaxCartas();
	//$activarTabla->idUsuario = $_POST[''];
	$activarTabla->idCliente = $_POST['idCliente'];
	$activarTabla->cuitCliente = $_POST['cuitCliente'];
	$activarTabla->cartaNumber = $_POST['numeroCarta'];
	$activarTabla->ajaxEditarCarta();
}


if (isset($_POST['currentCartaID'])){
	$activarTabla = new ajaxCartas();
	//$activarTabla->idUsuario = $_POST[''];
	$activarTabla->idCliente = $_POST['idCliente'];
	$activarTabla->cuitCliente = $_POST['cuitCliente'];
	$activarTabla->cartaID = $_POST['currentCartaID'];
	$activarTabla->ajaxGetCartaScannedImages();	
}

if ( isset($_POST['borrarIndividualImg']) ){
	$activarTabla = new ajaxCartas();	

	$activarTabla->imagenID = $_POST['borrarIndividualImg'];
	$activarTabla->imagenPath = $_POST['imagePath'];
	
	$activarTabla->ajaxBorrarIndividualImage();		
}


if ( isset($_POST['numeroCartaTyped']) ){
	$activarTabla = new ajaxCartas();	
	
	$activarTabla->idCliente = $_POST['idCliente'];
	$activarTabla->cuitCliente = $_POST['cuitCliente'];
	$activarTabla->cartaNumber = $_POST['numeroCartaTyped'];	
	
	$activarTabla->ajaxGetCartaDetailsToDescarga();		
}