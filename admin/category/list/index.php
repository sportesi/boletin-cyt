<?php
//Important need to be defined in the top page required pages
define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

require_once(__ROOT__ . '/common/session/Session.php');
require_once(__ROOT__ . '/common/DataAccess/DBSecurityConnections.php');

//Queries
define('__QUERY_GET_ALL_CATEGORIES_ORDER_BY_NAME__',
    'SELECT C.* FROM category C WHERE C.deleted = 0 ORDER BY C.name DESC');

//Check if the user is still login
if ($session->GetSessionValue('valid') != 'valid') {
    header('location:../../login/index.php');
}

if ($session->GetSessionValue('permission') < 2) {
    header('location:../../login/index.php');
}

$sectionOverride = 'Categorías: Listado';

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=8"/>
    <meta name="description"
          content="Electromagnetismo y Estado Solido Universidad Abierta Internacional,
          EES UAI Joaquin Abraham Wessolowski, oftware, Seguridad Informatica, Salud , Robótica e Inteligenia
          Artificial,Politicas y Ética, Periféricos y Auxiliares, Otros, Nanotecnologia, Matematica y Lógica, IT &
          Infraestuctura Informatica, Fuentes RRS varias, Fisica y Quimica, Comunicaciones, Computación Cuantica,
          Circuitos Integrados, Almacenamiento y Memorias "/>
    <meta name="keywords"
          content="Software, Seguridad Informatica, Salud , Robótica e Inteligenia Artificial,Politicas y Ética,
          Periféricos y Auxiliares, Otros, Nanotecnologia, Matematica y Lógica, IT & Infraestuctura Informatica,
          Fuentes RRS varias, Fisica y Quimica, Comunicaciones, Computación Cuantica, Circuitos Integrados,
          Almacenamiento y Memorias "/>

    <title>UAI - Boletín Científico - Tecnológico</title>

    <script type="text/javascript" src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/node_modules/datatables.net/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="/node_modules/datatables.net-bs/js/dataTables.bootstrap.js"></script>
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/node_modules/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/style/css/general.css" media="screen"/>
    <link rel="stylesheet" href="/node_modules/datatables.net-bs/css/dataTables.bootstrap.css">
</head>

<body>
<div class="container">
    <div class="row">
        <!-- Header and Navbar -->
        <div class="col-md-12">
            <div class="page-header">
                <?php require_once '../../../controls/menu/menu_nav.php'; ?>
                <?php require_once '../../../controls/header/widget.php'; ?>
            </div>
        </div>
        <!-- End Header and Navbar -->
        <div class="col-md-12">

            <?php if ($_GET['updated'] === 'true'): ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Categoría actualizada!</strong>
                </div>
            <?php endif ?>

            <div class="panel panel-default">
                <div class="panel-heading text-right">
                    <button onclick="OpenModalCreate();" class="btn btn-primary">Crear Categoría</button>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $rs = $dbSetting->ExecuteQuery(__QUERY_GET_ALL_CATEGORIES_ORDER_BY_NAME__); ?>

                        <?php while ($row = mysql_fetch_assoc($rs)): ?>
                            <tr class='center'>
                                <td><?php echo $row['name']; ?></td>
                                <td class='text-right'>
                                    <div class="">
                                        <a href="./enable-disable.php?id=<?php echo $row['id']; ?>&st=<?php echo intval(!$row["status"]); ?>"
                                           class="btn btn-success btn-xs">
                                            <?php echo !$row["status"] ? 'Habilitar' : 'Deshabilitar' ?>
                                        </a>
                                        <a role="button"
                                           onclick="OpenModalEdit('<?php echo $row['name']; ?>', '<?php echo $row['id']; ?>');"
                                           class="btn btn-default btn-xs">Editar</a>
                                        <a role="button" onclick="ask('./delete.php?id=<?php echo $row['id']; ?>');"
                                           class="btn btn-danger btn-xs">Borrar</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Editar Categoría</h4>
            </div>
            <div class="modal-body">
                <form action="/admin/category/list/update.php" method="POST" role="form">
                    <div class="form-group">
                        <input type="hidden" name="category_id">
                        <input type="text" class="form-control" name="name" placeholder="Nombre">
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Editar Categoría</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Crear Categoría</h4>
            </div>
            <div class="modal-body">
                <form action="./create.php" method="POST" role="form">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" name="name" placeholder="Nombre">
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Crear Categoría</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('table').dataTable({
            searching: false,
            ordering: false,
            lengthChange: false,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            }
        });
    });

    function ask(url) {
        if (confirm('¿Estas seguro de elimiar esta categoría?')) {
            window.location.href = url;
        }
    }

    function OpenModalEdit(name, id) {
        $('#modal-edit input[name="name"]').val(name);
        $('#modal-edit input[name="category_id"]').val(id);
        $('#modal-edit').modal('show');
    }

    function OpenModalCreate() {
        $('#modal-create').find('form')[0].reset();
        $('#modal-create').modal('show');
    }
</script>
</body>

</html>