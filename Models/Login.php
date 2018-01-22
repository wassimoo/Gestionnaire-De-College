<?php
/**
 * Created by PhpStorm.
 * User: wassim
 * Date: 16/01/18
 * Time: 16:57
 */
require_once "dbConfig.php";
require_once "Session.php";

class Login
{

    /**
     * process Login informations sent by method POST, on success redirect to Welcome page .
     * on failure returns 'false'
     * @throws PDOException
     * @throws InvalidInfoException
     * @throws invalidDataException
     * @return boolean Login success or failure
     */

    public static function processLogin($url)
    {
        if(!isset($_POST['id']) || !isset($_POST['pwd'])){
            require_once "Utils.php";
            _Url::redirect($url);
        }

        try {
            $_SESSION["dbc"] = new DB(3306,"","127.0.0.1","college_admin","college");
            $dbh = $_SESSION["dbc"]->establishConnection("2018");
            $stmt = $dbh->prepare("SELECT COUNT(ID_ADMIN) AS COUNTS FROM ADMIN WHERE ID_ADMIN = ? AND MDP  = ? ");
            $stmt->execute(array($_POST['id'],$_POST['pwd']));
            $row = $stmt->fetchAll();

            if ($row[0][0] == 1) {
                Session::resetSession($_POST['id']);
                return true;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            // TODO : redirect to 404
            echo "couldn't establish connection";
        }

    }

}
