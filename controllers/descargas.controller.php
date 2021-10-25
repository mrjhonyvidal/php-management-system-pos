<?php

class DescargasController{
 

  /**===============================================================

  CREAR DESCARGA

  =================================================================**/

  public function ctrCrearDescarga(){

    if(isset($_POST["descargaNumeroCartaInterno"])) {  
          
          $isDescargaAlreadyCreated = DescargasModel::mdlCheckIfExistDescarga($_POST['descargaNumeroCartaInterno']);
                   
          if($isDescargaAlreadyCreated['TOTAL_CARTA_DESCARGAS'] > 0)
          {
            echo '<script>
                  swal({
                      type: "warning",
                      text: "¡Ya existe una descarga asociada con este numero de carta!",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result){
                      if (result.value) {
                        window.location = "descargas";
                      }
                    });
                </script>';

          }else{


              $datos = array("numeroCartaPorte" => $_POST["descargaNumeroCartaInterno"],
                          "nuevoIDCartaPorte" => $_POST["descargaIDCartaPorte"],
                          "nuevoClienteID" => $_POST["descargaClienteID"],
                          "nuevoBruto"=> ($_POST["descargaNuevoBruto"]) ? $_POST["descargaNuevoBruto"] : 0,
                          "nuevoTara"=> ($_POST['descargaNuevoTara']) ? $_POST['descargaNuevoTara'] : 0,
                          "nuevoNetoSinMerma"=> ($_POST['descargaNuevoNetoSinMerma']) ? $_POST['descargaNuevoNetoSinMerma'] : 0,
                          "nuevoPorcentajeMerma"=> ($_POST['descargaNuevoPorcentajeMerma']) ? $_POST['descargaNuevoPorcentajeMerma'] : 0,
                          "nuevoMermaTotal"=> ($_POST['descargaNuevoMermaTotal']) ? $_POST['descargaNuevoMermaTotal'] : 0,
                          "nuevoNetoConMerma"=> ($_POST['descargaNuevoNetoConMerma']) ? $_POST['descargaNuevoNetoConMerma'] : 0,
                          "nuevoHoraSalida" => ($_POST['descargaNuevoHoraSalida']) ? $_POST['descargaNuevoHoraSalida'] : 0,
                          "nuevoFechaSalida" => ($_POST['descargaNuevoFechaSalida']) ? $_POST['descargaNuevoFechaSalida'] : 0,
                          "nuevoRecibo" => ($_POST['descargaNuevoRecibo']) ? $_POST['descargaNuevoRecibo'] : 0,
                          "nuevoCTG" => ($_POST['descargaNuevoCTGCod']) ? $_POST['descargaNuevoCTGCod'] : 0,
                          "nuevoCCCTG" => ($_POST['descargaNuevoCCCTGCod']) ? $_POST['descargaNuevoCCCTGCod'] : 0,
                          "nuevoCalidad" => ($_POST['descargaNuevoCalidad']) ? $_POST['descargaNuevoCalidad'] : 0,
                          "nuevoObservaciones" => ($_POST['descargaNuevoObservaciones']) ? $_POST['descargaNuevoObservaciones'] : 0                       
                          );


              $respuesta = DescargasModel::mdlIngresarDescarga($datos);

              if($respuesta == 'ok')
              {
                  echo '<script>
                    swal({
                        type: "success",
                        text: "¡La descarga fue cargada con éxito!",
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        closeOnConfirm: false,
                        confirmButtonText: "Cerrar"
                      }).then(function(result){
                        if (result.value) {
                          window.location = "descargas";
                        }
                      });
                  </script>';
              }else{
                echo '<script>
                    swal({
                        type: "error",
                        text: "¡El numero de carta de porte no existe!",
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        closeOnConfirm: false,
                        confirmButtonText: "Cerrar"
                      }).then(function(result){
                        if (result.value) {
                          window.location = "descargas";
                        }
                      });
                  </script>';
              }          
          }
      }      
  }


  /**===============================================================

  EDITAR DESCARGA

  =================================================================**/

