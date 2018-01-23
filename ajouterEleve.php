<?php
    require_once __DIR__ . "/Models/Session.php";
    require_once __DIR__ .'/Models/Queries.php';
    require_once __DIR__ ."/Models/importTwig.php";

    Session::LoadSession("login.html");
    $dbh = $_SESSION["dbc"]->Establishconnection("2018");
    $name = $_POST["name"];
    $lastName = $_POST["lastName"];
    $classeId = $_POST["classeId"];
    $tel = $_POST["tel"];
    $adresse = $_POST["adresse"];

    if($classeId <= 0 || $classeId > 17)
        echo false;
    
    //************************** Insert eleve **************************
    $query = "INSERT INTO `ELEVE` (`NOM_ELEVE`, `PRENOM_ELEVE`, `ADRESSE`, `TEL_PARENTS`, `ID_CLASSE`) VALUES (?, ?, ?, ?, ?)";
    if(Queries::performQuery($dbh, $query, array($lastName,$name,$adresse,$tel,$classeId),'insert')){
    //************************** Update classes **************************
        $query = "UPDATE `CLASSE` SET `NBR_ELEVES`= `NBR_ELEVES` +1 WHERE `ID`= ?";
        echo Queries::performQuery($dbh, $query,array($classeId),'update');
    }
    else
        echo false;