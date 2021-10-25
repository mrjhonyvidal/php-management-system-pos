<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <div class="container">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
       Administrador de usuarios
     </h1>
     <ol class="breadcrumb">
       <li><a href="cartas-de-porte"><i class="fa fa-dashboard"></i> Cartas</a></li>
       <li class="active">Panel de Usuarios</li>
     </ol>
   </section>

   <!-- Main content -->
   <section class="content">

     <!-- Default box -->
     <div class="box">

       <div class="box-header with-border">
         <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">
           Agregar Usuario
         </button>

       </div>

       <div class="box-body">
         <table id="tableUsuarios" class="table table-bordered table-striped dt-responsive nowrap tablasUsuarios tablas" width="100%">
           <thead>
             <tr>
               <th style="width:10px">#</th>
               <th>Nombre</th>
               <th>Usuario</th>
               <th>Cliente</th>
               <th>Foto</th>               
               <th>Estado</th>
               <th>Último login</th>
               <th>Acciones</th>
             </tr>
           </thead>
            <tbody>

              <?php
                $usuarios = UsuariosController::ctrMostrarUsuarios();

                foreach($usuarios as $key => $value){
                  echo '<tr>
                    <td>' . $value["id"] . '</td>
                    <td>' . $value["nombre"] . ' ' . $value["apellido"] . '</td>
                    <td>' . $value["usuario"] . '</td>
                    <td>' . $value["razon_social"] . '</td>';


                    if($value["foto"] != ""){
                      echo '<td><img src="' . $value["foto"] . '" class="img-thumbnail" width="40px"></td>';
                    }else{
                      echo '<td><img src="views/img/usuarios/gravatar.gif" class="img-thumbnail" width="40px"></td>';
                    }
                              

                    if ($value["estado"] == 'ACTIVADO'){

                      echo '<td><button class="btn btn-success btn-xs btnActivar" idUsuario = "' . $value["id"] . '" estadoUsuario ="DESACTIVADO">ACTIVADO</button></td>';  

                    }else{
                      echo '<td><button class="btn btn-danger btn-xs btnActivar" idUsuario = "' . $value["id"] . '" estadoUsuario ="ACTIVADO">DESACTIVADO</button></td>';  
                    }
                    

                    echo '<td>' . $value["ultimo_login"] . '</td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-warning btnEditarUsuario" data-id="' . $value["id"] . '" data-c="' . $value["cliente_id"] . '" aria-hidden="true" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger btnEliminarUsuario" iu="' . $value["id"] . '" f="' . $value["foto"] .'" u="' . $value["usuario"] .  '" c="' . $value["cliente_id"] . '"><i class="fa fa-times"></i></button>
                      </div>
                    </td>
                  </tr>';
                }
              ?>
             </tbody>
         </table>

       </div>

     </div>
     <!-- /.box -->

   </section>
   <!-- /.content -->
 </div>
