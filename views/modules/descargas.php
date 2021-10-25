<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <div class="container">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
       Panel de Descargas
     </h1>
   </section>

   <!-- Main content -->
   <section class="content">
      
     <!-- Default box -->
     <div class="box">
       
       <div class="box-header with-border">

       <?php if(UsuariosHelper::isSYSAdmin()){ ?>
          

         <button class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#modalAgregarDescarga">          
            Agregar Descarga
         </button>

         <?php } ?>       
        
       </div>

       <div class="box-body">
        <div id="orderByU" data-u="<?php echo $_SESSION['idusuario'] ?>"></div>        
        <div id="orderByC" data-c="<?php echo $_SESSION['idcliente'] ?>"></div>

        <div id="orderByD" data-d="<?php echo $_SESSION['cuitCliente'] ?>"></div>

         <table class="table table-bordered table-striped dt-responsive nowrap tablaDescargas" width="100%">

           <thead>
              <tr>                     
                <th>#ID</th>                
                <th>Carta Porte</th> 
                <th>Dia Salida</th>
                <th>Hora Salida</th>
                <th>CUIT Titular</th>                                
                <th>Calidad</th> 
                <th>Acciones</th>
              </tr>              
            </thead>
            

         </table>
       </div>  
            
     </div>
     <!-- /.box -->

   </section>
   <!-- /.content -->
 </div>
