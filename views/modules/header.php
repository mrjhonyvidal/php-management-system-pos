<header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="cartas-de-porte" class="navbar-brand"><b>Cuenca</b>SIS</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <!--
            <form class="navbar-form navbar-left" role="search">
              <div class="form-group">
                <input type="text" class="form-control" id="navbar-search-input" placeholder="Buscar por Carta o CUIT...">
              </div>
            </form>
            -->

            <li class="active">
              <a href="cartas-de-porte">
                <i class="fa fa-wpforms"></i>
                <span>Cartas</span>
              </a>
            </li>

            <li class="">
              <a href="descargas">
                <i class="fa fa-truck"></i>
                <span>Descargas</span>
              </a>
            </li>

            <?php if(UsuariosHelper::isSYSAdmin(null, $_SESSION['idcliente'])){ ?>
            <li class="">
              <a href="clientes">
                <i class="fa fa-users"></i>
                <span>Clientes</span>
              </a>
            </li>

            <li class="">
              <a href="usuarios">
                <i class="fa fa-user"></i>
                <span>Usuarios</span>
              </a>
            </li>

            <li class="">
              <a href="reportes">
                <i class="fa fa-line-chart"></i>
                <span>Reportes</span>
              </a>
            </li>
            <?php } ?>
          </ul>

        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->

            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->

                <?php 

                $usuario = UsuariosHelper::getAuthenticatedUserProfile($_SESSION["idusuario"]);                

                if($usuario["foto"] != ""){
                    echo '<img src="' . $usuario['foto'] . '" class="user-image">';
                }else{
                    echo '<img src="views/img/usuarios/gravatar.gif" class="user-image" alt="User Image">';
                }
                ?>
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs">Mi cuenta</span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                    <?php 
                    if($usuario["foto"] != ""){
                        echo '<img src="' . $usuario['foto'] . '" class="user-image">';
                    }else{
                        echo '<img src="views/img/usuarios/gravatar.gif" class="user-image" alt="User Image">';
                    }
                    ?>                    
                  <p>
                    <p><?php echo $usuario['nombre'] . ', ' . $usuario['apellido'] ?></p>
                    <small><?php echo $usuario['correo'] ?></small>
                  </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                  <div class="row">
                    <center><a href="http://freezing-jay.cloudvent.net/" target="_blank" title="Ayuda">
                      <i class="fa fa-question-circle"> FAQ </i>
                    </a></center>
                  </div>
                  <!-- /.row -->
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">                    
                    <?php echo '<div id="profile"><button class="btn btn-default btn-flat btnEditarProfile" data-id="' . $_SESSION["idusuario"] . '" data-c="' . $_SESSION["idcliente"] . '" aria-hidden="true" data-toggle="modal" data-target="#modalProfile"><i class="fa fa-pencil"> </i> Cuenta</button></div>';
                    ?>
                  </div>
                  <div class="pull-right">
                    <a href="salir" class="btn btn-default btn-flat">Salir</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>


   <!-- MODAL EDITAR USUARIO -->
 <div id="modalProfile" class="modal fade" role="dialog">
   <div class="modal-dialog modal-lg">

     <div class="modal-content">

       

       <div class="modal-header" style="background:#3c8dbc; color: #fff">
         <button type="button" class="close" data-dismiss="modal">&times;</button>         
       </div>
       <div class="modal-body">
         <div class="box-body">

          
             <!-- tabs left -->
         <div class="col-lg-12">    
          <div class="tabbable tabs-left" role="tabpanel">

           <div class="col-lg-3">     
              <ul class="nav nav-tabs">
                <li class="active"><a href="#acceso" role="tab"  aria-controls="accesoTab" data-toggle="tab">Acceso</a></li>
                <li><a href="#empresa" aria-controls="empresaTab" role="tab" data-toggle="tab">Datos Empresa</a></li>              

                 <?php if(UsuariosHelper::isSYSAdmin(null, $_SESSION['idcliente'])){ ?>
                      <li>
                        <a href="#configuraciones" aria-controls="configuracionesTab" role="tab" data-toggle="tab">Configuraciones</a>
                      </li>
                  <?php } ?>  
              </ul>
            </div>
            <div class="col-lg-8">
             <div class="tab-content">
             <div class="tab-pane active" role="tabpanel" id="acceso">


                  <form action="" role="form" method="post" enctype="multipart/form-data">

                      <div class="row">
                         <div class="col-lg-6">
                           <div class="form-group">
                             <div class="input-group">
                               <span class="label label-default">Nombre</span>
                                 <input type="text" class="form-control" id="profileNombre" name="profileNombre" value="" required>
                             </div>
                           </div>
                         </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                             <div class="input-group">
                                <span class="label label-default">Apellido</span>
                                 <input type="text" class="form-control" id="profileApellido" name="profileApellido" value="" required>
                             </div>
                           </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <div class="input-group">
                               <span class="label label-default"><i class="fa fa-post"></i> Correo</span>
                                <input type="text" class="form-control" id="profileCorreo" name="profileCorreo" value="">
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-6">
                           <div class="form-group">
                             <div class="input-group">
                                <span class="label label-default"><i class="fa fa-user"></i> Usuario</span>
                                 <input type="text" class="form-control" id="profileUsuario" name="profileUsuario" value="" readonly>
                                 <input type="hidden" name="profileIDUsuario" id="profileIDUsuario">
                                 <input type="hidden" name="profileClienteID" id="profileClienteID">
                                 <input type="hidden" name="profilePerfil" id="profilePerfil">
                                 <input type="hidden" name="profileEstado" id="profileEstado">
                             </div>
                           </div>
                        </div>

                        <div class="col-lg-6">
                           <div class="form-group">
                             <div class="input-group">

                                <span class="label label-default"><i class="fa fa-key"></i> Nueva Contraseña</span>
                                 <input type="password" class="form-control" name="profilePassword" value="">
                                 <input type="hidden" id="profilePasswordActual" name="profilePasswordActual">
                             </div>
                           </div>
                        </div>
                      </div>                  

                    <div class="form-group">
                         <span class="label label-default">Imagen de perfil</span>
                         <div class="panel">SUBIR FOTO</div>
                             <input type="file" class="nuevaFoto" accept="image/jpeg, image/jpg" name="profileFoto">
                             <p class="help-block">Peso máximo de la foto 2MB</p>
                             <img src="views/img/usuarios/gravatar.gif" class="img-thumbnail previsualizar-edicion" width="100px">
                             <input type="hidden" name="profileFotoActual" id="profileFotoActual">
                            
                    </div>


                  <button type="submit" class="btn btn-primary pull-right">Modificar</button>
                                                          
                   <?php
                      $editarUsuario = new UsuariosController();
                      $editarUsuario->ctrEditarProfileAcceso();
                   ?>

                 </form>

             </div>
             

             <div class="tab-pane" id="empresa" role="tab" >

                <form action="" role="form" method="post" enctype="multipart/form-data">
              

                   <div class="row">
                     <div class="col-lg-12">
                       <div class="form-group">
                         <div class="input-group">
                           <span class="label label-default">Razón</span>
                             <input type="text" class="form-control" id="profileRazonSocial" name="profileRazonSocial" value="" required>
                         </div>
                       </div>
                     </div>
                   </div>
                   
                   <div class="row">  
                     <div class="col-lg-6">
                       <div class="form-group">
                         <div class="input-group">
                            <span class="label label-default">CUIT</span>
                             <input type="text" class="form-control cuit" maxlength="12" id="profileCUIT" name="profileCUIT" value="" readonly required>
                         </div>
                       </div>
                    </div>

                    <div class="col-lg-6">
                       <div class="form-group">
                         <div class="input-group">
                            <span class="label label-default">Cliente Interno ID</span>
                             <input type="text" class="form-control" id="profileIdentificacionID" name="profileIdentificacionID" value="">
                         </div>
                       </div>
                    </div>
                  </div>        

                  <div class="row">
                    <div class="col-lg-12">
                       <div class="form-group">
                         <div class="input-group">
                            <span class="label label-default"><i class="fa fa-user"></i> Planta</span>
                             <input type="text" class="form-control" id="profilePlanta" name="profilePlanta" value="">
                         </div>
                       </div>
                    </div>
                   </div> 
                
                  <div class="row">
                     <div class="col-lg-6">
                       <div class="form-group">
                         <div class="input-group">

                            <span class="label label-default"><i class="fa fa-key"></i>Numero Planta</span>
                             <input type="text" class="form-control" id="profileNumeroPlanta" name="profileNumeroPlanta" value="">                     
                         </div>
                       </div>
                    </div>

                       <div class="col-lg-6">
                      <div class="form-group">
                        <div class="input-group">
                           <span class="label label-default">Pais</span>
                            <input type="text" class="form-control" id="profilePais" name="profilePais" value="">
                        </div>
                      </div>
                 
                 </div>
               </div>

               <button type="submit" class="btn btn-primary pull-right">Modificar</button>
            
               <?php
                  $editarCliente = new UsuariosController();
                  $editarCliente->ctrEditarProfileAcceso();
               ?>

             </form>

             </div>             


             <?php if(UsuariosHelper::isSYSAdmin(null, $_SESSION['idcliente'])){ ?>
            
               <div class="tab-pane" id="configuraciones" role="tab" >

                  <form action="" role="form" method="post">
                
                  <h3>Configuraciones del servidor de correo</h3>
                     <div class="row">
                       <div class="col-lg-12">
                         <div class="form-group">
                           <div class="input-group">
                             <span class="label label-default">Secret Key (API SendGrid)</span>
                               <input type="text" class="form-control" id="secret_key" name="secret_key" value="" required>
                           </div>
                         </div>
                       </div>
                     </div>

                      <div class="row">
                         <div class="col-lg-6">
                           <div class="form-group">
                             <div class="input-group">
                               <span class="label label-default">Nombre del remetente que aparece en el correo</span>
                                 <input type="text" class="form-control" id="correo_name" name="correo_name" value="" required>
                             </div>
                           </div>
                         </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                             <div class="input-group">
                                <span class="label label-default">Correo del remetente(Se visualiza en el correo)</span>
                                 <input type="text" class="form-control" id="correo_from" name="correo_from" value="" required>
                             </div>
                           </div>
                        </div>
                      </div>

                    <!--
                     
                     <div class="form-group">
                     <p>Usar Servidor SMTP o Servicio Online de Envio(SendGrid, MailChimp)</p>
                       <div class="input-group">
                           <span class="label label-default">Servidor Local (SMTP)</span>
                           <input type="radio" value="local" class="minimal" name="serviceType" placeholder="">

                           <span class="label label-default">Servicio Online</span>
                           <input type="radio" value="online" class="minimal" name="serviceType" placeholder="">
                       </div>
                    </div>                                       
                       -->
                     <button type="submit" class="btn btn-primary pull-right">Modificar</button>              
                     <?php
                        $editarConfiguraciones = new UsuariosController();
                        $editarConfiguraciones->ctrEditarProfileAcceso();
                     ?>

                   </form>                                                                                            
                 </div>            
             <?php } ?>

             </div>
            </div>
          </div>
        </div>
      <!-- /tabs -->       
         
              
          </div>
        </div>

         <div class="modal-footer">
                     <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>                  
          </div>

      </div>
     </div>
    </div>  

