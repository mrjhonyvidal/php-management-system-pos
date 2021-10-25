<?php

class ClientesController{


  /**===============================================================

  CREAR CLIENTE

  =================================================================**/

  public function ctrCrearCliente(){

    if(isset($_POST["nuevoCUIT"])){


            $datos = array("idIdentificacion" => $_POST["nuevoIdentificacionID"],
                          "razonSocial" => $_POST["nuevoRazonSocial"],
                          "cuit" => $_POST["nuevoCUIT"],
                          "planta" => $_POST['nuevoPlanta'],                        
                          "numeroPlanta" => $_POST['nuevoNumeroPlanta'],
                          "pais" => $_POST['nuevoPais']);

              $respuesta = ClientesModel::mdlIngresarCliente($datos);

              if($respuesta == 'ok')
              {
                  echo '<script>
                    swal({
                        type: "success",
                        text: "¡El cliente ha sido guardado correctamente!",
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        closeOnConfirm: false,
                        confirmButtonText: "Cerrar"
                      }).then(function(result){
                        if (result.value) {
                          window.location = "clientes";
                        }
                      });
                  </script>';
              }else{
                echo '<script>
                    swal({
                        type: "warning",
                        text: "¡Ya existe un cliente registrado con el CUIT!",
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        closeOnConfirm: false,
                        confirmButtonText: "Cerrar"
                      }).then(function(result){
                        if (result.value) {
                          window.location = "clientes";
                        }
                      });
                  </script>';
              }              
      }
  }



  /**===============================================================

  EDITAR CLIENTE
  =================================================================**/

  public function ctrEditarCliente(){

    if(isset($_POST["editarCUIT"])){
        
            $datos = array("idIdentificacion" => $_POST["editarIdentificacionID"],
                        "razonSocial"=> $_POST["editarRazonSocial"],
                        "cuit"=> $_POST['editarCUIT'],
                        "planta"=> $_POST['editarPlanta'],                        
                        "numeroPlanta"=> $_POST['editarNumeroPlanta'],
                        "pais"=> $_POST['editarPais']);

            $respuesta = ClientesModel::mdlEditarCliente($datos);

            if($respuesta == 'ok')
            {
                echo '<script>
                  swal({
                      type: "success",
                      text: "¡El cliente ha sido guardado correctamente!",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result){
                      if (result.value) {
                        window.location = "clientes";
                      }
                    });
                </script>';
            }else{
              echo '<script>
                  swal({
                      type: "error",
                      text: "¡El cliente ya se encuentra registrado en el sistema!",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result){
                      if (result.value) {
                        window.location = "clientes";
                      }
                    });
                </script>';
            }

        }
  }


  /** ===========================================================

  CHECK IF CLIENTE HAVE ACCESS TO SYSTEM

  ==============================================================**/
  static public function ctrClienteHaveAccess($clienteID){

      $usuariosHabilitados = ClientesModel::mdlGetClienteUsuariosHabilitados($clienteID);

      return (count($usuariosHabilitados) > 0 ) ? true : false;
  }



  /**===============================================================

  SHOW CLIENTE AND CLIENTES

  =================================================================**/


  static public function ctrMostrarClientes(){

      return ClientesModel::mdlMostrarClientes();
  }


  static public function ctrMostrarClienteByID($idCliente){

      return ClientesModel::mdlMostrarClienteByID($idCliente);
  }


  static public function ctrMostrarClienteByCUIT($idCUIT){

      return ClientesModel::mdlMostrarClienteByCUIT($idCUIT);
  }
  

  /**===============================================================

  BORRAR CLIENTE

  =================================================================**/

  public function ctrBorrarCliente() {

     if(isset($_GET['c'])){
    

      $totalCartasFromCliente = CartasModel::getTotalOfCartasByClient($_GET['c']);

      if($totalCartasFromCliente['TOTAL_CARTAS'] > 0){

         echo '<script>
                      swal({
                          type: "warning",
                          text: "¡No se puede borrar un cliente con cartas de porte registradas!",
                          confirmButtonColor: "#3085d6",
                          cancelButtonColor: "#d33",
                          closeOnConfirm: false,
                          confirmButtonText: "Cerrar"
                        }).then(function(result) {
                          if (result.value) {
                            window.location = "clientes";
                          }
                        });
                    </script>';

         return;           

      }else{

        $respuesta = ClientesModel::mdlBorrarCliente($_GET['c']);

          if($respuesta == 'ok')
                {
                    echo '<script>
                      swal({
                          type: "success",
                          text: "¡El cliente ha sido borrado correctamente!",
                          confirmButtonColor: "#3085d6",
                          cancelButtonColor: "#d33",
                          closeOnConfirm: false,
                          confirmButtonText: "Cerrar"
                        }).then(function(result) {
                          if (result.value) {
                            window.location = "clientes";
                          }
                        });
                    </script>';
                }else{
                  echo '<script>
                      swal({
                          type: "warning",
                          text: "No fue posible borrar al cliente correctamente, tente otra vez por favor.",
                          confirmButtonColor: "#3085d6",
                          cancelButtonColor: "#d33",
                          closeOnConfirm: false,
                          confirmButtonText: "Cerrar"
                        }).then((result) => {
                          if (result.value) {
                            window.location = "clientes";
                          }
                        });
                    </script>';
                }
      }    
    }  
  }


}
