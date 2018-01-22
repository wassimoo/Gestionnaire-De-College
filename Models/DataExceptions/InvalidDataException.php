<?php
    class invalidDataException extends Exception
    {
        function __construct(){
            $message =  "invalid data sent to server";
            $code = 0x1212;
        }
    }