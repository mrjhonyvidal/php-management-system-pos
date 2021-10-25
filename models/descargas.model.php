<?php
require_once 'conexion.php';


class DescargasModel{

  
static public function mdlIngresarDescarga($datos = []){

            $conn = Conexion::conectar();

            $stmt = $conn->prepare("INSERT INTO descargas(id_carta_porte, numero_carta_porte, id_cliente, obs_calidad, descarga_bruto, descarga_tara, descarga_neto, descarga_porcentaje_merma, descarga_kilos_merma, descarga_neto_con_merma, recibo, hora_salida, dia_salida, ctg_cod_cancelacion, numero_ccctg) VALUES (:idCarta, :numCarta, :idCliente, :observacion,  :bruto, :tara, :netoSinMerma, :porcentajeMerma, :mermaTotal, :netoConMerma, :recibo, :horaSalida, :fechaSalida, :ctgCancelacion, :numeroCCCTG)");
                  
            $conn->beginTransaction();    

            /**, obs_calidad, descarga_bruto, descarga_tara, descarga_neto, descarga_porcentaje_merma, descarga_kilos_merma, descarga_neto_con_merma, recibo, hora_salida, dia_salida, ctg_cod_cancelacion

            , :observacion,  :bruto, :tara, :netoSinMerma, :porcentajeMerma, :mermaTotal, :netoConMerma, :recibo, :horaSalida, :fechaSalida, :ctgCancelacion

            */          

            $stmt->bindParam(":numCarta", $datos['numeroCartaPorte'], PDO::PARAM_STR);
                        
            $stmt->bindParam(":idCarta", $datos['nuevoIDCartaPorte'], PDO::PARAM_STR);
                

                    
            $stmt->bindParam(":idCliente", $datos['nuevoClienteID'], PDO::PARAM_STR);
            

            $stmt->bindParam(":observacion", $datos['nuevoObservaciones'], PDO::PARAM_STR);

             $stmt->bindParam(":bruto", $datos['nuevoBruto'], PDO::PARAM_STR);

            $stmt->bindParam(":tara", $datos['nuevoTara'], PDO::PARAM_STR);
            
            $stmt->bindParam(":netoSinMerma", $datos['nuevoNetoSinMerma'], PDO::PARAM_STR);

            $stmt->bindParam(":porcentajeMerma", $datos['nuevoPorcentajeMerma'], PDO::PARAM_STR);

            $stmt->bindParam(":mermaTotal", $datos['nuevoMermaTotal'], PDO::PARAM_STR);

            $stmt->bindParam(":netoConMerma", $datos['nuevoNetoConMerma'], PDO::PARAM_STR);

            $stmt->bindParam(":recibo", $datos['nuevoRecibo'], PDO::PARAM_STR);

            $stmt->bindParam(":ctgCancelacion", $datos['nuevoCTG'], PDO::PARAM_STR);

            $stmt->bindParam(":numeroCCCTG", $datos['nuevoCCCTG'], PDO::PARAM_STR);


            $stmt->bindParam(":fechaSalida", $datos['nuevoFechaSalida'], PDO::PARAM_STR);

             $stmt->bindParam(":horaSalida", $datos['nuevoHoraSalida'], PDO::PARAM_STR);
             
             
             $stmt->execute();
             //$stmt = null;
      

            $stmt = $conn->prepare("UPDATE cartas_porte SET fecha_descarga = :fechaSalida, calidad = :calidad, estado = :estado WHERE numero_carta_porte = :numeroCartaPorte");

            $estado = 'DESCARGADO';
            
            $stmt->bindParam(":fechaSalida", $datos['nuevoFechaSalida'], PDO::PARAM_STR);
            $stmt->bindParam(":calidad", $datos['nuevoCalidad'], PDO::PARAM_STR);
            $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
            $stmt->bindParam(":numeroCartaPorte", $datos['numeroCartaPorte'], PDO::PARAM_STR);
            $stmt->execute();
            $stmt = null;
            

            $final_response = true;

     
            $conn->commit();
            
            if($final_response){
                return "ok";                
            }else{
              return "error";
            }
  }


