<?php

class CartasController{



  /**===============================================================

  IMPORTAR CARTAS DESDE CSV

  =================================================================**/

  public function ctrImportarCSVConTabla(){
    
    if(isset($_POST["importarCSV"])){
    
        $filename =  $_FILES["cartaCSV"]["tmp_name"];    

        // Check if file type is CSV or if XLSX
        $extension  = pathinfo($_FILES['cartaCSV']['name'], PATHINFO_EXTENSION);


        // TODO QUE SE ACEPTE LOS FORMATOS XLS, XLSX 
        // if($extension == 'csv' || $extension == 'xls' || $extension == 'xlsx')

        if($extension == 'csv' || $extension == 'xls' || $extension == 'xlsx')
        {

          try{
                $Reader = new PHPExcelReader($filename);
                // get the total rows of records                
                $total = $Reader->count();    
                              
                
                $Reader->seek(0);     
                $headers = $Reader->current();



                $show_success_message = 0;
                  
                // skip to the 1th row               
                for($i=1; $i < $total; $i++)
                {
                  
                  $Reader->seek($i);
                  $dataCurrentLine = $Reader->current(); 
                    
                  $totalAfterCheckingIfEmptyRow = array_filter($dataCurrentLine, 'strlen');   

                  if( count($totalAfterCheckingIfEmptyRow) > 20 ){
                     
                     $resultado = CartasModel::mdlImportarCartaFromCSV( $dataCurrentLine, $headers ); 
                  }                  

                   if($resultado == true)
                      $show_success_message = 1;                  
                   else{
                      $show_success_message = 0;                  
                   } 
                    
                 }

                 if($show_success_message == 1)
                 {
                         echo '<script>
                                  swal({
                                      type: "success",
                                      text: "Cartas de porte fueron importadas con éxito",
                                      confirmButtonColor: "#3085d6",
                                      cancelButtonColor: "#d33",
                                      closeOnConfirm: false,
                                      confirmButtonText: "Cerrar"
                                    }).then(function(result){
                                      if (result.value) {
                                        window.location = "cartas-de-porte";
                                      }
                                    });
                                </script>';
                 }else{
                      echo '<script>
                                  swal({
                                      type: "error",
                                      text: "No fue posible importar el archivo",
                                      confirmButtonColor: "#3085d6",
                                      cancelButtonColor: "#d33",
                                      closeOnConfirm: false,
                                      confirmButtonText: "Cerrar"
                                    }).then(function(result){
                                      if (result.value) {
                                        window.location = "cartas-de-porte";
                                      }
                                    });
                                </script>';
                 }             


              } catch (Exception $e) {
                  // En caso de mysql constraints segui
              }

          
         }else{
                  // File format must be CSV or XLSX
                  echo '<script>
                      swal({
                          type: "error",
                          text: "El formato del archivo debe ser CSV con columnas separadas por ;",
                          confirmButtonColor: "#3085d6",
                          cancelButtonColor: "#d33",
                          closeOnConfirm: false,
                          confirmButtonText: "Cerrar"
                        }).then(function(result){
                          if (result.value) {
                            window.location = "cartas-de-porte";
                          }
                        });
                    </script>';
              } 
        
      }  
  }


/** ======================================================================

GENERATE REPORTE

======================================================================**/

  public function generarReporte(){
     
    //if(isset($_POST["filtroType"]) && $_POST["filtroType"] == 'csv'){}
    //$respuesta = CartasModel::mdlGenerateReporte($datos, $type);
    
  }
  

  /**===============================================================

  CREAR CARTA

  =================================================================**/

