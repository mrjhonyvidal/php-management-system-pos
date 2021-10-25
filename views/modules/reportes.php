<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <div class="container">
   <!-- Content Header (Page header) -->
  
     <h2>
       Aplicar Filtros al Reporte
     </h2>     

    <div>
      <h5>Si deseeas ver todas las cartas de porte, no seleccione ningún filtro.</h5>  
   <!-- Main content -->
        <section class="content">

            <div class="row">             
             <form class="form-horizontal" action="" method="post" name="generarReporte">

               <div class="col-md-3 callout callout-info">                                         


                  <div class="form-group">
                   <div class="input-group">
                     <span class="label label-default">CUIT Titular</span>
                       <input type="text" class="form-control cuit" maxlength="12" id="filtroCUITCartaTitular" value="" placeholder="00-00000000-0" name="filtroCUITCartaTitular">                                    
                   </div>
                 </div>

                  <div class="form-group">
                   <div class="input-group">
                     <span class="label label-default">Calidad</span>
                      <select class="form-control" name="filtroCalidad" id="filtroCalidad">                       
                         <option></option>                                              
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


            
                 <div class="form-group">
                   <div class="input-group">
                     <span class="label label-default">Situación</span>
                      <select class="form-control" name="filtroSituacion" id="filtroSituacion">                       
                         <option></option>                                              
                         <option value="SIN DESCARGAR">SIN DESCARGAR</option>
                         <option value="DESCARGADO">DESCARGADO</option>
                         <option value="EN ESPERA">EN ESPERA</option>
                                                                        
                       </select>
                   </div>
                 </div>    
                                                                        
                                                                        
                   <div class="form-group">
                   <p>Agregar período de descarga</p>
                     <div class="input-group">
                       <span class="label label-default">Fecha de Descarga Inicial</span>
                         <input type="date" class="form-control" name="filtroFechaDescargaInicial" id="filtroFechaDescargaInicial" placeholder="">
                     </div>                   

                     <div class="input-group">
                       <span class="label label-default">Fecha de Descarga Final</span>
                         <input type="date" class="form-control" name="filtroFechaDescargaFinal" id="filtroFechaDescargaFinal" placeholder="">
                     </div>
                  </div>

                  <button type="submit" class="btn btn-primary pull-left" id="btnGenerateReporteCSV">Reporte CSV</button>

                  <button type="submit" class="btn btn-danger pull-right" id="btnGenerateReportePDF">Reporte PDF</button>
              </div>   

                <?php
                    //$reporteCartasPorte = new CartasController();
                    //$reporteCartasPorte->generarReporte();

                 ?>

              </form>                  
          </div>       
    
   </section>
   <!-- /.content -->
   </div>


 </div>
</div>
 <!-- /.content-wrapper -->
