<?php
require_once __DIR__ . "/Models/Session.php";
require_once __DIR__ . '/Models/Queries.php';
require_once __DIR__ . "/Models/importTwig.php";

Session::LoadSession("login.html");

$dbh = $_SESSION["dbc"]->Establishconnection("2018");

$classeId = $_POST["classeId"];

$query = "SELECT * FROM ELEVE WHERE ID_CLASSE = ?";

$rows = Queries::performQuery($dbh,$query,array($classeId),"select");

if($rows == null)
    echo "false";
else
    foreach($rows as $row){
        $msg = 
                '<div class="col-xl-2 col-lg-3 col-sm-4 col-6" >
                        <div class="contacts__item">
                            <a href="#" class="contacts__img" id="%s">
                                <img src="img/pp/eleves/%s.jpg" alt="">
                            </a>
                            <div class="contacts__info">
                                <strong>%s %s</strong>
                                <small>%s</small>
                            </div>
                        </div>
                </div>';
        $msg = sprintf($msg,$row["ID_ELEVE"],$row["ID_ELEVE"],$row["NOM_ELEVE"],$row["PRENOM_ELEVE"],$row["STATUS"]);
        echo $msg;
    }