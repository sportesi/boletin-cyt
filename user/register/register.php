<?php

define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

require_once(__ROOT__ . '/common/session/Session.php');
require_once(__ROOT__ . '/common/DataAccess/DBSecurityConnections.php');

try 
{
    $firstname = DBInformation::mysql_escape_mimic(filter_input(INPUT_POST, "name"));
    $lastname  = DBInformation::mysql_escape_mimic(filter_input(INPUT_POST, "lastName"));
    $turn_id   = DBInformation::mysql_escape_mimic(filter_input(INPUT_POST, "turns"));
    $campus_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_POST, "campus"));
    $email     = DBInformation::mysql_escape_mimic(filter_input(INPUT_POST, "email"));
    $comission = DBInformation::mysql_escape_mimic(filter_input(INPUT_POST, "comission"));
    $year      = DBInformation::mysql_escape_mimic(filter_input(INPUT_POST, "year"));

    /* Validacion de usuario */
    $query   = "SELECT * FROM user WHERE email='[0]' ORDER BY date DESC limit 1";
    $query   = $dbSetting->ReplaceParameter($query, '[0]', $email);
    $rs      = $dbSetting->ExecuteQuery($query);
    $row     = mysql_fetch_assoc($rs);
    $numrows = mysql_num_rows($rs);

    if ($numrows > 0) 
    {
        if ($row["permission_id"] != 1) 
        {
            throw new Exception("duplicated");
        }
        
        // Comprueba si el usuario existe en otro cuatrimestre
        $query = "SELECT * FROM user WHERE id=[0] AND CASE  when MONTH(date) > 3 then 1 when MONTH(date) > 8 then 2 END = CASE 
        when MONTH(NOW()) > 3 then 1 when MONTH(NOW()) > 8 then 2 END AND YEAR(date) = YEAR(NOW())";
        $query = $dbSetting->ReplaceParameter($query, '[0]', $row["id"]);
        $rss   = $dbSetting->ExecuteQuery($query);
        $valid = mysql_num_rows($rss);

        if ($valid != 0) 
        {
            throw new Exception("duplicated");
        }
    }
    /* Fin Validacion de usuario */

    $query = "INSERT INTO user (turn_id, campus_id, permission_id, year, firstname, lastname, password, email, comission, validated, date)
              VALUES ([0],[1],[2],[3],'[4]','[5]','[6]','[7]','[8]',[9],[10])";

    $query = $dbSetting->ReplaceParameter($query, '[0]',  $turn_id);
    $query = $dbSetting->ReplaceParameter($query, '[1]',  $campus_id);
    $query = $dbSetting->ReplaceParameter($query, '[2]',  '1');
    $query = $dbSetting->ReplaceParameter($query, '[3]',  $year);
    $query = $dbSetting->ReplaceParameter($query, '[4]',  $firstname);
    $query = $dbSetting->ReplaceParameter($query, '[5]',  $lastname);
    $query = $dbSetting->ReplaceParameter($query, '[6]',  '123456');
    $query = $dbSetting->ReplaceParameter($query, '[7]',  $email);
    $query = $dbSetting->ReplaceParameter($query, '[8]',  $comission);
    $query = $dbSetting->ReplaceParameter($query, '[9]',  'false');
    $query = $dbSetting->ReplaceParameter($query, '[10]', 'NOW()');

    $dbSetting->ExecuteQuery($query);

    header('Location: /?register_success=true');
} 
catch (Exception $e) 
{
    header('Location: /?error_register=' . $e->getMessage());
}