<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">Boletín Científicio - Tecnológico</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <!-- <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li> -->
        <li><a href="/news/top/">Noticias Top</a></li>
        <?php $query_str = "?year=" . date('Y') . "&cuatrimestre=" . ((date('m') > 8) ? 2 : 1); ?>
        <?php if ($session->GetSessionValue('valid') == 'valid'): ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              Configuración de Usuario <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="/user/update/index.php">Actualizar Datos</a></li>
              <li><a href="/user/change_password/index.php">Cambiar Contraseña</a></li>
            </ul>
          </li>

          <?php if ($session->GetSessionValue('permission') == 2): ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Cursos <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="/admin/users/report/courses/index.php<?php echo $query_str; ?>">Reporte</a></li>
                <li><a href="/admin/users/validate/index.php<?php echo $query_str; ?>">Validar Alumnos</a></li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Categorías <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="/admin/category/create/index.php">Crear</a></li>
                <li><a href="/admin/category/list/index.php">Listar</a></li>
              </ul>
            </li>

            <li><a href="/admin/users/news/list/index.php?offset=0&pageperview=10">Listar Noticias</a></li>
          <?php else: ?>
            <li><a href="/user/statistics/index.php?id=<?php echo $session->GetSessionValue('user_id') ?>">Rendimiento</a></li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Noticias <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="/news/create">Crear</a></li>
                <li><a href="/news/list/">Lista por usuario</a></li>
              </ul>
            </li>
          <?php endif; ?>
        <?php endif; ?>
      </ul>
      <div class="navbar-right">
        <?php if ($session->GetSessionValue('valid') == 'valid'): ?>
          <a href="/login/logout.php" class="btn btn-primary btn-sm navbar-btn">Salir</a>
        <?php else: ?>
          <a href="#" class="btn btn-success btn-sm navbar-btn" data-toggle="modal" data-target="#modal-register">Registrarse</a>
          <a href="#" class="btn btn-primary btn-sm navbar-btn" data-toggle="modal" data-target="#modal-login">Ingresar</a>
        <?php endif; ?>
      </div>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
