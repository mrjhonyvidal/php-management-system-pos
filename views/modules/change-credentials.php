<div id="back"></div>
<div class="login-box">
  <div class="login-logo">
    <a href="cartas-de-porte"><b>Cuenca</b>SIS</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Cambiar credenciales de acceso</p>

    <form action="" id="form" method="post">
     <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="passwordConfirm" class="form-control" placeholder="Repetir contraseña" required>
        <span class="glyphicon  glyphicon-lock form-control-feedback"></span>
      </div>
      
      <input type="hidden" id="correo" name="correo" value="<?php echo $_GET['c'] ?>">
      <input type="hidden" id="token" name="token" value="<?php echo $_GET['token'] ?>">
     
      <div class="row">
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Actualizar</button>
        </div>
      </div>

      <?php
        $login = new UsuariosController();
        $login->ctrChangeUserCrendetials();
      ?>

    </form>

    <a href="login">Ya tengo una cuenta</a><br>
    <a href="registro" class="text-center">Registrar una nueva cuenta</a>
  

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
