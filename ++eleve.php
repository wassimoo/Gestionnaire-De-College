<?php
require_once __DIR__ . "/Models/Session.php";
require_once __DIR__ . '/Models/Queries.php';
require_once __DIR__ . "/Models/importTwig.php";

Session::LoadSession("login.html");

$dbh = $_SESSION["dbc"]->Establishconnection("2018");
$name = $_POST["name"];
$lastName = $_POST["lastName"];
$classeId = $_POST["classeId"];
$tel = $_POST["tel"];
$adresse = $_POST["adresse"];

if ($classeId <= 0 || $classeId > 17)
    echo false;

try {
    //*********************** get new eleve id ********************/
    $query = "SELECT count(ID_ELEVE) FROM ELEVE";
    $id = Queries::performQuery($dbh, $query, array($classeId), 'select')[0][0];
    //************************** `ID_ELEVE`  ***********************/

    //************************** Upload profile Picture ********************/
    $uploaddir = 'img/pp/eleves/';

    $temp = explode(".", $_FILES["image"]["name"]);

    $newDest = $uploaddir . $id . '.' . end($temp);

    move_uploaded_file($_FILES['image']['tmp_name'], $newDest);

    //**********************************************************************/

    //************************** Insert eleve *******************************
    $query = "INSERT INTO ELEVE VALUES (? ,? , ? , ? , ? , ? )";
    if (Queries::performQuery($dbh, $query, array($id, $lastName, $name, $adresse, $tel, $classeId), 'insert')) {
        //************************** Update classes *****************************
        $query = "UPDATE `CLASSE` SET NBR_ELEVES= NBR_ELEVES +1 WHERE ID= ?";
        echo Queries::performQuery($dbh, $query, array($classeId), 'update');
        //**********************************************************************/
    } else
        echo false;

} catch (invalidDataException $e) {
    echo false;
}