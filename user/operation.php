<?php
//Important need to be defined in the top page required pages
define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

require_once(__ROOT__ . '/common/session/Session.php');
require_once(__ROOT__ . '/common/DataAccess/DBSecurityConnections.php');

//Queries
define('__QUERY_INSERT_USER__', "INSERT INTO user
  												   (turn_id,
  												    campus_id,
  												    permission_id,
  												    year,
  												    firstname,
  												    lastname,
  												    password,
  												    email,
  												    comission,
  												    validated,
  												    date
												   )
								  VALUES ([0],[1],[2],[3],'[4]','[5]','[6]','[7]','[8]',[9],[10])");

define('__QUERY_GET_USER_BY_EMAIL__', "SELECT * 
  										 FROM user 
  										 WHERE email='[0]' 
  										 ORDER BY date DESC limit 1");

define('__QUERY_GET_VALID_USER__', "SELECT * 
  									  FROM user 
  									  WHERE id=[0] 
  									        AND CASE  when MONTH(date) > 3 then 1 when MONTH(date) > 8 then 2 END = CASE  when MONTH(NOW()) > 3 then 1 when MONTH(NOW()) > 8 then 2 END AND YEAR(date) = YEAR(NOW())");

define('__QUERY_CHECK_USER_PASSWORD__', "SELECT * 
 										  FROM user 
 										  WHERE email ='[0]' 
 										  		AND password ='123456'");

define('__QUERY_UPDATE_USER_PASSWORD__', "UPDATE user SET password = '[0]' 
 										   WHERE email = '[1]' 
 										   		 AND password = '[2]'");

define('__QUERY_GET_USERS_BY_FILTERS__', "SELECT U.id,
 												  U.firstname,
 												  U.lastname, 
 												  C.id 'campus_id',
 												  C.name 'campus',
 												  U.year 'year_coursed',
 												  T.id 'turn_id',
 												  T.name 'turn',
 												  U.comission 'comission',
 												  CASE  when MONTH(U.date) > 3 then 1 when MONTH(U.date) > 8 then 2 END 'cuatrimestre',
 												  YEAR(U.date) 'year' 
 											FROM user U,
 											     turn T,
 											     campus C
 											WHERE U.turn_id = T.id 
 												  AND U.campus_id = C.id 
 												  AND U.validated = 1 ");

define('__QUERY_UPDATE_USER__', "UPDATE user SET firstname = '[0]',
  												  lastname = '[1]',
  												  campus_id = [2],
  												  year = [3],
  												  turn_id = [4],
  												  comission='[5]'
  											  WHERE id=[6]");

switch ($_GET['operation']) {
    case "save":
        SaveUser($dbSetting);
        break;
    case "verify":
        ValidateUser($dbSetting);
        break;
    case "check_status";
        CheckPassword($dbSetting, $session);
        break;
    case "password":
        ChangePassword($dbSetting, $session);
        break;
    case "user":
        GetUser($dbSetting);
        break;
    case "update";
        UpdateUser($dbSetting, $session);
        break;
}
exit();

function SaveUser($dbSetting)
{
    try {
        $firstname = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "first_name"));
        $lastname = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "last_name"));
        $turn_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "turn_id"));
        $campus_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "campus_id"));
        $email = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "email"));
        $comission = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "comission"));
        $year = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "year"));

        $query = __QUERY_INSERT_USER__;
        $query = $dbSetting->ReplaceParameter($query, '[0]', $turn_id);
        $query = $dbSetting->ReplaceParameter($query, '[1]', $campus_id);
        $query = $dbSetting->ReplaceParameter($query, '[2]', '1');
        $query = $dbSetting->ReplaceParameter($query, '[3]', $year);
        $query = $dbSetting->ReplaceParameter($query, '[4]', $firstname);
        $query = $dbSetting->ReplaceParameter($query, '[5]', $lastname);
        $query = $dbSetting->ReplaceParameter($query, '[6]', '123456');
        $query = $dbSetting->ReplaceParameter($query, '[7]', $email);
        $query = $dbSetting->ReplaceParameter($query, '[8]', $comission);
        $query = $dbSetting->ReplaceParameter($query, '[9]', 'false');
        $query = $dbSetting->ReplaceParameter($query, '[10]', 'NOW()');

        $dbSetting->ExecuteQuery($query);

        echo json_encode(array("successful" => "true"));
    } catch (Exception $e) {
        echo $e;
        echo "error";
    }
}

