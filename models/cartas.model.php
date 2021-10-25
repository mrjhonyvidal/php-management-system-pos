<?php
require_once 'conexion.php';

class CartasModel{


 static public function mdlImportarCartaFromCSV($datos, $headers){

      $cliente = UsuariosHelper::getClienteInfoWithUserLoggedIn();
      
      $conn = Conexion::conectar();
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $headers_utilizados = array_filter($headers, 'strlen'); 
      $cols = array();      
              
        for($i = 0; $i < count($datos); $i++){                                  
          // Fecha_descarga se encuentra en la posición 3 en el CSV importador            
          // Transforma la fecha de String ddmmYYYY a Date YYYY-mm-dd                              
          if($i == 2)
            $datos[2] = $datos[$i] = FechasHelper::transformaFechaStringToDate($datos[$i]);
          
          if(preg_match('/-/', $datos[$i])){
            $datos[$i] = trim(str_replace('-','',$datos[$i]));  
          }          

          $cols[] = "'" . $datos[$i] . "'";          
      }        
      
      // Concatena las columnas para que se pueda insertar en la tabla de Cartas
      $colsInSQLValueFormat = implode(",", $cols);     
            
      $conn->beginTransaction();
      
      $stmt = $conn->prepare("INSERT IGNORE INTO cartas_porte(id_cliente, grano, cosecha, fecha_descarga, fecha_descarga_2, cuit_destino, razon_social_destino, cuit_molca_posterior, molca_posterior, cuit_titular_carta_porte, razon_social_titular, molca_anterior, razon_social_intermediario, cuit_remitente, razon_remitente, molca, codigo_postal_destino, localidad_destino, tipo_entrega, bruto, tara, neto_sin_merma, merma_total, neto_con_merma, porcentaje_humedad, porcentaje_merma_humedad, descarga_kilo_por_humedad, porcentaje_zaranda, descarga_kilo_zaranda, fumigada, neto_procencia, numero_carta_porte, tipo_de_transporte, observaciones_carta_porte, cuit_empresa_transportista, razon_social_transportista, numero_ctg, procedencia, patente_chasis, observaciones_calidad, estado, corredor_comprador, cuit_entregador, razon_entregador, turno, hora_ingreso) VALUES (" . $cliente['id_cliente'] . "," . $colsInSQLValueFormat . ")");

      $resultado = $stmt->execute();
      $carta_added_id = $conn->lastInsertId();
      $stmt = null;

      if($carta_added_id){
          //check if the CUIT of Titular exist en la tabla cliente comparing with just added Carta Data CUIT Titular
          $stmt = $conn->prepare("SELECT id_cliente, cuit FROM clientes WHERE cuit = (SELECT cuit_titular_carta_porte FROM cartas_porte WHERE id_carta_porte=" .$carta_added_id . ")");

          $stmt->execute();

          $cartaClientCUITExistInClientesDB = $stmt->fetch();
          $stmt = null;      

          // if Exist then update with Cliente ID
          if ($cartaClientCUITExistInClientesDB['cuit'] != null){
              $stmt = $conn->prepare("UPDATE cartas_porte SET id_cliente =" . $cartaClientCUITExistInClientesDB['id_cliente'] . " WHERE cuit_titular_carta_porte = " . $cartaClientCUITExistInClientesDB['cuit']);            

              $resultado = $stmt->execute();                          

          }else{

            $stmt = $conn->prepare("SELECT razon_social_titular, cuit_titular_carta_porte FROM cartas_porte WHERE id_carta_porte = " . $carta_added_id);
            $stmt->execute();
            $datos_cliente_from_carta = $stmt->fetch();  
            $stmt = null;                               
            // If not exist then add new Cliente With information in Carta Porte and then update CartaPorte with lasted Cliente ID added   
            $stmt = $conn->prepare("INSERT IGNORE INTO clientes(razon_social, cuit) VALUES (:razon, :cuitCarta)");        
            $stmt->bindParam(":razon", $datos_cliente_from_carta['razon_social_titular'], PDO::PARAM_STR);
            $cuitCleaned = str_replace('-','',$datos_cliente_from_carta['cuit_titular_carta_porte']);
            $stmt->bindParam(":cuitCarta", $cuitCleaned, PDO::PARAM_STR); 

            $resultado = $stmt->execute();
            //then update CartaPorte with lasted Cliente ID added
            $cliente_added_id = $conn->lastInsertId();
            $stmt = null;       

            $stmt = $conn->prepare("UPDATE cartas_porte SET id_cliente = " . $cliente_added_id . " WHERE cuit_titular_carta_porte = " . $datos_cliente_from_carta['cuit_titular_carta_porte']);            

            $resultado = $stmt->execute();          
          }
      }
      
      $conn->commit();
          
        if($resultado){          
          $stmt = null;

          return true;
        }else{
          return false;  
        }      
  }
 
