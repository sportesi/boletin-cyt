<?php
//Important need to be defined in the top page required pages
define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

require_once(__ROOT__ . '/common/session/Session.php');
require_once(__ROOT__ . '/common/DataAccess/DBSecurityConnections.php');

define('__QUERY_GET_NEWS_BY_ID__', "SELECT link_1, link_2, link_3 FROM news WHERE id = [0]");

define('__QUERY_INSERT_STADISTIC_FOR_NEWS__', "INSERT INTO statistic (news_id, ip,date) VALUES([0],'[1]',[2])");

define('__QUERY_CHECK_DAY_INSERT_INTO_STADISTIC__', "SELECT * FROM statistic WHERE ip = '[0]' AND DATE(date)=CURDATE() AND news_id = [1]");


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

    // check day entry
    $query = __QUERY_CHECK_DAY_INSERT_INTO_STADISTIC__;
    $query = $dbSetting->ReplaceParameter($query, '[0]', $ip);
    $query = $dbSetting->ReplaceParameter($query, '[1]', $news_id);
    $rs = $dbSetting->ExecuteQuery($query);
    $num_rows = mysql_num_rows($rs);

    if ($num_rows == 0) {
        // Insert record
        $query = __QUERY_INSERT_STADISTIC_FOR_NEWS__;
        $query = $dbSetting->ReplaceParameter($query, '[0]', $news_id);
        $query = $dbSetting->ReplaceParameter($query, '[1]', $ip);
        $query = $dbSetting->ReplaceParameter($query, '[2]', 'NOW()');

        $dbSetting->ExecuteQuery($query);
    }
} catch (Exception $e) {
    header('Location: /');
}

header('Location: ' . $current_link);

?>