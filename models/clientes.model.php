<?php
require_once 'conexion.php';


class ClientesModel{

  

  static public function mdlIngresarCliente($datos){



      $checkIfExistUsuarioInDatabase = self::mdlVerificarSiClienteExiste($datos['cuit']);
     

      if($checkIfExistUsuarioInDatabase['TOTAL_CLIENTES'] > 0)
        return "error";

    

      $conn = Conexion::conectar();
      $stmt = $conn->prepare("INSERT INTO clientes (id_identificacion_interna, razon_social, cuit, pais, numero_planta, planta) VALUES (:idIdentificacion, :razonSocial, :cuit, :pais, :numeroPlanta, :planta)");
        
      $stmt->bindParam(":idIdentificacion", $datos['idIdentificacion'], PDO::PARAM_STR);

      $cuitClienteCleaned = str_replace('-','',$datos['cuit']);

      $stmt->bindParam(":razonSocial", $datos['razonSocial'], PDO::PARAM_STR);
      $stmt->bindParam(":cuit", $cuitClienteCleaned, PDO::PARAM_STR);
      $stmt->bindParam(":planta", $datos['planta'], PDO::PARAM_STR);
      $stmt->bindParam(":numeroPlanta", $datos['numeroPlanta'], PDO::PARAM_STR);
      $stmt->bindParam(":pais", $datos['pais'], PDO::PARAM_STR);    

      if($stmt->execute()){
          return "ok";
      }else{
        return "error";
      }

      $stmt = null;

  }


  static public function mdlEditarCliente($datos){


          //$cliente = UsuariosHelper::getClienteInfoWithUserLoggedIn();          
          $cliente = self::mdlMostrarClienteByCUIT($datos['cuit']);

          $conn = Conexion::conectar();
         
          
          $stmt = $conn->prepare("UPDATE clientes SET id_identificacion_interna = :idIdentificacion, razon_social = :razonSocial, cuit = :cuit, pais = :pais, numero_planta = :numeroPlanta, planta = :planta WHERE id_cliente = :idCliente");


          $cuitClienteCleaned = trim(str_replace('-','', $datos['cuit']));
         
          
          $stmt->bindParam(":idIdentificacion", $datos['idIdentificacion'], PDO::PARAM_STR);
          $stmt->bindParam(":razonSocial", $datos['razonSocial'], PDO::PARAM_STR);
          $stmt->bindParam(":cuit", $cuitClienteCleaned, PDO::PARAM_STR);
          $stmt->bindParam(":planta", $datos['planta'], PDO::PARAM_STR);
          $stmt->bindParam(":numeroPlanta", $datos['numeroPlanta'], PDO::PARAM_STR);
          $stmt->bindParam(":pais", $datos['pais'], PDO::PARAM_STR);
          

          $stmt->bindParam(":idCliente", $cliente['id_cliente'], PDO::PARAM_STR);

          if($stmt->execute()){
              return "ok";
          }else{
            return "error";
          }

          $stmt = null;

  }

  
  static public function mdlBorrarCliente( $idCliente ){
      
      $conn = Conexion::conectar();
      $conn->beginTransaction();
      
      $stmt = $conn->prepare("DELETE FROM clientes WHERE id_cliente = :id");          
      $stmt->bindParam(":id", $idCliente, PDO::PARAM_INT);        
      $stmt->execute();
      $stmt = null;
      

      $stmt = $conn->prepare("DELETE FROM cliente_usuarios WHERE id_cliente = :idcliente");      
      $stmt->bindParam(":idcliente", $idCliente, PDO::PARAM_INT);
      $stmt->execute();
      $stmt = null;


      $stmt = $conn->prepare("DELETE FROM usuarios WHERE cliente_id = :id");          
      $stmt->bindParam(":id", $idCliente, PDO::PARAM_INT);        
      $stmt->execute();
      $stmt = null;                        

      if($conn->commit()){
          return "ok";
      }else{
        return "error";
      }

      $stmt = null;    

  }


  static public function mdlGetClienteUsuariosHabilitados($clienteID){

       $stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios WHERE cliente_id = :clienteID AND estado = 'ACTIVADO'");

       $stmt->bindParam(":clienteID", $clienteID, PDO::PARAM_STR);      
     
       $stmt->execute();

       return $stmt->fetchAll();
  }


  static public function mdlMostrarClientes($usuarioID = null, $clienteID = null){

      //$cliente = UsuariosHelper::getClienteInfoWithUserLoggedIn();      
          
      $stmt = Conexion::conectar()->prepare("SELECT * FROM clientes ORDER BY id_cliente DESC");
     
      $stmt->execute();

      return $stmt->fetchAll();
  }



  static public function mdlVerificarSiClienteExiste($valorCUIT = null){

    // TODO buscar por CUIT

      $stmt = Conexion::conectar()->prepare("SELECT COUNT(id_cliente) AS TOTAL_CLIENTES FROM clientes WHERE cuit = :valor");
      $stmt->bindParam(":valor", $valorCUIT, PDO::PARAM_STR);
      $stmt->execute();

      return $stmt->fetch(PDO::FETCH_ASSOC);
  }



  static public function mdlMostrarClienteByID($id = null){
      
      
        $stmt = Conexion::conectar()->prepare("SELECT id_identificacion_interna, razon_social, cuit, pais, numero_planta, planta FROM clientes where id_cliente = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);    


      $stmt->execute();    

      return $stmt->fetch();
  }



  static public function mdlMostrarClienteByCUIT($cuit = null){

      //$cliente = UsuariosHelper::getClienteInfoWithUserLoggedIn();      
    
      $stmt = Conexion::conectar()->prepare("SELECT id_cliente, id_identificacion_interna, razon_social, cuit, pais, numero_planta, planta, rubro, obs FROM clientes WHERE cuit = :cuit");
      $stmt->bindParam(":cuit", $cuit, PDO::PARAM_STR);        

      $stmt->execute();    

      return $stmt->fetch();
  }


}
