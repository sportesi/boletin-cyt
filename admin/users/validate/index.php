<?php
//Important need to be defined in the top page required pages
define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

require_once(__ROOT__ . '/common/session/Session.php');
require_once(__ROOT__ . '/common/DataAccess/DBSecurityConnections.php');

//Queries
define(
    '__QUERY_GET_ALL_STUDENT_TO_VALIDATE_ORDER_BY_NAME__',
    "SELECT U.id, CONCAT_WS(',',U.firstname,NULL,U.lastname) 'fullname', C.name 'campus', U.year, T.name 'turn',
         U.comission 'comission', U.validated, U.date FROM user U, turn T, campus C
         WHERE U.turn_id = T.id AND U.campus_id = C.id AND U.validated = 0 AND U.permission_id = 1 "
);

//Check if the user is still login
if ($session->GetSessionValue('valid') != 'valid') {
    header('location: /index.php');
}

if ($session->GetSessionValue('permission') < 2) {
    header('location: /index.php');
}

$sectionOverride = 'Usuarios: Validar';

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

            <?php if ($_GET['validated'] === 'true'): ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Usuario validado!</strong>
                </div>
            <?php endif ?>

            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nombre completo</th>
                            <th>Campus</th>
                            <th>Año</th>
                            <th>Turno</th>
                            <th>Comisión</th>
                            <th>Fecha de Registo</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $rs = $dbSetting->ExecuteQuery(__QUERY_GET_ALL_STUDENT_TO_VALIDATE_ORDER_BY_NAME__); ?>

                        <?php while ($row = mysql_fetch_assoc($rs)): ?>
                            <tr class='center'>
                                <td><?php echo $row['fullname']; ?></td>
                                <td><?php echo $row['campus']; ?></td>
                                <td><?php echo $row['year']; ?></td>
                                <td><?php echo $row['turn']; ?></td>
                                <td><?php echo $row['comission']; ?></td>
                                <td><?php echo $row['date']; ?></td>
                                <td class='text-right'>
                                    <div class="">
                                        <a role="button" onclick="ask('./validate.php?id=<?php echo $row['id']; ?>');"
                                           class="btn btn-success btn-xs">Validar</a>
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
        if (confirm('¿Estas seguro de validar este usuario?')) {
            window.location.href = url;
        }
    }
</script>
</body>

</html>