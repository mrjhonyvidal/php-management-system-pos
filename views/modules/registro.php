<div id="back"></div>
<div class="register-box">
  <div class="register-logo">
    <a href="cartas-de-porte"><b>Cuenca</b>SIS</a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Crear una cuenta en el sistema</p>

    <form action="#" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="cuit" id="regCUIT" class="form-control cuit" maxlength="12" placeholder="CUIT">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" name="razonSocial" class="form-control " placeholder="Razón Social">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" name="usuario" id="regUsuario" class="form-control " placeholder="Usuario">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" name="correo" id="regCorreo" class="form-control" placeholder="Correo">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Contraseña">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="passwordConfirm" class="form-control" placeholder="Repetir contraseña">
        <span class="glyphicon  glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!--<div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Acepto los <a href="#">términos del sistematerms</a>
            </label>
          </div>
        </div>
        -->
        <!-- /.col -->
        <div class="col-xs-6">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Registrarse</button>
        </div>
        <!-- /.col -->
      </div>    


      <?php
        $login = new UsuariosController();
        $login->ctrRegisterUsuario();
      ?>

    </form>

    <a href="login" class="text-center">Ya tengo una cuenta</a><br />
    <a href="recovery">Recuperar contraseña</a><br>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->
