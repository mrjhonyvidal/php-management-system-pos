<?php
require_once 'conexion.php';


class UsuariosModel{

  
  static public function Auth($cuit, $password){

      $stmt = Conexion::conectar()->prepare("SELECT u.id, u.nombre, u.apellido, u.usuario, u.correo, u.password, u.cliente_id, u.perfil, u.foto, u.estado, c.cuit FROM usuarios AS u, clientes AS c, cliente_usuarios AS cu
                WHERE u.id = cu.id_usuario
                AND c.id_cliente = cu.id_cliente
                AND c.cuit = :cuit
                AND u.estado = 'ACTIVADO'
                ORDER BY u.id ASC
                LIMIT 1");



      $stmt->bindParam(":cuit", $cuit, PDO::PARAM_STR);
      $stmt->execute();

      $result = $stmt->fetch();

      $stmt = null;
    

      if( $result["cuit"] == $cuit && password_verify($password, $result["password"]) ){
            $_SESSION['iniciarSession'] = "logged";
            $_SESSION['idusuario'] = $result["id"];
            $_SESSION['nombre'] = $result["nombre"];
            $_SESSION['apellido'] = $result["apellido"];
            $_SESSION['usuario'] = $result["usuario"];
            $_SESSION['correo'] = $result["correo"];
            $_SESSION['perfil'] = $result["perfil"];
            $_SESSION['foto'] = $result["foto"];
            $_SESSION['idcliente'] = $result["cliente_id"];
            $_SESSION['cuitCliente'] = $result["cuit"];

            // Set TimeZone
            date_default_timezone_set('America/Argentina/Buenos_Aires');

            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $fechaActual = $fecha . ' ' . $hora;

            self::mdlActualizarUltimaFechadeLogin($fechaActual, $result["id"]);

            return true;

          }else{
            return false;
          }
  }

  static public function mdlActivarUsuarioByCorreo($email){


      $conn = Conexion::conectar();

    
      $stmt = $conn->prepare("UPDATE usuarios SET estado = 'ACTIVADO' WHERE correo = :correo");
            
      $stmt->bindParam(":correo", $email, PDO::PARAM_STR);            
      
      if($stmt->execute()){
          return "ok";
      }else{
        return "error";
      }

      $stmt = null;
  }


  static public function mdlIngresarUsuario($datos){


      $cliente = UsuariosHelper::getClienteInfoWithUserLoggedIn();

      $conn = Conexion::conectar();
      $stmt = $conn->prepare("INSERT INTO usuarios(nombre, apellido, usuario, correo, password, cliente_id, perfil, foto, estado) VALUES (:nombre, :apellido, :usuario, :correo, :password, :cliente_id, :perfil, :foto, :estado)");


      
       $checkIfExistUsuarioInDatabase = self::mdlVerificarSiUsuarioExiste('usuario', $datos['usuario']);
       $checkIfExistEmailInDatabase = self::mdlVerificarSiUsuarioExiste('correo', $datos['correo']);

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
        $stmt->bindParam(":cliente_id", $datos['cliente'], PDO::PARAM_STR);

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

       if( UsuariosHelper::isSYSAdmin() ){
        // TODO IF SYSADMIN THIS DATA DOESN'T COME FROM THE SESSION BUT FROM A SELECT BOX
        // CHANGE THIS TO GET FROM $datos['clienteSelected']
        $stmt->bindParam(":idcliente", $datos['cliente'], PDO::PARAM_STR);

      }else{
        $stmt->bindParam(":idcliente", $cliente['id_cliente'], PDO::PARAM_STR);
      }
      



      $stmt->bindParam(":idusuario", $user_added_id, PDO::PARAM_STR);
      $resultado = $stmt->execute();
      $conn->commit();    

      if($resultado){
          return "ok";
      }else{
        return "error";
      }

      $stmt = null;

  }


  static public function mdlEditarUsuario($datos){

              
          $conn = Conexion::conectar();
          $conn->beginTransaction();
          
          
          $stmt = $conn->prepare("UPDATE usuarios SET nombre = :nombre, apellido = :apellido, usuario = :usuario, correo = :correo, correo = :correo, password = :password, cliente_id = :clienteID, perfil = :perfil, foto = :foto, estado = :estado WHERE usuario = :usuario");      
          
          $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
          $stmt->bindParam(":apellido", $datos['apellido'], PDO::PARAM_STR);
          $stmt->bindParam(":usuario", $datos['usuario'], PDO::PARAM_STR);
          $stmt->bindParam(":correo", $datos['correo'], PDO::PARAM_STR);
          $stmt->bindParam(":password", $datos['password'], PDO::PARAM_STR);
          $stmt->bindParam(":clienteID", $datos['cliente'], PDO::PARAM_STR);


          $stmt->bindParam(":perfil", $datos['perfil'], PDO::PARAM_STR);
          $stmt->bindParam(":foto", $datos['foto'], PDO::PARAM_STR);
          $stmt->bindParam(":estado", $datos['estado'], PDO::PARAM_STR);      

          $stmt->execute();          

          $stmt = null;

          $stmt = $conn->prepare("UPDATE cliente_usuarios SET id_cliente = :cliente_id WHERE id_usuario = :usuarioID");

          $stmt->bindParam(":usuarioID", $datos['usuarioID'], PDO::PARAM_STR);
          $stmt->bindParam(":cliente_id", $datos['cliente'], PDO::PARAM_STR);
          $stmt->execute();


          if($conn->commit()){
              return "ok";
          }else{
            return "error";
          }

          $stmt = null;
  }


  static public function mdlActualizarUltimaFechadeLogin($fecha, $userID){
      
      $cliente = UsuariosHelper::getClienteInfoWithUserLoggedIn();

      $conn = Conexion::conectar();
      $stmt = $conn->prepare("UPDATE usuarios SET ultimo_login = :fecha WHERE id = :usuarioid");
            
      $stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);      
      $stmt->bindParam(":usuarioid", $userID, PDO::PARAM_STR);            


      if($stmt->execute()){
          return "ok";
      }else{
        return "error";
      }

      $stmt = null;    
  }


