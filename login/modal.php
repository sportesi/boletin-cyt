<div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-loginLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal-loginLabel">Ingresar</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger">
          <ul>
            <li>Escriba un <b>email</b>.</li>
            <li>Escriba la <b>contraseña</b>.</li>
            <li>El <b>email</b> o <b>contraseña</b> ingresados son incorrectos.</li>
            <li>El <b>usuario</b> no ha sido verificado por un docente.</li>
          </ul>
        </div>
        <form action="/login/login.php" method="post">
          <div class="form-group">
            <label for="input-email">Email</label>
            <input type="email" class="form-control" name="email" id="input-email" placeholder="Email">
          </div>
          <div class="form-group">
            <label for="input-password">Contraseña</label>
            <input type="password" class="form-control" name="password" id="input-password" placeholder="Contraseña">
          </div>
          <div class="text-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Ingresar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
