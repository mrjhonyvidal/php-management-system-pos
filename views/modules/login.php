<div id="back"></div>
<div class="login-box">
  <div class="login-logo">
    <a href="cartas-de-porte"><b>Cuenca</b>SIS</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Ingresar al sistema</p>

    <?php 
      if(isset($_GET['i']) == 'activacion'){
        echo '<div class="callout callout-success">Tu cuenta fue activada con éxito.</div>';  
      }      
    ?>

    <form action="" id="form" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control input-lg cuit" id="cuit" maxlength="12" name="ingCUIT" placeholder="CUIT" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control input-lg" name="ingPassword" placeholder="Contraseña" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <input type="hidden" class="form-control input-lg" name="activate" value="<?php echo $_GET['i'] ?>">
        <input type="hidden" class="form-control input-lg" name="correo" value="<?php echo $_GET['c'] ?>">
      </div>
      <div class="row">
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
        </div>
      </div>

      <?php
        $login = new UsuariosController();
        $login->ctrIngresoUsuario();
      ?>

    </form>

    <br />
    <a href="recovery">Recuperar contraseña</a><br>
    <a href="registro" class="text-center">Registrar una nueva cuenta</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