  static public function mdlEditarDescarga($datos){


          $cliente = UsuariosHelper::getClienteInfoWithUserLoggedIn();    
      

          $conn = Conexion::conectar();
          
          
          $stmt = $conn->prepare("UPDATE descargas SET numero_carta_porte = :numCarta, id_cliente = :IDCliente, obs_calidad = :ObsCalidad, descarga_bruto = :descargaBruto, descarga_tara = :descargaTara, descarga_neto = :descargaNeto, descarga_porcentaje_merma = :descargaPorcentajeMerma, descarga_kilos_merma = :descargaKilosMerma, descarga_neto_con_merma = :descargaNetoConMerma, recibo = :recibo, hora_salida = :horaSalida, dia_salida = :diaSalida, ctg_cod_cancelacion = :ctgCodCancelacion, numero_ccctg = :numeroCCCTG WHERE numero_carta_porte = :numCarta");

          $conn->beginTransaction();

          
          $stmt->bindParam(":IDCliente", $datos['nuevoClienteID'], PDO::PARAM_STR);
          $stmt->bindParam(":ObsCalidad", $datos['nuevoObservaciones'], PDO::PARAM_STR);
          $stmt->bindParam(":descargaBruto", $datos['nuevoBruto'], PDO::PARAM_STR);
          $stmt->bindParam(":descargaTara", $datos['nuevoTara'], PDO::PARAM_STR);

          $stmt->bindParam(":descargaNeto", $datos['nuevoNetoSinMerma'], PDO::PARAM_STR);

          $stmt->bindParam(":descargaPorcentajeMerma", $datos['nuevoPorcentajeMerma'], PDO::PARAM_STR);

          $stmt->bindParam(":descargaKilosMerma", $datos['nuevoMermaTotal'], PDO::PARAM_STR);
          $stmt->bindParam(":descargaNetoConMerma", $datos['nuevoNetoConMerma'], PDO::PARAM_STR);
          $stmt->bindParam(":recibo", $datos['nuevoRecibo'], PDO::PARAM_STR);

          $stmt->bindParam(":horaSalida", $datos['nuevoHoraSalida'], PDO::PARAM_STR);

          $stmt->bindParam(":diaSalida", $datos['nuevoFechaSalida'], PDO::PARAM_STR);
          
          $stmt->bindParam(":ctgCodCancelacion", $datos['nuevoCTG'], PDO::PARAM_STR);
          $stmt->bindParam(":numeroCCCTG", $datos['nuevoCCCTG'], PDO::PARAM_STR);


          $stmt->bindParam(":numCarta", $datos['numeroCartaPorte'], PDO::PARAM_STR);

          $stmt->execute();
          $stmt = null;


           $stmt = $conn->prepare("UPDATE cartas_porte SET fecha_descarga = :fechaSalida, calidad = :calidad, estado = :estado WHERE numero_carta_porte = :numeroCartaPorte");

            $estado = 'DESCARGADO';
            
            $stmt->bindParam(":fechaSalida", $datos['nuevoFechaSalida'], PDO::PARAM_STR);
            $stmt->bindParam(":calidad", $datos['nuevoCalidad'], PDO::PARAM_STR);
            $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
            $stmt->bindParam(":numeroCartaPorte", $datos['numeroCartaPorte'], PDO::PARAM_STR);

           $stmt->execute();
           $final_response = true;

           $conn->commit();
          
          if($final_response){
              return "ok";
          }else{
            return "error";
          }

          $stmt = null;

  }

  
  static public function mdlBorrarDescarga( $numeroCarta, $clienteID = null, $cuitCliente = null ){
      

      $conn = Conexion::conectar();

      if( UsuariosHelper::isSYSAdmin(null, $clienteID)){
        $stmt = $conn->prepare("DELETE FROM descargas WHERE numero_carta_porte = :numCarta");
      }

      $stmt->bindParam(":numCarta", $numeroCarta, PDO::PARAM_INT);        

      if($stmt->execute()){
          return "ok";
      }else{
        return "error";
      }

      $stmt = null;    

  }


  static public function mdlCheckIfExistDescarga($numeroCarta){

      $stmt = Conexion::conectar()->prepare("SELECT COUNT(numero_carta_porte) AS TOTAL_CARTA_DESCARGAS FROM descargas WHERE numero_carta_porte = :numCarta");
      
      $stmt->bindParam(":numCarta", $numeroCarta, PDO::PARAM_STR);

      $stmt->execute();

      return $stmt->fetch(PDO::FETCH_ASSOC);

  }


