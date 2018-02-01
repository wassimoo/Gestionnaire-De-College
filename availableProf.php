<?php
require_once __DIR__ . "/Models/Session.php";
require_once __DIR__ . '/Models/Queries.php';
require_once __DIR__ . "/Models/importTwig.php";

Session::LoadSession("login.html");

$dbh = $_SESSION["dbc"]->Establishconnection("2018");
$date = $_GET["hour"];

//********************** All availble professors ***********************/
$query = "SELECT DISTINCT AV.ID_ENSEIGNANT, AV.NOM_ENSEIGNANT, AV.PRENOM_ENSEIGNANT FROM
        (
            (SELECT ID_ENSEIGNANT, NOM_ENSEIGNANT, PRENOM_ENSEIGNANT from ENSEIGNANT) AV
                LEFT JOIN
            (select ID_ENSEIGNANT  from COURS where heure = ? ) BU
            ON  AV.ID_ENSEIGNANT = BU.ID_ENSEIGNANT

        )WHERE BU.ID_ENSEIGNANT IS NULL";

$rows = Queries::performQuery($dbh, $query, array($date), "select");

if ($rows == null) {
    echo false;
}

$set = "<option value ='0'>Professeurs Disponible</option>";

foreach ($rows as $row) {
    $set .= "<option value ='".$row["ID_ENSEIGNANT"]."'>". $row["NOM_ENSEIGNANT"]." ".$row["PRENOM_ENSEIGNANT"]."</option><br>";
}
echo $set;
