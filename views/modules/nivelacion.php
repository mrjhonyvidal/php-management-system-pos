<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <div class="container">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h4>
       Columnas identificadas en el archivo Excel (CSV, XLSX)
     </h4>
     <p>Verifique si las columnas corresponden a las del sistema</p>
   </section>

   <!-- Main content -->
   <section class="content">
  
     <!-- Default box -->
     <div class="box">
        
     <?php 
      $importarCSV = new CartasController();
      $importarCSV->ctrCompararCSVConTabla();
      
     ?>

     </div>
     <!-- /.box -->

   </section>
   <!-- /.content -->
 </div>
</div>
 <!-- /.content-wrapper -->
