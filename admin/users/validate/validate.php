<?php
//Important need to be defined in the top page required pages
define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

require_once(__ROOT__ . '/common/session/Session.php');
require_once(__ROOT__ . '/common/DataAccess/DBSecurityConnections.php');

try {
    $user_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "id"));
    $query = "UPDATE user SET validated = 1 WHERE id = {$user_id}";
    $rs = $dbSetting->ExecuteQuery($query);
    header('Location: /admin/users/validate/index.php?validated=true');
} catch (Exception $exception) {
    header('Location: /admin/users/validate/index.php?error=' . $exception->getMessage());
}