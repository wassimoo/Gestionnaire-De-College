<?php
require_once __DIR__ . '/../vendor/autoload.php';

class TwigLib
{
    public static function init($fileName)
    {
        $loader = new Twig_Loader_Filesystem(__DIR__ . '/../views/');
        $twig = new Twig_Environment($loader, array(

            'cache' => false,

        ));

        return $twig;
    }

    /* 
     * DESC:  will bind text to tags 
     * @args:
            $fileName: target file name
            $DATA : Array of data to be rendered 
     * */
    public static function bind($fileName,$data){
        $twig = self::init($fileName);
     return   $twig->render($fileName, $data);
    }
}
