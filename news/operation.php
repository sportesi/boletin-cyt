<?php
//Important need to be defined in the top page required pages
define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

require_once(__ROOT__ . '/common/session/Session.php');
require_once(__ROOT__ . '/common/DataAccess/DBSecurityConnections.php');

define('__QUERY_GET_COUNT_OF_NEWS__', "SELECT COUNT(*) 'total' 
    									   FROM news N");

define('__QUERY_GET_ALL_NEWS_BY_FILTER__', "SELECT N.id,N.user_id,
													   CONCAT_WS(',',U.firstname,NULL,U.lastname) 'fullname',
													   C.id 'campus_id',
													   C.name 'campus',
													   U.year 'year_coursed',
													   T.id 'turn_id',
													   T.name 'turn',
													   U.comission 'comission',
													   N.title,
													   N.sub_title,
													   N.summary,
													   N.sub_summary,
													   N.image_url,
													   N.image_comment,
													   N.category_id,
													   Cat.name 'category',
													   N.link_1,
													   N.link_2,
													   N.link_3,
													   N.date 
												FROM news N,
													 user U,
													 category Cat,
													 campus C,
													 turn T 
												WHERE N.category_id = Cat.id 
													  AND N.user_id = U.id 
													  AND U.campus_id = C.id 
													  AND U.turn_id = T.id");

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
    try {
        $category_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "category"));
        $user_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "user_id"));
        $news_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "id"));
        $offset = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "offset"));
        $pageperview = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "pageperview"));

        $query = __QUERY_GET_ALL_NEWS_BY_FILTER__;

        if ($category_id != '') {
            $query = $query . " AND N.category_id =" . $category_id;
        }

        if ($user_id != '') {
            $query = $query . " AND N.user_id=" . $user_id;
        }

        if ($news_id != '') {
            $query = $query . " AND N.id=" . $news_id;
        }

        $query = $query . " ORDER BY N.date DESC";

        if ($offset != '' && $pageperview != '') {
            $query = $query . " LIMIT " . $offset . " , " . $pageperview . " ";
        }

        $rs = $dbSetting->ExecuteQuery($query);

        for ($x = 0, $numrows = mysql_num_rows($rs); $x < $numrows; $x++) {
            $row = mysql_fetch_assoc($rs);

            $result[$x] = array("id" => $row["id"],
                "user_id" => $row["user_id"],
                "fullname" => $row["fullname"],
                "campus_id" => $row["campus_id"],
                "campus" => $row["campus"],
                "year_coursed" => $row["year_coursed"],
                "turn_id" => $row["turn_id"],
                "turn" => $row["turn"],
                "comission" => $row["comission"],
                "title" => $row["title"],
                "sub_title" => $row["sub_title"],
                "summary" => $row["summary"],
                "sub_summary" => $row["sub_summary"],
                "image_url" => $row["image_url"],
                "image_comment" => $row["image_comment"],
                "category_id" => $row["category_id"],
                "category" => $row["category"],
                "link_1" => $row["link_1"],
                "link_2" => $row["link_2"],
                "link_3" => $row["link_3"],
                "date" => $row["date"]
            );
        }

        $newResult = array();
        foreach ($result as $value) {
            $newResult[] = json_encode($value);
        }
        $output = "[" . implode($newResult, ",") . "]";
        echo $output;

    } catch (Exception $e) {
        echo $e;
    }
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