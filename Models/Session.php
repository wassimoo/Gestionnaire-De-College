<?php
/**
 * Created by PhpStorm.
 * User: wassim
 * Date: 14/01/18
 * Time: 23:24
 */

 require_once "Login.php";
 require_once "Utils.php";

class Session
{
    /*
     * Carries :
     *  user_id
     *  session_id
     *  last_activity
     */

     /**
      * Load Existing Session, Check for timeout, regenerate_id and redirect to login page if necessary
      * @param string $url path to login page in case of failure
      * @param int    $activityTimeOut last activity time out interval value in seconds
      * @param int    $last_reg_time   last refresh time out interval value in seconds
      * @return boolean true | false stating session loading success | failure. 
      */

    public static function LoadSession($url)
    {
        session_start();

        if (!isset($_SESSION['last_activity']) || !isset($_SESSION['last_reg_time']) || !isset($_SESSION['username']) || !isset($_SESSION["dbc"]))
        {
            //something is wrong! verify user login again
            return Login::processLogin($url);
        }else {
            return true;
        }
    }


    public static function resetSession($username)
    {
        $_SESSION['username'] = $username;
        $_SESSION['last_activity'] = time();
        $_SESSION['last_reg_time'] = time();
    }

    public static function regenerateId()
    {
        // Call session_create_id() while session is active to
        // make sure collision free.
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        // WARNING: Never use confidential strings for prefix!
        $newid = session_create_id('ADMIN');

        // Set deleted timestamp. Session data must not be deleted immediately for reasons.
        $_SESSION['last_reg_time'] = time();

        // Finish session
        session_commit();

        // Make sure to accept user defined session ID
        // NOTE: You must enable use_strict_mode for normal operations.
        ini_set('session.use_strict_mode', 0);

        // Set new custom session ID
        session_id($newid);

        // Start with custom session ID
        session_start();

        // Make sure use_strict_mode is enabled.
        // use_strict_mode is mandatory for security reasons.
        ini_set('session.use_strict_mode', 1);
    }
}