<?php

class UsuariosController{

  public function ctrIngresoUsuario(){


    if($_GET['i'] == 'activacion' && $_GET['c'] != ''){
      $respuesta = UsuariosModel::mdlActivarUsuarioByCorreo($_GET['c']);      
    }

    if($this->isValidCUIT() === 1 && $this->isValidPassword() === 1){

      $respuesta = UsuariosModel::Auth(trim(str_replace('-','',($_POST['ingCUIT']))), $_POST['ingPassword']);

      if ($respuesta){
        echo '<script>window.location = "cartas-de-porte" </script>';

      }else{
        echo '<br /><div class="alert alert-danger">Error al ingresar, vuelve a intentar</div>';
      }
    }
  }


  /**===============================================================

  CREAR USUARIO

  =================================================================**/

  public function ctrCrearUsuario(){

    if(isset($_POST["nuevoUsuario"])){
        if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoUsuario"]) &&
          !empty($_POST["nuevoUsuario"]) &&
          !empty($_POST["nuevoCorreo"])) {

            $fotoPerfil = "";

            if(isset($_FILES["nuevaFoto"]["tmp_name"])){
              $fotoPerfil = $this->transform_and_save_image($_FILES["nuevaFoto"], $_POST['nuevaFoto'], $_POST["nuevoUsuario"], $fotoPerfil);
            }


            $datos = array("nombre"=> $_POST["nuevoNombre"],
                        "apellido"=> $_POST["nuevoApellido"],
                        "usuario"=> $_POST['nuevoUsuario'],
                        "correo"=> $_POST['nuevoCorreo'],
                        "password"=> password_hash($_POST['nuevoPassword'], PASSWORD_DEFAULT),
                        "cliente"=> $_POST['nuevoClienteID'],
                        "estado"=> $_POST['nuevoEstado'],
                        "perfil"=> $_POST['nuevoPerfil'],
                        "foto" => $fotoPerfil);

            $respuesta = UsuariosModel::mdlIngresarUsuario($datos);

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

  EDITAR USUARIO

  =================================================================**/

  public function ctrEditarUsuario(){

    if(isset($_POST['editarUsuario'])){

      /** preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"]) &&
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarApellido"]) &&
        **/

      if(!empty($_POST['editarCorreo'])) {

            $fotoPerfil = $_POST['fotoActual'];

            if( isset($_FILES["editarFoto"]["tmp_name"]) && !empty( $_FILES["editarFoto"]["tmp_name"] ) ){
              $fotoPerfil = $this->transform_and_save_image($_FILES["editarFoto"], $_POST['editarFoto'], $_POST["editarUsuario"], $fotoPerfil);
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

            $datos = array("usuarioID"=> $_POST["idUsuario"],
                        "nombre"=> $_POST["editarNombre"],
                        "apellido"=> $_POST["editarApellido"],
                        "usuario"=> $_POST['editarUsuario'],
                        "correo"=> $_POST['editarCorreo'],
                        "password"=> $password,
                        "cliente"=> $_POST['editarClienteID'],
                        "estado"=> $_POST['editarEstado'],
                        "perfil"=> $_POST['editarPerfil'],
                        "foto" => $fotoPerfil);

            $respuesta = UsuariosModel::mdlEditarUsuario($datos);

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


public function ctrRegisterUsuario(){  

   if(isset($_POST['passwordConfirm']) && isset($_POST['password'])){

      if($_POST['passwordConfirm'] == $_POST['password']){
      
      $datosUsuarioyCliente = array("correo"=> $_POST['correo'],
                          "usuario"=> $_POST['usuario'],
                          "password"=> password_hash($_POST['password'], PASSWORD_DEFAULT),
                          "cuit" => $_POST['cuit'],
                          "razon"=> $_POST['razonSocial']);

          
      $respuesta = UsuariosModel::mdlRegisterClienteAssociatedUsuario($datosUsuarioyCliente);

      if($respuesta == 'ok'){
      

          try {              
              
              $response = CorreosHelper::activacionDeLaCuentaDeAcceso($_POST['correo'], $_POST['usuario']);   

               echo '<script>
                swal({
                    type: "success",
                    text: "Los datos fueron registrados con éxito. Por favor revise la bandeja de entrada o la carpeta de SPAM del correo electrónico registrado para activar el acceso al sistema.",
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    closeOnConfirm: false,
                    confirmButtonText: "Cerrar"
                  }).then(function(result){
                    if (result.value) {
                      window.location = "login";
                    }
                  });
              </script>';
          } catch (Exception $e) {
              echo 'Caught exception: ',  $e->getMessage(), "\n";
          }        
    
      }
          

      }else{
          echo '<script>
                    swal({
                        type: "warning",
                        text: "Las contraseñas deben ser idénticas.",
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        closeOnConfirm: false,
                        confirmButtonText: "Cerrar"
                      }).then(function(result){
                        if (result.value) {     

                        }
                      });
                  </script>';
      }

    }                 

}




public function ctrChangeUserCrendetials(){  

   if(isset($_POST['passwordConfirm']) && isset($_POST['password'])){

    if($_POST['passwordConfirm'] == $_POST['password']){
  
        require 'vendor/autoload.php';
        $carbon = new \Carbon\Carbon;

        $userInfo = UsuariosModel::mdlGetUserInfoFromCorreo($_POST['correo']);
            

        if($userInfo['token_recovery'] == $_POST['token'] && $userInfo['date_expiration_recovery'] > $carbon::now() && $_POST['correo'] ==  $userInfo['correo'] && $userInfo['estado'] == 'ACTIVADO'){

          $passwordHashed = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $respuesta = UsuariosModel::mdlUpdatePassword($userInfo['id'], $passwordHashed);

            if($respuesta == 'ok'){
               echo '<script>
                  swal({
                      type: "success",
                      text: "Datos de acceso actualizado con éxito.",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result){
                      if (result.value) {     
                         window.location = "login";
                      }
                    });
                </script>';
            }

        }else{
          echo '<script>
                  swal({
                      type: "warning",
                      text: "Token inválido o fecha de recuperación ha caducado, por favor envie nuevamente un pedido para recuperar el acceso al sistema.",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result){
                      if (result.value) {     
                         window.location = "recovery";
                      }
                    });
                </script>';
        }


       }else{
          echo '<script>
                    swal({
                        type: "warning",
                        text: "Las contraseñas deben ser idénticas.",
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        closeOnConfirm: false,
                        confirmButtonText: "Cerrar"
                      }).then(function(result){
                        if (result.value) {     

                        }
                      });
                  </script>';
       
       }

    }   

 } 



public function ctrRecoveryUsuario(){

  if(isset($_POST['clientCUIT'])){


    $cuitCleaned = trim(str_replace('-','',$_POST['clientCUIT']));

    $userInfo = UsuariosModel::mdlGetUserInfoFromClienteCUIT($cuitCleaned);


    if(!empty($userInfo['correo'])){

      require 'vendor/autoload.php';

        $token = $this->generate_token(11);

        $tokenToRecovery = password_hash($token, PASSWORD_DEFAULT);

        $carbon = new \Carbon\Carbon;

        // Set to 48 hours the expiration time
        $expiration_date = $carbon::now()->addDay(2);

          $actualizarUserDatosRecovery = UsuariosModel::mdlUpdateRecoveryData($userInfo['id'], $tokenToRecovery, $expiration_date);


          try {             
              $response = CorreosHelper::recuperacionContrasena($userInfo['correo'], $userInfo['nombre'], $tokenToRecovery);   

               echo '<script>
                swal({
                    type: "success",
                    text: "Por favor revise la bandeja de entrada o la carpeta de SPAM del correo electrónico asociado al CUIT para su cambio de contraseña.",
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    closeOnConfirm: false,
                    confirmButtonText: "Cerrar"
                  }).then(function(result){
                    if (result.value) {
                      window.location = "login";
                    }
                  });
              </script>';
          } catch (Exception $e) {
              echo 'Caught exception: ',  $e->getMessage(), "\n";
          }        


    }else{

      echo '<script>
          swal({
              type: "warning",
              text: "No hay un usuario asociado al CUIT, por favor, intente otra vez.",
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              closeOnConfirm: false,
              confirmButtonText: "Cerrar"
            }).then(function(result){
              if (result.value) {
                window.location = "recovery";
              }
            });
        </script>';

    }
    
    
  }
}


  /**===============================================================

  EDITAR USUARIO

  =================================================================**/

  public function ctrEditarProfileAcceso(){


    if(isset($_POST['profileUsuario']) || isset($_POST['profileCUIT']) || isset($_POST['secret_key'])){
      

      /** preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"]) &&
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarApellido"]) &&
        **/

     if(isset($_POST['secret_key'])){

        $datos = array("secret_key" => $_POST["secret_key"],
                      "correoName"=> $_POST["correo_name"],
                       "correoFrom"=> $_POST['correo_from']);

        $respuesta = ConfiguracionesModel::mdlIngresarConfiguraciones($datos); 
      
      }elseif(isset($_POST['profileCUIT'])){


          $datos = array("idIdentificacion" => $_POST["profileIdentificacionID"],
                    "razonSocial"=> $_POST["profileRazonSocial"],
                    "cuit"=> $_POST['profileCUIT'],
                    "planta"=> $_POST['profilePlanta'],                        
                    "numeroPlanta"=> $_POST['profileNumeroPlanta'],
                    "pais"=> $_POST['profilePais']);

          $respuesta = ClientesModel::mdlEditarCliente($datos);

      }elseif(!empty($_POST['profileCorreo'])) {

            $fotoPerfil = $_POST['profileFotoActual'];

            if( isset($_FILES["profileFoto"]["tmp_name"]) && !empty( $_FILES["profileFoto"]["tmp_name"] ) ){
              $fotoPerfil = $this->transform_and_save_image($_FILES["profileFoto"], $_POST['profileFoto'], $_POST["profileUsuario"], $fotoPerfil);
            }


            if($_POST['profilePassword'] != ""){

              if(preg_match('/^[a-zA-Z0-9@$#_]+$/', $_POST["profilePassword"])){
                  $password = password_hash($_POST['profilePassword'], PASSWORD_DEFAULT);
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
                        window.location = "cartas-de-porte";
                      }
                    });
                </script>';
              }
            }else{
              $password = $_POST['profilePasswordActual'];
            }

            

            if(isset($_POST['profileUsuario'])){

              $datos = array("usuarioID"=> $_POST["profileIDUsuario"],
                        "nombre"=> $_POST["profileNombre"],
                        "apellido"=> $_POST["profileApellido"],
                        "usuario"=> $_POST['profileUsuario'],
                        "correo"=> $_POST['profileCorreo'],
                        "password"=> $password,
                        "cliente"=> $_POST['profileClienteID'],
                        "estado"=> $_POST['profileEstado'],
                        "perfil"=> $_POST['profilePerfil'],
                        "foto" => $fotoPerfil);

              $respuesta = UsuariosModel::mdlEditarUsuario($datos);  
            }

            if(isset($_POST['secret_key'])){

              
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
                    window.location = "cartas-de-porte";
                  }
                });
            </script>';
        }



        if($respuesta == 'ok')
            {
                echo '<script>
                  swal({
                      type: "success",
                      text: "¡Tus datos han sido editados correctamente!",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result) {
                      if (result.value) {
                        window.location = "cartas-de-porte";
                      }
                    });
                </script>';
            }else{
              echo '<script>
                  swal({
                      type: "warning",
                      text: "¡Ningún cambio realizado debido a un error, intente nuevamente!",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result) {
                      if (result.value) {
                        window.location = "cartas-de-porte";
                      }
                    });
                </script>';
            }

    }

  }



  /**===============================================================

  EDITAR CONFIGURACIONES

  // TODO jvidal
  CONFIGURACIONES SISTEMA: correo radioButton: SendGrid show/hide o SMTP Server show/hide
  DB Configuraciones: para buscar grabar la info ahí y que va ser utilizada por el metodoHelper
  sendEmailHelper donde pasamos el tipo unicamente y llamamos pasando desde las configuraciones del servidor
  ::debemos instanciar para consumir del Model Configuraciones donde se llama email() ForgotPassword Usuario/Cliente  

  =====================================================================**/

  public function ctrEditarConfiguracionesGeneral(){

    if(isset($_POST['profileUsuario']) || isset($_POST['profileCUIT'])){

      /** preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"]) &&
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarApellido"]) &&
        **/

     if(isset($_POST['profileCUIT'])){


          $datos = array("idIdentificacion" => $_POST["profileIdentificacionID"],
                    "razonSocial"=> $_POST["profileRazonSocial"],
                    "cuit"=> $_POST['profileCUIT'],
                    "planta"=> $_POST['profilePlanta'],                        
                    "numeroPlanta"=> $_POST['profileNumeroPlanta'],
                    "pais"=> $_POST['profilePais']);

          $respuesta = ClientesModel::mdlEditarCliente($datos);

      }elseif(!empty($_POST['profileCorreo'])) {

            $fotoPerfil = $_POST['profileFotoActual'];

            if( isset($_FILES["profileFoto"]["tmp_name"]) && !empty( $_FILES["profileFoto"]["tmp_name"] ) ){
              $fotoPerfil = $this->transform_and_save_image($_FILES["profileFoto"], $_POST['profileFoto'], $_POST["profileUsuario"], $fotoPerfil);
            }


            if($_POST['profilePassword'] != ""){

              if(preg_match('/^[a-zA-Z0-9@$#_]+$/', $_POST["profilePassword"])){
                  $password = password_hash($_POST['profilePassword'], PASSWORD_DEFAULT);
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
                        window.location = "cartas-de-porte";
                      }
                    });
                </script>';
              }
            }else{
              $password = $_POST['profilePasswordActual'];
            }

            

            if(isset($_POST['profileUsuario'])){

              $datos = array("usuarioID"=> $_POST["profileIDUsuario"],
                        "nombre"=> $_POST["profileNombre"],
                        "apellido"=> $_POST["profileApellido"],
                        "usuario"=> $_POST['profileUsuario'],
                        "correo"=> $_POST['profileCorreo'],
                        "password"=> $password,
                        "cliente"=> $_POST['profileClienteID'],
                        "estado"=> $_POST['profileEstado'],
                        "perfil"=> $_POST['profilePerfil'],
                        "foto" => $fotoPerfil);


              $respuesta = UsuariosModel::mdlEditarUsuario($datos);  
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
                    window.location = "cartas-de-porte";
                  }
                });
            </script>';
        }



        if($respuesta == 'ok')
            {
                echo '<script>
                  swal({
                      type: "success",
                      text: "¡Tus datos han sido editados correctamente!",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result) {
                      if (result.value) {
                        window.location = "cartas-de-porte";
                      }
                    });
                </script>';
            }else{
              echo '<script>
                  swal({
                      type: "warning",
                      text: "¡Ningún cambio realizado debido a un error, intente nuevamente!",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then(function(result) {
                      if (result.value) {
                        window.location = "cartas-de-porte";
                      }
                    });
                </script>';
            }

    }

  }



  /**===============================================================

  SHOW USUARIOS AND USUARIO

  =================================================================**/


  static public function ctrMostrarUsuarios(){

      return UsuariosModel::mdlMostrarUsuarios();
  }


  static public function ctrMostrarUsuario($idUser, $idCliente = null){

      return UsuariosModel::mdlMostrarUsuario($idUser, $idCliente);
  }

  

  /**===============================================================

  BORRAR USUARIO

  =================================================================**/

  public function ctrBorrarUsuario() {


    if(isset($_GET['iu'])){

      $data = $_GET['iu'];


      if($_GET['f'] != ""){

          unlink($_GET['f']);
          rmdir('views/img/usuarios/' . $_GET["u"]);
      }

      $respuesta = UsuariosModel::mdlBorrarUsuario($_GET["iu"], $_GET['c']);

      if($respuesta == 'ok')
            {
                echo '<script>
                  swal({
                      type: "success",
                      text: "¡El usuario ha sido borrado correctamente!",
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
                      text: "No fue posible borrar al usuario correctamente, tente otra vez por favor.",
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      closeOnConfirm: false,
                      confirmButtonText: "Cerrar"
                    }).then((result) => {
                      if (result.value) {
                        window.location = "usuarios";
                      }
                    });
                </script>';
            }

    }

  }


  private function generate_token($size){

      $key = '';
      $pattern = 'kj412jjJK$H42149912ISUIUW0UJdL862927465KKZXXssxmmnsqSHLNMEhUiPPWw45';

      $max = strlen($pattern)-1;

      for($i = 0; $i < $size; $i++){
        $key .= $pattern{mt_rand(0,$max)};
      }

      return $key;
  }



  /**===============================================================

  HELPER FUNCTIONS

  =================================================================**/

  private function transform_and_save_image($image_uploaded_tmp, $image_filename, $image_user_owner, $foto){

            list($ancho, $alto) = getimagesize($image_uploaded_tmp["tmp_name"]);

            $nuevoAncho = 500;
            $nuevoAlto = 500;

            $directorio = "views/img/usuarios/" . $image_user_owner;

            // Verificar si ya existe otra imagen en la base de datos
            if(!empty($foto)){
              unlink($foto);
            }else{

              mkdir($directorio, 0755);

            }

            if($image_uploaded_tmp["type"] == "image/jpeg"){

              $aleatorio = md5(uniqid());

              $foto = "views/img/usuarios/" . $image_user_owner . "/" . $aleatorio . ".jpg";

              $origen = imagecreatefromjpeg($image_uploaded_tmp['tmp_name']);

              $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

              imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

              imagejpeg($destino, $foto);
            }


            if($image_uploaded_tmp["type"] == "image/png"){

              $aleatorio = md5(uniqid());

              $foto = "views/img/usuarios/" . $image_user_owner . "/" . $aleatorio . ".png";

              $origen = imagecreatefrompng($image_uploaded_tmp['tmp_name']);

              $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

              imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

              imagepng($destino, $foto);
            }

      // Returns the path to be stored in database;
      return $foto;
  }


  private function isValidCUIT(){
    //remove all non-numeric characters from CUIT field to avoid 00-8-0
    $CUIT = preg_replace('/\D/','', $_POST['ingCUIT']);
    return preg_match('/^[0-9]+$/', $CUIT);
  }


  private function isValidPassword(){

    return preg_match('/^[a-zA-Z0-9]+$/', $_POST['ingPassword']);
  }

}
