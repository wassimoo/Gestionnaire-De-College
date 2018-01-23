<?php
    require_once __DIR__ . "/Models/Session.php";
    require_once __DIR__ ."/Models/importTwig.php";

    Session::LoadSession("login.html");
    $dbh = $_SESSION["dbc"]->establishConnection("2018");
    
    echo TwigLib::bind('gestionEleve.html', array());
