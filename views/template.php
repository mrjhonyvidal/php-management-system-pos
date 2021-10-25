<?php
session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CUENCA | Sistema de gestión</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" href="views/img/template/shipping_icon.png">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="views/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="views/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="views/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="views/dist/css/AdminLTE.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="views/dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">-->

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">


  <link rel="stylesheet" href="views/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="views/bower_components/datatables.net-bs/css/fixedHeader.bootstrap.min.css">
  <link rel="stylesheet" href="views/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
  <link rel="stylesheet" href="views/bower_components/datatables.net-bs/css/buttons.dataTables.css">

  
  <script src="views/bower_components/sweetalert2/sweetalert2.all.min.js"></script>
  <script src="views/bower_components/core/core.js"></script>
</head>
<body class="hold-transition skin-blue layout-top-nav login-page">
<!-- Site wrapper -->

  <!-- header =============================================== -->
  <?php

    if(isset($_SESSION["iniciarSession"]) && $_SESSION['iniciarSession'] == 'logged'){

      echo '<div class="wrapper">';

      include "modules/header.php";


      if(isset($_GET["hub"])) {

        if(UsuariosHelper::isSYSAdmin()){

            if($_GET["hub"] == "cartas-de-porte" ||
                $_GET["hub"] == "clientes" ||
                $_GET["hub"] == "descargas" ||
                $_GET["hub"] == "nivelacion" ||
                $_GET["hub"] == "usuarios" ||
                $_GET["hub"] == "reportes" ||
                $_GET["hub"] == "salir"){

                  include "modules/" . $_GET["hub"] . ".php";
                }else{
                    include "modules/404.php";
                }
          }else{

            if($_GET["hub"] == "cartas-de-porte" ||
                $_GET["hub"] == "descargas" ||                
                $_GET["hub"] == "salir"){

                  include "modules/" . $_GET["hub"] . ".php";
                }else{
                    include "modules/404.php";
                }
          }
      }else{
        include "modules/cartas-de-porte.php";
      }
      //include "modules/footer.php";
      echo '</div>';
    }else{
      if(isset($_GET["hub"])) {
        if($_GET["hub"] == "login" ||
          $_GET["hub"] == "registro" ||
          $_GET["hub"] == "change-credentials" ||
          $_GET["hub"] == "recovery"){
            include "modules/" . $_GET["hub"] . ".php";
          }else{
              include "modules/login.php";
            }
        }else{
            include "modules/login.php";
        }
    }
  ?>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="views/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="views/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="views/bower_components/chart.js/Chart.js"></script>
<!-- SlimScroll -->
<script src="views/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="views/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="views/dist/js/adminlte.min.js"></script>

<script src="views/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>


<script src="views/bower_components/datatables.net/js/dataTables.buttons.min.js"></script>
<script src="views/bower_components/pdfmake/pdfmake.min.js"></script>

<script src="views/bower_components/pdfmake/vfs_fonts.js"></script>
<script src="views/bower_components/datatables.net/js/buttons.html5.min.js"></script>
<script src="views/bower_components/datatables.net/js/buttons.colVis.min.js"></script>


<script src="views/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="views/bower_components/datatables.net-bs/js/dataTables.fixedHeader.min.js"></script>
<script src="views/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
<script src="views/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>


<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>

<script src="views/js/template.js"></script>
<script src="views/js/register.js"></script>
<script src="views/js/header.js"></script>
<script src="views/js/usuarios.js"></script>
<script src="views/js/cartas.js"></script>
<script src="views/js/clientes.js"></script>
<script src="views/js/reportes.js"></script>
<script src="views/js/descargas.js"></script>

</body>
</html>