  public function ctrCrearCarta(){


    $respuesta = '';
    $imagenesEscaneadas = array();


    if(isset($_POST["nuevoCUITCartaPorteTitular"])){


        if(empty($_POST["nuevoCUITCartaPorteTitular"])){

          echo '<script>
                swal({
                    type: "error",
                    text: "El campo CUIT Titular no puede estar vacío.",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    closeOnConfirm: false,
                    confirmButtonText: "Cerrar"
                  }).then(function(result){
                    if (result.value) {
                      window.location = "cartas-de-porte";
                    }
                  });
              </script>';
              return;
          
          }

          $total = $this->isUniqueCartaNumero($_POST['nuevoNumeroCartaInterno']);

          if( $total['TOTAL_CARTAS'] > 0 ){            

              echo '<script>
                swal({
                    type: "error",
                    text: "El numero de carta de porte ya existe en el sistema.",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    closeOnConfirm: false,
                    confirmButtonText: "Cerrar"
                  }).then(function(result){
                    if (result.value) {
                      window.location = "cartas-de-porte";
                    }
                  });
              </script>';
             return; 
          }

            
            for($i = 0; $i < count($_FILES['nuevaScannedImages']['name']); $i++) {
              
              if(isset($_FILES["nuevaScannedImages"]["tmp_name"][$i])){
                    $imagenesEscaneadas[$i] = $this->transform_and_save_image($_FILES["nuevaScannedImages"]['tmp_name'][$i], $_FILES["nuevaScannedImages"]['type'][$i], $_POST['nuevaScannedImages'], $_POST["nuevoNumeroCartaInterno"]);
                    }
                          
            }
            
            /**
            $datos = array(
                        "numeroCartaInterno"=> $_POST["nuevoNumeroCartaInterno"],
                        "CUITCartaPorteTitular"=> $_POST['nuevoCUITCartaPorteTitular']);
            **/

            $datos = array(
                        "numeroCartaInterno"=> $_POST["nuevoNumeroCartaInterno"],
                        "procedenciaBruto"=> $_POST["nuevoProcedenciaBruto"],
                        "procedenciaTara"=> $_POST["nuevoProcedenciaTara"],
                        "procedenciaNeto"=> $_POST["nuevoProcedenciaNeto"],
                        "numeroCTG"=> ($_POST['nuevoNumeroCTG']) ? $_POST['nuevoNumeroCTG'] : 0,
                        "numeroCCCTG"=> ($_POST['nuevoNumeroCCCTG']) ? $_POST['nuevoNumeroCCCTG'] : 0,
                        "puertoCOD"=> ($_POST["nuevoPuertoCOD"]) ? $_POST["nuevoPuertoCOD"] : 0,
                        "nombrePuerto"=> ($_POST['nuevoNombrePuerto']) ? $_POST['nuevoNombrePuerto'] : 0,
                        "CUITEntregador"=> ($_POST['nuevoCUITEntregador']) ? $_POST['nuevoCUITEntregador'] : 0,
                        "IDEntregador"=> ($_POST['nuevoIDEntregador']) ? $_POST['nuevoIDEntregador'] : 0,
                        "razonEntregador"=> ($_POST['nuevoRazonEntregador']) ? $_POST['nuevoRazonEntregador'] : 0,
                        "IDMercaderia"=> ($_POST['nuevoIDMercaderia']) ? $_POST['nuevoIDMercaderia'] : 0,
                        "nombreMercaderia"=> ($_POST['nuevoNombreMercaderia']) ? $_POST['nuevoNombreMercaderia'] : 0,
                        "contrato"=> ($_POST['nuevoContrato']) ? $_POST['nuevoContrato'] : 0,
                        "kiloMercaderiaBruto"=> ($_POST['nuevoBruto']) ? $_POST['nuevoBruto'] : 0,
                        "netoSinMerma"=> ($_POST['nuevoNetoSinMerma']) ? $_POST['nuevoNetoSinMerma'] : 0,
                        "mermaTotal"=> ($_POST['nuevoMermaTotal']) ? $_POST['nuevoMermaTotal'] : 0,
                        "netoConMerma"=> ($_POST['nuevoNetoConMerma']) ? $_POST['nuevoNetoConMerma'] : 0,
                        "tara"=> ($_POST['nuevoTara']) ? $_POST['nuevoTara'] : 0,
                        "fechaDescarga"=> $_POST['nuevoFechaDescarga'],
                        "CUITCartaPorteTitular"=> str_replace('-','',$_POST['nuevoCUITCartaPorteTitular']),
                        "razonTitular"=> $_POST['nuevoRazonTitular'],
                        "IDInternoTitular"=> ($_POST['nuevoIDInternoTitular']) ? $_POST['nuevoIDInternoTitular'] : 0,
                        "CUITIntermediario"=> ($_POST['nuevoCUITIntermediario']) ? str_replace('-','',$_POST['nuevoCUITIntermediario']) : 0,
                        "razonIntermediario"=> ($_POST['nuevoRazonIntermediario']) ? $_POST['nuevoRazonIntermediario'] : 0,
                        "IDInternoIntermediario"=> ($_POST['nuevoIDInternoIntermediario']) ? $_POST['nuevoIDInternoIntermediario'] : 0,
                        "CUITRemitenteComercial"=> ($_POST['nuevoCUITRemitenteComercial']) ? str_replace('-','',$_POST['nuevoCUITRemitenteComercial']) : 0,
                        "razonRemitente"=> ($_POST['nuevoRazonRemitente']) ? $_POST['nuevoRazonRemitente'] : 0,
                        "IDInternoRemitente"=> ($_POST['nuevoIDInternoRemitente']) ? $_POST['nuevoIDInternoRemitente'] : 0,
                        "CUITDestinatario"=> ($_POST['nuevoCUITDestinatario']) ? str_replace('-','',$_POST['nuevoCUITDestinatario']) : 0,
                        "razonDestinatario"=> ($_POST['nuevoRazonDestinatario']) ? $_POST['nuevoRazonDestinatario'] : 0,
                        "CUITCorredor"=> ($_POST['nuevoCUITCorredor']) ? str_replace('-','',$_POST['nuevoCUITCorredor']) : 0,
                        "razonCorredor"=> ($_POST['nuevoRazonCorredor']) ? $_POST['nuevoRazonCorredor'] : 0,
                        "corredorComprador"=> ($_POST['nuevoCorredorComprador']) ? $_POST['nuevoCorredorComprador'] : 0,
                        "tipoEntrega"=> ($_POST['nuevoTipoEntrega']) ? $_POST['nuevoTipoEntrega'] : 0,
                        "localidadDestino"=> ($_POST['nuevoLocalidadDestino']) ? $_POST['nuevoLocalidadDestino'] : 0,                        
                        "numPlantaTitular"=> ($_POST['nuevoNumPlantaTitular']) ? $_POST['nuevoNumPlantaTitular'] : 0,
                        "plantaTitular"=> ($_POST['nuevoPlantaTitular']) ? $_POST['nuevoPlantaTitular'] : 0,
                        "checkboxEntrPlantaTitular"=> ($_POST['nuevoCheckboxEntrPlantaTitular']) ? $_POST['nuevoCheckboxEntrPlantaTitular'] : 0,
                        "checkboxExpPlantaTitular"=> ($_POST['nuevoCheckboxExpPlantaTitular']) ? $_POST['nuevoCheckboxExpPlantaTitular'] : 0,
                        "numPlantaIntermediario"=> ($_POST['nuevoNumPlantaIntermediario']) ? $_POST['nuevoNumPlantaIntermediario'] : 0,
                        "plantaIntermediario"=> ($_POST['nuevoPlantaIntermediario']) ? $_POST['nuevoPlantaIntermediario'] : 0,
                        "checkboxEntrPlantaIntermediario"=> ($_POST['nuevoCheckboxEntrPlantaIntermediario']) ? $_POST['nuevoCheckboxEntrPlantaIntermediario'] : 0,
                        "checkboxExpPlantaIntermediario"=> ($_POST['nuevoCheckboxExpPlantaIntermediario']) ? $_POST['nuevoCheckboxExpPlantaIntermediario'] : 0,
                        "numPlantaRemitente"=> ($_POST['nuevoNumPlantaRemitente']) ? $_POST['nuevoNumPlantaRemitente'] : 0,
                        "plantaRemitente"=> ($_POST['nuevoPlantaRemitente']) ? $_POST['nuevoPlantaRemitente'] : 0,
                        "checkboxEntrPlantaRemitente"=> ($_POST['nuevoCheckboxEntrPlantaRemitente']) ? $_POST['nuevoCheckboxEntrPlantaRemitente'] : 0,
                        "checkboxExpPlantaRemitente"=> ($_POST['nuevoCheckboxExpPlantaRemitente']) ? $_POST['nuevoCheckboxExpPlantaRemitente'] : 0,
                        "localidadProcedencia"=> ($_POST['nuevoLocalidadProcedencia']) ? $_POST['nuevoLocalidadProcedencia'] : 0,
                        "extraProcedencia"=> ($_POST['nuevoExtraProcedencia']) ? $_POST['nuevoExtraProcedencia'] : 0,
                        "horaIngreso"=> ($_POST['nuevoHoraIngreso']) ? $_POST['nuevoHoraIngreso'] : 0,
                        "turno"=> ($_POST['nuevoTurno']) ? $_POST['nuevoTurno'] : 0,
                        "patente"=> ($_POST['nuevoPatente']) ? $_POST['nuevoPatente'] : 0,
                        "CUITTransportista"=> ($_POST['nuevoCUITTransportista']) ? str_replace('-','',$_POST['nuevoCUITTransportista']) : 0,
                        "razonTransportista"=> ($_POST['nuevoRazonTransportista']) ? $_POST['nuevoRazonTransportista'] : 0,
                        "observaciones"=> ($_POST['nuevoObservaciones']) ? $_POST['nuevoObservaciones'] : '', 
                        "calidad"=> ($_POST['nuevoCalidad']) ? $_POST['nuevoCalidad'] : 0,
                        "kiloNeto"=> ($_POST['nuevoKiloNeto']) ? $_POST['nuevoKiloNeto'] : 0,
                        "situacion"=> ($_POST['nuevoSituacion']) ? $_POST['nuevoSituacion'] : 0);
                                

                                            
            $respuesta = CartasModel::mdlIngresarCarta($datos, $imagenesEscaneadas);
        

            if($respuesta == 'ok')
            {
                echo '<script>
                  swal({
                      type: "success",
                      text: "¡Carta de porte ingresada con éxito!",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result){
                      if (result.value) {
                        window.location = "cartas-de-porte";
                      }
                    });
                </script>';

            }elseif($respuesta == "permision_denied"){
                 echo '<script>
                  swal({
                      type: "warning",
                      text: "No tienes permiso para crear una carta de porte, consulte con un usuario con más permisos",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result){
                      if (result.value) {
                        window.location = "cartas-de-porte";
                      }
                    });
                </script>';
            }elseif($respuesta == 'numeroCartaYaExiste'){

              // TODO Implement Error
                echo '<script>
                  swal({
                      type: "error",
                      text: "Número de carta ya existe en la base de datos",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result){
                      if (result.value) {
                        window.location = "cartas-de-porte";
                      }
                    });
                </script>';

            }else{
                 echo '<script>
                  swal({
                      type: "error",
                      text: "Ocurrió un error al ingresar los datos a la base de datos",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result){
                      if (result.value) {
                        window.location = "cartas-de-porte";
                      }
                    });
                </script>';
            }                    
          
      }
  }


