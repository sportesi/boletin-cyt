<?php
//Important need to be defined in the top page required pages
define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

require_once(__ROOT__ . '/common/session/Session.php');
require_once(__ROOT__ . '/common/DataAccess/DBSecurityConnections.php');

//Queries
define('__QUERY_GET_ALL_COURSE_BY_FILTERS__', "SELECT campus.id 'campus_id', campus.name 'campus', YEAR(date) 'year', turn.id 'turn_id', turn.name 'turn', comission 'comission', CASE WHEN MONTH(user.date) > 8 THEN 2 WHEN MONTH(user.date) > 1 THEN 1 END 'cuatrimestre', user.year 'year_coursed'FROM user INNER JOIN turn ON user.turn_id = turn.id INNER JOIN campus ON user.campus_id = campus_id WHERE comission IN ('A' , 'B') ");

//Check if the user is still login
if ($session->GetSessionValue('valid') != 'valid') {
    header("location:../../../login/index.php");
}

if ($session->GetSessionValue('permission') < 2) {
    header("location:../../../login/index.php");
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <?php
    //Get User to used in the title
    $title_description = ' - Usuario: ' . $session->GetSessionValue('login_user');
    echo '<title>EES - UAI - Reporte por Curso ' . $title_description . '</title>';
    ?>
    <link rel='stylesheet' type='text/css' href="/style/css/general.css" media="screen"/>
    <style type="text/css" title="currentStyle">
        @import "/controls/grid/datatables-grid/css/demo_page.css";
        @import "/controls/grid/datatables-grid/css/demo_table.css";</style>

    <script type="text/javascript" language="JavaScript" src="/scripts/jquery/jquery.min.js"></script>
    <script type="text/javascript" language="JavaScript"
            src="/controls/grid/datatables-grid/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="JavaScript" src="/controls/menu/ddsmoothmenu.js"></script>
    <script type="text/javascript" language="JavaScript" src="/admin/users/report/courses/script/courses.js"></script>
    <link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu.css"/>
    <link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu-v.css"/>
    <link rel="stylesheet" type="text/css" href="/style/css/list.css"/>
</head>

<body id="dt_example">
<div id="smoothmenu1" class="ddsmoothmenu"></div>
<h1>Cursos</h1>
<div>
    <table style="width:300px; padding-left: 10px; ">
        <tr>
            <td>
                <div>Año</div>
            </td>
            <td>
                <div>Cuatrimestre</div>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <select id="year" class="textbox">
                    <option>2011</option>
                    <option>2012</option>
                    <option>2013</option>
                    <option>2014</option>
                    <option>2015</option>
                    <option>2016</option>
                    <option>2017</option>
                    <option>2018</option>
                    <option>2019</option>
                    <option>2020</option>
                </select>
            </td>
            <td>
                <select id="cuatrimestre" class="textbox">
                    <option>1</option>
                    <option>2</option>
                </select>
            </td>
            <td>
                <div>
                    <input type="button" value="Buscar" onclick="Search()" class="GeneralButtons"/>
                </div>
            </td>
        </tr>
    </table>

    <div id="container">

        <div id="output"></div>

        <div id="demo">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                <tr>
                    <th></th>
                    <th>Campus</th>
                    <th>Año</th>
                    <th>Turno</th>
                    <th>Comisión</th>
                    <th>Cuatrimestre</th>
                    <th>Año de cursada</th>
                </tr>
                </thead>
                <tbody>

                <?php

                try {
                    $query = __QUERY_GET_ALL_COURSE_BY_FILTERS__;

                    if ($_GET["year"] != null) {
                        $year = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "year"));

                        $query = $query . " AND YEAR(user.date) =" . $year;
                    }

                    if ($_GET["cuatrimestre"] != null) {
                        $cuatrimestre = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "cuatrimestre"));

                        $query = $query . " AND CASE  when MONTH(user.date) > 8 then 2 when MONTH(user.date) > 1 then 1 END =" . $cuatrimestre;
                    }

                    $query = $query . " GROUP BY campus.id , campus.name , YEAR(user.date) , turn.name , comission , CASE WHEN MONTH(user.date) > 8 THEN 2 WHEN MONTH(user.date) > 1 THEN 1 END , user.year , turn.id ORDER BY campus.id";

                    $rs = $dbSetting->ExecuteQuery($query);

                    while ($row = mysql_fetch_assoc($rs)) {
                        echo "<tr class='center'>" .
                            "<td class='center'> <a href='../student_course/index.php?campus={$row['campus_id']}&turn={$row['turn_id']}&year={$row['year']}&comission={$row['comission']}&cuatrimestre={$row['cuatrimestre']}&year_coursed={$row['year_coursed']}' >Ver curso</a> </td>" .
                            "<td class='center'> {$row['campus']} </td>" .
                            "<td class='center'> {$row['year']} </td>" .
                            "<td class='center'> {$row['turn']} </td>" .
                            "<td class='center'> {$row['comission']} </td>" .
                            "<td class='center'> {$row['cuatrimestre']} </td>" .
                            "<td class='center'> {$row['year_coursed']} </td>" .
                            "</tr>";
                    }

                } catch (Exception $e) {
                    echo $e;
                }


                function Validated($value)
                {
                    if ($value == 0) {
                        return "";
                    } else {
                        return "class='gradeD'";
                    }
                }

                function boolean($value)
                {
                    if ($value == 0) {
                        return "false";
                    } else {
                        return "true";
                    }
                }

                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th></th>
                    <th>Campus</th>
                    <th>Año</th>
                    <th>Turno</th>
                    <th>Comisión</th>
                    <th>Cuatrimestre</th>
                    <th>Año de cursada</th>
                </tr>
                </tfoot>
            </table>

        </div>
        <div class="spacer"></div>

    </div>

</div>
</body>
</html>