  static public function mdlMostrarDescargas($idUser = null, $idCliente = null, $cuitCliente = null){

      // Desde User Authenticated
      //$cliente = UsuariosHelper::getClienteInfoWithUserLoggedIn();

      if( UsuariosHelper::isSYSAdmin($idUser, $idCliente)){          
        $stmt = Conexion::conectar()->prepare("SELECT descargas.numero_carta_porte, descargas.dia_salida, descargas.hora_salida, cartas_porte.cuit_titular_carta_porte, cartas_porte.calidad FROM descargas LEFT JOIN cartas_porte ON (cartas_porte.id_carta_porte = descargas.id_carta_porte)");
      }else{
        $stmt = Conexion::conectar()->prepare("SELECT descargas.numero_carta_porte, descargas.dia_salida, descargas.hora_salida, cartas_porte.cuit_titular_carta_porte, cartas_porte.calidad FROM descargas LEFT JOIN cartas_porte ON (cartas_porte.id_carta_porte = descargas.id_carta_porte) WHERE cartas_porte.cuit_titular_carta_porte = :cuitCliente OR cartas_porte.cuit_corredor = :cuitCliente OR cartas_porte.cuit_entregador = :cuitCliente OR cartas_porte.cuit_destino = :cuitCliente OR cartas_porte.cuit_molca_posterior = :cuitCliente OR cartas_porte.cuit_empresa_transportista = :cuitCliente OR cartas_porte.cuit_procedencia = :cuitCliente OR cartas_porte.cuit_intermediario = :cuitCliente OR cartas_porte.cuit_remitente = :cuitCliente");
      }

      if( UsuariosHelper::isSYSAdmin($idUser, $idCliente) === false){            
        $stmt->bindParam(":cuitCliente", $cuitCliente, PDO::PARAM_STR);
      }
      

      $stmt->execute();

      return $stmt->fetchAll();
  }



  static public function mdlMostrarDescarga($cartaNumero, $idCliente, $CUITCliente){
        

       if( UsuariosHelper::isSYSAdmin(null, $idCliente)){                     
        
        $stmt = Conexion::conectar()->prepare("SELECT descargas.id_carta_porte, descargas.numero_carta_porte, descargas.id_cliente, descargas.obs_calidad, descargas.descarga_bruto, descargas.descarga_tara, descargas.descarga_neto, descargas.descarga_porcentaje_merma, descargas.descarga_kilos_merma, descargas.descarga_neto_con_merma, descargas.recibo, descargas.hora_salida, descargas.dia_salida, descargas.ultima_modificacion, descargas.ctg_cod_cancelacion, descargas.numero_ccctg, cartas_porte.cuit_titular_carta_porte, cartas_porte.razon_social_titular, cartas_porte.calidad, cartas_porte.titular_interno_id FROM descargas LEFT JOIN cartas_porte ON (descargas.numero_carta_porte = cartas_porte.numero_carta_porte) WHERE descargas.numero_carta_porte = :cartaNum");
        $stmt->bindParam(":cartaNum", $cartaNumero, PDO::PARAM_STR);    

      }else{
        
        $stmt = Conexion::conectar()->prepare("SELECT descargas.id_carta_porte, descargas.numero_carta_porte, descargas.id_cliente, descargas.obs_calidad, descargas.descarga_bruto, descargas.descarga_tara, descargas.descarga_neto, descargas.descarga_porcentaje_merma, descargas.descarga_kilos_merma, descargas.descarga_neto_con_merma, descargas.recibo, descargas.hora_salida, descargas.dia_salida, descargas.ultima_modificacion, descargas.ctg_cod_cancelacion, descargas.numero_ccctg, cartas_porte.cuit_titular_carta_porte, cartas_porte.razon_social_titular, cartas_porte.calidad, cartas_porte.titular_interno_id FROM descargas LEFT JOIN cartas_porte ON (descargas.numero_carta_porte = cartas_porte.numero_carta_porte) WHERE descargas.numero_carta_porte = :cartaNum AND (cartas_porte.cuit_titular_carta_porte = :cuitCliente OR cartas_porte.cuit_corredor = :cuitCliente OR cartas_porte.cuit_entregador = :cuitCliente OR cartas_porte.cuit_destino = :cuitCliente OR cartas_porte.cuit_molca_posterior = :cuitCliente OR cartas_porte.cuit_empresa_transportista = :cuitCliente OR cartas_porte.cuit_procedencia = :cuitCliente OR cartas_porte.cuit_intermediario = :cuitCliente OR cartas_porte.cuit_remitente = :cuitCliente)");

        $stmt->bindParam(":cartaNum", $cartaNumero, PDO::PARAM_STR);    
        $stmt->bindParam(":cuitCliente", $CUITCliente, PDO::PARAM_STR);
      }


      $stmt->execute();    

      return $stmt->fetch();
  }


}
