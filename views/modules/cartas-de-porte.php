<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <div class="container">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
       Panel de Cartas de Porte
     </h1>
   </section>
   <!-- Main content -->
   <section class="content">
         
     <!-- Default box -->
     <div class="box">
       
       <div class="box-header with-border">

       <?php if(UsuariosHelper::isSYSAdmin()){ ?>
           <div class="col-md-6">
             
             <form class="form-horizontal" action="" method="post" name="upload_csv" enctype="multipart/form-data">                                    
                <div class="form-group">
                 <div class="input-group">
                   <span class="label label-default">CSV</span>
                     <input type="file" name="cartaCSV" id="cartaCSV" required class="form-control">
                     <button type="submit" id="submit" name="importarCSV" class="btn btn-warning button-loading" data-loading-text="Loading...">Importar</button>
                 </div>
             
               </div>    

                <?php
                    $importarCartaFromCSV = new CartasController();
                    $importarCartaFromCSV->ctrImportarCSVConTabla();
                 ?>

              </form>                  
          </div> 
        

         <button class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#modalAgregarCarta">          
            Agregar Carta
         </button>

         <?php } ?>

          <!--<button class="btn btn-primary" style="float: right; margin-right: 5px" data-toggle="modal" data-target="#modalDescargarPDF">
            <i class="fa fa-file-pdf-o"></i>
             Descargar PDF
          </button>
          -->


       
        
       </div>
       
       <div class="box-body">
        <div id="orderByU" data-u="<?php echo $_SESSION['idusuario'] ?>"></div>        
        <div id="orderByC" data-c="<?php echo $_SESSION['idcliente'] ?>"></div>

        <div id="orderByD" data-d="<?php echo $_SESSION['cuitCliente'] ?>"></div>

         <table class="table table-bordered table-striped dt-responsive nowrap tablaCartas" width="100%">

           <thead>
              <tr>                     
                <th>#ID</th>                
                <th>C.P</th> 
                <th>Procedencia</th>
                <th>Titular</th>
                <th>CUIT Tit.</th>                                
                <th>Localidad Dest.</th> 
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
 <div id="modalAgregarCarta" class="modal fade" role="dialog">
   <div class="modal-dialog modal-lg">

     <div class="modal-content">

       <form action="" id="formY" role="form" method="post" enctype="multipart/form-data">

       <div class="modal-header" style="background:#3c8dbc; color: #fff">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Agregar Carta de Porte</h4>
       </div>
       <div class="modal-body">
         <div class="box-body">


         <!-- Begin contact information -->
                <div role="tabpanel">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#detallesCarta" aria-controls="detallesTab" role="tab" data-toggle="tab">Detalles</a></li>
                        <li role="presentation"><a href="#imagenesCarta" aria-controls="imagenesTab" role="tab" data-toggle="tab">Imágenes Escaneadas</a></li>
                        <!--<li><a href="#testcontact">Test Contact</a></li>-->
                    </ul>

                    <!-- Normal Contact Begin -->
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane active" id="detallesCarta">
                      <p>** Al completar las casillas (c/CUIT) automáticamente se completarán con datos de Razón Social/ID/Planta/etc de los <a href="clientes">clientes registrados</a> en el sistema.</p>
          
                        <!-- left column -->
                          <div class="col-sm-9">            
                                 <div class="row">                   

                                   <div class="col-lg-3">
                                     
                                      <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Número Interno de Carta </span>
                                           <input type="text" class="form-control input-lg" autofocus style="background: #eee" maxlength="18" id="nuevoNumeroCartaInterno" name="nuevoNumeroCartaInterno" placeholder="" required>
                                       </div>
                                       <input type="hidden" id="nuevoClienteID" name="nuevoClienteID">
                                        </div>
                                     </div>

                                     <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Número CTG</span>
                                           <input type="text" id="nuevoNumeroCTG" class="form-control" name="nuevoNumeroCTG" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Número CCCTG</span>
                                           <input type="text" id="nuevoNumeroCCCTG" class="form-control" name="nuevoNumeroCCCTG" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                  </div>
                                  <div class="row">                                               
                                    <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Puerto ID</span>
                                           <input type="text" id="nuevoPuertoCOD" class="form-control" name="nuevoPuertoCOD" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-5">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Nombre Puerto</span>
                                           <input type="text" id="nuevoNombrePuerto" class="form-control" name="nuevoNombrePuerto" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                </div>

                               <div class="row">

                                  <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">CUIT Entregador</span>
                                           <input type="text" class="form-control cuit" maxlength="12" id="nuevoCUITEntregador" name="nuevoCUITEntregador" placeholder="00-00000000-0">
                                       </div>
                                     </div>
                                  </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Razón Social Entregador</span>
                                           <input type="text" id="nuevoRazonEntregador" class="form-control" name="nuevoRazonEntregador" placeholder="">
                                       </div>
                                     </div>
                                   </div>
                                   
                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Entregador ID</span>
                                           <input type="text" maxlength="18" class="form-control" id="nuevoIDEntregador" name="nuevoIDEntregador" placeholder="">
                                       </div>
                                     </div>
                                   </div>
                                                                  
                                </div>

                                 <div class="row">
                                   
                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Mercadería ID</span>
                                           <input type="text" class="form-control" id="nuevoIDMercaderia" maxlength="18" name="nuevoIDMercaderia" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Nombre Mercadería</span>
                                           <input type="text" class="form-control" name="nuevoNombreMercaderia" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Contrato</span>
                                           <input type="text" class="form-control" name="nuevoContrato" placeholder="">
                                       </div>
                                     </div>
                                  </div>
                                </div>
                              

                          </div>

                          <div class="col-sm-3">

                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Fecha de Descarga</span>
                                           <input type="date" class="form-control" name="nuevoFechaDescarga" required placeholder="">
                                       </div>
                                     </div>
                                  </div>
                          </div> 



                          <div class="col-sm-12">   

                            <div class="row">
                                   
                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default"> Bruto(Kgs) Procedencia</span>
                                           <input type="text" class="form-control" id="nuevoProcedenciaBruto" name="nuevoProcedenciaBruto" placeholder="">
                                       </div>
                                     </div>
                                   </div>


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default"> Tara Procedencia</span>
                                           <input type="text" id="nuevoProcedenciaTara" class="form-control" name="nuevoProcedenciaTara" placeholder="">
                                       </div>
                                     </div>
                                   </div> 


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Neto Procedencia</span>
                                           <input type="text" id="nuevoProcedenciaNeto" class="form-control" name="nuevoProcedenciaNeto" placeholder="">
                                       </div>
                                     </div>
                                   </div> 

                                 </div>
                            </div> 





                           <div class="col-sm-12">   

                            <div class="row bg-gray">
                                   
                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default"> Bruto(Kgs)</span>
                                           <input type="text" class="form-control" id="nuevoBruto" name="nuevoBruto" placeholder="">
                                       </div>
                                     </div>
                                   </div>


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default"> Tara</span>
                                           <input type="text" id="nuevoTara" class="form-control" name="nuevoTara" placeholder="">
                                       </div>
                                     </div>
                                   </div> 


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Total Neto Sin Merma</span>
                                           <input type="text" id="nuevoNetoSinMerma" class="form-control" name="nuevoNetoSinMerma" placeholder="">
                                       </div>
                                     </div>
                                   </div> 

                                    <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Calcular Total Merma</span>
                                           <input type="text" class="form-control input-lg" style="background: #eee" maxlength="4" id="nuevoPorcentajeMerma" class="form-control" name="nuevoPorcentajeMerma" placeholder="%">
                                       </div>
                                     </div>
                                   </div>    


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Merma Total</span>
                                           <input type="text" id="nuevoMermaTotal" class="form-control" name="nuevoMermaTotal" placeholder="">
                                       </div>
                                     </div>
                                   </div> 


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Neto con Merma</span>
                                           <input type="text" id="nuevoNetoConMerma" class="form-control" name="nuevoNetoConMerma" placeholder="">
                                       </div>
                                     </div>
                                   </div> 

                                </div>  

                           </div>


                         
                          <div class="col-sm-7 ">
                            
                                <div class="row bg-blue">
                                   
                                   <div class="col-lg-4">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Titular C.P CUIT</span>
                                           <input type="text" class="form-control cuit" maxlength="12" id="nuevoCUITCartaPorteTitular" name="nuevoCUITCartaPorteTitular" placeholder="00-00000000-0" required>
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Razón Titular</span>
                                           <input type="text" id="nuevoRazonTitular" class="form-control" name="nuevoRazonTitular" placeholder="" required>
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">ID Titular</span>
                                           <input type="text" class="form-control" id="nuevoIDInternoTitular" maxlength="18" name="nuevoIDInternoTitular" placeholder="">
                                       </div>
                                     </div>
                                  </div>
                                </div> 


                                <div class="row bg-aqua">
                                   
                                   <div class="col-lg-4">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">CUIT Intermediario</span>
                                           <input type="text" class="form-control cuit" maxlength="12" id="nuevoCUITIntermediario" name="nuevoCUITIntermediario" placeholder="00-00000000-0">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Razón Intermediario</span>
                                           <input type="text" id="nuevoRazonIntermediario" class="form-control" name="nuevoRazonIntermediario" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">ID Interm</span>
                                           <input type="text" class="form-control" id="nuevoIDIntermediario" maxlength="18" name="nuevoIDIntermediario" placeholder="">
                                       </div>
                                     </div>
                                  </div>
                                </div>  


                                <div class="row bg-blue">
                                   
                                   <div class="col-lg-4">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">CUIT RemitenteComercial</span>
                                           <input type="text" class="form-control cuit" maxlength="12" id="nuevoCUITRemitenteComercial" name="nuevoCUITRemitenteComercial" placeholder="00-00000000-0">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Razón Remitente</span>
                                           <input type="text" id="nuevoRazonRemitente" class="form-control" name="nuevoRazonRemitente">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">ID Remit.</span>
                                           <input type="text" class="form-control" id="nuevoIDRemitente" maxlength="18" name="nuevoIDRemitente" placeholder="">
                                       </div>
                                     </div>
                                  </div>
                                </div>   


                                <div class="row bg-aqua">
                                   
                                   <div class="col-lg-4">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">CUIT Destinatario</span>
                                           <input type="text" class="form-control cuit" maxlength="12" id="nuevoCUITDestinatario" name="nuevoCUITDestinatario" placeholder="00-00000000-0">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Razón Destinatario</span>
                                           <input type="text" id="nuevoRazonDestinatario" class="form-control" name="nuevoRazonDestinatario" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   
                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">-----</span>
                                           <input type="text" class="form-control" disabled placeholder="">
                                       </div>
                                     </div>
                                  </div> 


                                </div>  


                                <div class="row bg-blue">
                                   
                                   <div class="col-lg-4">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">CUIT Corredor</span>
                                           <input type="text" class="form-control cuit" maxlength="12" id="nuevoCUITCorredor" name="nuevoCUITCorredor" placeholder="00-00000000-0">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Razón Corredor</span>
                                           <input type="text" id="nuevoRazonCorredor" class="form-control" name="nuevoRazonCorredor" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                    <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">-----</span>
                                           <input type="text" class="form-control" disabled placeholder="">
                                       </div>
                                     </div>
                                  </div>                                  
                                  
                                </div>                

                                <div class="row">
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                         <div class="input-group">
                                           <span class="label label-default">Tipo Entrega</span>
                                             <select class="form-control" name="nuevoTipoEntrega">                       
                                               <option value="1">1 - Entrega</option>
                                             </select>
                                         </div>
                                       </div>
                                    </div>

                                     <div class="col-lg-6">
                                       <div class="form-group">
                                         <div class="input-group">
                                           <span class="label label-default">Localidad Destino</span>
                                             <input type="text" id="nuevoLocalidadDestino" class="form-control" name="nuevoLocalidadDestino" placeholder="">
                                         </div>
                                       </div>
                                    </div>
                                 </div>       


                        </div>

                        <!-- RIGHT column -->
                        <div class="col-sm-5">                

                               <div class="row bg-blue">
                                   
                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Número </span>
                                           <input type="text" class="form-control" id="nuevoNumPlantaTitular" name="nuevoNumPlantaTitular" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Planta</span>
                                           <input type="text" class="form-control" id="nuevoPlantaTitular" name="nuevoPlantaTitular" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                           <span class="label label-default">Ent</span>
                                           <input type="checkbox" value="1" class="minimal" name="nuevoCheckboxEntrPlantaTitular" placeholder="">

                                           <span class="label label-default">Exp</span>
                                           <input type="checkbox" value="1" class="minimal" name="nuevoCheckboxExpPlantaTitular" placeholder="">

                                       </div>
                                     </div>
                                  </div>
                                </div>  



                                <div class="row bg-aqua">
                                   
                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Número </span>
                                           <input type="text" id="nuevoNumPlantaIntermediario" class="form-control" name="nuevoNumPlantaIntermediario" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Planta</span>
                                           <input type="text" id="nuevoPlantaIntermediario" class="form-control" name="nuevoPlantaIntermediario" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                           <span class="label label-default">Ent</span>
                                           <input type="checkbox" value="1" class="minimal" name="nuevoCheckboxEntrPlantaIntermediario" placeholder="">

                                           <span class="label label-default">Exp</span>
                                           <input type="checkbox" value="1" class="minimal" name="nuevoCheckboxExpPlantaIntermediario" placeholder="">

                                       </div>
                                     </div>
                                  </div>
                                </div>  



                                <div class="row bg-blue">
                                   
                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Número </span>
                                           <input type="text" id="nuevoNumPlantaRemitente" class="form-control" name="nuevoNumPlantaRemitente" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Planta</span>
                                           <input type="text" id="nuevoPlantaRemitente" class="form-control" name="nuevoPlantaRemitente" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                           <span class="label label-default">Ent</span>
                                           <input type="checkbox" value="1" class="minimal" name="nuevoCheckboxEntrPlantaRemitente" placeholder="">

                                           <span class="label label-default">Exp</span>
                                           <input type="checkbox" value="1" class="minimal" name="nuevoCheckboxExpPlantaRemitente" placeholder="">

                                       </div>
                                     </div>
                                  </div>
                                </div>

                                <div class="row bg-aqua">    
                                   <div class="col-lg-6">
                                      <div class="form-group">
                                         <div class="input-group">
                                         <span class="label label-default">------</span>
                                         <input type="text" disabled class="form-control">
                                      </div>
                                      </div>   
                                   </div>  
                                   <div class="col-lg-6">
                                      <div class="form-group">
                                         <div class="input-group">
                                         <span class="label label-default">------</span>
                                         <input type="text" disabled class="form-control">
                                      </div>
                                      </div>   
                                   </div>                              
                                </div>  

                                <div class="row bg-blue">
                                  
                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Corredor Comprador</span>
                                           <input type="text" id="nuevoCorredorComprador" class="form-control" name="nuevoCorredorComprador">
                                       </div>
                                     </div>
                                   </div>

                                </div>

                        </div>



                         <div class="col-sm-12">
                            
                                <div class="row">
                                   
                                   <div class="col-lg-8">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Localidad Procedencia</span>
                                           <input type="text" class="form-control" id="nuevoLocalidadProcedencia" name="nuevoLocalidadProcedencia">
                                       </div>
                                     </div>
                                    </div>                              

                                   <!--
                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">-</span>
                                           <input type="text" class="form-control" name="nuevoExtraProcedencia" disabled placeholder="">
                                       </div>
                                     </div>
                                  </div>
                                  -->
                                </div> 


                                <div class="row">
                                   
                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Hora Ingreso</span>
                                           <input type="time" class="form-control" name="nuevoHoraIngreso" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Turno</span>
                                           <input type="text" id="nuevoTurno" maxlength="11" class="form-control" name="nuevoTurno" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Patente</span>
                                           <input type="text" class="form-control" name="nuevoPatente" maxlength="15" placeholder="">
                                       </div>
                                     </div>
                                  </div>
                                </div>  


                                <div class="row">

                                  <div class="col-lg-4">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">CUIT Transportista</span>
                                           <input type="text" class="form-control cuit" maxlength="12" id="nuevoCUITTransportista" name="nuevoCUITTransportista" placeholder="00-00000000-0">
                                       </div>
                                     </div>
                                   </div>
                                   
                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Razón Transportista</span>
                                           <input type="text" id="nuevoRazonTransportista" class="form-control" name="nuevoRazonTransportista" placeholder="">
                                       </div>
                                     </div>
                                   </div>   
                                </div>


                                <div class="row">

                                
                                   
                                   <div class="col-lg-3">
                                     <div class="form-group">
                                         <div class="input-group">
                                           <span class="label label-default">Calidad</span>
                                             <select class="form-control" name="nuevoCalidad">                       
                                               <option value="" id="nuevoCalidad" selected>SELECCIONAR CALIDAD</option>
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

                                  <!--<div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Kgs. Netos PROCEDENCIA???:</span>
                                           <input type="text" class="form-control" name="nuevoKiloNeto" maxlength="15" placeholder="">
                                       </div>
                                     </div>
                                  </div>-->

                                  <div class="col-lg-3">
                                     <div class="form-group">
                                         <div class="input-group">
                                           <span class="label label-default">Situación</span>
                                             <select class="form-control" name="nuevoSituacion">                                                              
                                               <option value="SIN DESCARGAR" id="nuevoSituacion">SIN DESCARGAR</option>
                                               <option value="DESCARGADO">DESCARGADO</option>
                                               <option value="EN ESPERA">EN ESPERA</option>
                                               <option value="DESCARGADO">SIN DESCARGAR</option>

                                             </select>
                                         </div>
                                       </div>
                                  </div> 

                                </div>

                                 <div class="row">
                                   <div class="col-lg-12">
                                     <div class="form-group">
                                      <label>Observaciones de la carta de porte</label>
                                      <textarea id="nuevoObservaciones" class="form-control" rows="6" name="nuevoObservaciones" placeholder=""></textarea>
                                    </div>                                     
                                   </div>
                                </div>

                           </div> 


                        </div>  
                        <!--- FIN TAB CARTA DETALLES -->   


                        <!--- TAB IMAGENES ESCANEADAS CARTA -->   

                         <!-- Normal Contact Begin -->
                        <div role="tabpanel" class="tab-pane" id="imagenesCarta">

                           
                          <input type="file" id="nuevaScannedImages" accept="image/jpeg, image/jpg" multiple="multiple" name="nuevaScannedImages[]" />

                          <p class="help-block">Elija una imagen o várias de una sola vez, el peso máximo de cada imagen no debe superar los 2MB</p>

                          <p class="help-block">*Todas las imágenes irán ser modificadas automáticamente al cargarse para estar en el tamaño de una hoja A4 con calidad 72 ppi (842 pixels Ancho X 595 pixels Alto)</p>
                          
                          <div id="resultPreview" />

                         

                        </div>

                       </div>  <!-- Fin TabContent -->                        
                    </div> 
                </div>                   
              
          </div>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
         <button type="submit" class="btn btn-primary pull-right">Guardar</button>
       </div>

       <?php
          $crearCarta = new CartasController();
          $crearCarta->ctrCrearCarta();
       ?>

     </form>

     </div>
   </div>
 </div>




 <!-- MODAL EDITAR CARTA DE PORTE -->
 <div id="modalEditarCarta" class="modal fade" role="dialog">
   <div class="modal-dialog modal-lg">

     <div class="modal-content">

       <form action="" id="formX" role="form" method="post" enctype="multipart/form-data">

       <div class="modal-header" style="background:#3c8dbc; color: #fff">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Editar Carta de Porte</h4>
       </div>
       <div class="modal-body">
         <div class="box-body">


         <!-- Begin contact information -->
                <div role="tabpanel">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#editarDetallesCarta" aria-controls="detallesTab" role="tab" data-toggle="tab">Detalles</a></li>
                        <li role="presentation"><a href="#editarImagenesCarta" aria-controls="imagenesTab" role="tab" data-toggle="tab">Imágenes Escaneadas</a></li>
                        <!--<li><a href="#testcontact">Test Contact</a></li>-->
                    </ul>

                    <!-- Normal Contact Begin -->
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane active" id="editarDetallesCarta">
                      <p>** Al completar las casillas (c/CUIT) automáticamente se completarán con datos de Razón Social/ID/Planta/etc de los <a href="clientes">clientes registrados</a> en el sistema.</p>
          
                        <!-- left column -->
                          <div class="col-sm-9">            
                                 <div class="row">                   

                                      <div class="col-lg-3">                                     
                                        <div class="form-group">
                                           <div class="input-group">
                                             <span class="label label-default">Número Interno de Carta </span>
                                               <input type="text" class="form-control input-lg" style="background: #eee" maxlength="18" id="editarNumeroCartaInterno" name="editarNumeroCartaInterno" required>

                                                <input type="hidden" id="editarCartaID" name="editarCartaID">
                                           </div>
                                        </div>
                                      </div>


                                      <div class="col-lg-3">                                     
                                        <div class="form-group">
                                           <div class="input-group">
                                             <span class="label label-default">Número CTG</span>
                                               <input type="text" class="form-control input-lg" maxlength="18" id="editarNumeroCTG" name="editarNumeroCTG" >                   
                                           </div>
                                        </div>
                                      </div>


                                      <div class="col-lg-3">                                     
                                        <div class="form-group">
                                           <div class="input-group">
                                             <span class="label label-default">Número CCCTG</span>
                                               <input type="text" class="form-control input-lg" autofocus maxlength="18" id="editarNumeroCCCTG" name="editarNumeroCCCTG" >
                                           </div>
                                        </div>
                                      </div>
                                   
                                   </div> 

                                   <div class="row">

                                    <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Puerto ID</span>
                                           <input type="text" id="editarPuertoCOD" class="form-control" name="editarPuertoCOD">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-5">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Nombre Puerto</span>
                                           <input type="text" id="editarNombrePuerto" class="form-control" name="editarNombrePuerto">
                                       </div>
                                     </div>
                                   </div>

                                </div>

                               <div class="row">

                                  <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">CUIT Entregador</span>
                                           <input type="text" class="form-control cuit" maxlength="12" id="editarCUITEntregador" name="editarCUITEntregador" placeholder="00-00000000-0">
                                       </div>                                       
                                     </div>
                                  </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Razón Social Entregador</span>
                                           <input type="text" id="editarRazonEntregador" class="form-control" name="editarRazonEntregador" placeholder="">
                                       </div>
                                     </div>
                                   </div>
                                   
                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Entregador ID</span>
                                           <input type="text" maxlength="18" class="form-control" id="editarIDEntregador" name="editarIDEntregador">
                                       </div>
                                     </div>
                                   </div>
                                                                  
                                </div>

                                 <div class="row">
                                   
                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Mercadería ID</span>
                                           <input type="text" class="form-control" id="editarIDMercaderia" maxlength="18" name="editarIDMercaderia" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Nombre Mercadería</span>
                                           <input type="text" id="editarNombreMercaderia" class="form-control" name="editarNombreMercaderia" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Contrato</span>
                                           <input type="text" id="editarContrato" class="form-control" name="editarContrato" placeholder="">
                                       </div>
                                     </div>
                                  </div>
                                </div>                                                             
                          </div>

                          <div class="col-sm-3">

                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Fecha de Descarga</span>
                                           <input type="date" id="editarFechaDescarga" class="form-control" name="editarFechaDescarga" placeholder="" required>
                                       </div>
                                     </div>
                                  </div>
                          </div> 




                          <div class="col-sm-12">   

                            <div class="row">
                                   
                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default"> Bruto(Kgs) Procedencia</span>
                                           <input type="text" class="form-control" id="editarProcedenciaBruto" name="editarProcedenciaBruto" placeholder="">
                                       </div>
                                     </div>
                                   </div>


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default"> Tara Procedencia</span>
                                           <input type="text" id="editarProcedenciaTara" class="form-control" name="editarProcedenciaTara" placeholder="">
                                       </div>
                                     </div>
                                   </div> 


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Neto Procedencia</span>
                                           <input type="text" id="editarProcedenciaNeto" class="form-control" name="editarProcedenciaNeto" placeholder="">
                                       </div>
                                     </div>
                                   </div> 

                                 </div>
                            </div> 

                           <div class="col-sm-12">   

                            <div class="row bg-gray">

                              <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Bruto (B)</span>
                                           <input type="text" class="form-control" id="editarBruto" name="editarBruto" placeholder=""> 
                                       </div>
                                     </div>
                                   </div>              


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default"> Tara (T) </span>
                                           <input type="text" class="form-control" id="editarTara" name="editarTara" placeholder="">
                                       </div>
                                     </div>
                                   </div> 


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Neto (N/S)
                                           <input type="text" class="form-control" id="editarNetoSinMerma" name="editarNetoSinMerma" placeholder="">
                                       </div> ( B - T )
                                     </div>
                                   </div>  


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Calcular Total Merma</span>
                                           <input type="text" class="form-control input-lg" style="background: #eee" maxlength="4" id="editarPorcentajeMerma" class="form-control" name="editarPorcentajeMerma" placeholder="%">
                                       </div> ( X )
                                     </div>
                                   </div>                


                                    <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Merma Total (M/T)</span>
                                           <input type="text" class="form-control" id="editarMermaTotal" name="editarMermaTotal" placeholder="">
                                       </div> (N/S X % Merma)
                                     </div>
                                   </div> 


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Neto con Merma</span>
                                           <input type="text" id="editarNetoConMerma" class="form-control" name="editarNetoConMerma" placeholder=""> (N/S - M/T)
                                       </div>
                                     </div>
                                   </div> 
                                </div>   

                          </div>





                         
                          <div class="col-sm-7 ">
                            
                                <div class="row bg-blue">
                                   
                                   <div class="col-lg-4">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Titular C.P CUIT</span>
                                           <input type="text" class="form-control cuit" maxlength="12" id="editarCUITCartaPorteTitular" value="" name="editarCUITCartaPorteTitular" required>

                                           <input type="hidden" id="editarClienteID" name="editarClienteID">                                          
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Razón Titular</span>
                                           <input type="text" id="editarRazonTitular" class="form-control" name="editarRazonTitular" placeholder="" required>
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">ID Titular</span>
                                           <input type="text" class="form-control" id="editarIDInternoTitular" maxlength="18" name="editarIDInternoTitular" placeholder="">
                                       </div>
                                     </div>
                                  </div>
                                </div> 


                                <div class="row bg-aqua">
                                   
                                   <div class="col-lg-4">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">CUIT Intermediario</span>
                                           <input type="text" class="form-control cuit" maxlength="12" id="editarCUITIntermediario" name="editarCUITIntermediario" placeholder="00-00000000-0">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Razón Intermediario</span>
                                           <input type="text" id="editarRazonIntermediario" class="form-control" name="editarRazonIntermediario" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">ID Interm</span>
                                           <input type="text" class="form-control" id="editarIDIntermediario" maxlength="18" name="editarIDIntermediario" placeholder="">
                                       </div>
                                     </div>
                                  </div>
                                </div>  


                                <div class="row bg-blue">
                                   
                                   <div class="col-lg-4">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">CUIT RemitenteComercial</span>
                                           <input type="text" class="form-control cuit" maxlength="12" id="editarCUITRemitenteComercial" name="editarCUITRemitenteComercial" placeholder="00-00000000-0">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Razón Remitente</span>
                                           <input type="text" id="editarRazonRemitente" class="form-control" name="editarRazonRemitente">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">ID Remit.</span>
                                           <input type="text" class="form-control" id="editarIDRemitente" maxlength="18" name="editarIDRemitente" placeholder="">
                                       </div>
                                     </div>
                                  </div>
                                </div>   


                                <div class="row bg-aqua">
                                   
                                   <div class="col-lg-4">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">CUIT Destinatario</span>
                                           <input type="text" class="form-control cuit" maxlength="12" id="editarCUITDestinatario" name="editarCUITDestinatario" placeholder="00-00000000-0" >
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Razón Destinatario</span>
                                           <input type="text" id="editarRazonDestinatario" class="form-control" name="editarRazonDestinatario" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                     <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">-----</span>
                                           <input type="text" class="form-control" disabled placeholder="">
                                       </div>
                                     </div>
                                  </div> 

                                   
                                </div>  


                                <div class="row bg-blue">
                                   
                                   <div class="col-lg-4">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">CUIT Corredor</span>
                                           <input type="text" class="form-control cuit" maxlength="12" id="editarCUITCorredor" name="editarCUITCorredor" placeholder="00-00000000-0">
                                       </div>
                                     </div>
                                   </div>  
                                                          


                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Razón Corredor</span>
                                           <input type="text" id="editarRazonCorredor" class="form-control" name="editarRazonCorredor" placeholder="">
                                       </div>
                                     </div>
                                   </div>


                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">-----</span>
                                           <input type="text" class="form-control" disabled placeholder="">
                                       </div>
                                     </div>
                                  </div>   
                                  
                                  
                                </div>                

                                <div class="row">
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                         <div class="input-group">
                                           <span class="label label-default">Tipo Entrega</span>
                                             <select class="form-control" name="editarTipoEntrega">                       
                                               <option id="editarTipoEntrega"></option>
                                               <option value="1">1 - Entrega</option>
                                             </select>
                                         </div>
                                       </div>
                                    </div>

                                    <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Localidad Destino</span>
                                           <input type="text" id="editarLocalidadDestino" class="form-control" name="editarLocalidadDestino" placeholder="" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                 </div>       


                        </div>

                        <!-- RIGHT column -->
                        <div class="col-sm-5">                

                               <div class="row bg-blue">
                                   
                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Número </span>
                                           <input type="text" class="form-control" id="editarNumPlantaTitular" name="editarNumPlantaTitular" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Planta</span>
                                           <input type="text" class="form-control" id="editarPlantaTitular" name="editarPlantaTitular" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                           <span class="label label-default">Ent</span>
                                           <input type="checkbox" value="1" class="minimal" id="editarCheckboxEntrPlantaTitular" name="editarCheckboxEntrPlantaTitular" placeholder="">

                                           <span class="label label-default">Exp</span>
                                           <input type="checkbox" value="1" class="minimal" id="editarCheckboxExpPlantaTitular" name="editarCheckboxExpPlantaTitular" placeholder="">

                                       </div>
                                     </div>
                                  </div>
                                </div>  



                                <div class="row bg-aqua">
                                   
                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Número </span>
                                           <input type="text" id="editarNumPlantaIntermediario" class="form-control" name="editarNumPlantaIntermediario" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Planta</span>
                                           <input type="text" id="editarPlantaIntermediario" class="form-control" name="editarPlantaIntermediario" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                           <span class="label label-default">Ent</span>
                                           <input type="checkbox" value="1" class="minimal" id="editarCheckboxEntrPlantaIntermediario" name="editarCheckboxEntrPlantaIntermediario" placeholder="">

                                           <span class="label label-default">Exp</span>
                                           <input type="checkbox" value="1" id="editarCheckboxExpPlantaIntermediario" class="minimal" name="editarCheckboxExpPlantaIntermediario" placeholder="">

                                       </div>
                                     </div>
                                  </div>
                                </div>  



                                <div class="row bg-blue">
                                   
                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Número </span>
                                           <input type="text" id="editarNumPlantaRemitente" class="form-control" name="editarNumPlantaRemitente" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Planta</span>
                                           <input type="text" id="editarPlantaRemitente" class="form-control" name="editarPlantaRemitente" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                           <span class="label label-default">Ent</span>
                                           <input type="checkbox" value="1" class="minimal" id="editarCheckboxEntrPlantaRemitente" name="editarCheckboxEntrPlantaRemitente" placeholder="">

                                           <span class="label label-default">Exp</span>
                                           <input type="checkbox" value="1" class="minimal" id="editarCheckboxExpPlantaRemitente" name="editarCheckboxExpPlantaRemitente" placeholder="">

                                       </div>
                                     </div>
                                  </div>
                                </div>  


                                 <div class="row bg-aqua">    
                                   <div class="col-lg-6">
                                      <div class="form-group">
                                         <div class="input-group">
                                         <span class="label label-default">------</span>
                                         <input type="text" disabled class="form-control">
                                      </div>
                                      </div>   
                                   </div>  
                                   <div class="col-lg-6">
                                      <div class="form-group">
                                         <div class="input-group">
                                         <span class="label label-default">------</span>
                                         <input type="text" disabled class="form-control">
                                      </div>
                                      </div>   
                                   </div>                              
                                </div>  

                                <div class="row bg-blue">
                                  
                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Corredor Comprador</span>
                                           <input type="text" id="editarCorredorComprador" class="form-control" name="editarCorredorComprador">
                                       </div>
                                     </div>
                                   </div>

                                </div>

                        </div>



                         <div class="col-sm-12">
                            
                                <div class="row">

                                   <div class="col-lg-8">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Localidad Procedencia</span>
                                           <input type="text" class="form-control" id="editarLocalidadProcedencia" name="editarLocalidadProcedencia">
                                       </div>
                                     </div>
                                    </div>  
                                   
                                   <!--<div class="col-lg-4">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">CUIT Procedencia</span>
                                           <input type="text" class="form-control cuit" maxlength="12" id="editarCUITProcedencia" name="editarCUITProcedencia" placeholder="00-00000000-0">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Razón Procedencia</span>
                                           <input type="text" id="editarRazonProcedencia" class="form-control" name="editarRazonProcedencia" placeholder="">
                                       </div>
                                     </div>
                                   </div>
                                   -->

                                   <!--
                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">-</span>
                                           <input type="text" class="form-control" name="nuevoExtraProcedencia" disabled placeholder="">
                                       </div>
                                     </div>
                                  </div>
                                  -->
                                </div> 


                                <div class="row">
                                   
                                   <div class="col-lg-2">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Hora Salida</span>
                                           <input type="time" class="form-control" id="editarHoraIngreso" name="editarHoraIngreso" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Turno</span>
                                           <input type="text" id="editarTurno" maxlength="11" name="editarTurno" class="form-control" name="editarTurno" placeholder="">
                                       </div>
                                     </div>
                                   </div>

                                   <div class="col-lg-3">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Patente</span>
                                           <input type="text" class="form-control" id="editarPatente" name="editarPatente" maxlength="15" placeholder="">
                                       </div>
                                     </div>
                                  </div>
                                </div>  


                                <div class="row">

                                  <div class="col-lg-4">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">CUIT Transportista</span>
                                           <input type="text" class="form-control cuit" maxlength="12" id="editarCUITTransportista" name="editarCUITTransportista" placeholder="00-00000000-0">
                                       </div>
                                     </div>
                                   </div>
                                   
                                   <div class="col-lg-6">
                                     <div class="form-group">
                                       <div class="input-group">
                                         <span class="label label-default">Razón Transportista</span>
                                           <input type="text" id="editarRazonTransportista" class="form-control" name="editarRazonTransportista" placeholder="" placeholder="00-00000000-0">
                                       </div>
                                     </div>
                                   </div>   
                                </div>


                                <div class="row">
                                                                
                                   <div class="col-lg-4">
                                     <div class="form-group">
                                         <div class="input-group">
                                           <span class="label label-default">Calidad</span>
                                             <select class="form-control" name="editarCalidad">                       
                                               <option id="editarCalidad"></option>                                              
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
                                 

                                  <div class="col-lg-3">
                                     <div class="form-group">
                                         <div class="input-group">
                                           <span class="label label-default">Situación</span>
                                             <select class="form-control" name="editarSituacion">                       
                                               <option id="editarSituacion">SITUACIÓN</option>
                                               <option value="DESCARGADO">DESCARGADO</option>
                                               <option value="EN ESPERA">EN ESPERA</option>
                                               <option value="SIN DESCARGAR">SIN DESCARGAR</option>
                                             </select>
                                         </div>
                                       </div>
                                  </div> 

                                </div>


                                <div class="row">
                                   <div class="col-lg-12">
                                     <div class="form-group">
                                      <label>Observaciones de la carta de porte</label>
                                      <textarea id="editarObservaciones" class="form-control" rows="6" name="editarObservaciones" placeholder=""></textarea>
                                    </div>                                     
                                   </div>
                                </div>

                           </div> 


                        </div>  
                        <!--- FIN TAB CARTA DETALLES -->   


                        <!--- TAB IMAGENES ESCANEADAS CARTA -->   

                         <!-- Normal Contact Begin -->
                        <div role="tabpanel" class="tab-pane" id="editarImagenesCarta">

                     
                           
                          <input type="file" id="editarScannedImages" accept="image/jpeg, image/jpg" multiple="multiple" name="editarScannedImages[]" />
                        

                          <p class="help-block"><p>Elija una imagen o várias de una sola vez, el peso máximo de cada imagen no debe superar los 2MB</p>

                           <p class="help-block">*Todas las imágenes irán ser modificadas automáticamente al cargarse para estar en el tamaño de una hoja A4 con calidad 72 ppi (842 pixels Ancho X 595 pixels Alto)</p>
                          
                          <div id="resultEditarPreview" />                      

                        </div>

                        </div> <!-- Fin TabPanel -->                         
                    </div>  <!-- Fin TabContent -->             
                 </div>   

          </div>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
         <button type="submit" id="saveButton" class="btn btn-primary pull-right">Guardar cambios</button>
         <!--<button type="button" class="btn btn-info btnImprimirCarta" numeroCarta><i class="fa fa-print"></i>Imprimir en PDF</button></button>-->
       </div>

       <?php
          $editarCarta = new CartasController();
          $editarCarta->ctrEditarCarta();
       ?>

     </form>

     </div>
   </div>
 </div>

 <?php
    $borrarCarta = new CartasController();
    $borrarCarta->ctrBorrarCarta();
 ?>