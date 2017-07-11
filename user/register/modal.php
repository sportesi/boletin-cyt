<div class="modal fade" id="modal-register" tabindex="-1" role="dialog" aria-labelledby="modal-registerLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal-registerLabel">Registrarse</h4>
      </div>
      <div class="modal-body">
        <form action="/user/register/register.php" method="post">
          <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" placeholder="Nombre" name="name">
          </div>
          <div class="form-group">
            <label for="lastName">Apellido</label>
            <input type="text" class="form-control" id="lastName" placeholder="Apellido" name="lastName">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Email" name="email">
          </div>
          <div class="form-group">
            <label for="lastName">Localización</label>
            <select id="campus" class="form-control" name="campus">
              <option value="8">Boulogne</option>
              <option value="4">Castelar</option>
              <option value="1">Centro</option>
              <option value="3">Lomas de Zamora</option>
              <option value="10">Rosario</option>
            </select>
          </div>
          <div class="form-group">
            <label for="lastName">Turno</label>
            <select id="turns" class="form-control" name="turns">
              <option value="1">TM</option>
              <option value="2">TT</option>
              <option value="3">TN</option>
            </select>
          </div>
          <div class="form-group">
            <label for="lastName">Comisión</label>
            <select id="comission" class="form-control" name="comission">
							<option>A</option>
							<option>B</option>
							<option>C</option>
							<option>D</option>
							<option>E</option>
							<option>F</option>
							<option>G</option>
							<option>H</option>
							<option>I</option>
							<option>J</option>
							<option>K</option>
							</select>
          </div>
          <div class="form-group">
            <label for="lastName">Año</label>
            <select id="year" class="form-control" name="year">
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
            </select>
          </div>
          <div class="text-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Registrarse</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