  /**===============================================================

  EDITAR CARTA
  =================================================================**/

  public function ctrEditarCarta(){

   $respuesta = '';    
   $imagenesEscaneadas = array();   


    if(isset($_POST["editarCUITCartaPorteTitular"])){


        if(empty($_POST["editarCUITCartaPorteTitular"])){

          echo '<script>
                swal({
                    type: "error",
                    text: "El campo CUIT Titular no puede estar vacío.",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    closeOnConfirm: false,
                    confirmButtonText: "Cerrar"
                  }).then(function(result){
                    if (result.value) {
                      window.location = "cartas-de-porte";
                    }
                  });
              </script>';
      

          $total = $this->isUniqueCartaNumero($_POST['nuevoNumeroCartaInterno']);

          }elseif( $total['CARTAS_PORTE'] > 0){

            $respuesta = 'numeroCartaYaExiste';

              echo '<script>
                swal({
                    type: "error",
                    text: "El numero de Carta Interno no debe repetirse, debe ser único para cada carta de porte en el sistema.",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    closeOnConfirm: false,
                    confirmButtonText: "Cerrar"
                  }).then(function(result){
                    if (result.value) {
                      window.location = "cartas-de-porte";
                    }
                  });
              </script>';

          }else{ 


                  for($i = 0; $i < count($_FILES['editarScannedImages']['name']); $i++) {
                    
                    if(isset($_FILES["editarScannedImages"]["tmp_name"][$i])){
                          $imagenesEscaneadas[$i] = $this->transform_and_save_image($_FILES["editarScannedImages"]['tmp_name'][$i], $_FILES["editarScannedImages"]['type'][$i], $_POST['editarScannedImages'], $_POST["editarNumeroCartaInterno"]);


                            /**if($fotoIngresada != null){
                              $imagenesEscaneadas[$i] = $fotoIngresada;
                            }**/                                        
                        }                        
                  }
                
                $datos = array(
                            "numeroCartaInterno"=> $_POST["editarNumeroCartaInterno"],
                            "procedenciaBruto"=> $_POST["editarProcedenciaBruto"],
                            "procedenciaTara"=> $_POST["editarProcedenciaTara"],
                            "procedenciaNeto"=> $_POST["editarProcedenciaNeto"],
                            "numeroCTG"=> ($_POST["editarNumeroCTG"]) ? $_POST["editarNumeroCTG"] : 0,
                            "numeroCCCTG"=> ($_POST["editarNumeroCCCTG"]) ? $_POST["editarNumeroCCCTG"] : 0,
                            "puertoCOD"=> ($_POST["editarPuertoCOD"]) ? $_POST["editarPuertoCOD"] : 0,
                            "nombrePuerto"=> ($_POST['editarNombrePuerto']) ? $_POST['editarNombrePuerto'] : 0,
                            "CUITEntregador"=> ($_POST['editarCUITEntregador']) ? str_replace('-','',$_POST['editarCUITEntregador']) : 0,
                            "IDEntregador"=> ($_POST['editarIDEntregador']) ? $_POST['editarIDEntregador'] : 0,
                            "razonEntregador"=> ($_POST['editarRazonEntregador']) ? $_POST['editarRazonEntregador'] : 0,
                            "IDMercaderia"=> ($_POST['editarIDMercaderia']) ? $_POST['editarIDMercaderia'] : 0,
                            "nombreMercaderia"=> ($_POST['editarNombreMercaderia']) ? $_POST['editarNombreMercaderia'] : 0,
                            "contrato"=> ($_POST['editarContrato']) ? $_POST['editarContrato'] : 0,
                            "kiloMercaderiaBruto"=> ($_POST['editarBruto']) ? $_POST['editarBruto'] : 0,
                            "netoSinMerma"=> ($_POST['editarNetoSinMerma']) ? $_POST['editarNetoSinMerma'] : 0,
                            "mermaTotal"=> ($_POST['editarMermaTotal']) ? $_POST['editarMermaTotal'] : 0,
                            "netoConMerma"=> ($_POST['editarNetoConMerma']) ? $_POST['editarNetoConMerma'] : 0,
                            "tara"=> ($_POST['editarTara']) ? $_POST['editarTara'] : 0,
                            "fechaDescarga"=> $_POST['editarFechaDescarga'],                            
                            "CUITCartaPorteTitular"=> str_replace('-','',$_POST['editarCUITCartaPorteTitular']),
                            "razonTitular"=> $_POST['editarRazonTitular'],
                            "IDInternoTitular"=> ($_POST['editarIDInternoTitular']) ? $_POST['editarIDInternoTitular'] : 0,
                            "CUITIntermediario"=> ($_POST['editarCUITIntermediario']) ? str_replace('-','',$_POST['editarCUITIntermediario']) : 0,
                            "razonIntermediario"=> ($_POST['editarRazonIntermediario']) ? $_POST['editarRazonIntermediario'] : 0,
                            "IDInternoIntermediario"=> ($_POST['editarIDIntermediario']) ? $_POST['editarIDIntermediario'] : 0,
                            "CUITRemitenteComercial"=> ($_POST['editarCUITRemitenteComercial']) ? str_replace('-','',$_POST['editarCUITRemitenteComercial']) : 0,
                            "razonRemitente"=> ($_POST['editarRazonRemitente']) ? $_POST['editarRazonRemitente'] : 0,
                            "IDInternoRemitente"=> ($_POST['editarIDRemitente']) ? $_POST['editarIDRemitente'] : 0,
                            "CUITDestinatario"=> ($_POST['editarCUITDestinatario']) ? str_replace('-','',$_POST['editarCUITDestinatario']) : 0,
                            "razonDestinatario"=> ($_POST['editarRazonDestinatario']) ? $_POST['editarRazonDestinatario'] : 0,
                            "CUITCorredor"=> ($_POST['editarCUITCorredor']) ? str_replace('-','',$_POST['editarCUITCorredor']) : 0,
                            "razonCorredor"=> ($_POST['editarRazonCorredor']) ? $_POST['editarRazonCorredor'] : 0,
                            "corredorComprador"=> ($_POST['editarCorredorComprador']) ? $_POST['editarCorredorComprador'] : 0,
                            "tipoEntrega"=> ($_POST['editarTipoEntrega']) ? $_POST['editarTipoEntrega'] : 0,
                            "localidadDestino"=> ($_POST['editarLocalidadDestino']) ? $_POST['editarLocalidadDestino'] : 0,
                            "numPlantaTitular"=> ($_POST['editarNumPlantaTitular']) ? $_POST['editarNumPlantaTitular'] : 0,
                            "plantaTitular"=> ($_POST['editarPlantaTitular']) ? $_POST['editarPlantaTitular'] : 0,
                            "checkboxEntrPlantaTitular"=> ($_POST['editarCheckboxEntrPlantaTitular']) ? $_POST['editarCheckboxEntrPlantaTitular'] : 0,
                            "checkboxExpPlantaTitular"=> ($_POST['editarCheckboxExpPlantaTitular']) ? $_POST['editarCheckboxExpPlantaTitular'] : 0,
                            "numPlantaIntermediario"=> ($_POST['editarNumPlantaIntermediario']) ? $_POST['editarNumPlantaIntermediario'] : 0,
                            "plantaIntermediario"=> ($_POST['editarPlantaIntermediario']) ? $_POST['editarPlantaIntermediario'] : 0,
                            "checkboxEntrPlantaIntermediario"=> ($_POST['editarCheckboxEntrPlantaIntermediario']) ? $_POST['editarCheckboxEntrPlantaIntermediario'] : 0,
                            "checkboxExpPlantaIntermediario"=> ($_POST['editarCheckboxExpPlantaIntermediario']) ? $_POST['editarCheckboxExpPlantaIntermediario'] : 0,
                            "numPlantaRemitente"=> ($_POST['editarNumPlantaRemitente']) ? $_POST['editarNumPlantaRemitente'] : 0,
                            "plantaRemitente"=> ($_POST['editarPlantaRemitente']) ? $_POST['editarPlantaRemitente'] : 0,
                            "checkboxEntrPlantaRemitente"=> ($_POST['editarCheckboxEntrPlantaRemitente']) ? $_POST['editarCheckboxEntrPlantaRemitente'] : 0,
                            "checkboxExpPlantaRemitente"=> ($_POST['editarCheckboxExpPlantaRemitente']) ? $_POST['editarCheckboxExpPlantaRemitente'] : 0,
                            "localidadProcedencia"=> ($_POST['editarLocalidadProcedencia']) ? $_POST['editarLocalidadProcedencia'] : 0,
                            "extraProcedencia"=> ($_POST['editarExtraProcedencia']) ? $_POST['editarExtraProcedencia'] : 0,
                            "horaIngreso"=> ($_POST['editarHoraIngreso']) ? $_POST['editarHoraIngreso'] : 0,
                            "turno"=> ($_POST['editarTurno']) ? $_POST['editarTurno'] : 0,
                            "patente"=> ($_POST['editarPatente']) ? $_POST['editarPatente'] : 0,
                            "CUITTransportista"=> ($_POST['editarCUITTransportista']) ? str_replace('-','',$_POST['editarCUITTransportista']) : 0,
                            "razonTransportista"=> ($_POST['editarRazonTransportista']) ? $_POST['editarRazonTransportista'] : 0,
                            "observaciones"=> ($_POST['editarObservaciones']) ? $_POST['editarObservaciones'] : 0, 
                            "calidad"=> ($_POST['editarCalidad']) ? $_POST['editarCalidad'] : 0,
                            "kiloNeto"=> ($_POST['editarKiloNeto']) ? $_POST['editarKiloNeto'] : 0,
                            "situacion"=> ($_POST['editarSituacion']) ? $_POST['editarSituacion'] : 0,
                            "clienteID" => $_POST["editarClienteID"],
                            "cartaID" => $_POST["editarCartaID"]
                            );
                                    

                                                
                  $respuesta = CartasModel::mdlEditarCarta($datos, $imagenesEscaneadas);          

           }

                                     
            if($respuesta == 'ok')
            {
                echo '<script>
                  swal({
                      type: "success",
                      text: "¡Carta de porte modificada con éxito!",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result){
                      if (result.value) {
                        window.location = "cartas-de-porte";
                      }
                    });
                </script>';

            }elseif($respuesta == "permision_denied"){
                 echo '<script>
                  swal({
                      type: "warning",
                      text: "No tienes permiso para editar una carta de porte, consulte con un usuario con más permisos",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result){
                      if (result.value) {
                        window.location = "cartas-de-porte";
                      }
                    });
                </script>';
            }elseif($respuesta == 'numeroCartaYaExiste'){

              // TODO Implement Error
                echo '<script>
                  swal({
                      type: "error",
                      text: "Número de carta ya existe en la base de datos",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result){
                      if (result.value) {
                        window.location = "cartas-de-porte";
                      }
                    });
                </script>';

            }else{
                 echo '<script>
                  swal({
                      type: "error",
                      text: "Ocurrió un error al editar los datos a la base de datos",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result){
                      if (result.value) {
                        window.location = "cartas-de-porte";
                      }
                    });
                </script>';
            }                    
          
      }

  }