function ValidateUser($dbSetting)
{
    try {
        $email = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "email"));

        $query = __QUERY_GET_USER_BY_EMAIL__;
        $query = $dbSetting->ReplaceParameter($query, '[0]', $email);
        $rs = $dbSetting->ExecuteQuery($query);

        $row = mysql_fetch_assoc($rs);
        $numrows = mysql_num_rows($rs);

        if ($numrows > 0) {
            if ($row["permission_id"] == 1) {
                //check if the user is of the other cuatrimestre
                $query = __QUERY_GET_VALID_USER__;
                $query = $dbSetting->ReplaceParameter($query, '[0]', $row["id"]);
                $rss = $dbSetting->ExecuteQuery($query);
                $Validationnumrows = mysql_num_rows($rss);

                if ($Validationnumrows == 0) {
                    echo json_encode(array("status" => "free"));
                } else {
                    echo json_encode(array("status" => "duplicated"));
                }

                return;
            }

            echo json_encode(array("status" => "duplicated"));
        } else {
            echo json_encode(array("status" => "free"));
        }
    } catch (Exception $e) {
        echo $e;
        echo "error";
    }
}


function CheckPassword($dbSetting, $session)
{
    try {
        $email = $session->GetSessionValue('login_user');

        $query = __QUERY_CHECK_USER_PASSWORD__;
        $query = $dbSetting->ReplaceParameter($query, '[0]', $email);
        $rs = $dbSetting->ExecuteQuery($query);

        $numrows = mysql_num_rows($rs);

        if ($numrows > 0) {
            echo json_encode(array("status" => "need_change"));
        } else {
            echo json_encode(array("status" => "good"));
        }
    } catch (Exception $e) {
        echo $e;
        echo "error";
    }
}

function ChangePassword($dbSetting, $session)
{
    //Check if the user is still login
    if ($session->GetSessionValue('valid') != 'valid') {
        return 0;
    }

    try {
        $email = $session->GetSessionValue('login_user');

        $prev_password = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "prev_password"));
        $password = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "password"));

        $query = __QUERY_UPDATE_USER_PASSWORD__;
        $query = $dbSetting->ReplaceParameter($query, '[0]', $password);
        $query = $dbSetting->ReplaceParameter($query, '[1]', $email);
        $query = $dbSetting->ReplaceParameter($query, '[2]', $prev_password);

        $dbSetting->ExecuteQuery($query);

        echo json_encode(array("successful" => "true"));

    } catch (Exception $e) {
        echo $e;
        echo "error";
    }
}

function GetUser($dbSetting)
{
    try {
        $query = __QUERY_GET_USERS_BY_FILTERS__;

        if ($_GET["id"] != null) {
            $id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "id"));

            $query = $query . " AND U.id =" . $id;
        }

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

            $query = $query . " AND CASE  when MONTH(U.date) > 3 then 1 when MONTH(U.date) > 8 then 2 END =" . $cuatrimestre;
        }

        $query = $query . " ORDER BY CONCAT_WS(',',U.firstname,NULL,U.lastname) DESC";

        $rs = $dbSetting->ExecuteQuery($query);

        $result = [];

        for ($x = 0, $numrows = mysql_num_rows($rs); $x < $numrows; $x++) {
            $row = mysql_fetch_assoc($rs);

            $result[$x] = array(
                "id" => $row["id"],
                "firstname" => $row["firstname"],
                "lastname" => $row["lastname"],
                "campus" => $row["campus_id"],
                "year_coursed" => $row["year_coursed"],
                "turn" => $row["turn_id"],
                "comission" => $row["comission"]
            );
        }

        echo json_encode($result);

    } catch (Exception $e) {
        echo $e;
    }
}

function UpdateUser($dbSetting, $session)
{
    //Check if the user is still login
    if ($session->GetSessionValue('valid') != 'valid') {
        return 0;
    }

    try {
        $first_name = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "first_name"));
        $last_name = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "last_name"));
        $campus_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "campus_id"));
        $year = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "year"));
        $turn_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "turn_id"));
        $comission = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "comission"));

        $user_id = $session->GetSessionValue('user_id');

        $query = __QUERY_UPDATE_USER__;
        $query = $dbSetting->ReplaceParameter($query, '[0]', $first_name);
        $query = $dbSetting->ReplaceParameter($query, '[1]', $last_name);
        $query = $dbSetting->ReplaceParameter($query, '[2]', $campus_id);
        $query = $dbSetting->ReplaceParameter($query, '[3]', $year);
        $query = $dbSetting->ReplaceParameter($query, '[4]', $turn_id);
        $query = $dbSetting->ReplaceParameter($query, '[5]', $comission);
        $query = $dbSetting->ReplaceParameter($query, '[6]', $user_id);

        $dbSetting->ExecuteQuery($query);

        echo json_encode(array("successful" => "true"));
    } catch (Exception $e) {
        echo $e;
        echo "error";
    }
}