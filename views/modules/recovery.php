<div id="back"></div>
<div class="login-box">
  <div class="login-logo">
    <a href="cartas-de-porte"><b>Cuenca</b>SIS</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Recuperar datos de acceso</p>

    <form action="" id="form" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control input-lg cuit" id="cuit" maxlength="12" name="clientCUIT" placeholder="CUIT" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
     
      <div class="row">
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Recuperar</button>
        </div>
      </div>

      <?php
        $login = new UsuariosController();
        $login->ctrRecoveryUsuario();
      ?>

    </form>

    <br />
    <a href="login">Ya tengo una cuenta</a><br>
    <a href="registro" class="text-center">Registrar una nueva cuenta</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
