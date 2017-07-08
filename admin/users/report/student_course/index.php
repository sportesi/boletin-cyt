<?php
//Important need to be defined in the top page required pages
define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

require_once(__ROOT__ . '/common/session/Session.php');
require_once(__ROOT__ . '/common/DataAccess/DBSecurityConnections.php');

//Check if the user is still login
if ($session->GetSessionValue('valid') != 'valid') {
    header("location:../../../login/index.php");
}

if ($session->GetSessionValue('permission') < 2) {
    header("location:../../../login/index.php");
}
//Queries
define('__QUERY_GET_ALL_COURSE_PEOPLE_BY_FILTERS__', "SELECT U.id,
 														  CONCAT_WS(',',U.lastname,NULL,U.firstname) 'fullname',
 														  C.id 'campus_id',
 														  C.name 'campus',
 														  U.year 'year_coursed',
 														  T.id 'turn_id',
 														  T.name 'turn',
 														  U.comission 'comission',
 														  CASE  when MONTH(U.date) > 8 then 2 when MONTH(U.date) > 1 then 1 END 'cuatrimestre',YEAR(U.date) 'year'
 													FROM user U,
 														 turn T,
 														 campus C
 													WHERE U.turn_id = T.id 
 														  AND U.campus_id = C.id 
 														  AND U.validated = 1 
 														  AND U.permission_id = 1 ");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <?php
    //Get User to used in the title
    $title_description = ' - Usuario: ' . $session->GetSessionValue('login_user');
    echo '<title>EES - UAI - Curso ' . $title_description . '</title>';
    ?>

    <style type="text/css" title="currentStyle">
        @import "/controls/grid/datatables-grid/css/demo_page.css";
        @import "/controls/grid/datatables-grid/css/demo_table.css";</style>

    <script type="text/javascript" language="JavaScript" src="/scripts/jquery/jquery.min.js"></script>
    <script type="text/javascript" language="JavaScript"
            src="/controls/grid/datatables-grid/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="JavaScript" src="/controls/menu/ddsmoothmenu.js"></script>
    <script type="text/javascript" language="JavaScript"
            src="/admin/users/report/student_course/script/student_course.js"></script>
    <link rel="stylesheet" type="text/css" href="/style/css/general.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu.css"/>
    <link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu-v.css"/>
    <link rel="stylesheet" type="text/css" href="/style/css/list.css"/>

</head>

<body id="dt_example">
<div id="smoothmenu1" class="ddsmoothmenu"></div>
<div>
    <h1>Curso</h1>
    <table style="500px; padding-left: 10px;">
        <tr>
            <td>
                <div>Año</div>
                <div>
                    <select id="year" class="textbox">
                        <option value="2011" <?php echo ($_GET['year'] == '2011' ? 'selected' : ''); ?>>2011</option>
                        <option value="2012" <?php echo ($_GET['year'] == '2012' ? 'selected' : ''); ?>>2012</option>
                        <option value="2013" <?php echo ($_GET['year'] == '2013' ? 'selected' : ''); ?>>2013</option>
                        <option value="2014" <?php echo ($_GET['year'] == '2014' ? 'selected' : ''); ?>>2014</option>
                        <option value="2015" <?php echo ($_GET['year'] == '2015' ? 'selected' : ''); ?>>2015</option>
                        <option value="2016" <?php echo ($_GET['year'] == '2016' ? 'selected' : ''); ?>>2016</option>
                        <option value="2017" <?php echo ($_GET['year'] == '2017' ? 'selected' : ''); ?>>2017</option>
                        <option value="2018" <?php echo ($_GET['year'] == '2018' ? 'selected' : ''); ?>>2018</option>
                        <option value="2019" <?php echo ($_GET['year'] == '2019' ? 'selected' : ''); ?>>2019</option>
                    </select>
                </div>
            </td>
            <td>
                <div>Año de cursada</div>
                <div>
                    <select id="year_coursed" class="textbox">
                        <option value="1" <?php echo ($_GET['year_coursed'] == '1' ? 'selected' : ''); ?>>1</option>
                        <option value="2" <?php echo ($_GET['year_coursed'] == '2' ? 'selected' : ''); ?>>2</option>
                        <option value="3" <?php echo ($_GET['year_coursed'] == '3' ? 'selected' : ''); ?>>3</option>
                        <option value="4" <?php echo ($_GET['year_coursed'] == '4' ? 'selected' : ''); ?>>4</option>
                        <option value="5" <?php echo ($_GET['year_coursed'] == '5' ? 'selected' : ''); ?>>5</option>
                    </select>
                </div>
            </td>
            <td>
                <div>Comisión</div>
                <div>
                    <select id="comission" class="textbox">
                        <option value="A" <?php echo ($_GET['comission'] == 'A' ? 'selected' : ''); ?>>A</option>
                        <option value="B" <?php echo ($_GET['comission'] == 'B' ? 'selected' : ''); ?>>B</option>
                        <option value="C" <?php echo ($_GET['comission'] == 'C' ? 'selected' : ''); ?>>C</option>
                        <option value="D" <?php echo ($_GET['comission'] == 'D' ? 'selected' : ''); ?>>D</option>
                        <option value="E" <?php echo ($_GET['comission'] == 'E' ? 'selected' : ''); ?>>E</option>
                        <option value="F" <?php echo ($_GET['comission'] == 'F' ? 'selected' : ''); ?>>F</option>
                        <option value="G" <?php echo ($_GET['comission'] == 'G' ? 'selected' : ''); ?>>G</option>
                        <option value="H" <?php echo ($_GET['comission'] == 'H' ? 'selected' : ''); ?>>H</option>
                        <option value="I" <?php echo ($_GET['comission'] == 'I' ? 'selected' : ''); ?>>I</option>
                        <option value="J" <?php echo ($_GET['comission'] == 'J' ? 'selected' : ''); ?>>J</option>
                        <option value="K" <?php echo ($_GET['comission'] == 'K' ? 'selected' : ''); ?>>K</option>
                    </select>
                </div>
            </td>
            <td>
                <div>Turno</div>
                <div>
                    <select id="turns" class="textbox"></select>
                </div>
            </td>
            <td>
                <div>Localización</div>
                <div>
                    <select id="campus" class="textbox"></select>
                </div>
            </td>
            <td>
                <div>Cuatrimestre</div>
                <div>
                    <select id="cuatrimestre" class="textbox">
                        <option>1</option>
                        <option>2</option>
                    </select>
                </div>
            </td>
            <td valign="bottom">
                <div>
                    <input type="button" value="Buscar" onclick="Search()" class="GeneralButtons"/>
                </div>
            </td>
        </tr>
    </table>
    <br/>
    <div id="container">

        <div id="output"></div>

        <div id="demo">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                <tr>
                    <th></th>
                    <th>Nombre completo</th>
                    <th>Campus</th>
                    <th>Año de Cursada</th>
                    <th>Turno</th>
                    <th>Comisión</th>
                    <th>Cuatrimestre</th>
                    <th>Año</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <?php


                try {
                    $query = __QUERY_GET_ALL_COURSE_PEOPLE_BY_FILTERS__;

                    if ($_GET["campus"] != null) {
                        $campus = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "campus"));

                        $query = $query . " AND C.id =" . $campus;
                    }

                    if ($_GET["turn"] != null) {
                        $turn = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "turn"));

                        $query = $query . " AND T.id =" . $turn;
                    }

                    if ($_GET["comission"] != null) {
                        $comission = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "comission"));

                        $query = $query . " AND U.comission ='" . $comission . "'";
                    }

                    if ($_GET["year_cursed"] != null) {
                        $year_cursed = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "year_cursed"));

                        $query = $query . " AND U.year =" . $year_cursed;
                    }

                    if ($_GET["year"] != null) {
                        $year = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "year"));

                        $query = $query . " AND YEAR(U.date) =" . $year;
                    }

                    if ($_GET["cuatrimestre"] != null) {
                        $cuatrimestre = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "cuatrimestre"));

                        $query = $query . " AND CASE  when MONTH(U.date) > 8 then 2 when MONTH(U.date) > 1 then 1 END =" . $cuatrimestre;
                    }

                    $query = $query . " ORDER BY U.lastname ASC";

                    $rs = $dbSetting->ExecuteQuery($query);

                    while ($row = mysql_fetch_assoc($rs)) {
                        echo "<tr class='center'>" .
                            "<td class='center'> <a href='../../../../user/statistics/index.php?id={$row['id']}' >Ver actividad</a> </td>" .
                            "<td class='center'> {$row['fullname']} </td>" . "<td class='center'> {$row['campus']} </td>" .
                            "<td class='center'> {$row['year_coursed']} </td>" . "<td class='center'> {$row['turn']} </td>" .
                            "<td class='center'> {$row['comission']} </td>" . "<td class='center'> {$row['cuatrimestre']} </td>" .
                            "<td class='center'> {$row['year']} </td>" .
                            "<td class='center'> <input id='button_reset_{$row['id']}' type='button' value='Reseter clase' onclick='Reset(" . $row['id'] . ")'/> </td>" .
                            "<td class='center'> <input id='button__{$row['id']}' type='button' value='Borrar' onclick='Delete(" . $row['id'] . ")'/> </td>" .
                            "</tr>";
                    }

                } catch (Exception $e) {
                    echo $e;
                }

                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th></th>
                    <th>Nombre completo</th>
                    <th>Campus</th>
                    <th>Año de Cursada</th>
                    <th>Turno</th>
                    <th>Comisión</th>
                    <th>Cuatrimestre</th>
                    <th>Año</th>
                    <th></th>
                    <th></th>
                </tr>
                </tfoot>
            </table>

        </div>
        <div class="spacer"></div>

    </div>

</div>
</body>
</html>