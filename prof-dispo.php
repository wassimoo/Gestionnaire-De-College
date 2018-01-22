<?php
    require_once __DIR__ . "/Models/Session.php";
    require_once __DIR__ ."/Models/importTwig.php";

    Session::LoadSession("login.html");
    $dbh = DB::Establishconnection("127.0.0.1", "college_admin", "2018", "college");
    
    echo TwigLib::bind('prof-dispo.html', array());