 static public function mdlIngresarCarta($datos, $imagenesEscaneadas = [], $clienteID = null, $userID = null){

            $cuitCleaned = $datos['CUITCartaPorteTitular'];            
            $razon = $datos['razonTitular'];
            $numberPlanta = $datos['numPlantaTitular'];
            $namePlantaTitular = $datos['plantaTitular'];
            // Look if Cliente exists in Table Cliente otherwise CREATE A NEW ONE
            $clienteID = self::getOrAddClient($cuitCleaned, $razon, $numberPlanta, $namePlantaTitular);
            
            $conn = Conexion::conectar();            

            $stmt = $conn->prepare("INSERT INTO cartas_porte(numero_carta_porte, id_cliente, cuit_entregador, razon_entregador, contrato, procedencia_kilo_bruto, hora_ingreso, codigo_puerto, puerto, fecha_descarga, cuit_destino, razon_social_destino, cuit_titular_carta_porte, razon_social_titular, razon_social_intermediario, numero_planta_titular, planta_titular, numero_planta_intermediario, numero_planta_remitente, planta_remitente, planta_intermediario, titular_atencion_entrega, titular_atencion_exportacion, intermediario_atencion_entrega, intermediario_atencion_exportacion, remitente_atencion_entrega, remitente_atencion_exportacion, cuit_corredor, razon_corredor, localidad_destino, tipo_entrega, bruto, tara, neto_sin_merma, merma_total, neto_con_merma, neto_procencia, observaciones_carta_porte, cuit_empresa_transportista, razon_social_transportista, numero_ctg, patente_chasis, calidad, estado, mercaderia_id, nombre_mercaderia, cuit_intermediario, cuit_remitente, razon_remitente, turno, entregador_id, remitente_id, intermediario_id, titular_interno_id, procedencia_tara, localidad_procedencia, corredor_comprador, numero_ccctg) VALUES (:numeroCartaPorte, :idCliente, :cuitEntregador, :razonEntregador, :contrato, :procedenciaKiloBruto, :horaIngreso, :codigoPuerto, :puerto, :fechaDescarga, :cuitDestino, :razonSocialDestino, :cuitTitular, :razonSocialTitular, :razonSocialIntermediario, :numeroPlantaTitular, :plantaTitular, :numeroPlantaIntermediario, :numeroPlantaRemitente, :plantaRemitente, :plantaIntermediario, :titularAtencionEntrega, :titularAtencionExportacion, :intermediarioAtencionEntrega, :intermediarioAtencionExportacion,
              :remitenteAtencionEntrega, :remitenteAtencionExportacion, :cuitCorredor, :razonCorredor, :localidadDestino, :tipoEntrega, :bruto, :tara, :netoSinMerma, :mermaTotal, :netoConMerma, :netoProcencia, :observacionesCartaPorte, :cuitEmpresaTransportista, :razonSocialTransportista, :numeroCTG, :patenteChasis, :calidad, :estado, :mercaderia_id, :nombre_mercaderia, :cuitIntermediario, :cuitRemitente, :razonRemitenteComercial, :turnoCarta, :entregadorID, :remitenteID, :intermediarioID, :titularInternoID, :procedenciaTara, :localidadProcedencia, :corredorComprador, :numeroCCCTG)");        

            $conn->beginTransaction();    

            $stmt->bindParam(":numeroCartaPorte", $datos['numeroCartaInterno'], PDO::PARAM_STR);                        
            $stmt->bindParam(":cuitTitular", $datos['CUITCartaPorteTitular'], PDO::PARAM_STR);        
            $stmt->bindParam(":procedenciaKiloBruto", $datos['procedenciaBruto'], PDO::PARAM_STR);
            $stmt->bindParam(":netoProcencia", $datos['procedenciaNeto'], PDO::PARAM_STR);
            $stmt->bindParam(":procedenciaTara", $datos['procedenciaTara'], PDO::PARAM_STR);              
            $stmt->bindParam(":idCliente", $clienteID, PDO::PARAM_STR);
            $stmt->bindParam(":cuitEntregador", $datos['CUITEntregador'], PDO::PARAM_STR);
            $stmt->bindParam(":razonEntregador", $datos['razonEntregador'], PDO::PARAM_STR);
            $stmt->bindParam(":contrato", $datos['contrato'], PDO::PARAM_STR);
            $stmt->bindParam(":bruto", $datos['kiloMercaderiaBruto'], PDO::PARAM_STR);
            $stmt->bindParam(":tara", $datos['tara'], PDO::PARAM_STR);
            $stmt->bindParam(":netoSinMerma", $datos['netoSinMerma'], PDO::PARAM_STR);
            $stmt->bindParam(":mermaTotal", $datos['mermaTotal'], PDO::PARAM_STR);
            $stmt->bindParam(":netoConMerma", $datos['netoConMerma'], PDO::PARAM_STR);
            $stmt->bindParam(":fechaDescarga", $datos['fechaDescarga'], PDO::PARAM_STR);
            $stmt->bindParam(":horaIngreso", $datos['horaIngreso'], PDO::PARAM_STR);
            $stmt->bindParam(":codigoPuerto", $datos['puertoCOD'], PDO::PARAM_STR);
            $stmt->bindParam(":puerto", $datos['nombrePuerto'], PDO::PARAM_STR);
            $stmt->bindParam(":cuitDestino", $datos['CUITDestinatario'], PDO::PARAM_STR);
            $stmt->bindParam(":razonSocialDestino", $datos['razonDestinatario'], PDO::PARAM_STR);
            $stmt->bindParam(":cuitTitular", $datos['CUITCartaPorteTitular'], PDO::PARAM_STR);
            $stmt->bindParam(":razonSocialTitular", $datos['razonTitular'], PDO::PARAM_STR);
            $stmt->bindParam(":razonSocialIntermediario", $datos['razonIntermediario'], PDO::PARAM_STR);
            $stmt->bindParam(":numeroPlantaTitular", $datos['numPlantaTitular'], PDO::PARAM_STR);
            $stmt->bindParam(":plantaTitular", $datos['plantaTitular'], PDO::PARAM_STR);
            $stmt->bindParam(":numeroPlantaIntermediario", $datos['numPlantaIntermediario'], PDO::PARAM_STR);
            $stmt->bindParam(":numeroPlantaRemitente", $datos['numPlantaRemitente'], PDO::PARAM_STR);
            $stmt->bindParam(":plantaRemitente", $datos['plantaRemitente'], PDO::PARAM_STR);
            $stmt->bindParam(":plantaIntermediario", $datos['plantaIntermediario'], PDO::PARAM_STR);
            $stmt->bindParam(":titularAtencionEntrega", $datos['checkboxEntrPlantaTitular'], PDO::PARAM_STR);
            $stmt->bindParam(":titularAtencionExportacion", $datos['checkboxExpPlantaTitular'], PDO::PARAM_STR);
            $stmt->bindParam(":intermediarioAtencionEntrega", $datos['checkboxEntrPlantaIntermediario'], PDO::PARAM_STR);
            $stmt->bindParam(":intermediarioAtencionExportacion", $datos['checkboxExpPlantaIntermediario'], PDO::PARAM_STR);   
            $stmt->bindParam(":remitenteAtencionEntrega", $datos['checkboxEntrPlantaRemitente'], PDO::PARAM_STR);
            $stmt->bindParam(":remitenteAtencionExportacion", $datos['checkboxExpPlantaRemitente'], PDO::PARAM_STR);   
            $stmt->bindParam(":cuitCorredor", $datos['CUITCorredor'], PDO::PARAM_STR); 
            $stmt->bindParam(":razonCorredor", $datos['razonCorredor'], PDO::PARAM_STR);
            $stmt->bindParam(":corredorComprador", $datos['corredorComprador'], PDO::PARAM_STR);
            $stmt->bindParam(":localidadProcedencia", $datos['localidadProcfedencia'], PDO::PARAM_STR);
            $stmt->bindParam(":numeroCTG", $datos['numeroCTG'], PDO::PARAM_STR);
            $stmt->bindParam(":numeroCCCTG", $datos['numeroCCCTG'], PDO::PARAM_STR);      
            $stmt->bindParam(":localidadDestino", $datos['localidadDestino'], PDO::PARAM_STR);
            $stmt->bindParam(":tipoEntrega", $datos['tipoEntrega'], PDO::PARAM_STR);
            $stmt->bindParam(":observacionesCartaPorte", $datos['observaciones'], PDO::PARAM_STR);
            $stmt->bindParam(":cuitEmpresaTransportista", $datos['CUITTransportista'], PDO::PARAM_STR);
            $stmt->bindParam(":razonSocialTransportista", $datos['razonTransportista'], PDO::PARAM_STR);
            $stmt->bindParam(":patenteChasis", $datos['patente'], PDO::PARAM_STR);
            $stmt->bindParam(":calidad", $datos['calidad'], PDO::PARAM_STR);
            $stmt->bindParam(":estado", $datos['situacion'], PDO::PARAM_STR);
            $stmt->bindParam(":mercaderia_id", $datos['IDMercaderia'], PDO::PARAM_STR);
            $stmt->bindParam(":nombre_mercaderia", $datos['nombreMercaderia'], PDO::PARAM_STR);      
            $stmt->bindParam(":cuitIntermediario", $datos['CUITIntermediario'], PDO::PARAM_STR);            
            $stmt->bindParam(":cuitRemitente", $datos['CUITRemitenteComercial'], PDO::PARAM_STR);
            $stmt->bindParam(":razonRemitenteComercial", $datos['razonRemitente'], PDO::PARAM_STR);      
            $stmt->bindParam(":turnoCarta", $datos['turno'], PDO::PARAM_STR);
            $stmt->bindParam(":entregadorID", $datos['IDEntregador'], PDO::PARAM_STR);
            $stmt->bindParam(":remitenteID", $datos['IDInternoRemitente'], PDO::PARAM_STR);
            $stmt->bindParam(":intermediarioID", $datos['IDInternoIntermediario'], PDO::PARAM_STR);
            $stmt->bindParam(":titularInternoID", $datos['IDInternoTitular'], PDO::PARAM_STR);
                      
            $final_response = $stmt->execute();
            $carta_added_id = $conn->lastInsertId();

            $stmt = null;                        

            for($i = 0; $i < count($imagenesEscaneadas); $i++){

              $stmt = $conn->prepare("INSERT INTO carta_porte_imagenes (id_cliente, id_carta, imagen_archivo) VALUES (:idcliente, :idcarta, :imagen)");
              
              $stmt->bindParam(":idcliente", $clienteID, PDO::PARAM_STR);
              $stmt->bindParam(":idcarta", $carta_added_id, PDO::PARAM_STR);
              $stmt->bindParam(":imagen", $imagenesEscaneadas[$i], PDO::PARAM_STR);
              $stmt->execute();
              $stmt = null;

              $final_response = true;

            }        
            //$final_response = true;                    
            $conn->commit();
            
            if($final_response){
                return "ok";                
            }else{
              return "error";
            }

  }