  /**===============================================================

  SHOW CARTAS AND CARTA

  =================================================================**/


  static public function ctrMostrarCartas($idUsuario = null, $idCliente = null, $cuitCliente = null){

      return CartasModel::mdlMostrarCartas($idUsuario, $idCliente, $cuitCliente);
  }


  static public function ctrMostrarCarta($numeroCarta, $idCliente = null, $cuitCliente){

      return CartasModel::mdlMostrarCarta($numeroCarta, $idCliente, $cuitCliente);
  }

  static public function ctrGetScannedImages($cartaID = null, $idCliente = null, $cuitCliente = null){

      return CartasModel::mdlGetScannedImages($cartaID, $idCliente, $cuitCliente); 
  }


  static public function ctrGetCartaDetailsToDescarga($numeroCarta = null, $idCliente = null, $cuitCliente = null){

      return CartasModel::mdlGetCartasDetailToDescarga($numeroCarta, $idCliente, $cuitCliente);
  }

  

  /**===============================================================

  BORRAR CARTA

  =================================================================**/

  public function ctrBorrarCarta() {

    if(isset($_GET["i"] ) && isset($_GET["n"])){

      // Delete Folder and sub files including hidden
      self::delTree('views/img/cartas/' . $_GET['n']);
    
    $id_carta = $_GET['i'];
    $carta = $_GET['n'];
    $cliente = $_GET['c'];

    $respuesta = CartasModel::mdlBorrarCarta($id_carta, $carta, $cliente);

      if($respuesta == 'ok')
      {
        echo '<script>
          swal({
              type: "success",
              text: "¡La carta de porte ha sido borrada correctamente!",
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              closeOnConfirm: false,
              confirmButtonText: "Cerrar"
            }).then(function(result){
              if (result.value) {
                window.location = "cartas-de-porte";
              }
            });
        </script>';
      }   

    }

  }

