<?php
require_once __DIR__ . "/Models/Session.php";
require_once __DIR__ . '/Models/Queries.php';
require_once __DIR__ . "/Models/importTwig.php";

Session::LoadSession("login.html");

$dbh = $_SESSION["dbc"]->Establishconnection("2018");

$materiels = $_POST["materiel"];
$time = $_POST["date"];

$Qmateriels = "";

if ($materiels == null) {
    goto Query;
}

$Qmateriels =
    "(SELECT SALLE.NUM_SALLE
FROM SALLE
  NATURAL JOIN MATRIEL
WHERE MATRIEL.M_TYPE = ? ";

$n = count($materiels) - 1;
for ($i = 0; $i < $n; $i++) {
    $Qmateriels .=
        " AND SALLE.NUM_SALLE IN (SELECT NUM_SALLE
    FROM MATRIEL
    WHERE MATRIEL.M_TYPE = ?)";
}
$Qmateriels .= ")";

Query:
//********************** All availble professors ***********************/
$query =
    "SELECT DISTINCT A.NUM_SALLE,A.CAPACITE,A.TYPE
    FROM
      (
          (SELECT NUM_SALLE,CAPACITE,TYPE
           FROM SALLE) AS A
          LEFT JOIN
          (SELECT NUM_SALLE
           FROM COURS
           WHERE heure = ?) AS B
            ON A.NUM_SALLE = B.NUM_SALLE
      )
    WHERE B.NUM_SALLE IS NULL";
$query .= $Qmateriels != "" ? " AND A.NUM_SALLE IN " . $Qmateriels : $Qmateriels;

if($materiels == null)
        $materiels = array($time);
else
    array_unshift($materiels, $time);

$rows = Queries::performQuery($dbh, $query, $materiels, "select");

foreach ($rows as $row) {

    $tr = sprintf('<tr>
                    <td> %s </td>
                    <td> %s </td>
                    <td> %s </td>
                    <td>
                        <div class="icon-toggle" >
                            <input type="checkbox" id="%s">
                                <i class="zmdi zmdi-check"></i>
                        </div>
                    </td>
                </tr>', $row["NUM_SALLE"], $row["CAPACITE"], $row["TYPE"], $row["NUM_SALLE"]);

    echo $tr;
}

if ($rows == null) {
    echo false;
}