  static public function mdlEditarCarta($datos, $imagenesEscaneadas = [], $clienteID = null, $userID = null){

          $cliente = UsuariosHelper::getClienteInfoWithUserLoggedIn();          
          $conn = Conexion::conectar();
                
            $stmt = $conn->prepare("UPDATE cartas_porte SET numero_carta_porte = :numeroCartaPorte, id_cliente = :idCliente, cuit_entregador = :cuitEntregador, razon_entregador = :razonEntregador, contrato = :contrato, procedencia_kilo_bruto = :procedenciaKiloBruto, fecha_descarga = :fechaDescarga, hora_ingreso = :horaIngreso, codigo_puerto = :codigoPuerto, puerto = :puerto, cuit_destino = :cuitDestino, razon_social_destino = :razonSocialDestino, cuit_titular_carta_porte = :cuitTitular, razon_social_titular = :razonSocialTitular, razon_social_intermediario = :razonSocialIntermediario, numero_planta_titular = :numeroPlantaTitular,  planta_titular = :plantaTitular, numero_planta_intermediario = :numeroPlantaIntermediario, numero_planta_remitente = :numeroPlantaRemitente, planta_remitente = :plantaRemitente, planta_intermediario = :plantaIntermediario, titular_atencion_entrega = :titularAtencionEntrega, titular_atencion_exportacion = :titularAtencionExportacion, intermediario_atencion_entrega = :intermediarioAtencionEntrega, intermediario_atencion_exportacion = :intermediarioAtencionExportacion, remitente_atencion_entrega = :remitenteAtencionEntrega, remitente_atencion_exportacion = :remitenteAtencionExportacion, cuit_corredor = :cuitCorredor, razon_corredor = :razonCorredor, localidad_destino = :localidadDestino, tipo_entrega = :tipoEntrega, bruto = :bruto, tara = :tara, neto_sin_merma = :netoSinMerma, merma_total = :mermaTotal, neto_con_merma = :netoConMerma, neto_procencia = :netoProcencia, observaciones_carta_porte = :observacionesCartaPorte, cuit_empresa_transportista = :cuitEmpresaTransportista, razon_social_transportista = :razonSocialTransportista, numero_ctg = :numeroCTG, patente_chasis = :patenteChasis, calidad = :calidad, estado = :estado, mercaderia_id = :mercaderia_id, nombre_mercaderia = :nombre_mercaderia, cuit_intermediario = :cuitIntermediario, cuit_remitente = :cuitRemitente, razon_remitente = :razonRemitenteComercial, turno = :turnoCarta, entregador_id = :entregadorID, remitente_id = :remitenteID, intermediario_id = :intermediarioID, titular_interno_id = :titularInternoID, procedencia_tara = :procedenciaTara, localidad_procedencia = :localidadProcedencia ,corredor_comprador = :corredorComprador, numero_ccctg = :numeroCCCTG WHERE id_carta_porte = :cartaID");        
          
           $conn->beginTransaction();   

            $stmt->bindParam(":numeroCartaPorte", $datos['numeroCartaInterno'], PDO::PARAM_STR);                      
            $stmt->bindParam(":cuitTitular", $datos['CUITCartaPorteTitular'], PDO::PARAM_STR);        
            $stmt->bindParam(":procedenciaKiloBruto", $datos['procedenciaBruto'], PDO::PARAM_STR);
            $stmt->bindParam(":netoProcencia", $datos['procedenciaNeto'], PDO::PARAM_STR);
            $stmt->bindParam(":procedenciaTara", $datos['procedenciaTara'], PDO::PARAM_STR);                      
            $stmt->bindParam(":idCliente", $datos["clienteID"], PDO::PARAM_STR);
            $stmt->bindParam(":cuitEntregador", $datos['CUITEntregador'], PDO::PARAM_STR);
            $stmt->bindParam(":razonEntregador", $datos['razonEntregador'], PDO::PARAM_STR);
            $stmt->bindParam(":contrato", $datos['contrato'], PDO::PARAM_STR);          
            $stmt->bindParam(":localidadProcedencia", $datos['localidadProcedencia'], PDO::PARAM_STR);
            $stmt->bindParam(":bruto", $datos['kiloMercaderiaBruto'], PDO::PARAM_STR);            
            $stmt->bindParam(":tara", $datos['tara'], PDO::PARAM_STR);
            $stmt->bindParam(":netoSinMerma", $datos['netoSinMerma'], PDO::PARAM_STR);
            $stmt->bindParam(":mermaTotal", $datos['mermaTotal'], PDO::PARAM_STR);
            $stmt->bindParam(":netoConMerma", $datos['netoConMerma'], PDO::PARAM_STR);  
            $stmt->bindParam(":fechaDescarga", $datos['fechaDescarga'], PDO::PARAM_STR);
            $stmt->bindParam(":horaIngreso", $datos['horaIngreso'], PDO::PARAM_STR);
            $stmt->bindParam(":codigoPuerto", $datos['puertoCOD'], PDO::PARAM_STR);
            $stmt->bindParam(":puerto", $datos['nombrePuerto'], PDO::PARAM_STR);
            $stmt->bindParam(":cuitDestino", $datos['CUITDestinatario'], PDO::PARAM_STR);
            $stmt->bindParam(":razonSocialDestino", $datos['razonDestinatario'], PDO::PARAM_STR);
            $stmt->bindParam(":cuitTitular", $datos['CUITCartaPorteTitular'], PDO::PARAM_STR);
            $stmt->bindParam(":razonSocialTitular", $datos['razonTitular'], PDO::PARAM_STR);
            $stmt->bindParam(":razonSocialIntermediario", $datos['razonIntermediario'], PDO::PARAM_STR);
            $stmt->bindParam(":numeroPlantaTitular", $datos['numPlantaTitular'], PDO::PARAM_STR);
            $stmt->bindParam(":plantaTitular", $datos['plantaTitular'], PDO::PARAM_STR);
            $stmt->bindParam(":numeroPlantaIntermediario", $datos['numPlantaIntermediario'], PDO::PARAM_STR);
            $stmt->bindParam(":numeroPlantaRemitente", $datos['numPlantaRemitente'], PDO::PARAM_STR);
            $stmt->bindParam(":plantaRemitente", $datos['plantaRemitente'], PDO::PARAM_STR);
            $stmt->bindParam(":plantaIntermediario", $datos['plantaIntermediario'], PDO::PARAM_STR);
            $stmt->bindParam(":titularAtencionEntrega", $datos['checkboxEntrPlantaTitular'], PDO::PARAM_STR);
            $stmt->bindParam(":titularAtencionExportacion", $datos['checkboxExpPlantaTitular'], PDO::PARAM_STR);
            $stmt->bindParam(":intermediarioAtencionEntrega", $datos['checkboxEntrPlantaIntermediario'], PDO::PARAM_STR);
            $stmt->bindParam(":intermediarioAtencionExportacion", $datos['checkboxExpPlantaIntermediario'], PDO::PARAM_STR);   
            $stmt->bindParam(":remitenteAtencionEntrega", $datos['checkboxEntrPlantaRemitente'], PDO::PARAM_STR);
            $stmt->bindParam(":remitenteAtencionExportacion", $datos['checkboxExpPlantaRemitente'], PDO::PARAM_STR);   
            $stmt->bindParam(":cuitCorredor", $datos['CUITCorredor'], PDO::PARAM_STR); 
            $stmt->bindParam(":razonCorredor", $datos['razonCorredor'], PDO::PARAM_STR);
            $stmt->bindParam(":corredorComprador", $datos['corredorComprador'], PDO::PARAM_STR);
            $stmt->bindParam(":numeroCTG", $datos['numeroCTG'], PDO::PARAM_STR);
            $stmt->bindParam(":numeroCCCTG", $datos['numeroCCCTG'], PDO::PARAM_STR);          
            $stmt->bindParam(":localidadDestino", $datos['localidadDestino'], PDO::PARAM_STR);
            $stmt->bindParam(":tipoEntrega", $datos['tipoEntrega'], PDO::PARAM_STR);
            //$stmt->bindParam(":netoProcencia", $datos['kiloNeto'], PDO::PARAM_STR);
            $stmt->bindParam(":observacionesCartaPorte", $datos['observaciones'], PDO::PARAM_STR);
            $stmt->bindParam(":cuitEmpresaTransportista", $datos['CUITTransportista'], PDO::PARAM_STR);
            $stmt->bindParam(":razonSocialTransportista", $datos['razonTransportista'], PDO::PARAM_STR);
            //$stmt->bindParam(":cuitProcedencia", $datos['CUITProcedencia'], PDO::PARAM_STR);
            //$stmt->bindParam(":procedencia", $datos['razonProcedencia'], PDO::PARAM_STR);
            $stmt->bindParam(":patenteChasis", $datos['patente'], PDO::PARAM_STR);
            $stmt->bindParam(":calidad", $datos['calidad'], PDO::PARAM_STR);
            $stmt->bindParam(":estado", $datos['situacion'], PDO::PARAM_STR);
            $stmt->bindParam(":mercaderia_id", $datos['IDMercaderia'], PDO::PARAM_STR);
            $stmt->bindParam(":nombre_mercaderia", $datos['nombreMercaderia'], PDO::PARAM_STR);      
            $stmt->bindParam(":cuitIntermediario", $datos['CUITIntermediario'], PDO::PARAM_STR);            
            $stmt->bindParam(":cuitRemitente", $datos['CUITRemitenteComercial'], PDO::PARAM_STR);
            $stmt->bindParam(":razonRemitenteComercial", $datos['razonRemitente'], PDO::PARAM_STR);      
            $stmt->bindParam(":turnoCarta", $datos['turno'], PDO::PARAM_STR);
            $stmt->bindParam(":entregadorID", $datos['IDEntregador'], PDO::PARAM_STR);
            $stmt->bindParam(":remitenteID", $datos['IDInternoRemitente'], PDO::PARAM_STR);
            $stmt->bindParam(":intermediarioID", $datos['IDInternoIntermediario'], PDO::PARAM_STR);          
            $stmt->bindParam(":titularInternoID", $datos['IDInternoTitular'], PDO::PARAM_STR);  
            $stmt->bindParam(":cartaID", $datos["cartaID"], PDO::PARAM_STR);

            $final_response = $stmt->execute();            

            $stmt = null;                        
  
            //UPDATE CLIENTE ID OF DESCARGA IN CASE IT CHANGED THIS WAY WE DON'T LOSE TRACK OF NUMCARTA AND DESCARGA OWNER

            $stmt = $conn->prepare("UPDATE descargas SET id_cliente = :IDCliente WHERE numero_carta_porte = :numCarta");
            $stmt->bindParam(":IDCliente", $datos["clienteID"], PDO::PARAM_STR);
            $stmt->bindParam(":numCarta", $datos['numeroCartaInterno'], PDO::PARAM_STR);

            $final_response = $stmt->execute();            

            $stmt = null;                

            for($i = 0; $i < count($imagenesEscaneadas); $i++){

              $stmt = $conn->prepare("INSERT INTO carta_porte_imagenes (id_cliente, id_carta, imagen_archivo) VALUES (:idcliente, :idcarta, :imagen)");
              
              $stmt->bindParam(":idcliente", $datos["clienteID"], PDO::PARAM_STR);
              $stmt->bindParam(":idcarta", $datos["cartaID"], PDO::PARAM_STR);
              $stmt->bindParam(":imagen", $imagenesEscaneadas[$i], PDO::PARAM_STR);
              $stmt->execute();
              $stmt = null;

              $final_response = true;

            }        
            //$final_response = true;                    
            $conn->commit();
            
            if($final_response){
                return "ok";                
            }else{
              return "error";
            }        
          /**if( UsuariosHelper::isSYSAdmin() === false){
            $stmt->bindParam(":clienteID", $datos['numeroCartaInterno'], PDO::PARAM_STR);              
          }**/             

          if($stmt->execute()){
              return "ok";
          }else{
            return "error";
          }

          $stmt = null;
  }




