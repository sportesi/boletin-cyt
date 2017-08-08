<div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-loginLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modal-loginLabel">Ingresar</h4>
            </div>
            <div class="modal-body">
                <?php if (!empty(filter_input(INPUT_GET, 'error'))): ?>
                    <script>$('#modal-login').modal('show');</script>
                    <div class="alert alert-danger">
                        <?php
                        switch (filter_input(INPUT_GET, 'error')) {
                            case 'invalid':
                                echo "El <b>email</b> o <b>contraseña</b> ingresados son incorrectos.";
                                break;
                            case 'not-registered':
                                echo "El <b>usuario</b> no ha sido verificado por un docente.";
                                break;
                        }
                        ?>
                    </div>
                <?php endif ?>
                <form action="/login/login.php" method="post">
                    <div class="form-group">
                        <label for="input-email">Email</label>
                        <input type="email" class="form-control" name="email" id="input-email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="input-password">Contraseña</label>
                        <input type="password" class="form-control" name="password" id="input-password"
                               placeholder="Contraseña">
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
