<!-- Modal Actualizar Datos -->
<div class="modal fade" id="modal-update-user" tabindex="-1" role="dialog" aria-labelledby="modal-update-userLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modal-update-userLabel">Actualizar Datos</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Actualizar Datos -->

<!-- Modal Cambiar Contraseña -->
<div class="modal fade" id="modal-change-password" tabindex="-1" role="dialog"
     aria-labelledby="modal-change-passwordLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modal-change-passwordLabel">Cambiar Contraseña</h4>
            </div>
            <div class="modal-body">
                <?php if ($_SESSION['change-password']): ?>
                    <div class="alert alert-warning">
                        <p>Te sugerimos cambiar tu contraseña por razones de seguridad.</p>
                    </div>
                <?php endif; ?>
                
                <?php if (filter_input(INPUT_GET, 'change-password') === 'wrong-password'): ?>
                    <div class="alert alert-danger">
                        <p>Tu <b>contraseña</b> anterior es incorrecta.</p>
                    </div>
                    <script>$('#modal-change-password').modal('show');</script>
                <?php endif; ?>
                <form action="/user/change-password/change-password.php" method="post">
                    <div class="form-group">
                        <label for="input-old-password">Contraseña Anterior</label>
                        <input type="password" class="form-control" name="old-password" id="input-old-password"
                               placeholder="Contraseña Anterior">
                    </div>
                    <div class="form-group">
                        <label for="input-new-password">Contraseña Nueva</label>
                        <input type="password" class="form-control" name="new-password" id="input-new-password"
                               placeholder="Contraseña Nueva">
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php if ($_SESSION['change-password']): ?>
    <script>$('#modal-change-password').modal('show');</script>
<?php endif; ?>
<!-- Fin Modal Cambiar Contraseña -->