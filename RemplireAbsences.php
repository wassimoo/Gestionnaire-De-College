<?php
require_once __DIR__ .'/Models/Queries.php';
require_once __DIR__ ."/Models/Session.php";
require_once __DIR__ ."/Models/importTwig.php";

Session::LoadSession("login.html");

$data = array(
    'name' => $_SESSION["name"],
    'last_name' => $_SESSION["lastName"],
    'admin_id' => $_SESSION["username"]
); 
    echo TwigLib::bind('RemplireAbsences.html', $data);