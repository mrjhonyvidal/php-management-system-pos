<?php
require_once 'conexion.php';

class ConfiguracionesModel{

    static public function mdlIngresarConfiguraciones($datos = []){

            $conn = Conexion::conectar();

            $stmt = $conn->prepare("DELETE FROM configuraciones");
            $stmt->execute();
            $stmt = null;


            $stmt = $conn->prepare("INSERT INTO configuraciones (correo_from, correo_name, online_correo_provider_secret_key) VALUES (:correoFrom, :correoName, :onlineSecretKey)");


             $stmt->bindParam(":correoFrom", $datos['correoFrom'], PDO::PARAM_STR);
             $stmt->bindParam(":correoName", $datos['correoName'], PDO::PARAM_STR);
             $stmt->bindParam(":onlineSecretKey", $datos['secret_key'], PDO::PARAM_STR);
                                       

             if($stmt->execute()){
                  return "ok";
              }else{
                return "error";
              }         

      }

  static public function mdlMostrarConfiguraciones(){
    
      $stmt = Conexion::conectar()->prepare("SELECT * FROM configuraciones LIMIT 1");     
        
      $stmt->execute();

      return $stmt->fetch(PDO::FETCH_ASSOC);
  }  

}
