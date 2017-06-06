<?php

class DBSetting
{
    private $_dbInformation;
    private $_dbConnection;

    public function __construct(DBInformation $dbInformation)
    {
        $this->_dbInformation = $dbInformation;
    }

    public function SetConnection()
    {
        $connection = mysql_connect($this->_dbInformation->GetHostName(), $this->_dbInformation->GetUserName(), $this->_dbInformation->GetPassword()) or die(mysql_error());

        if (!mysql_ping($connection)) {
            sleep(10);
            $connection = mysql_connect($this->_dbInformation->GetHostName(), $this->_dbInformation->GetUserName(), $this->_dbInformation->GetPassword()) or die(mysql_error());
        }

        mysql_select_db($this->_dbInformation->GetDataBase(), $connection);

        $this->_dbConnection = $connection;
    }

    public function ReplaceParameter($query, $parameterName, $parameterValue)
    {
        $parameterValue = DBInformation::mysql_escape_mimic($parameterValue);

        return str_replace($parameterName, $parameterValue, $query);
    }

    public function ExecuteNonQuery($query)
    {
        $this->SetConnection();

        $rs = mysql_query($query, $this->_dbConnection) or die(mysql_error());
    }

    public function ExecuteQuery($query)
    {
        $this->SetConnection();

        $rs = mysql_query($query, $this->_dbConnection) or die(mysql_error());
        return $rs;
    }
}

class DBInformation
{
    private $hostname_db;
    private $database_db;
    private $username_db;
    private $password_db;

    public function __construct($hostname, $database, $username, $password)
    {
        $this->hostname_db = $hostname;
        $this->database_db = $database;
        $this->username_db = $username;
        $this->password_db = $password;
    }

    public function GetHostName()
    {
        return $this->hostname_db;
    }

    public function GetDataBase()
    {
        return $this->database_db;
    }

    public function GetUserName()
    {
        return $this->username_db;
    }

    public function GetPassword()
    {
        return $this->password_db;
    }

    public static function mysql_escape_mimic($inp)
    {
        if (is_array($inp)) {
            return array_map(__METHOD__, $inp);
        }

        if (!empty($inp) && is_string($inp)) {
            return str_replace(
                ['\\', "\0", "\n", "\r", "'", '"', "\x1a"],
                ['\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'],
                $inp
            );
        }

        return $inp;
    }
}
