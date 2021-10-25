<?php

class ReportesController{


  /**===============================================================

  CREAR REPORTE

  =================================================================**/

  public function ctrCrearReporte(){

    if(isset($_POST["nuevoReporte"])){
        if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoCarta"]) &&
          !empty($_POST["nuevoCarta"]) &&
          !empty($_POST["nuevoCorreo"])) {

            $fotoPerfil = "";

            if(isset($_FILES["nuevaFoto"]["tmp_name"])){
              $fotoPerfil = $this->transform_and_save_image($_FILES["nuevaFoto"], $_POST['nuevaFoto'], $_POST["nuevoCarta"], $fotoPerfil);
            }


            $datos = array("nombre"=> $_POST["nuevoNombre"],
                        "apellido"=> $_POST["nuevoApellido"],
                        "usuario"=> $_POST['nuevoCarta'],
                        "correo"=> $_POST['nuevoCorreo'],
                        "password"=> password_hash($_POST['nuevoPassword'], PASSWORD_DEFAULT),
                        "estado"=> $_POST['nuevoEstado'],
                        "perfil"=> $_POST['nuevoPerfil'],
                        "foto" => $fotoPerfil);

            $respuesta = CartasModel::mdlIngresarCarta($datos);

            if($respuesta == 'ok')
            {
                echo '<script>
                  swal({
                      type: "success",
                      text: "¡El usuario ha sido guardado correctamente!",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result){
                      if (result.value) {
                        window.location = "usuarios";
                      }
                    });
                </script>';
            }else{
              echo '<script>
                  swal({
                      type: "error",
                      text: "¡El usuario o correo ya se encuentra registrado en el sistema!",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result){
                      if (result.value) {
                        window.location = "usuarios";
                      }
                    });
                </script>';
            }

        }else{
            echo '<script>
              swal({
                  type: "error",
                  text: "El campo usuario no puede ir vacío o llevar caracteres especiales, así como correo tampoco puede estar vacío.",
                  showCancelButton: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#d33",
                  closeOnConfirm: false,
                  confirmButtonText: "Cerrar"
                }).then(function(result){
                  if (result.value) {
                    window.location = "usuarios";
                  }
                });
            </script>';
        }
      }
  }


  /**===============================================================

  EDITAR REPORTE
  =================================================================**/

  public function ctrEditarReporte(){

    if(isset($_POST['editarCliente'])){

      /** preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"]) &&
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarApellido"]) &&
        **/

      if(!empty($_POST['editarCorreo'])) {

            $fotoPerfil = $_POST['fotoActual'];

            if( isset($_FILES["editarFoto"]["tmp_name"]) && !empty( $_FILES["editarFoto"]["tmp_name"] ) ){
              $fotoPerfil = $this->transform_and_save_image($_FILES["editarFoto"], $_POST['editarFoto'], $_POST["editarCarta"], $fotoPerfil);
            }


            if($_POST['editarPassword'] != ""){

              if(preg_match('/^[a-zA-Z0-9@$#_]+$/', $_POST["editarPassword"])){
                  $password = password_hash($_POST['editarPassword'], PASSWORD_DEFAULT);
              }else{
                echo '<script>
                  swal({
                      type: "error",
                      text: "La contraseña no puede ser vacía o llevar caracteres especiales que no sean ()$ # @ _)",
                      showCancelButton: true,
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result){
                      if (result.value) {
                        window.location = "usuarios";
                      }
                    });
                </script>';
              }
            }else{
              $password = $_POST['passwordActual'];
            }

            $datos = array("nombre"=> $_POST["editarNombre"],
                        "apellido"=> $_POST["editarApellido"],
                        "usuario"=> $_POST['editarCarta'],
                        "correo"=> $_POST['editarCorreo'],
                        "password"=> $password,
                        "estado"=> $_POST['editarEstado'],
                        "perfil"=> $_POST['editarPerfil'],
                        "foto" => $fotoPerfil);

            $respuesta = CartasModel::mdlEditarCarta($datos);

            if($respuesta == 'ok')
            {
                echo '<script>
                  swal({
                      type: "success",
                      text: "¡El usuario ha sido editado correctamente!",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result) {
                      if (result.value) {
                        window.location = "usuarios";
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
                        window.location = "usuarios";
                      }
                    });
                </script>';
            }

        }else{
            echo '<script>
              swal({
                  type: "error",
                  text: "El campo correo no puede ir vacío!",
                  showCancelButton: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#d33",
                  closeOnConfirm: false,
                  confirmButtonText: "Cerrar"
                }).then(function(result) {
                  if (result.value) {
                    window.location = "usuarios";
                  }
                });
            </script>';
        }

    }

  }





  /**===============================================================

  SHOW REPORTE AND REPORTES

  =================================================================**/


  static public function ctrMostrarReportes(){

      return CartasModel::mdlMostrarReportes();
  }


  static public function ctrMostrarReporte($idReporte){

      return CartasModel::mdlMostrarReporte($idReporte);
  }

  

  /**===============================================================

  BORRAR CLIENTE

  =================================================================**/

  public function ctrBorrarReporte() {


    

  }

}
