<?php
    require_once __DIR__ . "/Models/Session.php";
    require_once __DIR__ . '/Models/Queries.php';
    require_once __DIR__ ."/Models/importTwig.php";

    Session::LoadSession("login.html");
    $dbh = $_SESSION["dbc"]->establishConnection("2018");
    
    $query = "SELECT ID_ELEVE, NOM_ELEVE, PRENOM_ELEVE, NUM_CLASSE, NIVEAU FROM ELEVE 
              INNER JOIN CLASSE
              ON ELEVE.ID_CLASSE = CLASSE.ID";
    $rows = Queries::performQuery($dbh,$query,NULL,"select");

    $data = array(
        "eleves" => $rows,
        'name' => $_SESSION["name"],
        'last_name' => $_SESSION["lastName"],
        'admin_id' => $_SESSION["username"]
    );

    echo TwigLib::bind('gestionEleve.html', $data);