  public function ctrEditarDescarga(){

    if(isset($_POST['descargaNumeroCartaInternoEditar'])){

     
     
              $datos = array("numeroCartaPorte" => $_POST["descargaNumeroCartaInternoEditar"],
                          "nuevoIDCartaPorte" => $_POST["descargaIDCartaPorteEditar"],
                          "nuevoClienteID" => $_POST["descargaClienteIDEditar"],
                          "nuevoBruto"=> ($_POST["descargaNuevoBrutoEditar"]) ? $_POST["descargaNuevoBrutoEditar"] : 0,
                          "nuevoTara"=> ($_POST['descargaNuevoTaraEditar']) ? $_POST['descargaNuevoTaraEditar'] : 0,
                          "nuevoNetoSinMerma"=> ($_POST['descargaNuevoNetoSinMermaEditar']) ? $_POST['descargaNuevoNetoSinMermaEditar'] : 0,
                          "nuevoPorcentajeMerma"=> ($_POST['descargaNuevoPorcentajeMermaEditar']) ? $_POST['descargaNuevoPorcentajeMermaEditar'] : 0,
                          "nuevoMermaTotal"=> ($_POST['descargaNuevoMermaTotalEditar']) ? $_POST['descargaNuevoMermaTotalEditar'] : 0,
                          "nuevoNetoConMerma"=> ($_POST['descargaNuevoNetoConMermaEditar']) ? $_POST['descargaNuevoNetoConMermaEditar'] : 0,
                          "nuevoHoraSalida" => ($_POST['descargaNuevoHoraSalidaEditar']) ? $_POST['descargaNuevoHoraSalidaEditar'] : 0,
                          "nuevoFechaSalida" => ($_POST['descargaNuevoFechaSalidaEditar']) ? $_POST['descargaNuevoFechaSalidaEditar'] : 0,
                          "nuevoRecibo" => ($_POST['descargaNuevoReciboEditar']) ? $_POST['descargaNuevoReciboEditar'] : 0,
                          "nuevoCTG" => ($_POST['descargaNuevoCTGCodEditar']) ? $_POST['descargaNuevoCTGCodEditar'] : 0,
                          "nuevoCCCTG" => ($_POST['descargaNuevoCCCTGCodEditar']) ? $_POST['descargaNuevoCCCTGCodEditar'] : 0,
                          "nuevoCalidad" => ($_POST['descargaNuevoCalidadEditar']) ? $_POST['descargaNuevoCalidadEditar'] : 0,
                          "nuevoObservaciones" => ($_POST['descargaNuevoObservacionesEditar']) ? $_POST['descargaNuevoObservacionesEditar'] : 0                       
                          );
            
            $respuesta = DescargasModel::mdlEditarDescarga($datos);

            if($respuesta == 'ok')
            {
                echo '<script>
                  swal({
                      type: "success",
                      text: "¡La descarga fue modificada con éxito!",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result) {
                      if (result.value) {
                        window.location = "descargas";
                      }
                    });
                </script>';
            }else{
              echo '<script>
                  swal({
                      type: "warning",
                      text: "¡Ningún cambio realizado!",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result) {
                      if (result.value) {
                        window.location = "descargas";
                      }
                    });
                </script>';
            }

      }  

  }





  /**===============================================================

  SHOW DESCARGA AND DESCARGAS

  =================================================================**/


  static public function ctrMostrarDescargas($Usuario, $IDCliente, $CUITCliente){

      return DescargasModel::mdlMostrarDescargas($Usuario, $IDCliente, $CUITCliente);
  }


  static public function ctrMostrarDescarga($cartaNumero, $IDCliente, $CUITCliente){

      return DescargasModel::mdlMostrarDescarga($cartaNumero, $IDCliente, $CUITCliente);
  }

  

  /**===============================================================

  BORRAR DESCARGA

  =================================================================**/

  public function ctrBorrarDescarga() {

    // Check if CUIT is there and also the number of NumeroCarta
     if(isset($_GET["c"] ) && isset($_GET["n"])){

      // Delete Folder and sub files including hidden
    
        
    $descargaCartaNumero = $_GET['n'];
    $clienteID = $_GET['ci'];

    $respuesta = DescargasModel::mdlBorrarDescarga($descargaCartaNumero, $clienteID);

      if($respuesta == 'ok')
      {
        echo '<script>
          swal({
              type: "success",
              text: "¡Descargas ha sido borrado con éxito!",
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              closeOnConfirm: false,
              confirmButtonText: "Cerrar"
            }).then(function(result){
              if (result.value) {
                window.location = "descargas";
              }
            });
        </script>';
      }   

    }

    
  }

 

}
