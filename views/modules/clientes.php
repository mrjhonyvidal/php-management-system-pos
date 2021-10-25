<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <div class="container">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
       Administrador de Clientes
     </h1>     
   </section>

   <!-- Main content -->
   <section class="content">


     <!-- Default box -->
       
     <div class="box">

  
       <div class="box-header with-border">
         <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCliente">
           Agregar Cliente
         </button>

       </div>

     <div class="box-body">
         <table id="tableClientes" class="table table-bordered table-striped dt-responsive tablasCliente nowrap tablas" width="100%">
           <thead>
             <tr>
               <th style="width:10px">#</th>
               <th>INTERNO</th>
               <th>Razón social</th>
               <th>CUIT</th>
               <th>País</th>
               <th>Numero Planta</th>
               <th>Planta</th>  
                <th>Acciones</th>               
             </tr>
           </thead>
            <tbody>

              <?php
                $clientes = ClientesController::ctrMostrarClientes();

                foreach($clientes as $key => $value){
                  echo '<tr>';

                  if( ClientesController::ctrClienteHaveAccess($value["id_cliente"]) == false){

                      echo '<td><button title="Crear Usuario de Acceso al Sistema" class="btn btn-success btnHabilitarAcceso" data-id="' . $value["id_cliente"] . '" data-c="' . $value["cuit"] . '" aria-hidden="true" data-toggle="modal" data-target="#modalCrearUsuarioAdmin"><i class="fa fa-user"></i></button></td>';
                    }else{
                      echo '<td> Acceso habilitado </td>';
                    }
                    
                    echo '<td>' . $value["id_identificacion_interna"] . '</td>
                    <td>' . $value["razon_social"] . '</td>';
                   
                    echo '<td>' . $value["cuit"] . '</td>';
                                                      
                    echo '<td>' . $value["pais"] . '</td>';
                    echo '<td>' . $value["numero_planta"] . '</td>';

                    echo '<td>' . $value["planta"] . '</td>
                    <td>
                      <div class="btn-group">';                  

                    echo '<button title="Editar Cliente" class="btn btn-warning btnEditarCliente" data-id="' . $value["id_cliente"] . '" data-c="' . $value["id_cliente"] . '" aria-hidden="true" data-toggle="modal" data-target="#modalEditarCliente"><i class="fa fa-pencil"></i></button>

                        <button title="Borrar Cliente" class="btn btn-danger btnEliminarCliente" iu="' . $value["id_cliente"] . '"c="' . $value["cuit"] . '"><i class="fa fa-times"></i></button>
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
 <div id="modalCrearUsuarioAdmin" class="modal fade" role="dialog">
   <div class="modal-dialog">

     <div class="modal-content">

       <form action="" role="form" method="post" enctype="multipart/form-data">

       <div class="modal-header" style="background:#3c8dbc; color: #fff">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Crear un usuario de acceso</h4>
       </div>
       <div class="modal-body">
         <div class="box-body">

          
           <div class="row">
             <div class="col-lg-6">
               <div class="form-group">
                 <div class="input-group">
                   <span class="label label-default">Nombre</span>
                     <input type="text" class="form-control" name="nuevoNombre" placeholder="Ingresar Nombre" required>
                 </div>
               </div>
             </div>
             <div class="col-lg-6">
               <div class="form-group">
                 <div class="input-group">
                   <span class="label label-default">Apellido</span>
                     <input type="text" class="form-control" name="nuevoApellido" placeholder="Ingresar Apellido" required>
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

                     <input type="hidden" class="form-control" name="nuevoClienteID" id="nuevoClienteID" value="">
                     
                     <input type="hidden" class="form-control" name="nuevoEstado" value="ACTIVADO">

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



<!-- MODAL NUEVO CLIENTE -->
 <div id="modalAgregarCliente" class="modal fade" role="dialog">
   <div class="modal-dialog">

     <div class="modal-content">

       <form action="" role="form" method="post" id="form" enctype="multipart/form-data">

       <div class="modal-header" style="background:#3c8dbc; color: #fff">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Crear Cliente</h4>
       </div>
       <div class="modal-body">
         <div class="box-body">

           <div class="row">
             <div class="col-lg-12">
               <div class="form-group">
                 <div class="input-group">
                   <span class="label label-default">Razón</span>
                     <input type="text" class="form-control" id="nuevoRazonSocial" name="nuevoRazonSocial" value="" required>
                 </div>
               </div>
             </div>
          </div>
            <div class="row">
            <div class="col-lg-4">
               <div class="form-group">
                 <div class="input-group">
                    <span class="label label-default">CUIT</span>
                     <input type="text" class="form-control cuit" maxlength="12" id="nuevoCUIT" name="nuevoCUIT" value="" required>
                 </div>
               </div>
            </div>

            <div class="col-lg-4">
               <div class="form-group">
                 <div class="input-group">
                    <span class="label label-default">Cliente Interno ID</span>
                     <input type="text" class="form-control" id="nuevoIdentificacionID" name="nuevoIdentificacionID" value="">
                 </div>
               </div>
            </div>
          </div>        

          <div class="row">
            <div class="col-lg-6">
               <div class="form-group">
                 <div class="input-group">
                    <span class="label label-default"><i class="fa fa-user"></i> Planta</span>
                     <input type="text" class="form-control" id="nuevoPlanta" name="nuevoPlanta" value="">
                 </div>
               </div>
            </div>
        
            <div class="col-lg-3">
               <div class="form-group">
                 <div class="input-group">

                    <span class="label label-default"><i class="fa fa-key"></i>Numero Planta</span>
                     <input type="text" class="form-control" id="nuevoNumeroPlanta" name="nuevoNumeroPlanta" value="">                     
                 </div>
               </div>
            </div>

               <div class="col-lg-3">
              <div class="form-group">
                <div class="input-group">
                   <span class="label label-default">Pais</span>
                    <input type="text" class="form-control" id="nuevoPais" name="nuevoPais" value="Argentina">
                </div>
              </div>
            
            </div>
          </div>        

         </div>
       </div>

       <div class="modal-footer">
         <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
         <button type="submit" class="btn btn-primary pull-right">Agregar cliente</button>
       </div>

       <?php
          $crearCliente = new ClientesController();
          $crearCliente->ctrCrearCliente();
       ?>

     </form>

     </div>
   </div>
 </div>




 <!-- MODAL EDITAR CLIENTE -->
 <div id="modalEditarCliente" class="modal fade" role="dialog">
   <div class="modal-dialog">

     <div class="modal-content">

       <form action="" role="form" method="post" enctype="multipart/form-data">

       <div class="modal-header" style="background:#3c8dbc; color: #fff">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Editar Cliente</h4>
       </div>
       <div class="modal-body">
         <div class="box-body">

           <div class="row">
             <div class="col-lg-12">
               <div class="form-group">
                 <div class="input-group">
                   <span class="label label-default">Razón</span>
                     <input type="text" class="form-control" id="editarRazonSocial" name="editarRazonSocial" value="" required>
                 </div>
               </div>
             </div>
           </div>
           
           <div class="row">  
             <div class="col-lg-4">
               <div class="form-group">
                 <div class="input-group">
                    <span class="label label-default">CUIT</span>
                     <input type="text" class="form-control cuit" maxlength="12" id="editarCUIT" name="editarCUIT" value="" readonly required>
                 </div>
               </div>
            </div>

            <div class="col-lg-4">
               <div class="form-group">
                 <div class="input-group">
                    <span class="label label-default">Cliente Interno ID</span>
                     <input type="text" class="form-control" id="editarIdentificacionID" name="editarIdentificacionID" value="">
                 </div>
               </div>
            </div>
          </div>        

          <div class="row">
            <div class="col-lg-6">
               <div class="form-group">
                 <div class="input-group">
                    <span class="label label-default"><i class="fa fa-user"></i> Planta</span>
                     <input type="text" class="form-control" id="editarPlanta" name="editarPlanta" value="">
                 </div>
               </div>
            </div>
        
             <div class="col-lg-3">
               <div class="form-group">
                 <div class="input-group">

                    <span class="label label-default"><i class="fa fa-key"></i>Numero Planta</span>
                     <input type="text" class="form-control" id="editarNumeroPlanta" name="editarNumeroPlanta" value="">                     
                 </div>
               </div>
            </div>

               <div class="col-lg-3">
              <div class="form-group">
                <div class="input-group">
                   <span class="label label-default">Pais</span>
                    <input type="text" class="form-control" id="editarPais" name="editarPais" value="">
                </div>
              </div>
            
            </div>
          </div>        

         </div>
       </div>

       <div class="modal-footer">
         <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
         <button type="submit" class="btn btn-primary pull-right">Modificar cliente</button>
       </div>

       <?php
          $editarCliente = new ClientesController();
          $editarCliente->ctrEditarCliente();
       ?>

     </form>

     </div>
   </div>
 </div>

<?php 
  
  $borrarCliente = new ClientesController();
  $borrarCliente->ctrBorrarCliente();

?>