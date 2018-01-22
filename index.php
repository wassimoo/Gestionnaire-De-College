<?php
require_once __DIR__ .'/Models/Queries.php';
require_once __DIR__ .'/Models/Utils.php';
require_once __DIR__ ."/Models/Session.php";
require_once __DIR__ ."/Models/importTwig.php";

    Session::LoadSession("login.html");
    $dbh = $_SESSION["dbc"]->establishConnection("2018");


    //************************** $nbr_eleves **************************
    $query = "SELECT COUNT(ID_ELEVE) FROM ELEVE";
    $rows = Queries::performQuery($dbh, $query, NULL);
    $nbrEleves = $rows[0][0];
    //*****************************************************************


    //************************** $nbr_profs **************************
    $query = "SELECT COUNT(ID_ENSEIGNANT) FROM ENSEIGNANT";
    $rows = Queries::performQuery($dbh, $query, NULL);
    $nbrProfs = $rows[0][0];
    //*****************************************************************


    //*********************** $name, $last_name ***********************
    $query = "SELECT * FROM ADMIN WHERE ID_ADMIN = ? ";
    $rows = Queries::performQuery($dbh, $query, array($_SESSION['username']));
    $name = $rows[0][1];
    $lastName = $rows[0][2];
    //*****************************************************************

    //********************** All Article things ***********************
    $query = "SELECT * FROM ARTICLE A INNER JOIN LIRE L 
              ON A.ID_ARTICLE = L.ID_ARTICLE AND L.ID_ADMIN = ? AND vu = FALSE 
              ORDER BY A.DATE_ARTICLE DESC ";
    $row = Queries::performQuery($dbh, $query, array($_SESSION['username']));
    $articleName = $row[0]["NOM_ARTICLE"];
    $pubDate = $row[0]["DATE_ARTICLE"];
    $writerName = $row[0]["NOM_ECRIVAIN"];
    $articleContent = $row[0]["CONTENU_ARTICLE"];
    $articleId = $row[0]["ID_ARTICLE"];
    $link = $row[0]["lien_extern"];
    //******************************************************************


    $data = array(
        'nbr_eleves' => $nbrEleves,
        'nbr_profs' => $nbrProfs,
        'admin_id' => $_SESSION["username"],
        'name' => $name,
        'last_name' => $lastName,
        'article_name' => $articleName,
        'writer' => $writerName,
        'publication_date' => $pubDate,
        'content' => $articleContent,
        'article_id' => $articleId,
        'lien_extern' => $link
    );

    $dbh = null; //close connection

echo TwigLib::bind('index.html', $data);