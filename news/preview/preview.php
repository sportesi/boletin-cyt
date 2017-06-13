<?php
//Important need to be defined in the top page required pages
define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

require_once(__ROOT__ . '/common/session/Session.php');
require_once(__ROOT__ . '/common/DataAccess/DBSecurityConnections.php');

define('__QUERY_GET_NEWS_BY_ID__', "SELECT link_1, link_2, link_3 FROM news WHERE id = [0]");

define('__QUERY_INSERT_STADISTIC_FOR_NEWS__', "INSERT INTO statistic (news_id, ip,date) VALUES([0],'[1]',[2])");

define('__QUERY_CHECK_DAY_INSERT_INTO_STADISTIC__', "SELECT * FROM statistic WHERE ip = '[0]' AND DATE(date)=CURDATE() AND news_id = [1]");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="/style/css/fullscreen_preview.css"/>
    <script type="text/javascript" language="javascript" src="/scripts/jquery/jquery.min.js"></script>
    <script type="text/javascript">
        var calcHeight = function () {
            var headerDimensions = $('#header-bar').height();
            $('#preview-frame').height($(window).height() - headerDimensions);
        }

        $(document).ready(function () {
            calcHeight();
            $('#header-bar a.close').mouseover(function () {
                $('#header-bar a.close').addClass('activated');
            }).mouseout(function () {
                $('#header-bar a.close').removeClass('activated');
            });
        });

        $(window).resize(function () {
            calcHeight();
        }).load(function () {
            calcHeight();
        });
    </script>

    <!--[if IE 6]>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#close-button').remove();
        });
    </script>
    <![endif]-->
</head>
<body>

<?php

$current_link = "";

try {
    $news_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "news_id"));
    $link_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "link"));

    $query = __QUERY_GET_NEWS_BY_ID__;
    $query = $dbSetting->ReplaceParameter($query, '[0]', $news_id);

    $rs = $dbSetting->ExecuteQuery($query);

    $row = mysql_fetch_assoc($rs);

    if ($link_id == 1) {
        $current_link = $row["link_1"];
    } else if ($link_id == 2) {
        $current_link = $row["link_2"];
    } else if ($link_id == 3) {
        $current_link = $row["link_3"];
    }

    $ip = $_SERVER['REMOTE_ADDR'];

    //check day entry
    $query = __QUERY_CHECK_DAY_INSERT_INTO_STADISTIC__;
    $query = $dbSetting->ReplaceParameter($query, '[0]', $ip);
    $query = $dbSetting->ReplaceParameter($query, '[1]', $news_id);
    $rs = $dbSetting->ExecuteQuery($query);
    $num_rows = mysql_num_rows($rs);

    if ($num_rows == 0) {
        //Insert record
        $query = __QUERY_INSERT_STADISTIC_FOR_NEWS__;
        $query = $dbSetting->ReplaceParameter($query, '[0]', $news_id);
        $query = $dbSetting->ReplaceParameter($query, '[1]', $ip);
        $query = $dbSetting->ReplaceParameter($query, '[2]', 'NOW()');

        $dbSetting->ExecuteQuery($query);
    }
} catch (Exception $e) {
    echo $e;
    echo "error";
}

$str = '<div id="header-bar">';
$str = $str . '<table width="100%">';
$str = $str . '<tr>';
$str = $str . '<td width="80%">';
$str = $str . '<div class="close-header">';
$str = $str . '<a id="close-button" title="Close Bar" class="close" href="' . $current_link . '">X</a>';
$str = $str . '</div>';
$str = $str . '<p class="meta-data">';
$str = $str . '<a class="close" href="' . $current_link . '">Quitar Frame</a>';
$str = $str . '</p>';
$str = $str . '</td>';
$str = $str . '<td width="20%" valign="middle" align="right">';
$str = $str . '<img src="/style/images/uai.png" /> &nbsp;';
$str = $str . '</td>';
$str = $str . '</tr>';
$str = $str . '</table>';
$str = $str . '</div>';
$str = $str . '<iframe id="preview-frame" src="' . $current_link . '" name="preview-frame" frameborder="0" noresize="noresize">';
$str = $str . '</iframe>';

echo $str;

?>

</body>
</html>

