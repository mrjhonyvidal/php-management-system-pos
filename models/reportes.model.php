<?php
require_once 'conexion.php';


class ClientesModel{

  
  static public function mdlIngresarReporte($datos){


      $cliente = UsuariosHelper::getClienteInfoWithUserLoggedIn();

      $conn = Conexion::conectar();
      $stmt = $conn->prepare("INSERT INTO usuarios(nombre, apellido, usuario, correo, password, cliente_id, perfil, foto, estado) VALUES (:nombre, :apellido, :usuario, :correo, :password, :cliente_id, :perfil, :foto, :estado)");


      
       $checkIfExistUsuarioInDatabase = self::mdlVerificarSiClienteExiste('cuit', $datos['cuit']);
       
      if($checkIfExistEmailInDatabase)
        return "error";

      if($checkIfExistUsuarioInDatabase)
        return "error";


      $conn->beginTransaction();
      $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
      $stmt->bindParam(":apellido", $datos['apellido'], PDO::PARAM_STR);
      $stmt->bindParam(":usuario", $datos['usuario'], PDO::PARAM_STR);
      $stmt->bindParam(":correo", $datos['correo'], PDO::PARAM_STR);
      $stmt->bindParam(":password", $datos['password'], PDO::PARAM_STR);


      if( UsuariosHelper::isSYSAdmin() ){
        // TODO IF SYSADMIN THIS DATA DOESN'T COME FROM THE SESSION BUT FROM A SELECT BOX
        // CHANGE THIS TO GET FROM $datos['clienteSelected']
        $stmt->bindParam(":cliente_id", $cliente['id_cliente'], PDO::PARAM_STR);

      }else{
        $stmt->bindParam(":cliente_id", $cliente['id_cliente'], PDO::PARAM_STR);
      }


      $stmt->bindParam(":perfil", $datos['perfil'], PDO::PARAM_STR);
      $stmt->bindParam(":foto", $datos['foto'], PDO::PARAM_STR);
      $stmt->bindParam(":estado", $datos['estado'], PDO::PARAM_STR);
      $stmt->execute();
      $user_added_id = $conn->lastInsertId();


      $stmt = null;

      $stmt = $conn->prepare("INSERT INTO cliente_usuarios (id_cliente, id_usuario) VALUES (:idcliente, :idusuario)");
      $stmt->bindParam(":idcliente", $cliente['id_cliente'], PDO::PARAM_STR);
      $stmt->bindParam(":idusuario", $user_added_id, PDO::PARAM_STR);
      $conn->commit();

      if($stmt->execute()){
          return "ok";
      }else{
        return "error";
      }

      $stmt = null;

  }


  static public function mdlEditarReporte($datos){


          $cliente = UsuariosHelper::getClienteInfoWithUserLoggedIn();    
      

          $conn = Conexion::conectar();


          if( UsuariosHelper::isSYSAdmin()){
          
            $stmt = $conn->prepare("UPDATE usuarios SET nombre = :nombre, apellido = :apellido, usuario = :usuario, correo = :correo, correo = :correo, password = :password, perfil = :perfil, foto = :foto, estado = :estado WHERE usuario = :usuario");

          }else{

            $stmt = $conn->prepare("UPDATE usuarios SET nombre = :nombre, apellido = :apellido, usuario = :usuario, correo = :correo, correo = :correo, password = :password, perfil = :perfil, foto = :foto, estado = :estado WHERE usuario = :usuario and cliente_id = :cliente_id");           
          }          
          
          $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
          $stmt->bindParam(":apellido", $datos['apellido'], PDO::PARAM_STR);
          $stmt->bindParam(":usuario", $datos['usuario'], PDO::PARAM_STR);
          $stmt->bindParam(":correo", $datos['correo'], PDO::PARAM_STR);
          $stmt->bindParam(":password", $datos['password'], PDO::PARAM_STR);


          if( UsuariosHelper::isSYSAdmin() === false){
            $stmt->bindParam(":cliente_id", $cliente['id_cliente'], PDO::PARAM_STR);              
          }           


          $stmt->bindParam(":perfil", $datos['perfil'], PDO::PARAM_STR);
          $stmt->bindParam(":foto", $datos['foto'], PDO::PARAM_STR);
          $stmt->bindParam(":estado", $datos['estado'], PDO::PARAM_STR);      

          if($stmt->execute()){
              return "ok";
          }else{
            return "error";
          }

          $stmt = null;

  }

  
  static public function mdlBorrarReporte( $datos ){

      $cliente = UsuariosHelper::getClienteInfoWithUserLoggedIn();



      $conn = Conexion::conectar();


      if( UsuariosHelper::isSYSAdmin()){
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id");
      }else{
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id AND cliente_id = :cliente_id");
      }


      $conn->beginTransaction();
      $stmt->bindParam(":id", $datos, PDO::PARAM_INT);      


      if( UsuariosHelper::isSYSAdmin() === false){
        $stmt->bindParam(":cliente_id", $cliente['id_cliente'], PDO::PARAM_STR);
      }


      $stmt->execute();

      $stmt = null;

       if( UsuariosHelper::isSYSAdmin()){
          $stmt = $conn->prepare("DELETE FROM cliente_usuarios WHERE id_usuario = :idusuario");
        }else{
          $stmt = $conn->prepare("DELETE FROM cliente_usuarios WHERE id_usuario = :idusuario and id_cliente = :cliente_id");
        }


      $stmt->bindParam(":idusuario", $datos, PDO::PARAM_INT);


      if( UsuariosHelper::isSYSAdmin() === false){       
        $stmt->bindParam(":cliente_id", $cliente['id_cliente'], PDO::PARAM_STR);
      }

      $conn->commit();

      if($stmt->execute()){
          return "ok";
      }else{
        return "error";
      }

      $stmt = null;    

  }


  
  static public function mdlMostrarReportes(){

      $cliente = UsuariosHelper::getClienteInfoWithUserLoggedIn();      

      if( UsuariosHelper::isSYSAdmin()){                 
        $stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios");
      }else{
        $stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios where cliente_id = :cliente_id");
      }

      if( UsuariosHelper::isSYSAdmin() === false){                 
        $stmt->bindParam(":cliente_id", $cliente['id_cliente'], PDO::PARAM_STR);
      }

      $stmt->execute();

      return $stmt->fetchAll();
  }


  static public function mdlVerificarSiReporteExiste($valorCUIT){

    // TODO buscar por CUIT

      $stmt = Conexion::conectar()->prepare("SELECT * FROM clientes WHERE cuit = :valor");
      $stmt->bindParam(":valor", $valorCUIT, PDO::PARAM_STR);
      $stmt->execute();

      return $stmt->fetch();
  }


  static public function mdlMostrarReporte($id){

        $cliente = UsuariosHelper::getClienteInfoWithUserLoggedIn();      

      if( UsuariosHelper::isSYSAdmin() === false){                 
        $stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios where id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);    
      }else{
        $stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios where id = :id and cliente_id = :cliente_id");
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);    
        $stmt->bindParam(":cliente_id", $cliente['id_cliente'], PDO::PARAM_STR);
      }


      $stmt->execute();    

      return $stmt->fetch();
  }


}