  static public function mdlRegisterClienteAssociatedUsuario($datos){

     $conn = Conexion::conectar();

     $conn->beginTransaction();


     /*** CREATE CLIENTES ***/

      $stmt = $conn->prepare("INSERT INTO clientes (razon_social, cuit) VALUES (:razonSocial, :cuit)");
              

      $cuitClienteCleaned = str_replace('-','',$datos['cuit']);

      $stmt->bindParam(":razonSocial", $datos['razon'], PDO::PARAM_STR);
      $stmt->bindParam(":cuit", $cuitClienteCleaned, PDO::PARAM_STR);      

      $stmt->execute();
      $cliente_added_id = $conn->lastInsertId();      

      $stmt = null;


      /***   CREATE USARIOS RELATED TO CLIENTE***/
      $stmt = $conn->prepare("INSERT INTO usuarios(usuario, correo, password, cliente_id) VALUES (:usuario, :correo, :password, :cliente_id)");

    
       $checkIfExistUsuarioInDatabase = self::mdlVerificarSiUsuarioExiste('usuario', $datos['usuario']);

       $checkIfExistEmailInDatabase = self::mdlVerificarSiUsuarioExiste('correo', $datos['correo']);

      if($checkIfExistEmailInDatabase)
        return "error";

      if($checkIfExistUsuarioInDatabase)
        return "error";
    

      $stmt->bindParam(":usuario", $datos['usuario'], PDO::PARAM_STR);
      $stmt->bindParam(":correo", $datos['correo'], PDO::PARAM_STR);
      $stmt->bindParam(":password", $datos['password'], PDO::PARAM_STR);
      $stmt->bindParam(":cliente_id", $cliente_added_id, PDO::PARAM_STR);

      $stmt->execute();
      $user_added_id = $conn->lastInsertId();


      $stmt = null;


      /*** RELATE CLIENTE Y USUARIOS EN LA TABLA N:N  ***/

      $stmt = $conn->prepare("INSERT INTO cliente_usuarios (id_cliente, id_usuario) VALUES (:idcliente, :idusuario)");

      
      $stmt->bindParam(":idcliente", $cliente_added_id, PDO::PARAM_STR);
      $stmt->bindParam(":idusuario", $user_added_id, PDO::PARAM_STR);


      $resultado = $stmt->execute();

      if($conn->commit()){
          return "ok";
      }else{
        return "error";
      }

      $stmt = null;
  }


  static public function mdlBorrarUsuario( $idUser, $idCliente ){

      // this is only the case is not using AJAX Edit
      //$cliente = UsuariosHelper::getClienteInfoWithUserLoggedIn();
      $conn = Conexion::conectar();
      $conn->beginTransaction();

      if( UsuariosHelper::isSYSAdmin( $idUser, $idCliente )){
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id");
      }else{
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id AND cliente_id = :cliente_id");
      }
    
      $stmt->bindParam(":id", $idUser, PDO::PARAM_INT);      

      if( UsuariosHelper::isSYSAdmin( $idUser, $idCliente ) === false){
        $stmt->bindParam(":cliente_id", $idCliente, PDO::PARAM_STR);
      }

      $stmt->execute();
      $stmt = null;

       if( UsuariosHelper::isSYSAdmin( $idUser, $idCliente )){
          $stmt = $conn->prepare("DELETE FROM cliente_usuarios WHERE id_usuario = :idusuario");
        }else{
          $stmt = $conn->prepare("DELETE FROM cliente_usuarios WHERE id_usuario = :idusuario and id_cliente = :cliente_id");
        }

      $stmt->bindParam(":idusuario", $idUser, PDO::PARAM_INT);

      if( UsuariosHelper::isSYSAdmin( $idUser, $idCliente) === false){       
        $stmt->bindParam(":cliente_id", $idCliente, PDO::PARAM_STR);
      }

      $conn->commit();

      if($stmt->execute()){
          return "ok";
      }else{
        return "error";
      }

      $stmt = null;    

  }


