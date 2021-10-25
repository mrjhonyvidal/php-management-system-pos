<?php 
/**
 * Clase que agrupa los correos que el sistema envia automáticamente
 * 
 * @author Jhony Vidal 
 */

class CorreosHelper{
 
 	// Los correos pueden ser enviados por un servidor SMTP local o por un servicio online (SendGrid)
 	protected static $configuracionesDeEnvio;

 	
	static public function activacionDeLaCuentaDeAcceso($correo, $usuario){		
		
		self::$configuracionesDeEnvio = ConfiguracionesModel::mdlMostrarConfiguraciones();


		require 'vendor/autoload.php';
		

		if(self::$configuracionesDeEnvio["tipo_servicio_correo"] == 'online'){
		  $message = new \SendGrid\Mail\Mail(); 
          $message->setFrom(self::$configuracionesDeEnvio["correo_from"], self::$configuracionesDeEnvio["correo_name"]);
          $message->setSubject("CuencaSIS - Bienvenido y habilite tu cuenta");
          $message->addTo($correo, $usuario);
          $message->addContent(
              "text/html", "<div style='width:100%; background:#eee; position:relative; font-family:sans-serif;padding-bottom:40px'>
              <center>
                <p style='padding:20px'>CuencaSIS | Sistema de Gestión Portuaria</p>
              </center> 

              <div style='position:relative; margin:auto; width:600px; background:white; padding:20px'>
                <center>      
                
                <h3 style='font-weight:100;color:#999'>ACTIVACIÓN DE TU CUENTA</h3>
                <hr style='border:1px solid #ccc; width:80%'>                
                <h4 style='font-weight:100; color:#999; padding:0 20px'>Utilize el siguiente enlace para confirmar y activar tu cuenta en CUENCA SIS.</h4>

                <a href='" . $_SERVER['SERVER_NAME'] . "/index.php?hub=login&do=dKKsn287KPOOWKWMNxnmBVvvbs1p241iPIsadJLwOp24Xzmvvc2Cvb627GHH2OPpks&c=" . $correo . "&i=activacion' target='_blank' style='text-decoration:none'>
                <div style='line-height:60px; background:#3c8dbc; width:60%; color:white'>Activar cuenta</div>
                </a>
                <br />              
                </center>
              </div>
            </div>"
          );	

          // jvidal get this info from DB!
          $sendgrid = new \SendGrid(self::$configuracionesDeEnvio["online_correo_provider_secret_key"]);

          return $sendgrid->send($message); 
		}else{		

				$mail = new \PHPMailer; 
				// TODO jvidal Buscar la info de distintos servidores para probar
				// TODO jvidal Buscar todo desde el servidor
				//Server settings
			    //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
			    //$mail->isSMTP();                                      // Set mailer to use SMTP
			    //$mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
			    //$mail->SMTPAuth = true;                               // Enable SMTP authentication
			    //$mail->Username = 'user@example.com';                 // SMTP username
			    //$mail->Password = 'secret';                           // SMTP password
			    //$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			    //$mail->Port = 587;                                    // TCP port to connect to

				//$mail->isSMTP();
				$mail->setFrom('gestion@cuencasis.com', 'Moderador'); 		
				$mail->addAddress($correo, $usuario);//Recipient name is optional				
				$mail->isHTML(true); 
				$mail->Subject = "CuencaSIS - Bienvenido y habilite tu cuenta"; 
				$mail->Body = "<div style='width:100%; background:#eee; position:relative; font-family:sans-serif;padding-bottom:40px'>
		              <center>
		                <p style='padding:20px'>CuencaSIS | Sistema de Gestión Portuaria</p>
		              </center> 

		              <div style='position:relative; margin:auto; width:600px; background:white; padding:20px'>
		                <center>      
		                
		                <h3 style='font-weight:100;color:#999'>ACTIVACIÓN DE TU CUENTA</h3>
		                <hr style='border:1px solid #ccc; width:80%'>                
		                <h4 style='font-weight:100; color:#999; padding:0 20px'>Utilize el siguiente enlace para confirmar y activar tu cuenta en CUENCA SIS.</h4>

		                <a href='" . $_SERVER['SERVER_NAME'] . "/index.php?hub=login&do=dKKsn287KPOOWKWMNxnmBVvvbs1p241iPIsadJLwOp24Xzmvvc2Cvb627GHH2OPpks&c=" . $correo ."&i=activacion' target='_blank' style='text-decoration:none'>
		                <div style='line-height:60px; background:#3c8dbc; width:60%; color:white'>Activar cuenta</div>
		                </a>
		                <br />              
		                </center>
		              </div>
		            </div>";

		     return $mail->send();    							
		}	
	}	