  static public function mdlDeleteIndividualImage($imageID, $imagePath){

    $conn = Conexion::conectar();
    $stmt = $conn->prepare("DELETE FROM carta_porte_imagenes WHERE id_carta_imagen = :id");
    $stmt->bindParam(":id", $imageID, PDO::PARAM_INT);  
    $stmt->execute();  
  
    if($stmt->execute()){
          return "ok";
      }else{
        return "error";
      }

      $stmt = null;    
  }


  static public function mdlBorrarCarta($idCarta, $numeroCarta, $idCliente ){
  
      $conn = Conexion::conectar();    
      $stmt = $conn->prepare("DELETE FROM cartas_porte WHERE numero_carta_porte = :numero");      
      $conn->beginTransaction();
      $stmt->bindParam(":numero", $numeroCarta, PDO::PARAM_INT);          
      $stmt->execute();
      $stmt = null;      
      $stmt = $conn->prepare("DELETE FROM carta_porte_imagenes WHERE id_carta = :carta AND id_cliente = :cliente");
    
      $stmt->bindParam(":carta", $idCarta, PDO::PARAM_INT);
      $stmt->bindParam(":cliente", $idCliente, PDO::PARAM_INT);

      $conn->commit();

      if($stmt->execute()){
          return "ok";
      }else{
        return "error";
      }

      $stmt = null;    

  }

