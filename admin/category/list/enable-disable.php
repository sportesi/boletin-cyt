<?php
//Important need to be defined in the top page required pages
define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

require_once(__ROOT__ . '/common/session/Session.php');
require_once(__ROOT__ . '/common/DataAccess/DBSecurityConnections.php');

try {
    $category_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "id"));
    $status = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "st"));
    $query = "UPDATE category SET status={$status} WHERE id = {$category_id}";
    $rs = $dbSetting->ExecuteQuery($query);
    header('Location: /admin/category/list/?updated=true');
} catch (Exception $exception) {
    header('Location: /admin/category/list/?error=' . $exception->getMessage());
}