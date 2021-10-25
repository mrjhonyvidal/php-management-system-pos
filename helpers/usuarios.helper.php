<?php

class UsuariosHelper{


	static public function getClienteInfoWithUserLoggedIn( $idCliente = null){

		if( $idCliente != null){

			$stmt = Conexion::conectar()->prepare("SELECT id_cliente, razon_social, cuit, pais FROM clientes WHERE id_cliente = :id_cliente");

			$stmt->bindParam(":id_cliente", $idCliente, PDO::PARAM_STR);
			$stmt->execute();
			
			return $stmt->fetch();
		}else{

			$stmt = Conexion::conectar()->prepare("SELECT id_cliente, razon_social, cuit, pais FROM clientes WHERE cuit = :cuit");
			$stmt->bindParam(":cuit", $_SESSION["cuitCliente"], PDO::PARAM_STR);
			$stmt->execute();
			
			return $stmt->fetch();
		}	
	}		


	static public function isSYSAdmin( $userId = null, $idCliente = null) {	


		$cliente = self::getClienteInfoWithUserLoggedIn( $idCliente ); 
				
		if($idCliente != null){
					
			if( strcmp($cliente['id_cliente'],1) == 0){								
					return true;
				}else{					
					return false;
				}

		}else{
			if( strcmp($_SESSION["idcliente"],1) == 0){								
					return true;
				}else{
					
					return false;
				}
		} 		
	}


	static public function getAuthenticatedUserProfile($idUsuario){
		
		return  UsuariosModel::mdlMostrarUsuario($idUsuario);
		
	}
}

