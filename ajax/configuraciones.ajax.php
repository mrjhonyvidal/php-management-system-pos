<?php

require_once "../helpers/usuarios.helper.php";
require_once "../models/configuraciones.model.php";

class AjaxConfiguraciones {
	

	/**
	 * BUSCAR INFO DE CONFIGURACIONES DEL AJAX
	 */
	public function ajaxGetConfiguracionesSistema(){
		$respuesta = ConfiguracionesModel::mdlMostrarConfiguraciones();

		echo json_encode($respuesta);
	}

}

/*** HABILITAR OBJETOS A PARTIR DE LA LLAMADA AJAX **/
if(isset($_POST['idCliente'])){

	$infoCliente = new AjaxConfiguraciones();
	$infoCliente->ajaxGetConfiguracionesSistema();
}