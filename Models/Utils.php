<?php
    class _URL
    {
        public static function redirect($url){
            header('Location: '.$url);
        }
    }
    