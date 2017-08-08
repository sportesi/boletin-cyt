<?php

//Important need to be defined in the top page required pages
define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

require_once(__ROOT__ . '/common/session/Session.php');
require_once(__ROOT__ . '/common/DataAccess/DBSecurityConnections.php');

//Queries
define('QUERY_LOGIN', "SELECT * FROM user U WHERE U.email='[0]' AND U.password ='[1]' ORDER BY date DESC limit 1");

define('QUERY_SEMESTER', "SELECT * FROM user WHERE id=[0] AND CASE WHEN MONTH(date) > 8 THEN 2 WHEN MONTH(date) > 1 THEN 1 END = CASE WHEN MONTH(NOW()) > 8 THEN 2 WHEN MONTH(NOW()) > 1 THEN 1 END AND YEAR(date) = YEAR(NOW())");

try
{
    $email = DBInformation::mysql_escape_mimic(filter_input(INPUT_POST, "email"));
    $password = DBInformation::mysql_escape_mimic(filter_input(INPUT_POST, "password"));

    $query = QUERY_LOGIN;

    $query = str_replace('[0]', $email, $query);
    $query = str_replace('[1]', $password, $query);

    $rs = $dbSetting->ExecuteQuery($query);
    $row = mysql_fetch_assoc($rs);

    if (count($row) == 0)
    {
        throw new Exception('not-registered');
    }

    if ($row["validated"] == "1")
    {
        if ($row["permission_id"] == 1)
        {
            //check if the user is of the other cuatrimestre
            $checkStr = QUERY_SEMESTER;

            $checkStr = $dbSetting->ReplaceParameter($checkStr,'[0]',$row["id"]);

            $rss = $dbSetting->ExecuteQuery($checkStr);

            $quarterValidation = mysql_num_rows($rss);

            if ($quarterValidation == 0)
            {
                throw new Exception('not-registered');
            }
        }

        $_SESSION['login_user'] = $email;
        $_SESSION['valid'] = 'valid';
        $_SESSION['permission'] = $row["permission_id"];
        $_SESSION['user_id'] = $row["id"];
        $_SESSION['change-password'] = false;

        if ($row["password"] == '123456')
        {
            $_SESSION['change-password'] = true;
        }

        header('Location: /');
    }
    else
    {
        throw new Exception("invalid");
    }
}
catch (Exception $e)
{
    header('Location: /?error=' . $e->getMessage());
}