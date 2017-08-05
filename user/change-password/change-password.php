<?php
//Important need to be defined in the top page required pages
define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

require_once(__ROOT__ . '/common/session/Session.php');
require_once(__ROOT__ . '/common/DataAccess/DBSecurityConnections.php');

//Queries
define('QUERY_UPDATE_USER_PASSWORD', "UPDATE user SET password = '[0]' WHERE email = '[1]' AND password = '[2]'");
define('QUERY_UPDATE_USER_PASSWORD_CHECK',
  "SELECT count(*) AS count FROM user WHERE email = '[1]' AND password = '[2]'");

try {
    if ($session->GetSessionValue('valid') != 'valid') {
        throw new Exception('user-invalid');
    }

    $email = $session->GetSessionValue('login_user');
    $oldPassword = DBInformation::mysql_escape_mimic(filter_input(INPUT_POST, "old-password"));
    $newPassword = DBInformation::mysql_escape_mimic(filter_input(INPUT_POST, "new-password"));

    $query = QUERY_UPDATE_USER_PASSWORD_CHECK;
    $query = $dbSetting->ReplaceParameter($query, '[1]', $email);
    $query = $dbSetting->ReplaceParameter($query, '[2]', $oldPassword);

    $valid = mysql_fetch_assoc($dbSetting->ExecuteQuery($query));

    if ($valid['count'] * 1 === 0) {
        throw new Exception('wrong-password');
    }

    $query = QUERY_UPDATE_USER_PASSWORD;
    $query = $dbSetting->ReplaceParameter($query, '[0]', $newPassword);
    $query = $dbSetting->ReplaceParameter($query, '[1]', $email);
    $query = $dbSetting->ReplaceParameter($query, '[2]', $oldPassword);

    $affected = $dbSetting->ExecuteQuery($query);

    if (isset($_SESSION['change-password']) && $_SESSION['change-password']) {
        $_SESSION['change-password'] = false;
    }

    header('Location: /?change-password=success');
} catch (Exception $e) {
    header('Location: /?change-password=' . $e->getMessage());
}