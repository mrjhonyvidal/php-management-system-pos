<?php

require_once "../helpers/usuarios.helper.php";
require_once "../controllers/descargas.controller.php";
require_once "../models/descargas.model.php";
require_once "../models/clientes.model.php";
require_once "../models/cartas.model.php";

/**
* 
*/
class ajaxDescargas {


	public $idUsuario;

	public $idCliente;

	public $cuitCliente;

	/**==========================
	MOSTRAR LA TABLA DE CARTAS
	=============================*/

	public function mostrarTablaDescarga(){

	
		$descargas = DescargasController::ctrMostrarDescargas($this->idUsuario, $this->idCliente, $this->cuitCliente);

		$totalDescargas = count($descargas);		

			echo '{
				  "data": [';

				 for($i=0; $i < $totalDescargas-1; $i++){
				 	echo '[
				      "' . ($i+1) . '",
				      "' . $descargas[$i]["numero_carta_porte"].'",
				      "' . $descargas[$i]["dia_salida"].'",				     
				      "' . $descargas[$i]["hora_salida"].'",
					  "' . $descargas[$i]["cuit_titular_carta_porte"] . '",
				      "' . $descargas[$i]["calidad"].'"				      
				    ],';	
				 }

				 

				 echo '[
				      "'.  $totalDescargas . '",
				      "' . $descargas[$totalDescargas-1]["numero_carta_porte"] . '",
				      "' . $descargas[$totalDescargas-1]["dia_salida"] . '",				     
				      "' . $descargas[$totalDescargas-1]["hora_salida"] . '",
					  "' . $descargas[$totalDescargas-1]["cuit_titular_carta_porte"] . '",					      
				      "' . $descargas[$totalDescargas-1]["calidad"] . '"				      				      
				      ]
				   ]
				}';		    							
		
	}


}


/**==========================
ACTIVAR TABLA DE CARTAS
=============================*/

$activarTabla = new ajaxDescargas();
$activarTabla->idUsuario = $_GET['usuario_id'];
$activarTabla->idCliente = $_GET['cliente_id'];
$activarTabla->cuitCliente = $_GET['cliente_cuit'];
$activarTabla->mostrarTablaDescarga();