 // Delete Folder and sub files including hidden
  static private function delTree($dir)
  { 
        $files = array_diff(scandir($dir), array('.', '..')); 

        foreach ($files as $file) { 
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
        }

        return rmdir($dir); 
  } 



  /**** ===========================================================
  BORRAR IMAGEN INDIVIDUAL
  ==============================================================**/
  public function ctrDeleteIndividualImage($imageID = null, $imagePath = null){

    if($imagePath != null){
       unlink($imagePath);       
    }

    return CartasModel::mdlDeleteIndividualImage($imageID, $imagePath);
  }


  private function isUniqueCartaNumero($numCarta = null) {
    return CartasModel::mdlCheckIfCartaIsUnique($numCarta);        
  }


  /**===============================================================

  HELPER FUNCTIONS

  =================================================================**/

  private function transform_and_save_image($images_scanned_tmp, $images_type, $images_filenames, $carta_porte_related){

            list($ancho, $alto) = getimagesize($images_scanned_tmp);

            // Medidas 30/70 dpi A4
            $nuevoAncho = 595;
            $nuevoAlto = 842;

            $directorio = "views/img/cartas/" . $carta_porte_related;

            // Verificar si ya existe otra imagen en la base de datos
            //if(!empty($foto)){
              //unlink($foto);
            //}else{

            // If folder with CUIT number doesn't exist then create
            

            if(!file_exists($directorio))
              mkdir($directorio, 0755);


            if($images_type == "image/jpeg"){

              $aleatorio = md5(uniqid());

              $foto = "views/img/cartas/" . $carta_porte_related . "/" . $aleatorio . ".jpg";

              $origen = imagecreatefromjpeg($images_scanned_tmp);

              $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

              imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

              imagejpeg($destino, $foto);
            }


            if($images_type == "image/png"){

              $aleatorio = md5(uniqid());

              $foto = "views/img/cartas/" . $carta_porte_related . "/" . $aleatorio . ".png";

              $origen = imagecreatefrompng($images_scanned_tmp);

              $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

              imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

              imagepng($destino, $foto);
            }

      // Returns the path to be stored in database;
      return $foto;
  }


  
  private function deleteScannedImageFromDBAndFolder($imageName, $idCartaPorte){

    if(!empty($foto)){
          unlink($foto);
      }    

    // Borrar imagen escaneada de carta_porte_imagenes donde el ID sea igual a $idCartaPorte

    // Borrar el archivo desde la carpeta /views/carta/
  }


}
