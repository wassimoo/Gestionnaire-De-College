<?php
class DB
{
    static $dbh;
    public static function Establishconnection($host, $username, $pwd, $dbname)
    {
        $port = 3306;
        $socket = "";
        try {
            $dbh = new PDO('mysql:host=' . $host . ';dbname=' . $dbname.';charset=utf8', $username, $pwd);
        }catch (PDOException $e) {
            echo "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return $dbh;
    }
}