  static public function mdlCheckIfCartaIsUnique( $numCarta = null){

      $stmt = Conexion::conectar()->prepare("SELECT COUNT(id_carta_porte) as TOTAL_CARTAS FROM cartas_porte WHERE numero_carta_porte = :numCarta");
      
      $stmt->bindParam(":numCarta", $numCarta, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
  }


  static public function getTotalOfCartasByClient( $clientID ){

      $stmt = Conexion::conectar()->prepare("SELECT COUNT(id_carta_porte) as TOTAL_CARTAS FROM cartas_porte WHERE id_cliente = :clienteID");
      
      $stmt->bindParam(":clienteID", $clientID, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
  }


  static public function mdlGetCartasDetailToDescarga($numCarta, $idCliente = null, $cuitCliente = null){

     if( UsuariosHelper::isSYSAdmin(null, $idCliente)){
        $stmt = Conexion::conectar()->prepare("SELECT id_carta_porte, id_cliente, cuit_titular_carta_porte, razon_social_titular, calidad, titular_interno_id FROM cartas_porte WHERE numero_carta_porte = :carta");

      }else{
        $stmt = Conexion::conectar()->prepare("SELECT cuit_titular_carta_porte, razon_social_titular, calidad, titular_interno_id FROM cartas_porte WHERE numero_carta_porte = :carta AND (cuit_titular_carta_porte = :cuitCliente OR cuit_corredor = :cuitCliente OR cuit_entregador = :cuitCliente OR cuit_destino = :cuitCliente OR cuit_molca_posterior = :cuitCliente OR cuit_empresa_transportista = :cuitCliente OR cuit_procedencia = :cuitCliente OR cuit_intermediario = :cuitCliente OR cuit_remitente = :cuitCliente)");
      }

      $stmt->bindParam(":carta", $numCarta, PDO::PARAM_STR);

      if( UsuariosHelper::isSYSAdmin(null, $idCliente) === false){
       //$stmt->bindParam(":cliente", $idCliente, PDO::PARAM_STR);
       $stmt->bindParam(":cuitCliente", $cuitCliente, PDO::PARAM_STR);
      }

      $stmt->execute();

      return $stmt->fetch();
      //return array('cuit_titular_carta_porte' => '22222', 'razon_social_titular' => 'jhony', 'titular_interno_id' => '5555');
  }


  static public function mdlGetScannedImages($cartaID, $idCliente = null, $cuitCliente = null){
    
    
        $stmt = Conexion::conectar()->prepare("SELECT id_carta_imagen, imagen_archivo FROM carta_porte_imagenes WHERE id_carta = :carta");
      

      $stmt->bindParam(":carta", $cartaID, PDO::PARAM_STR);  

      $stmt->execute();

      return $stmt->fetchAll();
  }


  static public function mdlGetIDCartaFromNumeroCarta($numeroCarta, $idCliente = null, $cuitCliente = null){
    
    if( UsuariosHelper::isSYSAdmin(null, $idCliente)){
        $stmt = Conexion::conectar()->prepare("SELECT id_carta_porte FROM cartas_porte WHERE numero_carta_porte = :carta");
      }else{
        $stmt = Conexion::conectar()->prepare("SELECT id_carta_porte FROM cartas_porte WHERE numero_carta_porte = :carta AND (cuit_titular_carta_porte = :cuitCliente OR cuit_corredor = :cuitCliente OR cuit_entregador = :cuitCliente OR cuit_destino = :cuitCliente OR cuit_molca_posterior = :cuitCliente OR cuit_empresa_transportista = :cuitCliente OR cuit_procedencia = :cuitCliente OR cuit_intermediario = :cuitCliente OR cuit_remitente = :cuitCliente)");
      }

      $stmt->bindParam(":carta", $numeroCarta, PDO::PARAM_STR);

      if( UsuariosHelper::isSYSAdmin(null, $idCliente) === false){
       //$stmt->bindParam(":cliente", $idCliente, PDO::PARAM_STR);
       $stmt->bindParam(":cuitCliente", $cuitCliente, PDO::PARAM_STR);
      }

      $stmt->execute();
      return $stmt->fetch();
  }



  static public function mdlMostrarCartas($idUser = null, $idCliente = null, $cuitCliente = null){

      // Desde User Authenticated
      //$cliente = UsuariosHelper::getClienteInfoWithUserLoggedIn();
      if( UsuariosHelper::isSYSAdmin($idUser, $idCliente)){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM cartas_porte");
      }else{
        $stmt = Conexion::conectar()->prepare("SELECT * FROM cartas_porte WHERE cuit_titular_carta_porte = :cuitCliente OR cuit_corredor = :cuitCliente OR cuit_entregador = :cuitCliente OR cuit_destino = :cuitCliente OR cuit_molca_posterior = :cuitCliente OR cuit_empresa_transportista = :cuitCliente OR cuit_procedencia = :cuitCliente OR cuit_intermediario = :cuitCliente OR cuit_remitente = :cuitCliente");
      }

      //id_cliente = :cliente OR
      if( UsuariosHelper::isSYSAdmin($idUser, $idCliente) === false){
       //$stmt->bindParam(":cliente", $idCliente, PDO::PARAM_STR);
       $stmt->bindParam(":cuitCliente", $cuitCliente, PDO::PARAM_STR);
      }

      $stmt->execute();

      return $stmt->fetchAll();
  }


  // GET data necessary to compose CSV Import/Export File
  static public function mdlMostrarDatosReporteCSV($cuitFilter = null, $calidadFilter = null, $situacionFilter = null, $fechaDescargaInicialFilter = null, $fechaDescargaFinalFilter = null){

    $sql = "SELECT numero_carta_porte, grano, cosecha, fecha_descarga, fecha_descarga_2, cuit_destino, razon_social_destino, cuit_molca_posterior, molca_posterior, cuit_titular_carta_porte, razon_social_titular, molca_anterior, razon_social_intermediario, molca, codigo_postal_destino, localidad_destino, tipo_entrega, bruto, tara, neto_sin_merma, merma_total, neto_con_merma, porcentaje_humedad, porcentaje_merma_humedad, descarga_kilo_por_humedad, porcentaje_zaranda, descarga_kilo_zaranda, fumigada, neto_procencia, tipo_de_transporte, observaciones_carta_porte, cuit_empresa_transportista, razon_social_transportista, numero_ctg, procedencia, patente_chasis, observaciones_calidad, estado, gdm_1, gdm_2 FROM cartas_porte WHERE 1 = 1";

    // Apply filters and aggregators
    if($cuitFilter != null)
      $sql .= " AND cuit_titular_carta_porte = " . $cuitFilter;

    // Apply filters and aggregators
    if($calidadFilter != null)
      $sql .= " AND calidad = '" . $calidadFilter . "'";
    
    // Apply filters and aggregators
    if($situacionFilter != null)
      $sql .= " AND estado = '" . $situacionFilter ."'";
   
     // Apply filters and aggregators
    if($fechaDescargaInicialFilter != null)
      $sql .= " AND fecha_descarga >= '" . $fechaDescargaInicialFilter . "'";

    // Apply filters and aggregators
    if($fechaDescargaFinalFilter != null)
      $sql .= " AND fecha_descarga <= " . $fechaDescargaFinalFilter;
    
     $stmt = Conexion::conectar()->prepare($sql);
     $stmt->execute();

     return $stmt->fetchAll();
  }

  

  // GET data necessary to compose CSV Import/Export File
  static public function mdlMostrarDatosReportePDF($cuitFilter = null, $calidadFilter = null, $situacionFilter = null, $fechaDescargaInicialFilter = null, $fechaDescargaFinalFilter = null){

    $sql = "SELECT * FROM cartas_porte WHERE 1 = 1";

    // Apply filters and aggregators
    if($cuitFilter != null)
      $sql .= " AND cuit_titular_carta_porte = " . $cuitFilter;

    // Apply filters and aggregators
    if($calidadFilter != null)
      $sql .= " AND calidad = '" . $calidadFilter . "'";
    
    // Apply filters and aggregators
    if($situacionFilter != null)
      $sql .= " AND estado = '" . $situacionFilter ."'";   

     // Apply filters and aggregators
    if($fechaDescargaInicialFilter != null)
      $sql .= " AND fecha_descarga >= '" . $fechaDescargaInicialFilter . "'";


    // Apply filters and aggregators
    if($fechaDescargaFinalFilter != null)
      $sql .= " AND fecha_descarga <= " . $fechaDescargaFinalFilter;
    
     $stmt = Conexion::conectar()->prepare($sql);
     $stmt->execute();

     return $stmt->fetchAll();
  }


  static public function mdlVerificarSiNumeroCartaExiste($item, $valor){

    $stmt = Conexion::conectar()->prepare("SELECT * FROM cartas_porte WHERE $item = :valor");
      $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
      $stmt->execute();

      return $stmt->fetch();
  }


  static public function mdlMostrarCarta($numeroCarta = null, $idCliente = null, $cuitCliente){
  

    if( UsuariosHelper::isSYSAdmin( null, $idCliente )){
      $stmt = Conexion::conectar()->prepare("SELECT * FROM cartas_porte WHERE numero_carta_porte = :cartaNumber");
     }else{
      $stmt = Conexion::conectar()->prepare("SELECT * FROM cartas_porte WHERE numero_carta_porte = :cartaNumber AND (cuit_titular_carta_porte = :cuitCliente OR cuit_corredor = :cuitCliente OR cuit_entregador = :cuitCliente OR cuit_destino = :cuitCliente OR cuit_molca_posterior = :cuitCliente OR cuit_empresa_transportista = :cuitCliente OR cuit_procedencia = :cuitCliente OR cuit_intermediario = :cuitCliente OR cuit_remitente = :cuitCliente)");
     }     
      $stmt->bindParam(":cartaNumber", $numeroCarta, PDO::PARAM_STR);

      if( UsuariosHelper::isSYSAdmin( null, $idCliente ) === false){
       $stmt->bindParam(":cuitCliente", $cuitCliente, PDO::PARAM_STR);
      }
      $stmt->execute();
      return $stmt->fetch();
  }

  static public function getOrAddClient($cuitTitular = null, $razonTitular = null, $numeroPlanta = null, $namePlanta = null){
      
      $conn = Conexion::conectar();
      $stmt = $conn->prepare("SELECT id_cliente, cuit FROM clientes WHERE cuit = " . $cuitTitular);
      $stmt->execute();
      $clientInDB = $stmt->fetch();
      $stmt = null;    

      // if Exist then update with Cliente ID
      if ($clientInDB['cuit'] != null){          
          return $clientInDB['id_cliente'];                                             
      }else{

      $stmt = $conn->prepare("INSERT INTO clientes (razon_social, cuit, numero_planta, planta) VALUES (:razon, :cuit, :numPlanta, :nombrePlanta)");        

      $stmt->bindParam(":cuit", $cuitTitular, PDO::PARAM_STR);
      $stmt->bindParam(":razon", $razonTitular, PDO::PARAM_STR); 
      $stmt->bindParam(":numPlanta", $numeroPlanta, PDO::PARAM_STR); 
      $stmt->bindParam(":nombrePlanta", $namePlanta, PDO::PARAM_STR); 
      $stmt->execute();
      //then update CartaPorte with lasted Cliente ID added
      return $conn->lastInsertId();      
      $stmt = null;       
     }     

   }
}