</div>
 <!-- /.content-wrapper -->

 <!-- MODAL AGREGAR USUARIO -->
 <div id="modalAgregarUsuario" class="modal fade" role="dialog">
   <div class="modal-dialog">

     <div class="modal-content">

       <form action="" role="form" method="post" enctype="multipart/form-data">

       <div class="modal-header" style="background:#3c8dbc; color: #fff">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Agregar Usuario</h4>
       </div>
       <div class="modal-body">
         <div class="box-body">


          <div class="row">
             <div class="col-lg-12"">
              <div class="form-group">
                 <div class="input-group" style="width: 100%">
                   <span class="label label-default">Cliente</span>
                     <select class="form-control" name="nuevoClienteID" required>
                       <option value="" id="nuevoClienteID">Seleccionar Cliente</option>                                              
                        <?php 

                          
                          $clientes = ClientesController::ctrMostrarClientes();

                          foreach($clientes as $key => $value){
                              echo '<option value="' . $value["id_cliente"] . '">' . $value["razon_social"] . '</option>';     
                          }                         

                        ?>
                      
                   </select>
                 </div>
               </div>
             </div>
          </div>


           <div class="row">
             <div class="col-lg-6">
               <div class="form-group">
                 <div class="input-group">
                   <span class="label label-default">Nombre</span>
                     <input type="text" class="form-control" name="nuevoNombre" placeholder="Ingresar Nombre">
                 </div>
               </div>
             </div>
             <div class="col-lg-6">
               <div class="form-group">
                 <div class="input-group">
                   <span class="label label-default">Apellido</span>
                     <input type="text" class="form-control" name="nuevoApellido" placeholder="Ingresar Apellido">
                 </div>
               </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <div class="input-group">
                   <span class="label label-default"><i class="fa fa-post"></i> Correo</span>
                    <input type="text" class="form-control" id="nuevoCorreo" name="nuevoCorreo" placeholder="Ingrese tu correo" value="">
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
               <div class="form-group">
                 <div class="input-group">
                   <span class="label label-default"><i class="fa fa-user"></i> Usuario</span>
                     <input type="text" class="form-control" id="nuevoUsuario" name="nuevoUsuario" placeholder="Ingresar Usuario" required>
                 </div>
               </div>
             </div>
            <div class="col-lg-6">
               <div class="form-group">
                 <div class="input-group">
                   <span class="label label-default"><i class="fa fa-key"></i> Contraseña</span>
                     <input type="password" class="form-control" name="nuevoPassword" placeholder="Ingresar Contraseña" required>
                 </div>
               </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
               <div class="form-group">
                 <div class="input-group">
                   <span class="label label-default">Perfil</span>
                     <select class="form-control" name="nuevoPerfil">                       
                       <option value="Administrador">Administrador</option>
                     </select>
                 </div>
               </div>
            </div>

            <div class="col-lg-6">
               <div class="form-group">
                 <div class="input-group">
                   <span class="label label-default">Estado</span>
                     <select class="form-control" name="nuevoEstado">
                       <option value="ACTIVADO">ACTIVADO</option>
                       <option value="DESACTIVADO">DESACTIVADO</option>
                     </select>
                 </div>
               </div>
            </div>
          </div>

           <div class="form-group">
             <div class="panel">SUBIR FOTO</div>
                 <input type="file" class="nuevaFoto" name="nuevaFoto">

                 <p class="help-block">Peso máximo de la foto 2MB</p>
                 <img src="views/img/usuarios/gravatar.gif" class="img-thumbnail previsualizar" width="100px">               
           </div>

         </div>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
         <button type="submit" class="btn btn-primary pull-right">Guardar</button>
       </div>

       <?php
          $crearUsuario = new UsuariosController();
          $crearUsuario->ctrCrearUsuario();
       ?>

     </form>

     </div>
   </div>
 </div>




 <!-- MODAL EDITAR USUARIO -->
 <div id="modalEditarUsuario" class="modal fade" role="dialog">
   <div class="modal-dialog">

     <div class="modal-content">

       <form action="" role="form" method="post" enctype="multipart/form-data">

       <div class="modal-header" style="background:#3c8dbc; color: #fff">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Editar Usuario</h4>
       </div>
       <div class="modal-body">
         <div class="box-body">

           <div class="row">
             <div class="col-lg-12"">
              <div class="form-group">
                 <div class="input-group" style="width: 100%">
                   <span class="label label-default">Cliente</span>
                     <select class="form-control" name="editarClienteID" required>
                       <option id="editarClienteID"></option>                                              
                        <?php 

                         
                          $clientes = ClientesController::ctrMostrarClientes();

                          foreach($clientes as $key => $value){
                              echo '<option value="' . $value["id_cliente"] . '">' . $value["razon_social"] . '</option>';     
                          }
                          

                        ?>
                      
                   </select>
                 </div>
               </div>
             </div>
          </div>

           <div class="row">
             <div class="col-lg-6">
               <div class="form-group">
                 <div class="input-group">
                   <span class="label label-default">Nombre</span>
                     <input type="text" class="form-control" id="editarNombre" name="editarNombre" value="">
                 </div>
               </div>
             </div>
            <div class="col-lg-6">
               <div class="form-group">
                 <div class="input-group">
                    <span class="label label-default">Apellido</span>
                     <input type="text" class="form-control" id="editarApellido" name="editarApellido" value="">
                 </div>
               </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <div class="input-group">
                   <span class="label label-default"><i class="fa fa-post"></i> Correo</span>
                    <input type="text" class="form-control" id="editarCorreo" name="editarCorreo" value="">
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
               <div class="form-group">
                 <div class="input-group">
                    <span class="label label-default"><i class="fa fa-user"></i> Usuario</span>
                     <input type="text" class="form-control" id="editarUsuario" name="editarUsuario" value="" readonly>
                     <input type="hidden" name="idUsuario" id="idUsuario">
                 </div>
               </div>
            </div>

            <div class="col-lg-6">
               <div class="form-group">
                 <div class="input-group">

                    <span class="label label-default"><i class="fa fa-key"></i> Nueva Contraseña</span>
                     <input type="password" class="form-control" name="editarPassword" value="">
                     <input type="hidden" id="passwordActual" name="passwordActual">
                 </div>
               </div>
            </div>
          </div>

        <div class="row">
          <div class="col-lg-6">
           <div class="form-group">
             <div class="input-group">
               <span class="label label-default">Perfil</span>
                 <select class="form-control" name="editarPerfil">
                   <option value="" id="editarPerfil"></option>                   
                 </select>
             </div>
           </div>
          </div>

          <div class="col-lg-6">
           <div class="form-group">
             <div class="input-group">
               <span class="label label-default">Estado</span>
                 <select class="form-control" name="editarEstado">
                  <option value="" id="editarEstado">Seleccionar estado</option>
                   <option value="ACTIVADO">ACTIVADO</option>
                   <option value="INACTIVO">DESACTIVADO</option>
                 </select>
             </div>
           </div>
         </div>
        </div>

        <div class="form-group">
             <span class="label label-default">Imagen de perfil</span>
             <div class="panel">SUBIR FOTO</div>
                 <input type="file" class="nuevaFoto" accept="image/jpeg, image/jpg" name="editarFoto">
                 <p class="help-block">Peso máximo de la foto 2MB</p>
                 <img src="views/img/usuarios/gravatar.gif" class="img-thumbnail previsualizar-edicion" width="100px">
                 <input type="hidden" name="fotoActual" id="fotoActual">
                
           </div>

         </div>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
         <button type="submit" class="btn btn-primary pull-right">Modificar usuario</button>
       </div>

       <?php
          $editarUsuario = new UsuariosController();
          $editarUsuario->ctrEditarUsuario();
       ?>

     </form>

     </div>
   </div>
 </div>

<?php 
  
  $borrarUsuario = new UsuariosController();
  $borrarUsuario->ctrBorrarUsuario();

?>