	static public function recuperacionContrasena($correo, $nombre = null, $tokenToRecovery = null){		
				
		self::$configuracionesDeEnvio = ConfiguracionesModel::mdlMostrarConfiguraciones();

		require 'vendor/autoload.php';
			 
	      	  
		if(self::$configuracionesDeEnvio["tipo_servicio_correo"] == 'online'){
		  $message = new \SendGrid\Mail\Mail(); 
          $message->setFrom(self::$configuracionesDeEnvio["correo_from"], self::$configuracionesDeEnvio["correo_nombre"]);
          $message->setSubject("CuencaSIS - Recuperación de acceso al sistema");
          $message->addTo($correo, $nombre);
          $message->addContent(
              "text/html", "<div style='width:100%; background:#eee; position:relative; font-family:sans-serif;padding-bottom:40px'>
              <center>
                <p style='padding:20px'>CuencaSIS | Sistema de Gestión Portuaria</p>
              </center> 

              <div style='position:relative; margin:auto; width:600px; background:white; padding:20px'>
                <center>      
                
                <h3 style='font-weight:100;color:#999'>RECUPERAR ACCESO AL SISTEMA</h3>
                <hr style='border:1px solid #ccc; width:80%'>
                <h4 style='font-weight:100; color:#999; padding:0 20px'>Utilize el siguiente enlace para registrar una nueva contraseña de acceso</h4>

                <a href='" . $_SERVER['SERVER_NAME'] . "/index.php?hub=change-credentials&token=" . $tokenToRecovery . "&c=" . $correo . "' target='_blank' style='text-decoration:none'>
                <div style='line-height:60px; background:#3c8dbc; width:60%; color:white'>Actualizar datos</div>
                </a>
                <br />
                <h5 style='font-weight:100; color:#999'>El enlace de recuperación es válido solamente por 48 horas, después ya no se podrá acceder al mismo, por lo que deberías acceder nuevamente a la <a href='" . $_SERVER['SERVER_NAME'] . "/recovery' target='_blank'>URL de recuperación de contraseña</a>.</h5>
                </center>
              </div>
            </div>"
          );	

          // jvidal get this info from DB!
          $sendgrid = new \SendGrid(self::$configuracionesDeEnvio["online_correo_provider_secret_key"]);

          return $sendgrid->send($message); 
		}else{
				

				$mail = new \PHPMailer; 
				// TODO jvidal Buscar la info de distintos servidores para probar
						
				$mail->setFrom(self::$configuracionesDeEnvio["correo_from"], self::$configuracionesDeEnvio["correo_nombre"]); 		
				$mail->addAddress($correo, $usuario);//Recipient name is optional				
				$mail->isHTML(true); 
				$mail->Subject = "CuencaSIS - Bienvenido y habilite tu cuenta"; 
				$mail->Body = "<div style='width:100%; background:#eee; position:relative; font-family:sans-serif;padding-bottom:40px'>
			              <center>
			                <p style='padding:20px'>CuencaSIS | Sistema de Gestión Portuaria</p>
			              </center> 

			              <div style='position:relative; margin:auto; width:600px; background:white; padding:20px'>
			                <center>      
			                
			                <h3 style='font-weight:100;color:#999'>RECUPERAR ACCESO AL SISTEMA</h3>
			                <hr style='border:1px solid #ccc; width:80%'>
			                <h4 style='font-weight:100; color:#999; padding:0 20px'>Utilize el siguiente enlace para registrar una nueva contraseña de acceso</h4>

			                <a href='" . $_SERVER['SERVER_NAME'] . "/index.php?hub=change-credentials&token=" . $tokenToRecovery . "&c=" . $correo . "' target='_blank' style='text-decoration:none'>
			                <div style='line-height:60px; background:#3c8dbc; width:60%; color:white'>Actualizar datos</div>
			                </a>
			                <br />
			                <h5 style='font-weight:100; color:#999'>El enlace de recuperación es válido solamente por 48 horas, después ya no se podrá acceder al mismo, por lo que deberías acceder nuevamente a la <a href='" . $_SERVER['SERVER_NAME'] . "/recovery' target='_blank'>URL de recuperación de contraseña</a>.</h5>
			                </center>
			              </div>
			            </div>";

		     return $mail->send();    							
		}	

	}

}