  static public function mdlActivarUsuario($userStatus, $userID){

      $cliente = UsuariosHelper::getClienteInfoWithUserLoggedIn();

      $conn = Conexion::conectar();

      if( UsuariosHelper::isSYSAdmin()){
        $stmt = $conn->prepare("UPDATE usuarios SET estado = :estado WHERE id = :usuarioid");
      }else{
        $stmt = $conn->prepare("UPDATE usuarios SET estado = :estado WHERE id = :idusuario AND  cliente_id = :cliente_id");
      }
            
      $stmt->bindParam(":estado", $userStatus, PDO::PARAM_STR);      
      $stmt->bindParam(":idusuario", $userID, PDO::PARAM_STR);            

       if( UsuariosHelper::isSYSAdmin() === false){
          $stmt->bindParam(":cliente_id", $cliente['id_cliente'], PDO::PARAM_STR);
       }


      if($stmt->execute()){
          return "ok";
      }else{
        return "error";
      }

      $stmt = null;
  }


  static public function mdlMostrarUsuarios(){

      $cliente = UsuariosHelper::getClienteInfoWithUserLoggedIn();      

      if( UsuariosHelper::isSYSAdmin()){                 
        $stmt = Conexion::conectar()->prepare("SELECT usuarios.*, clientes.* FROM usuarios, clientes WHERE clientes.id_cliente = usuarios.cliente_id  ORDER BY usuarios.id DESC");
      }else{
        $stmt = Conexion::conectar()->prepare("SELECT usuarios.*, clientes.* FROM usuarios, clientes WHERE clientes.id_cliente = usuarios.cliente_id AND cliente_id = :cliente_id ORDER BY usuarios.id DESC");
      }

      if( UsuariosHelper::isSYSAdmin() === false){                 
        $stmt->bindParam(":cliente_id", $cliente['id_cliente'], PDO::PARAM_STR);
      }

      $stmt->execute();

      return $stmt->fetchAll();
  }


  static public function mdlVerificarSiUsuarioExiste($item, $valor){

    $stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios WHERE $item = :valor");
      $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
      $stmt->execute();

      return $stmt->fetch();
  }



  static public function mdlGetUserInfoFromClienteCUIT($cuit){

      $conn = Conexion::conectar();

        
        $stmt = $conn->prepare("SELECT usuarios.id, usuarios.correo, usuarios.nombre FROM usuarios LEFT JOIN clientes ON (usuarios.cliente_id = clientes.id_cliente) where clientes.cuit = :cuit AND usuarios.perfil = 'Administrador' AND usuarios.estado='ACTIVADO'");
        $stmt->bindParam(":cuit", $cuit, PDO::PARAM_STR);
      

      $stmt->execute();    

      return $stmt->fetch();

  }


  static public function mdlGetUserInfoFromCorreo($correo){

      $conn = Conexion::conectar();

        
        $stmt = $conn->prepare("SELECT * FROM usuarios where correo = :correo");
        $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
      

      $stmt->execute();    

      return $stmt->fetch();

  }


  static public function mdlUpdateRecoveryData($userID, $token, $expiration_date = null){

    $conn = Conexion::conectar();

     $stmt = $conn->prepare("UPDATE usuarios SET token_recovery = :token, date_expiration_recovery = :dateRecovery WHERE id = :id");      
          
          $stmt->bindParam(":token", $token, PDO::PARAM_STR);
          $stmt->bindParam(":dateRecovery", $expiration_date, PDO::PARAM_STR);
          $stmt->bindParam(":id", $userID, PDO::PARAM_STR);
          
          return $stmt->execute();                  
  }


  static public function mdlUpdatePassword($userID, $newPassword){     
            

      $conn = Conexion::conectar();
      $stmt = $conn->prepare("UPDATE usuarios SET password = :pass WHERE id = :id");
            
      $stmt->bindParam(":pass", $newPassword, PDO::PARAM_STR);      
      $stmt->bindParam(":id", $userID, PDO::PARAM_STR);            


      if($stmt->execute()){
          return "ok";
      }else{
        return "error";
      }

      $stmt = null;      

  }


  static public function mdlMostrarUsuario($idUser = null, $idCliente = null){
            
          
      $conn = Conexion::conectar();

        
        $stmt = $conn->prepare("SELECT usuarios.*, clientes.razon_social FROM usuarios LEFT JOIN clientes ON (usuarios.cliente_id = clientes.id_cliente) where usuarios.id = :id");
        $stmt->bindParam(":id", $idUser, PDO::PARAM_STR);
      

      $stmt->execute();    

      return $stmt->fetch();
  }


}
