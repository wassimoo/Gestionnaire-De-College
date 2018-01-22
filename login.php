<?php
/**
 * Created by PhpStorm.
 * User: wassim
 * Date: 21/01/18
 * Time: 00:54
 */


require_once __DIR__ . "/Models/Session.php";

if (Session::LoadSession("login.html") == false) {
    echo "false";
} else {
    echo "true";
}