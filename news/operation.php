<?php
//Important need to be defined in the top page required pages
define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

require_once(__ROOT__ . '/common/session/Session.php');
require_once(__ROOT__ . '/common/DataAccess/DBSecurityConnections.php');

define('__QUERY_GET_COUNT_OF_NEWS__', "SELECT COUNT(*) 'total'
    									   FROM news N");

define('__QUERY_DELETE_NEWS_BY_ID__', "DELETE FROM news WHERE id = [0]");

switch ($_GET['operation']) {
    case "news":
        GetNews($dbSetting);
        break;
    case "count_news":
        GetCount($dbSetting);
        break;
    case "delete":
        Delete($dbSetting, $session);
        break;
}

exit();

function GetCount($dbSetting)
{
    try {
        $category_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "category"));
        $user_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "user_id"));
        $news_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "id"));

        $query = __QUERY_GET_COUNT_OF_NEWS__;

        if ($category_id != '' || $user_id != '' || $news_id != '') {
            $query = $query . " WHERE ";
        }

        if ($category_id != '') {
            $query = $query . " N.category_id = " . $category_id;
        }

        if ($user_id != '') {
            $query = $query . " N.user_id = " . $user_id;
        }

        if ($news_id != '') {
            $query = $query . " N.id = " . $news_id;
        }

        $rs = $dbSetting->ExecuteQuery($query);

        $numrows = mysql_num_rows($rs);

        if ($numrows > 0) {
            $row = mysql_fetch_assoc($rs);
            echo $row["total"];
        } else {
            echo "0";
        }

    } catch (Exception $e) {
        echo $e;
        echo "error";
    }
}

function GetNews($dbSetting)
{
    return new Exception('Not Implemented');
}

function Delete($dbSetting, $session)
{
    //Check if the user is still login
    if ($session->GetSessionValue('valid') != 'valid') {
        return 0;
    }

    try {
        $news_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "news_id"));

        $user_id = $session->GetSessionValue('user_id');

        $query = __QUERY_DELETE_NEWS_BY_ID__;
        $query = $dbSetting->ReplaceParameter($query, '[0]', $news_id);

        if ($session->GetSessionValue('permission') != 2) {
            $query = $query . " AND user_id = " . $user_id;
        }

        $rs = $dbSetting->ExecuteQuery($query);

        echo json_encode(array("successful" => "true"));

    } catch (Exception $e) {
        echo "Error doing delete";
    }
}