</div>
 <!-- /.content-wrapper -->

 <!-- MODAL AGREGAR CARTA DE PORTE -->
 <div id="modalAgregarDescarga" class="modal fade" role="dialog">
   <div class="modal-dialog modal-lg">

     <div class="modal-content">

       <form action="" id="formY" role="form" method="post">

       <div class="modal-header" style="background:#3c8dbc; color: #fff">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Agregar Descarga</h4>
       </div>
       <div class="modal-body">
         <div class="box-body">

         <!-- Begin contact information -->
            <div role="tabpanel">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#detallesDescarga" aria-controls="detallesTab" role="tab" data-toggle="tab">Detalles</a></li>                        
                    <!--<li><a href="#testcontact">Test Contact</a></li>-->
                </ul>

                <!-- Normal Contact Begin -->
                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active" id="detallesDescarga">                     
                    <!-- left column -->
                      <div class="col-sm-12">            
                             <div class="row bg-gray">                   

                               <div class="col-lg-3">
                                 
                                  <div class="form-group">
                                   <div class="input-group">
                                     <span class="label label-default">Buscar Numero Carta </span>
                                       <input type="text" class="form-control input-lg" autofocus style="background: #eee" maxlength="18" id="descargaNumeroCartaInterno" name="descargaNumeroCartaInterno" placeholder="" required>
                                   </div>
                                    <input type="hidden" id="descargaClienteID" name="descargaClienteID">
                                    <input type="hidden" id="descargaIDCartaPorte" name="descargaIDCartaPorte">
                                    </div>
                                 </div>
                               </div>
                      </div>

                       <div class="col-sm-12 ">
                            
                                <div class="row bg-gray">
                                   
                                   <div class="col-lg-4">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Titular C.P CUIT</span>
                                           <input type="text" class="form-control cuit" maxlength="12" id="descargaCUITCartaPorteTitular" value="" name="descargaCUITCartaPorteTitular" readonly required>
                                                                          
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Razón Titular</span>
                                           <input type="text" id="descargaRazonTitular" readonly class="form-control" name="descargaRazonTitular" placeholder="" required>
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">ID Titular</span>
                                           <input type="text" class="form-control" readonly id="descargaIDInternoTitular" maxlength="18" name="descargaIDInternoTitular" placeholder="">
                                       </div>
                                     </div>
                                  </div>
                                </div> 
                           </div>     
                    

                       <div class="col-sm-12">   

                            <div class="row">

                              <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Bruto (B)</span>
                                           <input type="text" class="form-control" id="descargaNuevoBruto" name="descargaNuevoBruto" placeholder=""> 
                                       </div>
                                     </div>
                                   </div>              


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default"> Tara (T) </span>
                                           <input type="text" class="form-control" id="descargaNuevoTara" name="descargaNuevoTara" placeholder="">
                                       </div>
                                     </div>
                                   </div> 


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Neto (N/S)
                                           <input type="text" class="form-control" id="descargaNuevoNetoSinMerma" name="descargaNuevoNetoSinMerma" placeholder="">
                                       </div> ( B - T )
                                     </div>
                                   </div>  


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Calcular Total Merma</span>
                                           <input type="text" class="form-control input-lg" style="background: #eee" maxlength="4" id="descargaNuevoPorcentajeMerma" class="form-control" name="descargaNuevoPorcentajeMerma" placeholder="%">
                                       </div> ( X )
                                     </div>
                                   </div>                


                                    <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Merma Total (M/T)</span>
                                           <input type="text" class="form-control" id="descargaNuevoMermaTotal" name="descargaNuevoMermaTotal" placeholder="">
                                       </div> (N/S X % Merma)
                                     </div>
                                   </div> 


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Neto con Merma</span>
                                           <input type="text" id="descargaNuevoNetoConMerma" class="form-control" name="descargaNuevoNetoConMerma" placeholder=""> (N/S - M/T)
                                       </div>
                                     </div>
                                   </div> 
                                </div>   

                          </div>


                          
                            
                                <div class="row">
                                 <div class="col-sm-12 ">
                                   
                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Hora Salida</span>
                                           <input type="time" class="form-control" id="descargaNuevoHoraSalida" name="descargaNuevoHoraSalida" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Fecha Salida (Obligatorio)</span>
                                           <input type="date" class="form-control" id="descargaNuevoFechaSalida" name="descargaNuevoFechaSalida" required placeholder="">
                                       </div>
                                     </div>
                                  </div>

                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Recibo</span>
                                           <input type="text" class="form-control" id="descargaNuevoRecibo" name="descargaNuevoRecibo" placeholder="">
                                       </div>
                                     </div>
                                  </div>

                                  </div>
                                 </div>

                                 <div class="row">
                                  <div class="col-sm-12 ">

                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">CTG COD.</span>
                                           <input type="text" class="form-control" id="descargaNuevoCTGCod" name="descargaNuevoCTGCod" placeholder="">
                                       </div>
                                     </div>
                                  </div>


                                  <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">CCCTG COD.</span>
                                           <input type="text" class="form-control" id="descargaNuevoCCCTGCod" name="descargaNuevoCCCTGCod" placeholder="">
                                       </div>
                                     </div>
                                  </div>


                                  <div class="col-lg-3">
                                     <div class="form-group">
                                         <div class="input-group">
                                           <span class="label label-default">Calidad</span>
                                            <select class="form-control" name="descargaNuevoCalidad">                       
                                               <option id="descargaNuevoCalidad"></option>                                              
                                               <option value="CONFORME">CONFORME</option>
                                               <option value="CONDICIONES CAMARA">CONDICIONES CAMARA</option>
                                               <option value="FUERA DE ESTANDAR">FUERA DE ESTANDAR</option>
                                               <option value="FUERA DE GRADO">FUERA DE GRADO</option>
                                               <option value="RECHAZO">RECHAZO</option>  
                                               <option value="GRADO1">GRADO1</option>  
                                               <option value="GRADO2">GRADO2</option>  
                                               <option value="GRADO3">GRADO3</option>                                                 
                                             </select>
                                         </div>
                                       </div>
                                  </div>  


                                </div> 
                           </div>

                          <div class="row">
                               <div class="col-lg-12">
                                 <div class="form-group">
                                  <label>Observaciones de calidad</label>
                                  <textarea id="descargaNuevoObservaciones" class="form-control" rows="6" name="descargaNuevoObservaciones" placeholder=""></textarea>
                                </div>                                     
                               </div>
                            </div>




                 </div>
               </div>                  
          </div>
      </div>
    </div>
     <div class="modal-footer">
         <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
         <button type="submit" class="btn btn-primary pull-right">Guardar</button>
       </div>

       <?php
          $crearDescarga = new DescargasController();
          $crearDescarga->ctrCrearDescarga();
       ?>

     </form>

     </div>
   </div>
 </div>





 <!-- MODAL EDITAR CARTA DE PORTE -->
 <div id="modalEditarDescarga" class="modal fade" role="dialog">
   <div class="modal-dialog modal-lg">

     <div class="modal-content">
      

     <form action="" id="formX" role="form" method="post">

       <div class="modal-header" style="background:#3c8dbc; color: #fff">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Editar Descarga</h4>
       </div>
       <div class="modal-body">
         <div class="box-body">

         <!-- Begin contact information -->
            <div role="tabpanel">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#detallesDescarga" aria-controls="detallesTab" role="tab" data-toggle="tab">Detalles</a></li>                        
                    <!--<li><a href="#testcontact">Test Contact</a></li>-->
                </ul>

                <!-- Normal Contact Begin -->
                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active" id="detallesDescarga">                     
                    <!-- left column -->
                      <div class="col-sm-12">            
                             <div class="row bg-gray">                   

                               <div class="col-lg-3">
                                 
                                  <div class="form-group">
                                   <div class="input-group">
                                     <span class="label label-default">Buscar Numero Carta </span>
                                       <input type="text" class="form-control input-lg" autofocus style="background: #eee" maxlength="18" id="descargaNumeroCartaInternoEditar" name="descargaNumeroCartaInternoEditar" placeholder="" required>
                                   </div>
                                    <input type="hidden" id="descargaClienteIDEditar" name="descargaClienteIDEditar">
                                    <input type="hidden" id="descargaIDCartaPorteEditar" name="descargaIDCartaPorteEditar">
                                    </div>
                                 </div>
                               </div>
                      </div>

                       <div class="col-sm-12 ">
                            
                                <div class="row bg-gray">
                                   
                                   <div class="col-lg-4">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Titular C.P CUIT</span>
                                           <input type="text" class="form-control cuit" maxlength="12" id="descargaCUITCartaPorteTitularEditar" value="" name="descargaCUITCartaPorteTitularEditar" readonly required>
                                                                          
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Razón Titular</span>
                                           <input type="text" id="descargaRazonTitularEditar" readonly class="form-control" name="descargaRazonTitularEditar" placeholder="" required>
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">ID Titular</span>
                                           <input type="text" class="form-control" readonly id="descargaIDInternoTitularEditar" maxlength="18" name="descargaIDInternoTitularEditar" placeholder="">
                                       </div>
                                     </div>
                                  </div>
                                </div> 
                           </div>     
                    

                       <div class="col-sm-12">   

                            <div class="row">

                              <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Bruto (B)</span>
                                           <input type="text" class="form-control" id="descargaNuevoBrutoEditar" name="descargaNuevoBrutoEditar" placeholder=""> 
                                       </div>
                                     </div>
                                   </div>              


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default"> Tara (T) </span>
                                           <input type="text" class="form-control" id="descargaNuevoTaraEditar" name="descargaNuevoTaraEditar" placeholder="">
                                       </div>
                                     </div>
                                   </div> 


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Neto (N/S)
                                           <input type="text" class="form-control" id="descargaNuevoNetoSinMermaEditar" name="descargaNuevoNetoSinMermaEditar" placeholder="">
                                       </div> ( B - T )
                                     </div>
                                   </div>  


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Calcular Total Merma</span>
                                           <input type="text" class="form-control input-lg" style="background: #eee" maxlength="4" id="descargaNuevoPorcentajeMermaEditar" class="form-control" name="descargaNuevoPorcentajeMermaEditar" placeholder="%">
                                       </div> ( X )
                                     </div>
                                   </div>                


                                    <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Merma Total (M/T)</span>
                                           <input type="text" class="form-control" id="descargaNuevoMermaTotalEditar" name="descargaNuevoMermaTotalEditar" placeholder="">
                                       </div> (N/S X % Merma)
                                     </div>
                                   </div> 


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Neto con Merma</span>
                                           <input type="text" id="descargaNuevoNetoConMermaEditar" class="form-control" name="descargaNuevoNetoConMermaEditar" placeholder=""> (N/S - M/T)
                                       </div>
                                     </div>
                                   </div> 
                                </div>   

                          </div>


                          
                            
                                <div class="row">
                                 <div class="col-sm-12 ">
                                   
                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Hora Salida</span>
                                           <input type="time" class="form-control" id="descargaNuevoHoraSalidaEditar" name="descargaNuevoHoraSalidaEditar" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Fecha Salida (Obligatorio)</span>
                                           <input type="date" class="form-control" id="descargaNuevoFechaSalidaEditar" name="descargaNuevoFechaSalidaEditar" required placeholder="">
                                       </div>
                                     </div>
                                  </div>                                

                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Recibo</span>
                                           <input type="text" class="form-control" id="descargaNuevoReciboEditar" name="descargaNuevoReciboEditar" placeholder="">
                                       </div>
                                     </div>
                                  </div>

                                  </div>
                                </div>

                                <div class="row">
                                 <div class="col-sm-12 ">

                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">CTG COD.</span>
                                           <input type="text" class="form-control" id="descargaNuevoCTGCodEditar" name="descargaNuevoCTGCodEditar" placeholder="">
                                       </div>
                                     </div>
                                  </div>


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">CCCTG COD.</span>
                                           <input type="text" class="form-control" id="descargaNuevoCCCTGCodEditar" name="descargaNuevoCCCTGCodEditar" placeholder="">
                                       </div>
                                     </div>
                                  </div>


                                  <div class="col-lg-3">
                                     <div class="form-group">
                                         <div class="input-group">
                                           <span class="label label-default">Calidad</span>
                                            <select class="form-control" name="descargaNuevoCalidadEditar">                       
                                               <option id="descargaNuevoCalidadEditar"></option>                                              
                                               <option value="CONFORME">CONFORME</option>
                                               <option value="CONDICIONES CAMARA">CONDICIONES CAMARA</option>
                                               <option value="FUERA DE ESTANDAR">FUERA DE ESTANDAR</option>
                                               <option value="FUERA DE GRADO">FUERA DE GRADO</option>
                                               <option value="RECHAZO">RECHAZO</option>  
                                               <option value="GRADO1">GRADO1</option>  
                                               <option value="GRADO2">GRADO2</option>  
                                               <option value="GRADO3">GRADO3</option>                                                 
                                             </select>
                                         </div>
                                       </div>
                                  </div>  


                                </div> 
                           </div>

                          <div class="row">
                               <div class="col-lg-12">
                                 <div class="form-group">
                                  <label>Observaciones de calidad</label>
                                  <textarea id="descargaNuevoObservacionesEditar" class="form-control" rows="6" name="descargaNuevoObservacionesEditar" placeholder=""></textarea>
                                </div>                                     
                               </div>
                            </div>




                 </div>
               </div>                  
          </div>
      </div>
    </div>
     <div class="modal-footer">
         <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
         <button type="submit" class="btn btn-primary pull-right">Guardar</button>
       </div>

       <?php
          $editarDescarga = new DescargasController();
          $editarDescarga->ctrEditarDescarga();
       ?>

     </form>


     </div>
   </div>
 </div>

<?php
    $borrarDescarga = new DescargasController();
    $borrarDescarga->ctrBorrarDescarga();
 ?>