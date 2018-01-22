<?php
class DB
{   
     public $port;
     public $socket;
     public $host;
     public $dbname;
     public $username;
    
    function __construct($port,$socket,$host,$username,$dbname){
        $this->port = $port;
        $this->socket = $socket;
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
    }

    public  function establishconnection($pwd)
    {
        try {
             return new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname.';charset=utf8', $this->username, $pwd);
        }catch (PDOException $e) {
            echo "Error!: " . $e->getMessage() . "<br/>"; //TODO : will it propagate ? will be less uglier to hide this echo message from user
            die();
        }
    }

    public static function validateConnection($con){

    }
}
