<?php

require_once "../controllers/cartas.controller.php";
require_once "../models/cartas.model.php";
require_once "../helpers/usuarios.helper.php";

/**
* 
*/
class ajaxDataCartas {


	public $idUsuario;

	public $idCliente;

	public $cuitCliente;

	/**==========================
	MOSTRAR LA TABLA DE CARTAS
	=============================*/

	public function mostrarTabla(){

	
		$cartas = CartasController::ctrMostrarCartas($this->idUsuario, $this->idCliente, $this->cuitCliente);

		$totalCartas = count($cartas);	

			echo '{
				  "data": [';

				 for($i=0; $i < $totalCartas-1; $i++){
				 	echo '[
				      "' . ($i+1) . '",
				      "' . $cartas[$i]["numero_carta_porte"].'",
				      "' . $cartas[$i]["procedencia"].'",				     
				      "' . $cartas[$i]["razon_social_titular"].'",
					  "' . $cartas[$i]["cuit_titular_carta_porte"].'",					      
				      "' . $cartas[$i]["localidad_destino"].'"				      
				    ],';	
				 }

				 

				 echo '[
				      "'.  $totalCartas . '",
				      "' . $cartas[$totalCartas-1]["numero_carta_porte"] . '",
				      "' . $cartas[$totalCartas-1]["procedencia"] . '",				     
				      "' . $cartas[$totalCartas-1]["razon_social_titular"] . '",
					  "' . $cartas[$totalCartas-1]["cuit_titular_carta_porte"] . '",					      
				      "' . $cartas[$totalCartas-1]["localidad_destino"] . '"				      				      
				      ]
				   ]
				}';		    							
		
	}


}


/**==========================
ACTIVAR TABLA DE CARTAS
=============================*/

$activarTabla = new ajaxDataCartas();
$activarTabla->idUsuario = $_GET['usuario_id'];
$activarTabla->idCliente = $_GET['cliente_id'];
$activarTabla->cuitCliente = $_GET['cliente_cuit'];
$activarTabla->mostrarTabla();

