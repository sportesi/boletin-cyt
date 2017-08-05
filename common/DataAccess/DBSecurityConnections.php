<?php

require_once(__ROOT__ . '/common/DataAccess/BDSettings.php');

$devConn = [
    '0.0.0.0',
    'localhost',
    '127.0.0.1',
    '192.168.99.100',
    'dockerhost',
];

$connection = in_array($_SERVER['HTTP_HOST'], $devConn) ? 'db' : '127.0.0.1';

$dbInformation = new DBInformation($connection, "ees_db", "ees_uai", "QERA7854");
$dbSetting = new DBSetting($dbInformation);
